<?php
/**
 * Enquiry Form. The form itself is a Contact Form 7 form (old ids: VI 380,
 * EN 1228) that does not exist in the new database yet; it is referenced by
 * the slug it is expected to be created under, which resolves to its id once
 * the form exists (until then the block renders the intro only).
 */

return static function ( DOMElement $s, array $page ): array {
	$fields = array(
		'heading' => ls_t( $s, '.ef__intro > h2' ),
		'note'    => ls_t( $s, '.ef__note' ),
	);
	if ( ls_one( $s, '.wpcf7' ) ) {
		$fields['cf7_form'] = 'en' === ( $page['lang'] ?? '' ) ? 'enquiry-form-en' : 'enquiry-form-vi';
	}

	$custom = array_diff( ls_classes( $s ), array( 'block', 'container', 'lasanmarine-enquiry-form' ) );
	if ( $custom ) {
		$fields['custom_class'] = implode( ' ', $custom );
	}
	return $fields;
};
