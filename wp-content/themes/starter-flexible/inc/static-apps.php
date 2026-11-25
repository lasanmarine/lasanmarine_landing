<?php
/**
 * Static apps (the browser tools: simulators, calculators) shown by the App
 * Embed block and the full-screen app template.
 *
 * The apps and their versions live in the Lasan Static Apps plugin (builds in
 * wp-content/plugins/lasan-static-apps/apps/, or uploaded in Admin → App tĩnh).
 * Without the plugin the tool pages show no app.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** URL of the version of an app in use, '' if none. */
function starter_flexible_app_src( string $slug ): string {
	$slug = sanitize_key( $slug );
	return '' !== $slug && function_exists( 'lasan_static_app_url' ) ? lasan_static_app_url( $slug ) : '';
}

// The App Embed block's picker lists the installed apps instead of a fixed list.
add_filter(
	'acf/load_field/key=field_ae_app',
	static function ( $field ) {
		$choices = function_exists( 'lasan_static_apps' ) ? lasan_static_apps() : array();
		if ( $choices ) {
			asort( $choices );
			$field['choices'] = $choices;
		}
		return $field;
	}
);

/**
 * Cards for a tools hub: the page's child pages that run an app (template
 * "Ứng dụng toàn màn hình") and are not in the hand-written list yet. A tool
 * page made for an uploaded app (Admin → App tĩnh → "Tạo trang công cụ")
 * shows in /cong-cu/ without editing the hub.
 *
 * @param array<int, array<string, mixed>> $items Cards already on the page (with 'url').
 * @return array<int, array<string, mixed>> Cards to add.
 */
function starter_flexible_app_page_cards( array $items ): array {
	$hub = is_page() ? (int) get_queried_object_id() : 0;
	if ( ! $hub ) {
		return array();
	}
	$listed = array();
	foreach ( $items as $item ) {
		$path = (string) wp_parse_url( (string) ( $item['url'] ?? '' ), PHP_URL_PATH );
		if ( '' !== $path ) {
			$listed[ untrailingslashit( $path ) ] = true;
		}
	}
	$pages = get_pages(
		array(
			'parent'      => $hub,
			'post_status' => 'publish',
			'meta_key'    => '_wp_page_template', // phpcs:ignore WordPress.DB.SlowDBQuery
			'meta_value'  => 'page-app.php', // phpcs:ignore WordPress.DB.SlowDBQuery
			'sort_column' => 'menu_order,post_date',
		)
	);
	$en    = function_exists( 'pll_get_post_language' ) && 'en' === pll_get_post_language( $hub );
	$cards = array();
	$n     = count( $items );
	foreach ( $pages as $page ) {
		$url = (string) get_permalink( $page );
		if ( isset( $listed[ untrailingslashit( (string) wp_parse_url( $url, PHP_URL_PATH ) ) ] ) ) {
			continue;
		}
		$cards[] = array(
			'index'    => sprintf( '%02d', ++$n ),
			'icon'     => 'compass',
			'name'     => get_the_title( $page ),
			'desc'     => (string) $page->post_excerpt,
			'url'      => $url,
			'cta'      => $en ? 'Open the tool' : 'Mở công cụ',
			'target'   => '_self',
			'children' => array(),
		);
	}
	return $cards;
}
