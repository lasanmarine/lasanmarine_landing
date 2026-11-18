<?php
/**
 * Capability Matrix. `label` is not rendered and is kept from the existing
 * doc. A cell's link label is its CTA text (empty when no CTA is shown).
 */

require_once __DIR__ . '/_icon-match.php';

return static function ( DOMElement $s, array $page ): array {
	$items = array();
	foreach ( ls_all( $s, '.cm__cell' ) as $cell ) {
		$href = $cell->getAttribute( 'href' );
		$row  = array(
			'index'    => ls_t( $cell, '.cm__index' ),
			'name'     => ls_t( $cell, '.cm__name' ),
			'desc'     => ls_t( $cell, '.cm__desc' ),
			'link'     => '' !== $href ? ls_link( $cell, ls_t( $cell, '.cm__cta' ) ) : array(),
			'children' => array_map( static fn( $li ) => array( 'name' => ls_text( $li ) ), ls_all( $cell, '.cm__children > li' ) ),
		);
		$icon = ls_icon_match( ls_one( $cell, '.cm__icon svg' ) );
		if ( '' !== $icon ) {
			$row['icon'] = $icon;
		} else {
			fwrite( STDERR, "  ! capability-matrix: không nhận ra icon ({$page['key']})\n" );
		}
		$items[] = $row;
	}
	$fields = array(
		'heading' => ls_t( $s, '.cm__heading' ),
		'items'   => $items,
	);
	$custom = array_diff( ls_classes( $s ), array( 'block', 'container', 'lasanmarine-capability-matrix' ) );
	if ( $custom ) {
		$fields['custom_class'] = implode( ' ', $custom );
	}
	return $fields;
};
