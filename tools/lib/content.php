<?php
/**
 * Shared machinery for the content CLI: turning a JSON page description into
 * ACF block markup, and reading it back out again.
 *
 * @package Starter_Flexible
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Top-level ACF field definitions for a block, read from
 * blocks/<slug>/<slug>.json.
 *
 * @return array<int, array<string, mixed>>
 */
function lasan_content_defs( string $slug ): array {
	static $cache = array();
	if ( isset( $cache[ $slug ] ) ) {
		return $cache[ $slug ];
	}
	$file = get_stylesheet_directory() . "/blocks/{$slug}/{$slug}.json";
	$json = is_file( $file ) ? json_decode( (string) file_get_contents( $file ), true ) : null;

	return $cache[ $slug ] = ( is_array( $json ) && ! empty( $json['fields'] ) ) ? $json['fields'] : array();
}

/** Every block slug the theme ships. @return array<int, string> */
function lasan_content_block_slugs(): array {
	$dir   = get_stylesheet_directory() . '/blocks';
	$slugs = array();
	foreach ( (array) glob( $dir . '/*', GLOB_ONLYDIR ) as $path ) {
		$slug = basename( (string) $path );
		if ( is_file( $path . '/block.json' ) ) {
			$slugs[] = $slug;
		}
	}
	sort( $slugs );

	return $slugs;
}

/**
 * Flatten authored values into ACF's stored shape: `path => value` plus
 * `_path => field_key`. Without the key pointers the block editor cannot map
 * stored values back to fields and wipes them on the first save.
 *
 * @param array<string, mixed>             $out     Collected output, by reference.
 * @param array<string, mixed>             $values  Authored values.
 * @param array<int, array<string, mixed>> $defs    Field definitions.
 * @param array<int, string>               $unknown Field names with no definition.
 */
function lasan_content_fill( array &$out, string $prefix, array $values, array $defs, array &$unknown, string $trail = '' ): void {
	$known = array();

	foreach ( $defs as $def ) {
		$name = (string) ( $def['name'] ?? '' );
		$key  = (string) ( $def['key'] ?? '' );
		$type = (string) ( $def['type'] ?? '' );

		if ( '' === $name || '' === $key || 'tab' === $type || 'message' === $type ) {
			continue;
		}
		$known[] = $name;

		if ( ! array_key_exists( $name, $values ) ) {
			continue;
		}

		$value = $values[ $name ];
		$path  = $prefix . $name;
		$subs  = isset( $def['sub_fields'] ) && is_array( $def['sub_fields'] ) ? $def['sub_fields'] : array();

		if ( 'repeater' === $type ) {
			$rows               = is_array( $value ) ? array_values( $value ) : array();
			$out[ $path ]       = count( $rows );
			$out[ '_' . $path ] = $key;
			foreach ( $rows as $i => $row ) {
				if ( is_array( $row ) ) {
					lasan_content_fill( $out, $path . '_' . $i . '_', $row, $subs, $unknown, $trail . $name . '[]›' );
				}
			}
			continue;
		}

		if ( 'group' === $type ) {
			$out[ '_' . $path ] = $key;
			if ( is_array( $value ) ) {
				lasan_content_fill( $out, $path . '_', $value, $subs, $unknown, $trail . $name . '›' );
			}
			continue;
		}

		$out[ $path ]       = $value;
		$out[ '_' . $path ] = $key;
	}

	foreach ( array_keys( $values ) as $name ) {
		if ( ! in_array( (string) $name, $known, true ) ) {
			$unknown[] = $trail . $name;
		}
	}
}

/**
 * Rebuild authored values from ACF's stored shape — the inverse of the fill
 * above, used by `dump`.
 *
 * @param array<string, mixed>             $data
 * @param array<int, array<string, mixed>> $defs
 * @return array<string, mixed>
 */
function lasan_content_unfill( array $data, string $prefix, array $defs ): array {
	$values = array();

	foreach ( $defs as $def ) {
		$name = (string) ( $def['name'] ?? '' );
		$type = (string) ( $def['type'] ?? '' );
		if ( '' === $name || 'tab' === $type || 'message' === $type ) {
			continue;
		}
		$path = $prefix . $name;
		if ( ! array_key_exists( $path, $data ) ) {
			continue;
		}
		$subs = isset( $def['sub_fields'] ) && is_array( $def['sub_fields'] ) ? $def['sub_fields'] : array();

		if ( 'repeater' === $type ) {
			$rows  = array();
			$count = (int) $data[ $path ];
			for ( $i = 0; $i < $count; $i++ ) {
				$rows[] = lasan_content_unfill( $data, $path . '_' . $i . '_', $subs );
			}
			$values[ $name ] = $rows;
			continue;
		}

		if ( 'group' === $type ) {
			$values[ $name ] = lasan_content_unfill( $data, $path . '_', $subs );
			continue;
		}

		$values[ $name ] = $data[ $path ];
	}

	return $values;
}

