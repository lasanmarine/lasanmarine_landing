<?php
/**
 * Image + Text. The label and caption are not rendered, so they are kept from
 * the existing doc. The image alt comes from the media library.
 */

return static function ( DOMElement $s, array $page ): array {
	$grid  = ls_one( $s, '.it' );
	$frame = ls_one( $s, '.frame' );
	$img   = $frame ? ls_one( $frame, 'img' ) : null;

	$fields = array(
		'heading' => ls_t( $s, '.it__heading' ),
		'content' => ls_inner_html( ls_one( $s, '.it__body > .prose' ) ),
		'cta'     => ls_link( ls_one( $s, '.it__cta' ) ),
	);
	if ( $img ) {
		$fields['image'] = ls_image( $img );
	} else {
		$fields['image']       = '';
		$fields['placeholder'] = ls_t( $s, '.frame__placeholder' );
	}
	if ( $grid ) {
		$fields['image_position'] = ls_has_class( $grid, 'it--flip' ) ? 'left' : 'right';
		foreach ( array( 'even', 'text', 'media' ) as $split ) {
			if ( ls_has_class( $grid, 'it--' . $split ) ) {
				$fields['split'] = $split;
			}
		}
	}
	if ( $frame ) {
		foreach ( ls_classes( $frame ) as $c ) {
			if ( str_starts_with( $c, 'ratio-' ) ) {
				$fields['ratio'] = $c;
			}
		}
	}

	$custom = array_diff( ls_classes( $s ), array( 'block', 'container', 'lasanmarine-image-text' ) );
	if ( $custom ) {
		$fields['custom_class'] = implode( ' ', $custom );
	}
	return $fields;
};
