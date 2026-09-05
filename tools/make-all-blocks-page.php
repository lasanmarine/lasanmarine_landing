<?php
/**
 * Build a single "All Blocks" QA page that contains every acf/* block, each
 * filled with synthesised sample content and serialised in the ACF-editor
 * shape (name + _name field-key pointers, flattened repeaters/groups).
 *
 * Idempotent: re-running updates the same page (matched by _lasan_content_key).
 *
 * Run from the WordPress root:
 *   php tools/make-all-blocks-page.php
 */

declare(strict_types=1);

$wp_load = dirname( __DIR__ ) . '/wp-load.php';
if ( ! is_file( $wp_load ) ) {
	fwrite( STDERR, "Cannot locate wp-load.php\n" );
	exit( 1 );
}
require_once $wp_load;

/** @return array<int, array<string, mixed>> */
function ab_field_defs( string $slug ): array {
	$file = get_stylesheet_directory() . "/blocks/{$slug}/{$slug}.json";
	$json = is_file( $file ) ? json_decode( (string) file_get_contents( $file ), true ) : null;

	return ( is_array( $json ) && ! empty( $json['fields'] ) && is_array( $json['fields'] ) ) ? $json['fields'] : array();
}

/** Synthesise a plausible value for one field definition. */
function ab_sample_value( array $def, int $row = 0 ) {
	$type  = (string) ( $def['type'] ?? '' );
	$label = (string) ( $def['label'] ?? ucfirst( (string) ( $def['name'] ?? 'Field' ) ) );
	$name  = (string) ( $def['name'] ?? '' );

	switch ( $type ) {
		case 'textarea':
		case 'wysiwyg':
			$text = "Nội dung mẫu cho {$label}. Đoạn văn ngắn để kiểm tra bố cục, khoảng cách và cách khối hiển thị trên trang.";
			return 'wysiwyg' === $type ? '<p>' . $text . '</p>' : $text;

		case 'number':
			if ( isset( $def['default_value'] ) && is_numeric( $def['default_value'] ) ) {
				return (int) $def['default_value'];
			}
			return in_array( $name, array( 'x', 'y' ), true ) ? ( 20 + $row * 12 ) : ( 4 + $row );

		case 'email':
			return 'lien-he@lasanmarine.vn';

		case 'select':
			if ( isset( $def['default_value'] ) && '' !== $def['default_value'] ) {
				return $def['default_value'];
			}
			$choices = isset( $def['choices'] ) && is_array( $def['choices'] ) ? array_keys( $def['choices'] ) : array();
			return $choices ? $choices[0] : '';

		case 'link':
			return array( 'title' => $label, 'url' => home_url( '/lien-he/' ), 'target' => '' );

		case 'image':
		case 'file':
			return ''; // Let the block fall back to its placeholder.

		case 'post_object':
		case 'taxonomy':
			return ''; // Empty -> block resolves its own default (latest posts, etc.).

		case 'true_false':
			return 1;

		case 'text':
		default:
			if ( isset( $def['default_value'] ) && '' !== $def['default_value'] ) {
				return (string) $def['default_value'];
			}
			// Short, index-ish values read better for the common repeater fields.
			if ( 'index' === $name ) {
				return str_pad( (string) ( $row + 1 ), 2, '0', STR_PAD_LEFT );
			}
			if ( in_array( $name, array( 'value', 'kw', 'strength', 'factor', 'span', 'year', 'rpm', 'size' ), true ) ) {
				return (string) ( 10 + $row * 5 );
			}
			if ( 'suffix' === $name ) {
				return '+';
			}
			return 0 === $row ? "Mẫu {$label}" : "Mẫu {$label} {$row}";
	}
}

/**
 * @param array<string, mixed> $out
 * @param array<int, array<string, mixed>> $defs
 */
