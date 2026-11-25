<?php
/**
 * Page cache (Cache Enabler) for production — re-runnable.
 *
 *   WP_PATH=/home/lasanmarinecom/lasanmarine.com WP_HOME=https://lasanmarine.com php ~/lasan-tools/page-cache.php [off]
 *
 * Why: every page took ~0.7 s of PHP on the server (TTFB ~1 s through
 * Cloudflare), almost a third of a phone's Largest Contentful Paint. The pages
 * are the same for every visitor who is not logged in (the cookie banner and
 * the consent choice run in the browser), so they are served from a static
 * file instead. The whole cache is cleared whenever a post is saved — menus,
 * project lists and footers link across pages — and by tools/content.php and
 * tools/seo-settings.php after every run.
 *
 * Not enabled on the local docker site (nothing to gain, and it would hide
 * changes while editing).
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
define( 'WP_ADMIN', true ); // activation hooks run as in the dashboard
error_reporting( E_ALL & ~E_DEPRECATED & ~E_NOTICE & ~E_WARNING );
require ( getenv( 'WP_PATH' ) ?: dirname( __DIR__ ) ) . '/wp-load.php';
require_once ABSPATH . 'wp-admin/includes/plugin.php';

$plugin = 'cache-enabler/cache-enabler.php';

if ( in_array( 'off', $argv, true ) ) {
	do_action( 'cache_enabler_clear_complete_cache' );
	deactivate_plugins( $plugin );
	echo "Đã tắt cache trang.\n";
	exit( 0 );
}

$settings = array(
	'cache_expires'                      => 0,  // no time expiry: cleared on change
	'cache_expiry_time'                  => 0,
	'clear_site_cache_on_saved_post'     => 1,  // a save clears every page
	'clear_site_cache_on_saved_comment'  => 0,
	'clear_site_cache_on_changed_plugin' => 1,
	'convert_image_urls_to_webp'         => 0,  // the uploads are WebP already
	'mobile_cache'                       => 0,  // one responsive page for all
	'compress_cache'                     => 1,  // serve pre-gzipped files
	'minify_html'                        => 0,
	'minify_inline_css_js'               => 0,
	'excluded_post_ids'                  => '',
	'excluded_page_paths'                => '',
	'excluded_query_strings'             => '/^(?!(fbclid|ref|mc_(cid|eid)|utm_(source|medium|campaign|term|content|expid)|gclid|fb_(action_ids|action_types|source)|age-verified|usqp|cn-reloaded|_ga|_ke)).+$/',
	'excluded_cookies'                   => '/^(wp-postpass|wordpress_logged_in|comment_author)_/',
);

if ( ! is_plugin_active( $plugin ) ) {
	$r = activate_plugin( $plugin );
	echo 'kích hoạt: ', is_wp_error( $r ) ? $r->get_error_message() : 'ok', "\n";
}
update_option( 'cache_enabler', array_merge( (array) get_option( 'cache_enabler', array() ), $settings ) );
if ( class_exists( 'Cache_Enabler' ) && method_exists( 'Cache_Enabler', 'update_backend' ) ) {
	Cache_Enabler::update_backend(); // rewrites advanced-cache.php and the settings file
}
do_action( 'cache_enabler_clear_complete_cache' );

$config = (string) file_get_contents( ABSPATH . 'wp-config.php' );
printf( "WP_CACHE trong wp-config.php: %s\n", preg_match( "/define\\(\\s*'WP_CACHE'\\s*,\\s*true/", $config ) ? 'có' : 'KHÔNG' );
printf( "advanced-cache.php: %s\n", is_file( WP_CONTENT_DIR . '/advanced-cache.php' ) ? 'có' : 'KHÔNG' );
echo "Xong.\n";
