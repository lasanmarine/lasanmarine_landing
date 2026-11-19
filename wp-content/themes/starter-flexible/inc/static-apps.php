<?php
/**
 * Static apps (the browser tools: simulators, calculators) shown by the App
 * Embed block and the full-screen app template.
 *
 * Apps are managed in the admin by the Lasan Static Apps plugin (upload a
 * build, versions, roll back). Apps the plugin does not have yet still run
 * from the theme's apps/ folder, as before, so nothing breaks while the
 * plugin is off or an app has not been imported.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** URL of an app's index.html: the plugin's current version, else the theme's copy; '' if none. */
function starter_flexible_app_src( string $slug ): string {
	$slug = sanitize_key( $slug );
	if ( '' === $slug ) {
		return '';
	}
	if ( function_exists( 'lasan_static_app_url' ) ) {
		$url = lasan_static_app_url( $slug );
		if ( '' !== $url ) {
			return $url;
		}
	}
	return is_file( get_template_directory() . '/apps/' . $slug . '/index.html' )
		? get_template_directory_uri() . '/apps/' . $slug . '/index.html'
		: '';
}

/**
 * Apps to choose from: the plugin's, plus any still only in the theme.
 *
 * @return array<string, string> slug => name
 */
function starter_flexible_app_choices(): array {
	$choices = function_exists( 'lasan_static_apps' ) ? lasan_static_apps() : array();
	foreach ( (array) glob( get_template_directory() . '/apps/*/index.html' ) as $index ) {
		$slug = basename( dirname( (string) $index ) );
		if ( ! isset( $choices[ $slug ] ) ) {
			$html             = (string) file_get_contents( (string) $index, false, null, 0, 20000 );
			$choices[ $slug ] = preg_match( '#<title>([^<]+)</title>#i', $html, $m )
				? trim( (string) preg_replace( '/\s*[|–—-]\s*(Lasan Marine|LASAN MARINE).*$/u', '', html_entity_decode( $m[1], ENT_QUOTES, 'UTF-8' ) ) )
				: $slug;
		}
	}
	asort( $choices );
	return $choices;
}

// The App Embed block's picker lists what is installed instead of a fixed list.
add_filter(
	'acf/load_field/key=field_ae_app',
	static function ( $field ) {
		$choices = starter_flexible_app_choices();
		if ( $choices ) {
			$field['choices'] = $choices;
		}
		return $field;
	}
);