function ab_fill( array &$out, string $prefix, array $defs, int $row = 0 ): void {
	foreach ( $defs as $def ) {
		$name = (string) ( $def['name'] ?? '' );
		$key  = (string) ( $def['key'] ?? '' );
		$type = (string) ( $def['type'] ?? '' );

		if ( '' === $name || '' === $key || 'tab' === $type || 'message' === $type ) {
			continue;
		}
		if ( 'custom_class' === $name ) {
			$out['custom_class']  = '';
			$out['_custom_class'] = $key;
			continue;
		}

		$path = $prefix . $name;
		$subs = ( isset( $def['sub_fields'] ) && is_array( $def['sub_fields'] ) ) ? $def['sub_fields'] : array();

		if ( 'repeater' === $type ) {
			$count = ( '' !== $prefix ) ? 2 : 3; // fewer rows for nested repeaters
			$out[ $path ]       = $count;
			$out[ '_' . $path ] = $key;
			for ( $i = 0; $i < $count; $i++ ) {
				ab_fill( $out, $path . '_' . $i . '_', $subs, $i );
			}
			continue;
		}

		if ( 'group' === $type ) {
			$out[ '_' . $path ] = $key;
			ab_fill( $out, $path . '_', $subs, $row );
			continue;
		}

		$out[ $path ]       = ab_sample_value( $def, $row );
		$out[ '_' . $path ] = $key;
	}
}

function ab_block( string $slug, array $inner = array() ): array {
	$data = array();
	ab_fill( $data, '', ab_field_defs( $slug ) );

	return array(
		'blockName'    => 'acf/' . $slug,
		'attrs'        => array( 'name' => 'acf/' . $slug, 'data' => $data, 'mode' => 'preview' ),
		'innerBlocks'  => $inner,
		'innerHTML'    => '',
		'innerContent' => $inner ? array_fill( 0, count( $inner ), null ) : array(),
	);
}

$blocks_dir = get_stylesheet_directory() . '/blocks';
$slugs      = array_map( 'basename', glob( $blocks_dir . '/*', GLOB_ONLYDIR ) ?: array() );
sort( $slugs );

// Calculators sit inside a tool-shell; render them nested there and skip the
// standalone copies so the page mirrors how the site actually uses them.
$nested_in_shell = array( 'power-converter', 'shaft-diameter', 'engine-lookup' );

$block_list = array();
foreach ( $slugs as $slug ) {
	if ( in_array( $slug, $nested_in_shell, true ) ) {
		continue;
	}
	if ( 'tool-shell' === $slug ) {
		$block_list[] = ab_block( 'tool-shell', array( ab_block( 'power-converter' ) ) );
		$block_list[] = ab_block( 'tool-shell', array( ab_block( 'shaft-diameter' ) ) );
		$block_list[] = ab_block( 'tool-shell', array( ab_block( 'engine-lookup' ) ) );
		continue;
	}
	$block_list[] = ab_block( $slug );
}

$content = implode( "\n\n", array_map( 'serialize_block', $block_list ) );

$key      = 'all_blocks_qa';
$existing = get_posts(
	array(
		'post_type'      => 'page',
		'post_status'    => 'any',
		'posts_per_page' => 1,
		'lang'           => '',
		'meta_key'       => '_lasan_content_key',
		'meta_value'     => $key,
	)
);

$post_id = wp_insert_post(
	wp_slash(
		array(
			'ID'           => $existing ? (int) $existing[0]->ID : 0,
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_title'   => 'All Blocks',
			'post_name'    => 'all-blocks',
			'post_content' => $content,
		)
	),
	true
);

if ( is_wp_error( $post_id ) ) {
	fwrite( STDERR, $post_id->get_error_message() . "\n" );
	exit( 1 );
}

update_post_meta( (int) $post_id, '_lasan_content_key', $key );
if ( function_exists( 'pll_set_post_language' ) && ! pll_get_post_language( (int) $post_id ) ) {
	pll_set_post_language( (int) $post_id, pll_default_language() ?: 'vi' );
}

printf( "All Blocks page #%d (%d blocks): %s\n", (int) $post_id, count( $block_list ), get_permalink( (int) $post_id ) );
