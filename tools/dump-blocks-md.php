<?php
/**
 * Write BLOCKS.md — every LASAN block with its ACF fields — straight from
 * blocks/<slug>/block.json and blocks/<slug>/<slug>.json, so the document
 * cannot drift from the field groups the theme actually registers.
 *
 * Needs no WordPress. Run from the WordPress root:
 *   php tools/dump-blocks-md.php
 */

declare(strict_types=1);

$theme     = dirname( __DIR__ ) . '/wp-content/themes/starter-flexible';
$blocks_dir = $theme . '/blocks';

if ( ! is_dir( $blocks_dir ) ) {
	fwrite( STDERR, "Cannot locate the blocks directory\n" );
	exit( 1 );
}

/** @return array<string, mixed>|null */
function bd_json( string $file ): ?array {
	if ( ! is_file( $file ) ) {
		return null;
	}
	$decoded = json_decode( (string) file_get_contents( $file ), true );

	return is_array( $decoded ) ? $decoded : null;
}

/**
 * The field group for a block: the one JSON file beside block.json that
 * carries a `fields` array.
 *
 * @return array{0: array<int, array<string, mixed>>, 1: string}
 */
function bd_fields( string $block_folder ): array {
	foreach ( glob( $block_folder . '/*.json' ) ?: array() as $file ) {
		if ( 'block.json' === basename( $file ) ) {
			continue;
		}
		$group = bd_json( $file );
		if ( $group && ! empty( $group['fields'] ) && is_array( $group['fields'] ) ) {
			return array( $group['fields'], (string) ( $group['key'] ?? '' ) );
		}
	}

	return array( array(), '' );
}

/** The right-hand column: what an editor needs to know about one field. */
function bd_note( array $def ): string {
	$type = (string) ( $def['type'] ?? '' );
	$bits = array();

	if ( 'select' === $type && ! empty( $def['choices'] ) && is_array( $def['choices'] ) ) {
		$keys = array_map(
			static function ( $key ): string {
				return '`' . $key . '`';
			},
			array_keys( $def['choices'] )
		);
		$bits[] = 'Chọn: ' . implode( ', ', $keys );
	}

	if ( in_array( $type, array( 'image', 'file' ), true ) ) {
		$bits[] = 'Trả về `' . ( $def['return_format'] ?? 'array' ) . '`';
	}

	if ( 'link' === $type ) {
		$bits[] = 'Trả về mảng `url` / `title` / `target`';
	}

	if ( 'repeater' === $type ) {
		$limits = array();
		if ( ! empty( $def['min'] ) ) {
			$limits[] = 'tối thiểu ' . (int) $def['min'];
		}
		if ( ! empty( $def['max'] ) ) {
			$limits[] = 'tối đa ' . (int) $def['max'];
		}
		$bits[] = 'Repeater' . ( $limits ? ' — ' . implode( ', ', $limits ) : '' );
	}

	$default = $def['default_value'] ?? null;
	if ( null !== $default && '' !== $default && array() !== $default ) {
		$bits[] = 'Mặc định `' . ( is_bool( $default ) ? ( $default ? '1' : '0' ) : $default ) . '`';
	}

	if ( ! empty( $def['required'] ) ) {
		$bits[] = '**Bắt buộc**';
	}

	$instructions = trim( (string) ( $def['instructions'] ?? '' ) );
	if ( '' !== $instructions ) {
		$bits[] = $instructions;
	}

	return implode( ' · ', $bits );
}

/**
 * Flatten a field group into table rows. Repeater sub-fields follow their
 * parent, addressed as `parent[].child` the way a template reads them.
 *
 * @param array<int, array<string, mixed>> $defs
 *
 * @return array<int, array{0:string,1:string,2:string,3:string}>
 */
function bd_rows( array $defs ): array {
	$rows = array();

	foreach ( $defs as $def ) {
		$type = (string) ( $def['type'] ?? '' );
		$name = (string) ( $def['name'] ?? '' );

		// Tabs and messages are chrome; custom_class and the spacing pair are
		// documented once in the preamble instead of on every block.
		if ( in_array( $type, array( 'tab', 'message' ), true ) || 'custom_class' === $name ) {
			continue;
		}

		$rows[] = array(
			(string) ( $def['label'] ?? $name ),
			'' !== $name ? '`' . $name . '`' : '',
			'`' . $type . '`',
			bd_note( $def ),
		);

		foreach ( (array) ( $def['sub_fields'] ?? array() ) as $sub ) {
			$sub_type = (string) ( $sub['type'] ?? '' );
			if ( in_array( $sub_type, array( 'tab', 'message' ), true ) ) {
				continue;
			}
			$rows[] = array(
				'↳ ' . (string) ( $sub['label'] ?? ( $sub['name'] ?? '' ) ),
				'`' . $name . '[].' . (string) ( $sub['name'] ?? '' ) . '`',
				'`' . $sub_type . '`',
				bd_note( $sub ),
			);
		}
	}

	return $rows;
}

