<?php
/**
 * Plugin Name:       Lasan Static Apps
 * Description:       Quản lý các công cụ dạng app tĩnh (index.html + assets): tải bản build .zip trong trang quản trị, có phiên bản và khôi phục, hiển thị qua khối “App Embed”.
 * Version:           1.0.0
 * Requires at least: 6.4
 * Requires PHP:      8.1
 * Author:            Công ty TNHH Lasan Marine
 * Text Domain:       lasan-static-apps
 * License:           GPL-2.0-or-later
 *
 * @package Lasan_Static_Apps
 */

namespace Lasan\StaticApps;

defined( 'ABSPATH' ) || exit;

require_once __DIR__ . '/includes/class-store.php';
require_once __DIR__ . '/includes/class-admin.php';
require_once __DIR__ . '/includes/functions.php';

final class Plugin {

	public static function init(): void {
		if ( is_admin() ) {
			Admin::init();
		}
	}

	/**
	 * A readable name for an app that still ships in the theme, taken from the
	 * <title> of its index.html.
	 */
	public static function theme_app_label( string $slug ): string {
		$html = (string) @file_get_contents( get_template_directory() . '/apps/' . $slug . '/index.html', false, null, 0, 20000 ); // phpcs:ignore
		if ( preg_match( '#<title>([^<]+)</title>#i', $html, $m ) ) {
			return trim( (string) preg_replace( '/\s*[|–—-]\s*(Lasan Marine|LASAN MARINE).*$/u', '', html_entity_decode( $m[1], ENT_QUOTES, 'UTF-8' ) ) );
		}
		return $slug;
	}
}

add_action( 'plugins_loaded', array( Plugin::class, 'init' ) );