/**
 * Resolve an authored link. Accepts `{label, page}` (a page key or slug),
 * `{label, url}` (site-relative or absolute), or an already-resolved ACF link.
 *
 * @param array<string, mixed> $link
 * @return array<string, string>
 */
function lasan_content_link( array $link ): array {
	if ( isset( $link['url'] ) && ! isset( $link['page'] ) && ! isset( $link['label'] ) ) {
		return $link; // Already in ACF shape.
	}

	$label = (string) ( $link['label'] ?? $link['title'] ?? '' );
	$url   = (string) ( $link['url'] ?? '' );

	if ( isset( $link['page'] ) ) {
		$id  = lasan_content_find_page( (string) $link['page'] );
		$url = $id ? (string) get_permalink( $id ) : '';
		if ( ! $id ) {
			fwrite( STDERR, "  ! link tới trang không tìm thấy: {$link['page']}\n" );
		}
	} elseif ( '' !== $url && ! preg_match( '#^(https?:)?//#', $url ) && ! str_starts_with( $url, '#' ) ) {
		// A bare `#anchor` stays as it is; anything else relative gets the site root.
		$url = home_url( $url );
	}

	return array( 'url' => $url, 'title' => $label, 'target' => (string) ( $link['target'] ?? '_self' ) );
}

/**
 * Walk authored values and resolve every field the block defines as a link.
 *
 * @param array<string, mixed>             $values
 * @param array<int, array<string, mixed>> $defs
 * @return array<string, mixed>
 */
function lasan_content_resolve_links( array $values, array $defs ): array {
	foreach ( $defs as $def ) {
		$name = (string) ( $def['name'] ?? '' );
		$type = (string) ( $def['type'] ?? '' );
		if ( '' === $name || ! array_key_exists( $name, $values ) ) {
			continue;
		}
		$subs = isset( $def['sub_fields'] ) && is_array( $def['sub_fields'] ) ? $def['sub_fields'] : array();

		if ( 'link' === $type && is_array( $values[ $name ] ) && $values[ $name ] ) {
			$values[ $name ] = lasan_content_link( $values[ $name ] );
			continue;
		}
		if ( in_array( $type, array( 'relationship', 'post_object' ), true ) && ! is_array( $values[ $name ] ) && ! is_numeric( $values[ $name ] ) ) {
			// A single post_object may be written as one slug.
			$found = get_posts(
				array(
					'post_type'      => (array) ( $def['post_type'] ?? 'any' ),
					'post_status'    => 'any',
					'posts_per_page' => 1,
					'name'           => (string) $values[ $name ],
					'lang'           => '',
				)
			);
			$values[ $name ] = $found ? (int) $found[0]->ID : '';
			continue;
		}
		if ( in_array( $type, array( 'relationship', 'post_object' ), true ) && is_array( $values[ $name ] ) ) {
			// Written as slugs so a content file survives a re-import that
			// renumbers posts.
			$ids = array();
			foreach ( $values[ $name ] as $ref ) {
				if ( is_numeric( $ref ) ) {
					$ids[] = (int) $ref;
					continue;
				}
				$found = get_posts(
					array(
						'post_type'      => (array) ( $def['post_type'] ?? 'any' ),
						'post_status'    => 'any',
						'posts_per_page' => 1,
						'name'           => (string) $ref,
						'lang'           => '',
					)
				);
				if ( $found ) {
					$ids[] = (int) $found[0]->ID;
				} else {
					fwrite( STDERR, "  ! không tìm thấy bài `{$ref}`\n" );
				}
			}
			$values[ $name ] = $ids;
			continue;
		}
		if ( 'image' === $type && is_array( $values[ $name ] ) && isset( $values[ $name ]['media'] ) ) {
			$media_key       = (string) $values[ $name ]['media'];
			$values[ $name ] = lasan_content_media_id( $media_key );
			if ( ! $values[ $name ] ) {
				fwrite( STDERR, "  ! không có media `{$media_key}` — chạy `lasan media` trước\n" );
			}
			continue;
		}
		if ( 'repeater' === $type && is_array( $values[ $name ] ) ) {
			$values[ $name ] = array_map(
				static fn( $row ) => is_array( $row ) ? lasan_content_resolve_links( $row, $subs ) : $row,
				$values[ $name ]
			);
			continue;
		}
		if ( 'group' === $type && is_array( $values[ $name ] ) ) {
			$values[ $name ] = lasan_content_resolve_links( $values[ $name ], $subs );
		}
	}

	return $values;
}

