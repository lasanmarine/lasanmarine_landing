<?php
/**
 * Public API for themes — global functions, so a theme can check
 * function_exists() and fall back when the plugin is off.
 *
 * @package Lasan_Static_Apps
 */

defined( 'ABSPATH' ) || exit;

/**
 * Installed apps as slug => title, for an app picker.
 *
 * @return array<string, string>
 */
function lasan_static_apps(): array {
	$out = array();
	foreach ( \Lasan\StaticApps\Store::all() as $slug => $app ) {
		$out[ $slug ] = (string) $app['title'];
	}
	return $out;
}

/** URL of an app's current index.html, '' when it is not installed. */
function lasan_static_app_url( string $slug ): string {
	return \Lasan\StaticApps\Store::url( $slug );
}