$slugs = array_map( 'basename', glob( $blocks_dir . '/*', GLOB_ONLYDIR ) ?: array() );
sort( $slugs );

$out = array();
$out[] = '# Danh sách khối — LASAN Marine';
$out[] = '';
$out[] = 'Sinh tự động từ `blocks/<slug>/block.json` và `blocks/<slug>/<slug>.json`.';
$out[] = 'Chạy lại `php tools/dump-blocks-md.php` sau khi sửa field.';
$out[] = '';
$out[] = 'Mọi khối đều có thêm ba field dùng chung, không lặp lại trong các bảng bên dưới:';
$out[] = '';
$out[] = '| Field | Name | Type | Ghi chú |';
$out[] = '| --- | --- | --- | --- |';
$out[] = '| Custom Class | `custom_class` | `text` | Class thêm vào thẻ bọc ngoài của khối |';
$out[] = '| Padding Top | `padding_top` | `number` | Tab **Khoảng cách**. Để trống thì dùng khoảng cách mặc định của khối |';
$out[] = '| Padding Bottom | `padding_bottom` | `number` | Tab **Khoảng cách** |';
$out[] = '';
$out[] = 'Mọi khối cũng đều bật `anchor` — ô **HTML Anchor** của trình soạn thảo.';
$out[] = '';
$out[] = '---';
$out[] = '';
$out[] = '## Mục lục';
$out[] = '';

$blocks = array();
foreach ( $slugs as $slug ) {
	$config = bd_json( $blocks_dir . '/' . $slug . '/block.json' );
	if ( ! $config || empty( $config['name'] ) ) {
		continue;
	}
	$blocks[ $slug ] = $config;
	$out[] = sprintf( '- [%s](#%s) — `acf/%s`', (string) ( $config['title'] ?? $slug ), $slug, $slug );
}

$out[] = '';
$out[] = '---';
$out[] = '';

foreach ( $blocks as $slug => $config ) {
	$folder = $blocks_dir . '/' . $slug;
	list( $defs, $group_key ) = bd_fields( $folder );

	$out[] = '<a id="' . $slug . '"></a>';
	$out[] = '## ' . (string) ( $config['title'] ?? $slug );
	$out[] = '';
	$out[] = '`acf/' . $slug . '` · `blocks/' . $slug . '/`' . ( '' !== $group_key ? ' · field group `' . $group_key . '`' : '' );

	$description = trim( (string) ( $config['description'] ?? '' ) );
	if ( '' !== $description ) {
		$out[] = '';
		$out[] = $description;
	}

	$traits = array();
	if ( ! empty( $config['align'] ) ) {
		$traits[] = 'Căn `' . $config['align'] . '` — băng tràn hết khổ';
	}
	if ( ! empty( $config['supports']['jsx'] ) ) {
		$traits[] = 'Nhận khối con (InnerBlocks)';
	}
	if ( is_file( $folder . '/assets/script.js' ) ) {
		$traits[] = 'Có JavaScript riêng';
	}
	if ( $traits ) {
		$out[] = '';
		$out[] = '> ' . implode( ' · ', $traits );
	}

	$out[] = '';

	$rows = bd_rows( $defs );
	if ( ! $rows ) {
		$out[] = '_Không có field riêng._';
	} else {
		$out[] = '| Field | Name | Type | Ghi chú |';
		$out[] = '| --- | --- | --- | --- |';
		foreach ( $rows as $row ) {
			$out[] = '| ' . implode( ' | ', $row ) . ' |';
		}
	}

	$out[] = '';
	$out[] = '---';
	$out[] = '';
}

$target = $theme . '/BLOCKS.md';
file_put_contents( $target, implode( "\n", $out ) );

printf( "BLOCKS.md — %d khối: %s\n", count( $blocks ), $target );
