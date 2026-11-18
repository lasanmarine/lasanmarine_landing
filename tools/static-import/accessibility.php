<?php
/**
 * WP Accessibility settings for this site (re-runnable).
 *
 *   docker exec -u www-data lasan_wp php /var/www/html/tools/static-import/accessibility.php
 *
 * On: the toolbar (font size, high contrast) at the right edge, on phones too;
 * removing redundant title attributes; lang/dir on <html>. Off: what the
 * theme already does or that would override its design — skip links (the
 * theme has its own), forced focus outline and underlines (the theme styles
 * both), stripping target="_blank" (share links open a new tab on purpose),
 * the grayscale toggle (admin-only in the plugin anyway), statistics.
 *
 * @package Starter_Flexible
 */

$_SERVER['HTTP_HOST']   = $_SERVER['HTTP_HOST'] ?? ( parse_url( getenv( 'WP_HOME' ) ?: 'http://localhost', PHP_URL_HOST ) . ( parse_url( getenv( 'WP_HOME' ) ?: '', PHP_URL_PORT ) ? ':' . parse_url( getenv( 'WP_HOME' ), PHP_URL_PORT ) : '' ) );
$_SERVER['REQUEST_URI'] = '/';
require dirname( __DIR__, 2 ) . '/wp-load.php';

$settings = array(
	'wpa_toolbar'          => 'on',
	'wpa_toolbar_fs'       => 'on',
	'wpa_toolbar_ct'       => 'on',
	'wpa_toolbar_gs'       => '',
	'wpa_toolbar_right'    => 'on',
	'wpa_toolbar_mobile'   => 'on',
	'wpa_toolbar_size'     => '',
	'wpa_toolbar_default'  => '',
	'wpa_widget_toolbar'   => '',
	'wpa_remove_titles'    => 'on',
	'wpa_lang_attributes'  => 'on',
	'wpa_focus'            => '',
	'wpa_underline'        => '',
	'wpa_target'           => '',
	'wpa_tabindex'         => '',
	'wpa_continue'         => '',
	'wpa_track_stats'      => '',
	'wpa_disable_fullscreen' => '',
);
foreach ( $settings as $k => $v ) {
	update_option( $k, $v );
	printf( "  %-24s %s\n", $k, '' === $v ? 'off' : $v );
}
echo "Xong.\n";
