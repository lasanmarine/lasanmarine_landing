<?php
/**
 * Plugin Name:       Lasan Static Apps
 * Description:       Quản lý các công cụ dạng app tĩnh (index.html + assets): tải bản build .zip trong trang quản trị, đánh số phiên bản (1.2.0), ghi chú thay đổi và khôi phục bản cũ, hiển thị qua khối “App Embed”.
 * Version:           1.2.0
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

	const VERSION = '1.2.0';

	public static function init(): void {
		// On init, not before: an upgrade clears the page cache, which needs rewrite rules.
		add_action( 'init', array( Store::class, 'maybe_upgrade' ), 1 );
		if ( is_admin() ) {
			Admin::init();
		}
	}

	/** On activation: upgrade stored data and install the bundled apps. */
	public static function activate(): void {
		Store::maybe_upgrade();
		Store::sync_bundled();
	}
}

add_action( 'plugins_loaded', array( Plugin::class, 'init' ) );
register_activation_hook( __FILE__, array( Plugin::class, 'activate' ) );
