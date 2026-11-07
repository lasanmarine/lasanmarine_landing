<?php
/**
 * Font preload — the woff2 files the first screen draws with start
 * downloading with the HTML instead of after the stylesheet, so the web fonts
 * replace the fallback sooner and the text jumps less on a slow connection.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Both families in the Latin and Vietnamese subsets, at the weight body copy
 * uses.
 *
 * @return string[] File names in fe/dist.
 */
function starter_flexible_critical_fonts(): array {
	return array(
		'manrope-latin-wght-normal.woff2',
		'manrope-vietnamese-wght-normal.woff2',
		'be-vietnam-pro-latin-400-normal.woff2',
		'be-vietnam-pro-vietnamese-400-normal.woff2',
	);
}

function starter_flexible_preload_fonts(): void {
	if ( is_admin() || ( function_exists( 'starter_flexible_vite_is_dev_mode' ) && starter_flexible_vite_is_dev_mode() ) ) {
		return;
	}

	$dist = get_stylesheet_directory() . '/fe/dist/';
	$uri  = get_stylesheet_directory_uri() . '/fe/dist/';
	foreach ( starter_flexible_critical_fonts() as $font ) {
		if ( is_file( $dist . $font ) ) {
			printf( '<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n", esc_url( $uri . $font ) );
		}
	}
}
add_action( 'wp_head', 'starter_flexible_preload_fonts', 0 );