/**
 * Turn resolved links back into `{label, page}` where the target is a known
 * page, so a dumped file carries no host name and applies on any environment.
 *
 * @param array<string, mixed>             $values
 * @param array<int, array<string, mixed>> $defs
 * @return array<string, mixed>
 */
function lasan_content_pageify_links( array $values, array $defs ): array {
	foreach ( $defs as $def ) {
		$name = (string) ( $def['name'] ?? '' );
		$type = (string) ( $def['type'] ?? '' );
		if ( '' === $name || ! array_key_exists( $name, $values ) ) {
			continue;
		}
		$subs = isset( $def['sub_fields'] ) && is_array( $def['sub_fields'] ) ? $def['sub_fields'] : array();

		if ( 'link' === $type && is_array( $values[ $name ] ) && ! empty( $values[ $name ]['url'] ) ) {
			$link  = $values[ $name ];
			$id    = url_to_postid( (string) $link['url'] );
			$label = (string) ( $link['title'] ?? '' );
			$key   = $id ? (string) get_post_meta( $id, '_lasan_content_key', true ) : '';
			$ref   = '' !== $key ? $key : ( $id ? (string) get_post_field( 'post_name', $id ) : '' );
			// Only keep the page ref if it resolves back to this very page —
			// otherwise the link would silently retarget on the next apply.
			if ( $id && lasan_content_find_page( $ref ) === $id ) {
				$values[ $name ] = array( 'label' => $label, 'page' => $ref );
			} elseif ( str_starts_with( (string) $link['url'], '#' ) ) {
				$values[ $name ] = array( 'label' => $label, 'url' => (string) $link['url'] );
			} else {
				$path            = (string) ( wp_parse_url( (string) $link['url'], PHP_URL_PATH ) ?: '/' );
				$values[ $name ] = array( 'label' => $label, 'url' => $path );
			}
			continue;
		}
		if ( in_array( $type, array( 'relationship', 'post_object' ), true ) && is_array( $values[ $name ] ) ) {
			$values[ $name ] = array_values(
				array_filter(
					array_map(
						static fn( $id ) => is_numeric( $id ) ? (string) get_post_field( 'post_name', (int) $id ) : $id,
						$values[ $name ]
					)
				)
			);
			continue;
		}
		if ( 'image' === $type && is_numeric( $values[ $name ] ) && (int) $values[ $name ] > 0 ) {
			$media_key = lasan_content_media_key( (int) $values[ $name ] );
			if ( '' !== $media_key ) {
				$values[ $name ] = array( 'media' => $media_key );
			}
			continue;
		}
		if ( 'repeater' === $type && is_array( $values[ $name ] ) ) {
			$values[ $name ] = array_map(
				static fn( $row ) => is_array( $row ) ? lasan_content_pageify_links( $row, $subs ) : $row,
				$values[ $name ]
			);
			continue;
		}
		if ( 'group' === $type && is_array( $values[ $name ] ) ) {
			$values[ $name ] = lasan_content_pageify_links( $values[ $name ], $subs );
		}
	}

	return $values;
}

/**
 * Attachment id for a media key — the file name (without extension) a file in
 * tools/media/ was imported under. Keeps content files free of numeric ids,
 * which differ between environments.
 */
function lasan_content_media_id( string $key ): int {
	static $cache = array();
	if ( isset( $cache[ $key ] ) ) {
		return $cache[ $key ];
	}
	$found = get_posts(
		array(
			'post_type'      => 'attachment',
			'post_status'    => 'inherit',
			'posts_per_page' => 1,
			'meta_key'       => '_lasan_media_key',
			'meta_value'     => $key,
			'lang'           => '',
		)
	);

	return $cache[ $key ] = $found ? (int) $found[0]->ID : 0;
}

/** The media key an attachment was imported under, if any. */
function lasan_content_media_key( int $id ): string {
	return (string) get_post_meta( $id, '_lasan_media_key', true );
}

