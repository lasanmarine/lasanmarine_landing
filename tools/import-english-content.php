<?php
/**
 * Clone the Vietnamese Lasan content into English and connect it in Polylang.
 *
 * Run from the WordPress root: php tools/import-english-content.php
 */

declare(strict_types=1);

$wp_load = dirname(__DIR__) . '/wp-load.php';
if ( ! is_file( $wp_load ) ) {
	fwrite( STDERR, "Cannot locate wp-load.php\n" );
	exit( 1 );
}
$_SERVER['HTTP_HOST']   = $_SERVER['HTTP_HOST'] ?? 'localhost:49731';
$_SERVER['REQUEST_URI'] = $_SERVER['REQUEST_URI'] ?? '/';
require_once $wp_load;

if ( ! function_exists( 'pll_set_post_language' ) || ! function_exists( 'pll_save_post_translations' ) ) {
	fwrite( STDERR, "Polylang must be active.\n" );
	exit( 1 );
}

const LASAN_SOURCE_LANG = 'vi';
const LASAN_TARGET_LANG = 'en';

$slug_map = array(
	'trang-chu'                         => 'home',
	'gioi-thieu'                        => 'about-us',
	'nang-luc'                          => 'capabilities',
	'thiet-ke-tau' => 'ship-design',
	'thiet-ke-tau-ca'                   => 'fishing-vessel-design',
	'phuong-tien-thuy-noi-dia'          => 'inland-waterway-vessel-design',
	'dich-vu-cntt'                      => 'information-technology-services',
	'du-an'                             => 'projects',
	'tin-tuc'                           => 'insights',
	'tuyen-dung'                        => 'careers',
	'lien-he'                           => 'contact',
	'cong-cu'                           => 'tools',
	'chuyen-doi-cong-suat'              => 'power-converter',
	'kiem-tra-duong-kinh-truc-chan-vit' => 'propeller-shaft-diameter',
	'tra-cuu-dong-co'                   => 'engine-lookup',
);

/** @var array<string, string> $translation_cache */
$translation_cache = array(
	'Trang chủ' => 'Home',
	'Giới thiệu' => 'About Us',
	'Năng lực' => 'Capabilities',
	'Dự án' => 'Projects',
	'Tin tức' => 'Insights',
	'Tuyển dụng' => 'Careers',
	'Liên hệ' => 'Contact',
	'Công cụ' => 'Tools',
	'Dịch vụ' => 'Services',
	'Dịch vụ CNTT' => 'Information Technology Services',
	'Thiết kế tàu' => 'Ship Design',
	'Thiết kế tàu cá' => 'Fishing Vessel Design',
	'Thiết kế phương tiện thủy nội địa' => 'Inland Waterway Vessel Design',
	'Đường kính trục chân vịt' => 'Propeller Shaft Diameter',
	'Chuyển đổi công suất' => 'Power Converter',
	'Tra cứu động cơ' => 'Engine Lookup',
	'GIỚI THIỆU' => 'ABOUT US',
	'DỊCH VỤ' => 'SERVICES',
	'DỰ ÁN' => 'PROJECTS',
	'BÀI VIẾT' => 'INSIGHTS',
	'CÔNG CỤ' => 'TOOLS',
	'Dịch vụ thiết kế tàu cá' => 'Fishing Vessel Design',
	'Dịch vụ thiết kế phương tiện thủy nội địa' => 'Inland Waterway Vessel Design',
	'SỐ ĐIỆN THOẠI' => 'PHONE NUMBER',
);

function lasan_en_should_translate( string $value, $key = null ): bool {
	$value = trim( $value );
	if ( '' === $value || in_array( (string) $key, array( 'url', 'href', 'target', 'icon', 'id', 'index', 'email', 'phone', 'maps_api_key' ), true ) ) {
		return false;
	}
	if ( preg_match( '#^(?:https?://|mailto:|tel:|/|\#)#', $value ) || is_email( $value ) ) {
		return false;
	}
	if ( preg_match( '/^[\d\s.,:+\-–—%\/|()]+$/u', $value ) ) {
		return false;
	}
	return true;
}

