<?php
/**
 * Static apps (the browser tools: simulators, calculators) shown by the App
 * Embed block and the full-screen app template.
 *
 * The apps and their versions live in the Lasan Static Apps plugin (builds in
 * wp-content/plugins/lasan-static-apps/apps/, or uploaded in Admin → App tĩnh).
 * Without the plugin the tool pages show no app.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** URL of the version of an app in use, '' if none. */
function starter_flexible_app_src( string $slug ): string {
	$slug = sanitize_key( $slug );
	return '' !== $slug && function_exists( 'lasan_static_app_url' ) ? lasan_static_app_url( $slug ) : '';
}

// The App Embed block's picker lists the installed apps instead of a fixed list.
add_filter(
	'acf/load_field/key=field_ae_app',
	static function ( $field ) {
		$choices = function_exists( 'lasan_static_apps' ) ? lasan_static_apps() : array();
		if ( $choices ) {
			asort( $choices );
			$field['choices'] = $choices;
		}
		return $field;
	}
);