/**
 * Import one image file into the media library, keyed by its file name so a
 * re-run updates the same attachment instead of piling up duplicates.
 */
function lasan_content_import_media( string $path ): int {
	$key = sanitize_title( pathinfo( $path, PATHINFO_FILENAME ) );
	if ( ! is_file( $path ) ) {
		return 0;
	}

	$existing = lasan_content_media_id( $key );
	if ( $existing ) {
		return $existing;
	}

	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$tmp = wp_tempnam( basename( $path ) );
	if ( ! $tmp || ! copy( $path, $tmp ) ) {
		return 0;
	}

	$id = media_handle_sideload(
		array( 'name' => basename( $path ), 'tmp_name' => $tmp ),
		0,
		null,
		array( 'post_title' => $key )
	);
	if ( is_wp_error( $id ) ) {
		@unlink( $tmp ); // phpcs:ignore
		return 0;
	}

	update_post_meta( (int) $id, '_lasan_media_key', $key );

	return (int) $id;
}

/**
 * Build one serialisable block from an authored `{type, fields, inner}` entry.
 *
 * @param array<string, mixed> $entry
 * @param array<int, string>   $problems
 * @return array<string, mixed>
 */
function lasan_content_block( array $entry, array &$problems ): array {
	$slug = (string) ( $entry['type'] ?? '' );
	$defs = lasan_content_defs( $slug );

	if ( ! $defs && ! in_array( $slug, lasan_content_block_slugs(), true ) ) {
		$problems[] = "khối không tồn tại: {$slug}";
	}

	$fields  = is_array( $entry['fields'] ?? null ) ? $entry['fields'] : array();
	$fields  = lasan_content_resolve_links( $fields, $defs );
	// Padding Top / Bottom are appended to every block group at runtime, so they
	// are not in blocks/<slug>/<slug>.json — add them here or the CLI would
	// reject a spacing value as an unknown field.
	$defs[] = array( 'name' => 'padding_top', 'type' => 'number' );
	$defs[] = array( 'name' => 'padding_bottom', 'type' => 'number' );

	$unknown = array();
	$out     = array();
	lasan_content_fill( $out, '', $fields, $defs, $unknown );

	foreach ( $unknown as $name ) {
		$problems[] = "{$slug}: không có trường `{$name}`";
	}

	$inner = array();
	foreach ( (array) ( $entry['inner'] ?? array() ) as $child ) {
		if ( is_array( $child ) ) {
			$inner[] = lasan_content_block( $child, $problems );
		}
	}

	$attrs = array( 'name' => 'acf/' . $slug, 'data' => $out, 'mode' => (string) ( $entry['mode'] ?? 'preview' ) );
	if ( ! empty( $entry['anchor'] ) ) {
		$attrs['anchor'] = sanitize_title( (string) $entry['anchor'] );
	}

	return array(
		'blockName'    => 'acf/' . $slug,
		'attrs'        => $attrs,
		'innerBlocks'  => $inner,
		'innerHTML'    => '',
		'innerContent' => $inner ? array_fill( 0, count( $inner ), null ) : array(),
	);
}

/**
 * The language a page is currently being applied in. A Vietnamese page must
 * link to Vietnamese pages even where an English page shares the slug.
 */
function lasan_content_lang( ?string $set = null ): string {
	static $lang = '';
	if ( null !== $set ) {
		$lang = $set;
	}

	return $lang;
}

/**
 * Pick the candidate whose language matches the page being applied, falling
 * back to the first one when Polylang is absent or nothing matches.
 *
 * @param array<int, WP_Post> $posts
 */
function lasan_content_pick( array $posts ): int {
	if ( ! $posts ) {
		return 0;
	}
	$want = lasan_content_lang();
	if ( '' !== $want && function_exists( 'pll_get_post_language' ) ) {
		foreach ( $posts as $post ) {
			if ( (string) pll_get_post_language( (int) $post->ID ) === $want ) {
				return (int) $post->ID;
			}
		}
	}

	return (int) $posts[0]->ID;
}