/** Collect unique translatable strings from block attributes. */
function lasan_en_collect_strings( $value, array &$strings, $key = null ): void {
	if ( is_array( $value ) ) {
		foreach ( $value as $child_key => $child ) {
			lasan_en_collect_strings( $child, $strings, $child_key );
		}
		return;
	}
	if ( is_string( $value ) && lasan_en_should_translate( $value, $key ) ) {
		$strings[ $value ] = true;
	}
}

/** Translate plain text with Google's public translation endpoint. */
function lasan_en_translate_text( string $text, bool $html = false ): string {
	global $translation_cache;
	if ( ! $html && isset( $translation_cache[ $text ] ) ) {
		return $translation_cache[ $text ];
	}

	$query = http_build_query(
		array(
			'client' => 'gtx',
			'sl'     => LASAN_SOURCE_LANG,
			'tl'     => LASAN_TARGET_LANG,
			'dt'     => 't',
			'q'      => $text,
		)
	);
	$ch = curl_init( 'https://translate.googleapis.com/translate_a/single' );
	curl_setopt_array( $ch, array( CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 45, CURLOPT_USERAGENT => 'Lasan-English-Importer/1.0', CURLOPT_POST => true, CURLOPT_POSTFIELDS => $query ) );
	$body = curl_exec( $ch );
	$code = (int) curl_getinfo( $ch, CURLINFO_RESPONSE_CODE );
	curl_close( $ch );
	if ( 200 !== $code || ! is_string( $body ) ) {
		throw new RuntimeException( 'Translation request failed with HTTP ' . $code );
	}
	$decoded = json_decode( $body, true );
	$translated = '';
	foreach ( (array) ( $decoded[0] ?? array() ) as $part ) {
		$translated .= (string) ( $part[0] ?? '' );
	}
	if ( '' === $translated ) {
		throw new RuntimeException( 'Translation service returned an empty result.' );
	}
	if ( ! $html ) {
		$translation_cache[ $text ] = $translated;
	}
	return $translated;
}

/** Warm the translation cache in compact batches to avoid API rate limits. */
function lasan_en_translate_batch( array $strings ): void {
	global $translation_cache;
	$pending = array_values( array_filter( $strings, static fn( string $value ): bool => ! isset( $translation_cache[ $value ] ) ) );
	$batches = array();
	$batch = array();
	$length = 0;
	foreach ( $pending as $string ) {
		if ( $batch && $length + strlen( $string ) > 2800 ) {
			$batches[] = $batch;
			$batch = array();
			$length = 0;
		}
		$batch[] = $string;
		$length += strlen( $string ) + 32;
	}
	if ( $batch ) {
		$batches[] = $batch;
	}

	foreach ( $batches as $index => $values ) {
		$separator = "\n<<<LASAN_SPLIT_7F3A>>>\n";
		$translated = lasan_en_translate_text( implode( $separator, $values ), true );
		$parts = preg_split( '/\s*<<<LASAN_SPLIT_7F3A>>>\s*/', $translated );
		if ( count( $parts ) !== count( $values ) ) {
			throw new RuntimeException( 'Translation batch separator was not preserved.' );
		}
		foreach ( $values as $part_index => $source ) {
			$translation_cache[ $source ] = trim( (string) $parts[ $part_index ] );
		}
		echo 'Translated batch ' . ( $index + 1 ) . '/' . count( $batches ) . "...\n";
		if ( $index + 1 < count( $batches ) ) {
			sleep( 1 );
		}
	}
}

function lasan_en_translate_value( $value, $key = null ) {
	global $translation_cache;
	if ( is_array( $value ) ) {
		foreach ( $value as $child_key => $child ) {
			$value[ $child_key ] = lasan_en_translate_value( $child, $child_key );
		}
		return $value;
	}
	if ( is_string( $value ) && lasan_en_should_translate( $value, $key ) ) {
		return $translation_cache[ $value ] ?? lasan_en_translate_text( $value );
	}
	return $value;
}

