<?php
/**
 * Value Grid. The `label` field is not rendered, so it is kept from the
 * existing doc. Icons are recognised from the inline SVG.
 */

require_once __DIR__ . '/_icon-match.php';

return static function ( DOMElement $s, array $page ): array {
	$items = array();
	foreach ( ls_all( $s, '.vg__cell' ) as $cell ) {
		$a    = ls_one( $cell, '.vg__link' );
		$row  = array(
			'title' => ls_t( $cell, '.vg__title' ),
			'desc'  => ls_t( $cell, '.vg__desc' ),
			'link'  => $a ? ls_link( $a ) : array(),
		);
		$icon = ls_icon_match( ls_one( $cell, '.vg__icon svg' ) );
		if ( '' !== $icon ) {
			$row['icon'] = $icon;
		} else {
			fwrite( STDERR, "  ! value-grid: không nhận ra icon ({$page['key']})\n" );
		}
		$items[] = $row;
	}
	$fields = array(
		'heading' => ls_t( $s, '.vg__heading' ),
		'items'   => $items,
	);
	$custom = array_diff( ls_classes( $s ), array( 'block', 'container', 'lasanmarine-value-grid' ) );
	if ( $custom ) {
		$fields['custom_class'] = implode( ' ', $custom );
	}
	return $fields;
};
