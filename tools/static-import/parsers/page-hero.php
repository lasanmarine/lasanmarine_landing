<?php
/**
 * Page Hero. The background image, tags and placeholder are not rendered, so
 * they are kept from the existing doc. When the page embeds an app, the block
 * prepends its own "open" button, which is not authored and is dropped here.
 */

return static function ( DOMElement $s, array $page ): array {
	$h      = ls_one( $s, '.phero__headline' );
	$fields = array(
		'headline'      => ls_text( $h ),
		'heading_level' => $h ? strtolower( $h->tagName ) : 'h1',
		'lead'          => ls_t( $s, '.phero__lead' ),
	);
	$height = (int) ls_style_var( $s, '--phero-h' );
	if ( $height ) {
		$fields['height'] = $height;
	}

	$links = ls_all( $s, '.phero__action' );
	$doc   = $s->ownerDocument;
	if ( $links && ls_one( $doc, '.lasanmarine-app-embed' ) ) {
		array_shift( $links ); // injected "Mở công cụ / Open full screen"
	}
	$fields['actions'] = array_map( static fn( $a ) => array( 'link' => ls_link( $a ) ), $links );

	$custom = array_diff( ls_classes( $s ), array( 'phero', 'band--navy', 'block', 'lasanmarine-page-hero' ) );
	if ( $custom ) {
		$fields['custom_class'] = implode( ' ', $custom );
	}
	return $fields;
};
