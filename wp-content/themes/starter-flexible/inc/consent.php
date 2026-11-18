<?php
/**
 * Consent and the cost of third-party code on first load.
 *
 * - Google tag (gtag.js, printed by Site Kit) waits for "statistics" consent.
 *   It used to load on every first visit before any choice — not allowed under
 *   an opt-in banner, and 530 KB of script that held the main thread ~0.8 s on
 *   a phone. It is printed in Complianz's blocked-script form (type text/plain,
 *   src kept in data-cmplz-src), which Complianz turns back into a running
 *   script the moment the visitor accepts statistics. Site Kit's inline
 *   snippets stay as they are: they define gtag() and queue commands in
 *   dataLayer, so the theme's events (fe/src/lib/analytics.js) are kept and
 *   sent once the tag loads.
 * - Stylesheets nothing on the first screen depends on load without blocking
 *   the first paint: WP Accessibility's helpers (the toolbar is styled by the
 *   theme) and Complianz's placeholder styles for blocked embeds (the map in
 *   the footer). The banner's own stylesheet stays render-blocking, so the
 *   banner never shows unstyled.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Whether Complianz is running (it is what releases blocked scripts). */
function starter_flexible_consent_manager_active(): bool {
	return defined( 'cmplz_version' ) || function_exists( 'cmplz_get_option' );
}

add_filter(
	'script_loader_tag',
	static function ( $tag, $handle, $src ) {
		if ( ! starter_flexible_consent_manager_active() || false === strpos( (string) $src, 'googletagmanager.com/gtag/js' ) ) {
			return $tag;
		}
		// $tag also holds Site Kit's inline before/after snippets: rewrite only
		// the <script> element that loads gtag.js, leave the snippets running.
		return (string) preg_replace_callback(
			'#<script\b[^>]*\ssrc=("|\')[^"\']*googletagmanager\.com/gtag/js[^"\']*\1[^>]*>#',
			static function ( $m ) {
				$el = (string) preg_replace( '/\stype=("|\')[^"\']*\1/', '', $m[0] );
				$el = (string) preg_replace( '/\ssrc=("|\')/', ' data-cmplz-src=$1', $el, 1 );
				return (string) preg_replace( '/^<script\b/', '<script type="text/plain" data-category="statistics" data-service="google-analytics"', $el, 1 );
			},
			(string) $tag
		);
	},
	30,
	3
);

add_filter(
	'style_loader_tag',
	static function ( $html, $handle ) {
		if ( ! in_array( $handle, array( 'wpa-style', 'cmplz-general' ), true ) || is_admin() ) {
			return $html;
		}
		$async = (string) preg_replace( "/media=(['\"])[^'\"]*\\1/", "media='print' onload=\"this.media='all';this.onload=null\"", (string) $html, 1 );
		return $async . '<noscript>' . $html . '</noscript>';
	},
	10,
	2
);
