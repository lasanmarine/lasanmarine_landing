<?php
/**
 * Deliverables. Every field is visible in the markup.
 */

return static function ( DOMElement $s, array $page ): array {
	$fields = array(
		'heading'    => ls_t( $s, '.dl__heading' ),
		'intro'      => ls_t( $s, '.dl__intro' ),
		'note_label' => ls_t( $s, '.dl__note-label' ),
		'note'       => '',
		'items'      => array(),
	);
	$note = ls_one( $s, '.dl__note' );
	if ( $note ) {
		foreach ( ls_children( $note ) as $span ) {
			if ( ! ls_has_class( $span, 'dl__note-label' ) ) {
				$fields['note'] = ls_text( $span );
			}
		}
	}
	foreach ( ls_all( $s, '.dl__item' ) as $li ) {
		$fields['items'][] = array(
			'title'  => ls_t( $li, '.dl__title' ),
			'desc'   => ls_t( $li, '.dl__desc' ),
			'format' => ls_t( $li, '.dl__format' ),
		);
	}
	$custom = array_diff( ls_classes( $s ), array( 'block', 'container', 'lasanmarine-deliverables' ) );
	$fields['custom_class'] = implode( ' ', $custom );
	return $fields;
};
