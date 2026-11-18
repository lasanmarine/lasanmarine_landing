<?php
/**
 * WP Accessibility (plugin) in this theme's languages.
 *
 * The plugin ships no Vietnamese translation, so its toolbar buttons would
 * read in English on the Vietnamese site. Its few visitor-facing strings are
 * translated here; English pages keep the plugin's own wording.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter(
	'gettext_wp-accessibility',
	static function ( $translation, $text ) {
		if ( function_exists( 'pll_current_language' ) && 'en' === pll_current_language( 'slug' ) ) {
			return $translation;
		}
		static $vi = array(
			'Toggle High Contrast'  => 'Bật/tắt tương phản cao',
			'Toggle Grayscale'      => 'Bật/tắt thang xám',
			'Toggle Font size'      => 'Phóng to/thu nhỏ chữ',
			'Accessibility Toolbar' => 'Công cụ hỗ trợ tiếp cận',
			'Accessibility'         => 'Hỗ trợ tiếp cận',
		);
		return $vi[ $text ] ?? $translation;
	},
	10,
	2
);

/*
 * The toolbar's look comes from the theme (fe/src/styles/layout/_a11y-toolbar.scss),
 * not from the plugin's a11y.css: that file draws grey boxes unlike the rest
 * of the site, loads an icon font for two glyphs, and sets
 * `body * { transition: font-size .3s }` — a transition on every element of
 * the page, which also re-laid the whole page out on every frame of a font
 * size change. Its font-size and contrast stylesheets stay.
 */
add_action(
	'wp_enqueue_scripts',
	static function () {
		wp_dequeue_style( 'wpa-toolbar' );
		wp_dequeue_style( 'ui-font' );
	},
	100
);