function lasan_en_translate_blocks( string $content ): string {
	$blocks = parse_blocks( $content );
	$translate = static function ( array $blocks ) use ( &$translate ): array {
		foreach ( $blocks as &$block ) {
			if ( isset( $block['attrs']['data'] ) ) {
				$block['attrs']['data'] = lasan_en_translate_value( $block['attrs']['data'] );
			}
			if ( ! empty( $block['innerBlocks'] ) ) {
				$block['innerBlocks'] = $translate( $block['innerBlocks'] );
			}
		}
		unset( $block );
		return $blocks;
	};
	return implode( "\n\n", array_map( 'serialize_block', $translate( $blocks ) ) );
}

function lasan_en_source_posts( string $post_type ): array {
	$args = array(
			'post_type'        => $post_type,
			'post_status'      => 'publish',
			'posts_per_page'   => -1,
			'orderby'          => 'ID',
			'order'            => 'ASC',
			'lang'             => LASAN_SOURCE_LANG,
			'suppress_filters' => false,
		);
	if ( 'post' === $post_type ) {
		$args['meta_query'] = array( array( 'key' => '_lasan_content_key', 'compare' => 'EXISTS' ) );
	}
	return get_posts( $args );
}

$source_pages = lasan_en_source_posts( 'page' );
$source_posts = lasan_en_source_posts( 'post' );
$strings = array();
foreach ( array_merge( $source_pages, $source_posts ) as $source ) {
	lasan_en_collect_strings( $source->post_title, $strings, 'title' );
	lasan_en_collect_strings( $source->post_excerpt, $strings, 'excerpt' );
	if ( 'page' === $source->post_type ) {
		foreach ( parse_blocks( $source->post_content ) as $block ) {
			lasan_en_collect_strings( $block['attrs']['data'] ?? array(), $strings );
		}
	}
}

// Warm the cache before writing anything, so a service failure cannot leave a
// partially imported English site.
lasan_en_translate_batch( array_keys( $strings ) );

$english_ids = array();
foreach ( $source_pages as $source ) {
	$translations = pll_get_post_translations( $source->ID );
	$existing_id = isset( $translations[ LASAN_TARGET_LANG ] ) ? (int) $translations[ LASAN_TARGET_LANG ] : 0;
	$slug = $slug_map[ $source->post_name ] ?? sanitize_title( lasan_en_translate_text( $source->post_title ) );
	$postarr = array(
		'ID'           => $existing_id,
		'post_type'    => 'page',
		'post_status'  => 'publish',
		'post_title'   => lasan_en_translate_text( $source->post_title ),
		'post_name'    => $slug,
		'post_excerpt' => lasan_en_translate_text( $source->post_excerpt ?: $source->post_title ),
		'post_content' => lasan_en_translate_blocks( $source->post_content ),
		'post_parent'  => 0,
	);
	$target_id = wp_insert_post( wp_slash( $postarr ), true );
	if ( is_wp_error( $target_id ) ) {
		throw new RuntimeException( $target_id->get_error_message() );
	}
	$target_id = (int) $target_id;
	pll_set_post_language( $target_id, LASAN_TARGET_LANG );
	pll_save_post_translations( array( LASAN_SOURCE_LANG => $source->ID, LASAN_TARGET_LANG => $target_id ) );
	update_post_meta( $target_id, '_lasan_english_source_id', $source->ID );
	update_post_meta( $target_id, '_lasan_meta_title', lasan_en_translate_text( (string) get_post_meta( $source->ID, '_lasan_meta_title', true ) ?: $source->post_title ) );
	update_post_meta( $target_id, '_lasan_meta_description', lasan_en_translate_text( (string) get_post_meta( $source->ID, '_lasan_meta_description', true ) ?: $source->post_excerpt ) );
	$english_ids[ $source->ID ] = $target_id;
}

foreach ( $source_pages as $source ) {
	if ( $source->post_parent && isset( $english_ids[ $source->post_parent ], $english_ids[ $source->ID ] ) ) {
		wp_update_post( array( 'ID' => $english_ids[ $source->ID ], 'post_parent' => $english_ids[ $source->post_parent ] ) );
	}
}

