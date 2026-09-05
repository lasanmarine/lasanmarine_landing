<?php
/**
 * Theme supports, menus, and setup.
 *
 * @package Starter_Flexible
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function starter_flexible_setup(): void {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );

	add_theme_support(
		'custom-logo',
		array(
			'height'      => 100,
			'width'       => 400,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		)
	);

	register_nav_menus(
		array(
			'header_menu' => __( 'Header Menu', 'starter-flexible' ),
			'footer_menu' => __( 'Footer Menu', 'starter-flexible' ),
		)
	);
}
add_action( 'after_setup_theme', 'starter_flexible_setup' );

function starter_flexible_nav_menu_link_attributes( array $atts, $menu_item, $args ): array {
	if ( ! isset( $args->menu_id ) ) {
		return $atts;
	}

	$class_map = array(
		'primary-menu'        => 'site-nav__link',
		'mobile-primary-menu' => 'site-mobile-drawer__link',
		'footer-menu'         => 'site-footer__link',
	);

	$menu_id = (string) $args->menu_id;
	if ( ! isset( $class_map[ $menu_id ] ) ) {
		return $atts;
	}

	$current_class = isset( $atts['class'] ) ? trim( (string) $atts['class'] ) : '';
	$atts['class'] = trim( $current_class . ' ' . $class_map[ $menu_id ] );

	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'starter_flexible_nav_menu_link_attributes', 10, 3 );

/**
 * Arm the reveals before first paint; dropped again if the script never runs.
 *
 * Ported from the inline snippet in the Astro site's BaseLayout.
 */
function starter_flexible_print_reveal_primer(): void {
	$js = <<<'JS'
(function () {
	if (
		window.matchMedia('(prefers-reduced-motion: reduce)').matches ||
		!('IntersectionObserver' in window)
	)
		return;
	var root = document.documentElement;
	root.classList.add('reveal-on');
	setTimeout(function () {
		if (!window.__revealReady) root.classList.remove('reveal-on');
	}, 2500);
})();
JS;

	wp_print_inline_script_tag( $js );
}
add_action( 'wp_head', 'starter_flexible_print_reveal_primer', 1 );

/** Keep the Astro page titles and descriptions after moving content to WP. */
function starter_flexible_lasan_document_title( string $title ): string {
	if ( defined( 'WPSEO_VERSION' ) ) {
		return $title;
	}

	if ( ! is_singular( 'page' ) ) {
		return $title;
	}

	$ported_title = (string) get_post_meta( get_queried_object_id(), '_lasan_meta_title', true );
	return '' !== trim( $ported_title ) ? $ported_title : $title;
}
add_filter( 'pre_get_document_title', 'starter_flexible_lasan_document_title' );

function starter_flexible_lasan_meta_description(): void {
	if ( defined( 'WPSEO_VERSION' ) ) {
		return;
	}

	if ( ! is_singular( 'page' ) ) {
		return;
	}

	$description = (string) get_post_meta( get_queried_object_id(), '_lasan_meta_description', true );
	if ( '' !== trim( $description ) ) {
		echo '<meta name="description" content="' . esc_attr( $description ) . '">' . "\n";
	}
}
add_action( 'wp_head', 'starter_flexible_lasan_meta_description', 2 );
