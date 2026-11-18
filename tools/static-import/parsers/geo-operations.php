<?php
/**
 * Geo Operations. Each province is a list button plus a pin in the SVG; the
 * pin's centre gives the province's x/y.
 */

return static function ( DOMElement $s, array $page ): array {
	$pins = array();
	foreach ( ls_all( $s, 'g[data-geo-pin]' ) as $g ) {
		$dot = ls_one( $g, '.geo__pin-dot' ) ?? ls_one( $g, 'circle' );
		$pins[ (int) $g->getAttribute( 'data-i' ) ] = $dot;
	}
	$provinces = array();
	foreach ( ls_all( $s, '.geo__list button[data-geo-row]' ) as $btn ) {
		$i   = (int) $btn->getAttribute( 'data-i' );
		$dot = $pins[ $i ] ?? null;
		$provinces[] = array(
			'name' => ls_text( $btn ),
			'x'    => $dot ? (float) $dot->getAttribute( 'cx' ) : 0,
			'y'    => $dot ? (float) $dot->getAttribute( 'cy' ) : 0,
		);
	}

	$fields = array(
		'label'     => ls_t( $s, '.geo__label' ),
		'heading'   => ls_t( $s, '.geo__heading' ),
		'note'      => ls_t( $s, '.geo__note' ),
		'provinces' => $provinces,
	);

	$custom = array_diff( ls_classes( $s ), array( 'block', 'lasanmarine-geo-operations' ) );
	if ( $custom ) {
		$fields['custom_class'] = implode( ' ', $custom );
	}
	return $fields;
};