/** Find a page by importer key first, then by slug, preferring the current language. */
function lasan_content_find_page( string $ref ): int {
	static $cache = array();
	$cache_key = lasan_content_lang() . '|' . $ref;
	if ( isset( $cache[ $cache_key ] ) ) {
		return $cache[ $cache_key ];
	}

	$matched = get_posts(
		array(
			'post_type'      => 'page',
			'post_status'    => 'any',
			'posts_per_page' => -1,
			'meta_key'       => '_lasan_content_key',
			'meta_value'     => $ref,
			'lang'           => '',
		)
	);
	if ( $matched ) {
		return $cache[ $cache_key ] = lasan_content_pick( $matched );
	}
	// A miss is never cached: `apply` runs two passes, and a page created in
	// the first must be found in the second instead of being created twice.

	// `get_page_by_path()` wants the full path, so a child page's bare slug
	// ("marine-rd") misses; fall back to matching post_name directly.
	$by_name = get_posts(
		array(
			'post_type'      => 'page',
			'post_status'    => 'any',
			'posts_per_page' => -1,
			'name'           => $ref,
			'lang'           => '',
		)
	);
	if ( $by_name ) {
		return $cache[ $cache_key ] = lasan_content_pick( $by_name );
	}

	$page = get_page_by_path( $ref, OBJECT, 'page' );
	if ( $page instanceof WP_Post ) {
		return $cache[ $cache_key ] = (int) $page->ID;
	}

	return 0;
}

/**
 * Apply one authored page document. Returns the page id.
 *
 * @param array<string, mixed> $doc
 * @param array<int, string>   $problems
 */
