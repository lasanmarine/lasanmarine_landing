<?php
/**
 * Design Brief. Heading, intro and letterhead come from the island props
 * (script[data-props]); the label is not rendered (kept from the existing doc).
 *
 * The CF7 form is referenced by slug. The export rendered form #773 (fields
 * brief-code/-customer/-vessel/-email/-body/-json); in the old site its slug was
 * `nhiem-vu-thu-thiet-ke`. That form must exist in WordPress for the
 * `.db__cf7` part to render.
 */

return static function ( DOMElement $s, array $page ): array {
	$script = ls_one( $s, '.island[data-island=design-brief] script[data-props]' );
	$props  = $script ? (array) json_decode( (string) $script->textContent, true ) : array();
	$intro  = ls_one( $s, '.db__intro' );
	$head   = (array) ( $props['letterhead'] ?? array() );

	$fields = array(
		'heading' => $props ? (string) ( $props['heading'] ?? '' ) : ls_t( $s, '.db__intro h2' ),
		'intro'   => $props ? (string) ( $props['intro'] ?? '' ) : ls_t( $s, '.db__intro .copy' ),
	);
	if ( $head ) {
		$org = (string) ( $head['org'] ?? '' );
		// The org falls back to Settings › legal name, then this literal.
		$fields['doc_org']    = 'CÔNG TY TNHH LASAN MARINE' === $org ? '' : $org;
		$fields['doc_place']  = (string) ( $head['place'] ?? '' );
		$fields['doc_symbol'] = (string) ( $head['symbol'] ?? '' );
	}
	if ( ls_one( $s, '.db__cf7 .wpcf7' ) ) {
		$fields['cf7_form'] = 'nhiem-vu-thu-thiet-ke';
	}
	$fields['custom_class'] = implode( ' ', array_diff( ls_classes( $s ), array( 'block', 'container', 'db', 'lasanmarine-design-brief' ) ) );
	return $fields;
};
