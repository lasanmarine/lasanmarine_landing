<?php
/**
 * Service Spotlight. Every field is visible in the markup (the image alt is
 * the heading; the placeholder only shows when there is no image).
 */

return static function ( DOMElement $s, array $page ): array {
	$img    = ls_one( $s, '.spotlight__media .frame img' );
	$cta    = ls_one( $s, '.spotlight__panel > a.btn' );
	$fields = array(
		'label'       => ls_t( $s, '.spotlight__label' ),
		'image'       => $img ? ls_image( $img ) : '',
		'caption'     => ls_t( $s, '.spotlight__caption' ),
		'heading'     => ls_t( $s, '.spotlight__heading' ),
		'body'        => ls_t( $s, '.spotlight__panel > .copy' ),
		'items'       => array_map( static fn( $li ) => array( 'text' => ls_text( $li ) ), ls_all( $s, '.spotlight__items > li' ) ),
		'cta'         => $cta ? ls_link( $cta ) : array(),
	);
	if ( ! $img ) {
		$fields['placeholder'] = ls_t( $s, '.frame__placeholder' );
	}
	$custom = array_diff( ls_classes( $s ), array( 'block', 'lasanmarine-service-spotlight' ) );
	$fields['custom_class'] = implode( ' ', $custom );
	return $fields;
};
