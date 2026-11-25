<?php
/**
 * Process Timeline. `label` and each step's `index` are not rendered, so they
 * are kept from the existing doc (steps are merged by position).
 */

return static function ( DOMElement $s, array $page ): array {
	$fields = array(
		'heading' => ls_t( $s, '.pt__heading' ),
		'intro'   => ls_t( $s, '.pt__intro' ),
		'steps'   => array(),
	);
	foreach ( ls_all( $s, '.pt__step' ) as $li ) {
		$fields['steps'][] = array(
			'title' => ls_t( $li, '.pt__title' ),
			'desc'  => ls_t( $li, '.pt__desc' ),
		);
	}
	$custom = array_diff( ls_classes( $s ), array( 'block', 'container', 'lasanmarine-process-timeline' ) );
	$fields['custom_class'] = implode( ' ', $custom );
	return $fields;
};
