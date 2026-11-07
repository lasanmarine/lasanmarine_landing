<?php
/**
 * English UI strings. The theme's strings are written in Vietnamese; on the
 * English side of the site (Polylang) each one is swapped for its entry in
 * inc/i18n/en.php. A string missing from the table stays Vietnamese.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The VI → EN table, or null when the current page is not English.
 *
 * @return array<string, string>|null
 */
function starter_flexible_i18n_table(): ?array {
	static $table = null;

	if ( ! function_exists( 'pll_current_language' ) || 'en' !== pll_current_language( 'slug' ) ) {
		return null;
	}
	if ( null === $table ) {
		$table = require __DIR__ . '/i18n/en.php';
	}

	return $table;
}

/**
 * Swap one translated string.
 *
 * @param string $translation Current translation.
 * @param string $text        Source (Vietnamese) string.
 */
function starter_flexible_i18n_swap( string $translation, string $text ): string {
	$table = starter_flexible_i18n_table();

	return null !== $table && isset( $table[ $text ] ) ? $table[ $text ] : $translation;
}

add_filter( 'gettext_starter-flexible', 'starter_flexible_i18n_swap', 10, 2 );
add_filter(
	'gettext_with_context_starter-flexible',
	static fn( string $translation, string $text ): string => starter_flexible_i18n_swap( $translation, $text ),
	10,
	2
);
add_filter(
	'ngettext_starter-flexible',
	static function ( string $translation, string $single, string $plural, $number ): string {
		return starter_flexible_i18n_swap( $translation, 1 === (int) $number ? $single : $plural );
	},
	10,
	4
);
