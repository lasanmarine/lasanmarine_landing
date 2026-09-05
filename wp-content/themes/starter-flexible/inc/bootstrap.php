<?php
/**
 * Theme bootstrap (loads all theme modules).
 *
 * @package Starter_Flexible
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'STARTER_FLEXIBLE_THEME_DIR' ) ) {
	define( 'STARTER_FLEXIBLE_THEME_DIR', get_stylesheet_directory() );
}
if ( ! defined( 'STARTER_FLEXIBLE_THEME_URI' ) ) {
	define( 'STARTER_FLEXIBLE_THEME_URI', get_stylesheet_directory_uri() );
}
if ( ! defined( 'STARTER_FLEXIBLE_THEME_VERSION' ) ) {
	define( 'STARTER_FLEXIBLE_THEME_VERSION', wp_get_theme()->get( 'Version' ) );
}

require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/icons.php';
require_once __DIR__ . '/vite.php';
require_once __DIR__ . '/assets.php';
require_once __DIR__ . '/media.php';
require_once __DIR__ . '/media-webp.php';
require_once __DIR__ . '/site-settings.php';
require_once __DIR__ . '/navigation.php';
require_once __DIR__ . '/theme.php';
require_once __DIR__ . '/widgets.php';
require_once __DIR__ . '/blocks.php';
require_once __DIR__ . '/seo-analysis.php';
require_once __DIR__ . '/service-redirects.php';
