<?php
/**
 * Rich Text. The label is never rendered, so it is kept from the existing doc.
 * Body links stay as host-free site paths: the content tools resolve
 * {{page:key}} only in core-block HTML, not inside wysiwyg fields.
 */

return static function ( DOMElement $s, array $page ): array {
	$col    = ls_one( $s, '.rt__column' );
	$cls    = $col ? ls_classes( $col ) : array();
	$width  = 'medium';
	foreach ( array( 'narrow', 'medium', 'wide' ) as $w ) {
		if ( in_array( 'rt--' . $w, $cls, true ) ) {
			$width = $w;
		}
	}
	$body   = ls_one( $s, '.rt__body' );
	$fields = array(
		'heading' => ls_t( $s, '.rt__heading' ),
		'content' => $body ? (string) preg_replace_callback(
			'/href="([^"]*)"/',
			static fn( $m ) => 'href="' . esc_attr( ls_resolve_old_id( html_entity_decode( $m[1] ) ) ) . '"',
			ls_inner_html( $body )
		) : '',
		'align'   => in_array( 'rt--center', $cls, true ) ? 'center' : 'left',
		'width'   => $width,
	);
	$custom = array_diff( ls_classes( $s ), array( 'block', 'container', 'lasanmarine-rich-text' ) );
	$fields['custom_class'] = implode( ' ', $custom );
	return $fields;
};
