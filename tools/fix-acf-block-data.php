<?php
/**
 * One-off migration: rewrite ACF block data in existing pages/posts into the
 * shape the block editor expects.
 *
 * The content importer wrote block attributes as plain `{"name": value}` without
 * the `_name -> field_key` pointers (and with repeaters as nested arrays). The
 * front end tolerates that via the theme's fallback extractor, but the Gutenberg
 * editor cannot map those values back to fields, so it shows empty fields and
 * wipes the content on the first save.
 *
 * This script re-flattens every ACF block whose data is still in the raw shape,
 * using each block's own field definitions, and leaves already-migrated blocks
 * (those that carry `_` pointer keys) untouched.
 *
 * Run from the WordPress root:
 *   php tools/fix-acf-block-data.php          # dry run, prints what would change
 *   php tools/fix-acf-block-data.php --write  # apply
 */

declare(strict_types=1);

$wp_load = dirname( __DIR__ ) . '/wp-load.php';
if ( ! is_file( $wp_load ) ) {
	fwrite( STDERR, "Cannot locate wp-load.php\n" );
	exit( 1 );
}
require_once $wp_load;

$write = in_array( '--write', $argv, true );

/** @return array<int, array<string, mixed>> */
function lasan_fix_field_defs( string $slug ): array {
	static $cache = array();
	if ( isset( $cache[ $slug ] ) ) {
		return $cache[ $slug ];
	}
	$file = get_stylesheet_directory() . "/blocks/{$slug}/{$slug}.json";
	$json = is_file( $file ) ? json_decode( (string) file_get_contents( $file ), true ) : null;

	return $cache[ $slug ] = ( is_array( $json ) && ! empty( $json['fields'] ) && is_array( $json['fields'] ) )
		? $json['fields']
		: array();
}

/**
 * @param array<string, mixed> $out
 * @param array<string, mixed> $values
 * @param array<int, array<string, mixed>> $defs
 */
function lasan_fix_fill( array &$out, string $prefix, array $values, array $defs ): void {
	foreach ( $defs as $def ) {
		$name = (string) ( $def['name'] ?? '' );
		$key  = (string) ( $def['key'] ?? '' );
		$type = (string) ( $def['type'] ?? '' );

		if ( '' === $name || '' === $key || 'tab' === $type || 'message' === $type ) {
			continue;
		}
		if ( ! array_key_exists( $name, $values ) ) {
			continue;
		}

		$value = $values[ $name ];
		$path  = $prefix . $name;
		$subs  = ( isset( $def['sub_fields'] ) && is_array( $def['sub_fields'] ) ) ? $def['sub_fields'] : array();

		if ( 'repeater' === $type ) {
			$rows = is_array( $value ) ? array_values( $value ) : array();
			$out[ $path ]       = count( $rows );
			$out[ '_' . $path ] = $key;
			foreach ( $rows as $i => $row ) {
				if ( is_array( $row ) ) {
					lasan_fix_fill( $out, $path . '_' . $i . '_', $row, $subs );
				}
			}
			continue;
		}

		if ( 'group' === $type ) {
			$out[ '_' . $path ] = $key;
			if ( is_array( $value ) ) {
				lasan_fix_fill( $out, $path . '_', $value, $subs );
			}
			continue;
		}

		$out[ $path ]       = $value;
		$out[ '_' . $path ] = $key;
	}
}

/**
 * @param array<int, array<string, mixed>> $blocks
 * @return array{0: array<int, array<string, mixed>>, 1: int}
 */
function lasan_fix_blocks( array $blocks, int &$changed ): array {
	foreach ( $blocks as &$block ) {
		if ( ! empty( $block['innerBlocks'] ) ) {
			$block['innerBlocks'] = lasan_fix_blocks( $block['innerBlocks'], $changed )[0];
		}

		$name = (string) ( $block['blockName'] ?? '' );
		if ( 0 !== strpos( $name, 'acf/' ) ) {
			continue;
		}

		$data = $block['attrs']['data'] ?? null;
		if ( ! is_array( $data ) || array() === $data ) {
			continue;
		}

		// Already migrated: ACF pointer keys present.
		foreach ( array_keys( $data ) as $data_key ) {
			if ( is_string( $data_key ) && '' !== $data_key && '_' === $data_key[0] ) {
				continue 2;
			}
		}

		$slug = substr( $name, 4 );
		$defs = lasan_fix_field_defs( $slug );
		if ( ! $defs ) {
			continue;
		}

		$fixed = array();
		lasan_fix_fill( $fixed, '', $data, $defs );
		if ( ! $fixed ) {
			continue;
		}

		$block['attrs']['data'] = $fixed;
		++$changed;
	}
	unset( $block );

	return array( $blocks, $changed );
}

$query = new WP_Query(
	array(
		'post_type'      => array( 'page', 'post' ),
		'post_status'    => 'any',
		'posts_per_page' => -1,
		'fields'         => 'ids',
		// Polylang scopes queries to one language by default (the VI pages);
		// an empty lang takes every translation, EN pages included.
		'lang'           => '',
	)
);

$total_posts = 0;
$total_blocks = 0;

foreach ( $query->posts as $post_id ) {
	$post = get_post( $post_id );
	if ( ! $post instanceof WP_Post || ! has_blocks( $post->post_content ) ) {
		continue;
	}

	$changed = 0;
	list( $blocks ) = lasan_fix_blocks( parse_blocks( $post->post_content ), $changed );
	if ( 0 === $changed ) {
		continue;
	}

	$new_content = implode( "\n\n", array_map( 'serialize_block', $blocks ) );
	$total_posts++;
	$total_blocks += $changed;

	printf( "%s #%d %-28s  %d block(s)\n", $write ? 'FIX ' : 'DRY ', $post->ID, $post->post_name, $changed );

	if ( $write ) {
		wp_update_post(
			wp_slash(
				array(
					'ID'           => $post->ID,
					'post_content' => $new_content,
				)
			)
		);
	}
}

printf(
	"\n%s: %d post(s), %d block(s)%s\n",
	$write ? 'Updated' : 'Would update',
	$total_posts,
	$total_blocks,
	$write ? '' : "  — re-run with --write to apply"
);
