<?php
/**
 * Hero. Each panel (headline / lead / photo sharing a data-hero-panel index)
 * becomes one `items` row; buttons belong to the block.
 */

return static function ( DOMElement $s, array $page ): array {
	$slides = array();
	$level  = 'h1';
	foreach ( ls_all( $s, '.hero__headline' ) as $h ) {
		$i = (int) $h->getAttribute( 'data-hero-panel' );
		if ( 0 === $i ) {
			$level = strtolower( $h->tagName );
		}
		$head = '';
		$acc  = '';
		$tail = '';
		$seen = false;
		foreach ( $h->childNodes as $c ) {
			if ( $c instanceof DOMElement && 'span' === strtolower( $c->tagName ) && ! $seen ) {
				$acc  = ls_text( $c );
				$seen = true;
			} elseif ( $seen ) {
				$tail .= $c->textContent;
			} else {
				$head .= $c->textContent;
			}
		}
		$slides[ $i ] = array(
			'image'           => '',
			'headline'        => trim( (string) preg_replace( '/\s+/u', ' ', $head ) ),
			'headline_accent' => $acc,
			'headline_tail'   => trim( (string) preg_replace( '/\s+/u', ' ', $tail ) ),
			'lead'            => '',
		);
	}
	foreach ( ls_all( $s, '.hero__lead' ) as $p ) {
		$i = (int) $p->getAttribute( 'data-hero-panel' );
		$slides[ $i ]         = ( $slides[ $i ] ?? array( 'image' => '', 'headline' => '', 'headline_accent' => '', 'headline_tail' => '' ) );
		$slides[ $i ]['lead'] = ls_text( $p );
	}
	foreach ( ls_all( $s, '.hero__frame' ) as $f ) {
		$i = (int) $f->getAttribute( 'data-hero-panel' );
		$slides[ $i ]          = ( $slides[ $i ] ?? array( 'headline' => '', 'headline_accent' => '', 'headline_tail' => '', 'lead' => '' ) );
		$slides[ $i ]['image'] = ls_image( ls_one( $f, 'img' ) );
	}
	ksort( $slides );

	$fields = array(
		'items'         => array_values( $slides ),
		'eyebrow'       => ls_t( $s, '.hero__eyebrow' ),
		'subline'       => ls_t( $s, '.hero__subline' ),
		'heading_level' => $level,
		'primary'       => array(),
		'secondary'     => array(),
	);
	foreach ( ls_all( $s, '.hero__actions a' ) as $a ) {
		$key            = ls_has_class( $a, 'btn--secondary' ) ? 'secondary' : 'primary';
		$link           = ls_link( $a );
		// tel:/mailto: would get the site root prefixed by lasan_content_link();
		// the ACF shape (no label) is passed through untouched.
		if ( isset( $link['url'] ) && preg_match( '/^(tel|mailto|sms|zalo):/i', $link['url'] ) ) {
			$link = array( 'url' => $link['url'], 'title' => $link['label'], 'target' => $link['target'] ?? '' );
		}
		$fields[ $key ] = $link;
	}
	if ( $s->hasAttribute( 'data-hero-autoplay' ) ) {
		$fields['autoplay'] = (int) $s->getAttribute( 'data-hero-autoplay' ) / 1000;
	}

	$custom = array_diff( ls_classes( $s ), array( 'hero', 'band--navy', 'block', 'lasanmarine-hero' ) );
	if ( $custom ) {
		$fields['custom_class'] = implode( ' ', $custom );
	}
	return $fields;
};