function lasan_content_apply( array $doc, array &$problems, bool $dry_run = false ): int {
	$key   = (string) ( $doc['key'] ?? '' );
	$slug  = (string) ( $doc['slug'] ?? $key );
	$title = (string) ( $doc['title'] ?? $slug );

	if ( '' === $key || '' === $slug ) {
		$problems[] = 'thiếu `key` hoặc `slug`';
		return 0;
	}

	lasan_content_lang( (string) ( $doc['lang'] ?? '' ) );

	$blocks = array();
	foreach ( (array) ( $doc['blocks'] ?? array() ) as $entry ) {
		if ( is_array( $entry ) ) {
			$blocks[] = lasan_content_block( $entry, $problems );
		}
	}
	$content = implode( "\n\n", array_map( 'serialize_block', $blocks ) );

	$seo         = is_array( $doc['seo'] ?? null ) ? $doc['seo'] : array();
	$description = (string) ( $seo['description'] ?? '' );
	$existing    = lasan_content_find_page( $key );
	if ( ! $existing ) {
		$existing = lasan_content_find_page( $slug );
	}

	if ( $dry_run ) {
		printf(
			"  %s  %-14s %2d khối  %s\n",
			$existing ? 'cập nhật' : 'tạo mới',
			$key,
			count( $blocks ),
			$existing ? '#' . $existing : ''
		);
		return $existing;
	}

	$postarr = array(
		'ID'           => $existing,
		'post_type'    => 'page',
		'post_status'  => (string) ( $doc['status'] ?? 'publish' ),
		'post_title'   => $title,
		'post_name'    => $slug,
		'post_content' => $content,
		'post_excerpt' => $description,
	);

	$id = wp_insert_post( wp_slash( $postarr ), true );
	if ( is_wp_error( $id ) ) {
		$problems[] = $key . ': ' . $id->get_error_message();
		return 0;
	}
	$id = (int) $id;

	update_post_meta( $id, '_lasan_content_key', $key );
	update_post_meta( $id, '_lasan_meta_title', (string) ( $seo['title'] ?? $title ) );
	update_post_meta( $id, '_lasan_meta_description', $description );

	// The theme stands down from printing a title and a description whenever
	// Yoast is active, so on a site with Yoast the fields above are read by
	// nobody. Write its keys too and the JSON stays the one source either way.
	if ( defined( 'WPSEO_VERSION' ) ) {
		update_post_meta( $id, '_yoast_wpseo_title', (string) ( $seo['title'] ?? $title ) );
		update_post_meta( $id, '_yoast_wpseo_metadesc', $description );
	}

	if ( isset( $doc['parent'] ) ) {
		$parent = lasan_content_find_page( (string) $doc['parent'] );
		if ( $parent ) {
			wp_update_post( array( 'ID' => $id, 'post_parent' => $parent ) );
		} else {
			$problems[] = $key . ': không tìm thấy trang cha ' . $doc['parent'];
		}
	}

	// Language and translation links, when Polylang is active.
	$lang = (string) ( $doc['lang'] ?? '' );
	if ( '' !== $lang && function_exists( 'pll_set_post_language' ) ) {
		pll_set_post_language( $id, $lang );

		$source_ref = (string) ( $doc['translation_of'] ?? '' );
		if ( '' !== $source_ref && function_exists( 'pll_save_post_translations' ) ) {
			$source = lasan_content_find_page( $source_ref );
			if ( $source ) {
				$source_lang = pll_get_post_language( $source );
				pll_save_post_translations( array( $source_lang => $source, $lang => $id ) );
			} else {
				$problems[] = $key . ': không tìm thấy bản gốc ' . $source_ref;
			}
		}
	}

	if ( ! empty( $doc['front_page'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $id );
	}

	printf( "  ✓ %-14s #%-4d %2d khối  %s\n", $key, $id, count( $blocks ), get_permalink( $id ) );

	return $id;
}

/**
 * Field definitions for a post type, read from inc/fields/<name>.json — the
 * same file the editor loads, so the CLI never drifts from the admin UI.
 *
 * @return array<int, array<string, mixed>>
 */
function lasan_content_type_defs( string $post_type ): array {
	static $cache = array();
	if ( isset( $cache[ $post_type ] ) ) {
		return $cache[ $post_type ];
	}
	$file = get_stylesheet_directory() . "/inc/fields/{$post_type}.json";
	$json = is_file( $file ) ? json_decode( (string) file_get_contents( $file ), true ) : null;

	return $cache[ $post_type ] = ( is_array( $json ) && ! empty( $json['fields'] ) ) ? $json['fields'] : array();
}

/**
 * Apply a document describing posts of one type — the Dự án post type today.
 * Each entry is matched on its slug, so a re-run edits rather than duplicates.
 *
 * @param array<string, mixed> $doc
 * @param array<int, string>   $problems
 */
function lasan_content_apply_posts( array $doc, array &$problems, bool $dry_run = false ): void {
	$post_type = (string) ( $doc['post_type'] ?? '' );
	if ( '' === $post_type || ! post_type_exists( $post_type ) ) {
		$problems[] = "post type không tồn tại: {$post_type}";
		return;
	}

	$defs = lasan_content_type_defs( $post_type );
	lasan_content_lang( (string) ( $doc['lang'] ?? '' ) );

	foreach ( (array) ( $doc['posts'] ?? array() ) as $index => $entry ) {
		if ( ! is_array( $entry ) ) {
			continue;
		}
		$slug  = (string) ( $entry['slug'] ?? '' );
		$title = (string) ( $entry['title'] ?? '' );
		if ( '' === $slug || '' === $title ) {
			$problems[] = "{$post_type}: thiếu `slug` hoặc `title`";
			continue;
		}

		$found = get_posts(
			array(
				'post_type'      => $post_type,
				'post_status'    => 'any',
				'posts_per_page' => 1,
				'name'           => $slug,
				'lang'           => '',
			)
		);
		$id = $found ? (int) $found[0]->ID : 0;

		if ( $dry_run ) {
			printf( "  %s  %-34s %s\n", $id ? 'cập nhật' : 'tạo mới ', $slug, $id ? '#' . $id : '' );
			continue;
		}

		$id = (int) wp_insert_post(
			wp_slash(
				array(
					'ID'           => $id,
					'post_type'    => $post_type,
					'post_status'  => (string) ( $entry['status'] ?? 'publish' ),
					'post_title'   => $title,
					'post_name'    => $slug,
					'post_content' => (string) ( $entry['content'] ?? '' ),
					'post_excerpt' => (string) ( $entry['excerpt'] ?? '' ),
					'menu_order'   => (int) ( $entry['order'] ?? $index ),
				)
			),
			true
		);
		if ( ! $id ) {
			$problems[] = "{$slug}: không lưu được";
			continue;
		}

		// Featured image, by the media key the file was imported under.
		if ( ! empty( $entry['image']['media'] ) ) {
			$media_key = (string) $entry['image']['media'];
			$media_id  = lasan_content_media_id( $media_key );
			if ( $media_id ) {
				set_post_thumbnail( $id, $media_id );
			} else {
				$problems[] = "{$slug}: không có media `{$media_key}`";
			}
		}

		// Taxonomy terms are created on demand, so a new material needs no
		// separate setup step.
		foreach ( (array) ( $entry['terms'] ?? array() ) as $taxonomy => $names ) {
			if ( ! taxonomy_exists( (string) $taxonomy ) ) {
				$problems[] = "{$slug}: taxonomy không tồn tại {$taxonomy}";
				continue;
			}
			wp_set_object_terms( $id, array_map( 'strval', (array) $names ), (string) $taxonomy, false );
		}

		if ( $defs && isset( $entry['fields'] ) && is_array( $entry['fields'] ) ) {
			$values = lasan_content_resolve_links( $entry['fields'], $defs );
			foreach ( $values as $name => $value ) {
				if ( function_exists( 'update_field' ) ) {
					update_field( $name, $value, $id );
				} else {
					update_post_meta( $id, (string) $name, $value );
				}
			}
		}

		if ( '' !== (string) ( $doc['lang'] ?? '' ) && function_exists( 'pll_set_post_language' ) ) {
			pll_set_post_language( $id, (string) $doc['lang'] );
		}

		printf( "  ✓ %-34s #%-5d %s\n", $slug, $id, get_permalink( $id ) );
	}
}

/**
 * Apply one menu document: rebuild a nav menu from JSON and assign it to a
 * theme location. Items are recreated wholesale — a menu is small, and this
 * keeps the file the single source of truth.
 *
 * Polylang keys secondary-language locations as `<location>___<lang>`, so a
 * language-tagged document lands in the right slot.
 *
 * @param array<string, mixed> $doc
 * @param array<int, string>   $problems
 */
function lasan_content_apply_menu( array $doc, array &$problems, bool $dry_run = false ): void {
	$name     = (string) ( $doc['menu'] ?? '' );
	$location = (string) ( $doc['location'] ?? '' );
	$lang     = (string) ( $doc['lang'] ?? '' );
	if ( '' === $name ) {
		$problems[] = 'menu: thiếu `menu`';
		return;
	}
	lasan_content_lang( $lang );

	$count = 0;
	$walk  = static function ( array $items ) use ( &$walk, &$count ): void {
		foreach ( $items as $item ) {
			++$count;
			if ( ! empty( $item['children'] ) ) {
				$walk( (array) $item['children'] );
			}
		}
	};
	$walk( (array) ( $doc['items'] ?? array() ) );

	if ( $dry_run ) {
		printf( "  menu      %-28s %2d mục  → %s\n", $name, $count, $location ?: '(không gán)' );
		return;
	}

	$menu    = wp_get_nav_menu_object( $name );
	$menu_id = $menu ? (int) $menu->term_id : (int) wp_create_nav_menu( $name );
	if ( ! $menu_id ) {
		$problems[] = "menu: không tạo được {$name}";
		return;
	}

	foreach ( wp_get_nav_menu_items( $menu_id ) ?: array() as $existing ) {
		wp_delete_post( (int) $existing->ID, true );
	}

	/**
	 * Add one level of items, then recurse. A child without its own target
	 * inherits the parent's URL, which is what the mega panel's chips want.
	 */
	$add = static function ( array $items, int $parent_id, string $parent_url ) use ( &$add, $menu_id, &$problems, $lang ): void {
		foreach ( $items as $item ) {
			$label = (string) ( $item['label'] ?? '' );
			if ( '' === $label ) {
				continue;
			}

			$page_id = isset( $item['page'] ) ? lasan_content_find_page( (string) $item['page'] ) : 0;
			if ( isset( $item['page'] ) && ! $page_id ) {
				$problems[] = "menu: không tìm thấy trang {$item['page']}";
			}
			// A menu belongs to one language: point it at that language's page,
			// not at whichever page happens to carry the key.
			if ( $page_id && '' !== $lang && function_exists( 'pll_get_post' ) ) {
				$translated = pll_get_post( $page_id, $lang );
				if ( $translated ) {
					$page_id = (int) $translated;
				}
			}
			$url = $page_id ? (string) get_permalink( $page_id ) : (string) ( $item['url'] ?? $parent_url );
			if ( '' !== $url && ! preg_match( '#^(https?:)?//#', $url ) && ! str_starts_with( $url, '#' ) ) {
				$url = home_url( $url );
			}

			$id = wp_update_nav_menu_item(
				$menu_id,
				0,
				array(
					'menu-item-title'       => $label,
					'menu-item-status'      => 'publish',
					'menu-item-parent-id'   => $parent_id,
					'menu-item-description' => (string) ( $item['description'] ?? '' ),
					'menu-item-classes'     => implode( ' ', array_map( 'sanitize_html_class', (array) ( $item['classes'] ?? array() ) ) ),
					'menu-item-type'        => $page_id ? 'post_type' : 'custom',
					'menu-item-object'      => $page_id ? 'page' : '',
					'menu-item-object-id'   => $page_id,
					'menu-item-url'         => $page_id ? '' : $url,
				)
			);
			if ( is_wp_error( $id ) ) {
				$problems[] = "menu: {$label} — " . $id->get_error_message();
				continue;
			}

			if ( ! empty( $item['children'] ) ) {
				$add( (array) $item['children'], (int) $id, $url );
			}
		}
	};
	$add( (array) ( $doc['items'] ?? array() ), 0, home_url( '/' ) );

	if ( '' !== $location ) {
		$locations = (array) get_theme_mod( 'nav_menu_locations', array() );
		$default   = function_exists( 'pll_default_language' ) ? (string) pll_default_language() : '';
		$slot      = ( '' !== $lang && '' !== $default && $lang !== $default ) ? $location . '___' . $lang : $location;

		$locations[ $slot ] = $menu_id;
		set_theme_mod( 'nav_menu_locations', $locations );
	}

	if ( '' !== $lang && function_exists( 'pll_set_term_language' ) ) {
		pll_set_term_language( $menu_id, $lang );
	}

	printf( "  ✓ menu    %-28s %2d mục  → %s\n", $name, $count, $location ?: '(không gán)' );
}

/**
 * Read one page back out as an authored document.
 *
 * @return array<string, mixed>|null
 */
function lasan_content_dump( string $ref ): ?array {
	$id = lasan_content_find_page( $ref );
	if ( ! $id ) {
		return null;
	}
	$post = get_post( $id );
	if ( ! $post instanceof WP_Post ) {
		return null;
	}
	if ( function_exists( 'pll_get_post_language' ) ) {
		lasan_content_lang( (string) pll_get_post_language( $id ) );
	}

	$to_entry = static function ( array $block ) use ( &$to_entry ): ?array {
		$name = (string) ( $block['blockName'] ?? '' );
		if ( ! str_starts_with( $name, 'acf/' ) ) {
			return null;
		}
		$slug  = substr( $name, 4 );
		$data  = (array) ( $block['attrs']['data'] ?? array() );
		$defs  = lasan_content_defs( $slug );
		$entry = array( 'type' => $slug );
		if ( ! empty( $block['attrs']['anchor'] ) ) {
			$entry['anchor'] = (string) $block['attrs']['anchor'];
		}
		$entry['fields'] = lasan_content_pageify_links( lasan_content_unfill( $data, '', $defs ), $defs );
		$inner = array();
		foreach ( (array) ( $block['innerBlocks'] ?? array() ) as $child ) {
			$child_entry = $to_entry( (array) $child );
			if ( $child_entry ) {
				$inner[] = $child_entry;
			}
		}
		if ( $inner ) {
			$entry['inner'] = $inner;
		}

		return $entry;
	};

	$blocks = array();
	foreach ( parse_blocks( $post->post_content ) as $block ) {
		$entry = $to_entry( (array) $block );
		if ( $entry ) {
			$blocks[] = $entry;
		}
	}

	$doc = array(
		'key'   => (string) ( get_post_meta( $id, '_lasan_content_key', true ) ?: $post->post_name ),
		'title' => $post->post_title,
		'slug'  => $post->post_name,
	);
	if ( function_exists( 'pll_get_post_language' ) ) {
		$doc['lang'] = (string) pll_get_post_language( $id );

		// Only a secondary-language page records its source, so the pair is
		// declared once rather than from both sides.
		$default_lang = function_exists( 'pll_default_language' ) ? (string) pll_default_language() : '';
		$others = ( '' !== $default_lang && $doc['lang'] === $default_lang ) ? array() : (array) ( function_exists( 'pll_get_post_translations' ) ? pll_get_post_translations( $id ) : array() );
		foreach ( $others as $lang => $other ) {
			if ( (int) $other !== $id && (string) $lang !== $doc['lang'] ) {
				$other_key = (string) get_post_meta( (int) $other, '_lasan_content_key', true );
				if ( '' !== $other_key && ! isset( $doc['translation_of'] ) ) {
					$doc['translation_of'] = $other_key;
				}
			}
		}
	}
	if ( $post->post_parent ) {
		$doc['parent'] = (string) ( get_post_meta( $post->post_parent, '_lasan_content_key', true ) ?: get_post_field( 'post_name', $post->post_parent ) );
	}
	if ( (int) get_option( 'page_on_front' ) === $id ) {
		$doc['front_page'] = true;
	}
	$doc['seo']    = array(
		'title'       => (string) get_post_meta( $id, '_lasan_meta_title', true ),
		'description' => (string) get_post_meta( $id, '_lasan_meta_description', true ),
	);
	$doc['blocks'] = $blocks;

	return $doc;
}
