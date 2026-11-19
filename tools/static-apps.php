<?php
/**
 * Turn on Lasan Static Apps and import the apps that ship in the theme —
 * the same as the "Nhập các app này" button, for a server without a browser.
 *
 *   WP_PATH=/home/lasanmarinecom/lasanmarine.com WP_HOME=https://lasanmarine.com php ~/lasan-tools/static-apps.php
 *
 * @package Starter_Flexible
 */

if ( 'cli' !== PHP_SAPI ) {
	exit( 1 );
}

$home = (string) ( getenv( 'WP_HOME' ) ?: 'http://localhost' );
$_SERVER['HTTP_HOST']   = parse_url( $home, PHP_URL_HOST ) . ( parse_url( $home, PHP_URL_PORT ) ? ':' . parse_url( $home, PHP_URL_PORT ) : '' );
$_SERVER['REQUEST_URI'] = '/';
if ( str_starts_with( $home, 'https://' ) ) {
	$_SERVER['HTTPS'] = 'on';
}
define( 'WP_ADMIN', true );
error_reporting( E_ALL & ~E_DEPRECATED & ~E_NOTICE & ~E_WARNING );
require ( getenv( 'WP_PATH' ) ?: dirname( __DIR__ ) ) . '/wp-load.php';
require_once ABSPATH . 'wp-admin/includes/plugin.php';

$plugin = 'lasan-static-apps/lasan-static-apps.php';
if ( ! is_plugin_active( $plugin ) ) {
	$r = activate_plugin( $plugin );
	echo 'kích hoạt: ', is_wp_error( $r ) ? $r->get_error_message() : 'ok', "\n";
	if ( is_wp_error( $r ) ) {
		exit( 1 );
	}
	require_once WP_PLUGIN_DIR . '/' . $plugin;
}

foreach ( \Lasan\StaticApps\Admin::theme_apps_not_imported() as $slug => $label ) {
	$r = \Lasan\StaticApps\Store::install_dir( get_template_directory() . '/apps/' . $slug, $slug, $label );
	printf( "  %-24s %s\n", $slug, is_wp_error( $r ) ? 'LỖI ' . $r->get_error_message() : "phiên bản $r ($label)" );
}
foreach ( \Lasan\StaticApps\Store::all() as $slug => $app ) {
	printf( "  %-24s → %s\n", $slug, lasan_static_app_url( $slug ) );
}
echo "Xong.\n";
