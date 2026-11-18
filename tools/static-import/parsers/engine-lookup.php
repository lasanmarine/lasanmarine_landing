<?php
/**
 * engine-lookup — a Svelte island inside Tool Shell. Units, labels and data are
 * built in inc/helpers.php, so the only authored field is custom_class, which
 * is appended to the base class in the island props' moduleClass ("pc el").
 * $s is the .island div (the block has no wrapper of its own).
 */

return static function ( DOMElement $s, array $page ): array {
	$island = ls_has_class( $s, 'island' ) ? $s : ls_one( $s, '.island' );
	$script = $island ? ls_one( $island, 'script[data-props]' ) : null;
	$props  = $script ? (array) json_decode( (string) $script->textContent, true ) : array();
	$cls    = preg_split( '/\s+/', trim( (string) ( $props['moduleClass'] ?? '' ) ) ) ?: array();
	return array( 'custom_class' => implode( ' ', array_diff( array_filter( $cls ), explode( ' ', 'pc el' ) ) ) );
};
