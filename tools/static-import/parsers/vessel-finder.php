<?php
/**
 * Vessel Finder. Card icons are only rendered when a card has no photo; they
 * are recognised by comparing the SVG with the theme's icon paths.
 */

require_once __DIR__ . '/_icon-match.php';

return static function ( DOMElement $s, array $page ): array {
	$items = array();
	foreach ( ls_all( $s, '.vf__card' ) as $card ) {
		$img  = ls_one( $card, '.vf__media img' );
		$row  = array(
			'image' => $img ? ls_image( $img ) : '',
			'title' => ls_t( $card, '.vf__title' ),
			'desc'  => ls_t( $card, '.vf__desc' ),
			'link'  => 'a' === strtolower( $card->tagName ) ? ls_link( $card, '' ) : array(),
		);
		$icon = ls_icon_match( ls_one( $card, '.vf__icon svg' ) );
		if ( '' !== $icon ) {
			$row['icon'] = $icon;
		}
		$items[] = $row;
	}
	$fields = array(
		'heading' => ls_t( $s, '.vf__heading' ),
		'intro'   => ls_t( $s, '.vf__intro' ),
		'items'   => $items,
	);
	$custom = array_diff( ls_classes( $s ), array( 'block', 'container', 'lasanmarine-vessel-finder' ) );
	if ( $custom ) {
		$fields['custom_class'] = implode( ' ', $custom );
	}
	return $fields;
};
