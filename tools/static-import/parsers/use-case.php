<?php
/**
 * Use Case. The `label` field is not rendered, so it is kept from the
 * existing doc. The solution label is rendered per case (with a language
 * fallback when empty); the first case's label is taken.
 */

return static function ( DOMElement $s, array $page ): array {
	$fields = array(
		'heading'        => ls_t( $s, '.uc__intro h2' ),
		'intro'          => ls_t( $s, '.uc__intro .copy' ),
		'solution_label' => ls_t( $s, '.uc__solution-label' ),
	);
	$items = array();
	foreach ( ls_all( $s, '.uc__case' ) as $c ) {
		$a    = ls_one( $c, '.uc__link' );
		$item = array(
			'problem'  => ls_t( $c, '.uc__problem' ),
			'context'  => ls_t( $c, '.uc__context' ),
			'solution' => ls_t( $c, '.uc__solution > p' ),
			'link'     => $a ? ls_link( $a ) : array(),
		);
		$items[] = $item;
	}
	$fields['items'] = $items;

	$custom = array_diff( ls_classes( $s ), array( 'block', 'container', 'lasanmarine-use-case' ) );
	$fields['custom_class'] = implode( ' ', $custom );
	return $fields;
};
