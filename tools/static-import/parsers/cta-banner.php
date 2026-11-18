<?php
/**
 * CTA Banner. The theme is the band's cb--<theme> class; the primary button is
 * the plain one, the secondary carries btn--secondary.
 */

return static function ( DOMElement $s, array $page ): array {
	$band   = ls_one( $s, '.cb' );
	$fields = array(
		'label'   => ls_t( $s, '.cb__label' ),
		'heading' => ls_t( $s, '.cb__heading' ),
		'content' => ls_t( $s, '.cb__content' ),
	);
	if ( $band ) {
		foreach ( array( 'navy', 'pale', 'outline' ) as $theme ) {
			if ( ls_has_class( $band, 'cb--' . $theme ) ) {
				$fields['theme'] = $theme;
			}
		}
	}
	$primary   = null;
	$secondary = null;
	foreach ( ls_all( $s, '.cb__actions a' ) as $a ) {
		if ( ls_has_class( $a, 'btn--secondary' ) ) {
			$secondary = $secondary ?? $a;
		} else {
			$primary = $primary ?? $a;
		}
	}
	$fields['primary_cta']   = ls_link( $primary );
	$fields['secondary_cta'] = ls_link( $secondary );

	$custom = array_diff( ls_classes( $s ), array( 'block', 'lasanmarine-cta-banner' ) );
	if ( $custom ) {
		$fields['custom_class'] = implode( ' ', $custom );
	}
	return $fields;
};
