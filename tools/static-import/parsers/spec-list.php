<?php
/**
 * Spec List. Phone/email values are rendered as links; their text is the value.
 */

return static function ( DOMElement $s, array $page ): array {
	$h    = ls_one( $s, '.sl__intro > h1, .sl__intro > h2' );
	$rows = array();
	foreach ( ls_all( $s, '.spec' ) as $spec ) {
		$rows[] = array(
			'label' => ls_t( $spec, '.spec__label' ),
			'value' => ls_t( $spec, '.spec__value' ),
		);
	}
	$fields = array(
		'heading'       => ls_text( $h ),
		'heading_level' => $h ? strtolower( $h->tagName ) : 'h2',
		'note'          => ls_t( $s, '.sl__note' ),
		'rows'          => $rows,
	);

	$custom = array_diff( ls_classes( $s ), array( 'block', 'container', 'lasanmarine-spec-list' ) );
	if ( $custom ) {
		$fields['custom_class'] = implode( ' ', $custom );
	}
	return $fields;
};
