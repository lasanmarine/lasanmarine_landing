<?php
/**
 * Contact Statement. Phone comes from the "Gọi / Call …" button text, email
 * from the hint link, Zalo from the Zalo button (VI only; EN pages do not show
 * it, so the doc's value is kept). The waves and the hint
 * copy are fixed in the template.
 */

return static function ( DOMElement $s, array $page ): array {
	$fields = array(
		'heading'     => '',
		'description' => '',
		'phone'       => '',
		'email'       => ls_t( $s, '.cs__email' ),
		'cta'         => ls_link( ls_one( $s, '.cs__cta' ) ),
	);

	// The heading is a wysiwyg (<p>…</p>) inside an <h2>; libxml closes the
	// <h2> at the <p>, so its paragraphs follow it as unclassed siblings.
	$h = ls_one( $s, '.cs__heading' );
	if ( $h ) {
		$html = ls_inner_html( $h );
		for ( $n = $h->nextSibling; $n; $n = $n->nextSibling ) {
			if ( $n instanceof DOMElement ) {
				if ( '' !== $n->getAttribute( 'class' ) ) {
					break;
				}
				$html .= ls_outer_html( $n );
			}
		}
		$fields['heading'] = trim( $html );
	}

	$desc = ls_one( $s, '.cs__description' );
	if ( $desc ) {
		$html = (string) preg_replace( '#<br\s*/?>\s*#i', "\n", ls_inner_html( $desc ) );
		$fields['description'] = trim( implode( "\n", array_map( 'trim', explode( "\n", $html ) ) ) );
	}

	$call = ls_one( $s, '.cs__call' );
	if ( $call ) {
		$fields['phone'] = trim( (string) preg_replace( '/^(Gọi|Call)\s+/u', '', ls_text( $call ) ) );
	}

	$zalo = ls_one( $s, '.cs__zalo' );
	if ( $zalo ) {
		$fields['zalo'] = (string) preg_replace( '#^https?://zalo\.me/#', '', $zalo->getAttribute( 'href' ) );
	} elseif ( 'vi' === ( $page['lang'] ?? '' ) ) {
		$fields['zalo'] = ''; // no phone, so no Zalo button either
	}

	$mascot           = ls_one( $s, '.cs__mascot img' );
	$fields['mascot'] = $mascot ? ls_image( $mascot ) : '';

	$custom = array_diff( ls_classes( $s ), array( 'block', 'lasanmarine-contact-statement' ) );
	if ( $custom ) {
		$fields['custom_class'] = implode( ' ', $custom );
	}
	return $fields;
};