foreach ( $source_posts as $source ) {
	$translations = pll_get_post_translations( $source->ID );
	$existing_id = isset( $translations[ LASAN_TARGET_LANG ] ) ? (int) $translations[ LASAN_TARGET_LANG ] : 0;
	$target_id = wp_insert_post(
		wp_slash(
			array(
				'ID'           => $existing_id,
				'post_type'    => 'post',
				'post_status'  => 'publish',
				'post_title'   => lasan_en_translate_text( $source->post_title ),
				'post_name'    => sanitize_title( lasan_en_translate_text( $source->post_title ) ),
				'post_excerpt' => lasan_en_translate_text( $source->post_excerpt ?: $source->post_title ),
				'post_content' => lasan_en_translate_text( $source->post_content, true ),
				'post_date'    => $source->post_date,
			)
		),
		true
	);
	if ( is_wp_error( $target_id ) ) {
		throw new RuntimeException( $target_id->get_error_message() );
	}
	$target_id = (int) $target_id;
	pll_set_post_language( $target_id, LASAN_TARGET_LANG );
	pll_save_post_translations( array( LASAN_SOURCE_LANG => $source->ID, LASAN_TARGET_LANG => $target_id ) );
	update_post_meta( $target_id, '_lasan_english_source_id', $source->ID );
}

// Rebuild English links after every target slug and parent relationship exists.
foreach ( $english_ids as $source_id => $target_id ) {
	$content = (string) get_post_field( 'post_content', $target_id );
	foreach ( $english_ids as $linked_source_id => $linked_target_id ) {
		$content = str_replace( get_permalink( $linked_source_id ), get_permalink( $linked_target_id ), $content );
	}
	wp_update_post( wp_slash( array( 'ID' => $target_id, 'post_content' => $content ) ) );
}

$nav_menus = (array) PLL()->options->get( 'nav_menus' );
foreach ( array( 'header_menu' => 'LASAN Header', 'footer_menu' => 'LASAN Footer' ) as $location => $source_name ) {
	$source_menu = wp_get_nav_menu_object( $source_name );
	$target_name = $source_name . ' EN';
	$target_menu = wp_get_nav_menu_object( $target_name );
	$menu_id = $target_menu ? (int) $target_menu->term_id : (int) wp_create_nav_menu( $target_name );
	foreach ( wp_get_nav_menu_items( $menu_id ) ?: array() as $item ) {
		wp_delete_post( (int) $item->ID, true );
	}
	$menu_item_ids = array();
	foreach ( wp_get_nav_menu_items( (int) $source_menu->term_id ) ?: array() as $item ) {
		$target_object_id = $english_ids[ (int) $item->object_id ] ?? 0;
		$new_id = wp_update_nav_menu_item( $menu_id, 0, array(
			'menu-item-title' => lasan_en_translate_text( $item->title ), 'menu-item-status' => 'publish',
			'menu-item-type' => $target_object_id ? 'post_type' : 'custom', 'menu-item-object' => $target_object_id ? 'page' : '',
			'menu-item-object-id' => $target_object_id, 'menu-item-url' => $target_object_id ? '' : $item->url,
			'menu-item-parent-id' => $menu_item_ids[ (int) $item->menu_item_parent ] ?? 0,
			'menu-item-classes' => implode( ' ', array_filter( (array) $item->classes ) ),
		) );
		if ( ! is_wp_error( $new_id ) ) $menu_item_ids[ $item->ID ] = (int) $new_id;
	}
	$nav_menus[ get_stylesheet() ][ $location ][ LASAN_TARGET_LANG ] = $menu_id;
}
PLL()->options->set( 'nav_menus', $nav_menus );

$vi_front = (int) get_option( 'page_on_front' );
if ( isset( $english_ids[ $vi_front ] ) ) {
	PLL()->options->set( 'page_on_front', array( LASAN_SOURCE_LANG => $vi_front, LASAN_TARGET_LANG => $english_ids[ $vi_front ] ) );
}

flush_rewrite_rules();
echo 'Imported ' . count( $source_pages ) . ' English pages and ' . count( $source_posts ) . " English posts.\n";
