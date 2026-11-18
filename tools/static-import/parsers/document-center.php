<?php
/**
 * Document Center. The label is not rendered (kept from the existing doc).
 * Cards show "Title" with source/year split out of "Title (Source, Year)", so
 * the title is put back together. Filter names are shown sentence-cased when
 * authored in capitals; the shown form is stored (renders identically).
 * No card in the export carries a file (all "contact to request"), so `file`
 * is only filled when a download link exists.
 */

return static function ( DOMElement $s, array $page ): array {
	$fields = array(
		'heading'    => ls_t( $s, '.dc__heading' ),
		'view_all'   => ls_link( ls_one( $s, '.dc__head > a' ) ),
		'all_label'  => ls_t( $s, '.dc__filter[data-doc-filter=all]' ),
		'empty_text' => ls_t( $s, '.dc__empty' ),
	);

	$groups = array();
	foreach ( ls_all( $s, '.dc__filter' ) as $btn ) {
		$i = $btn->getAttribute( 'data-doc-filter' );
		if ( 'all' !== $i ) {
			$name = ls_text( $btn );
			// A name still in capitals was stored with `&amp;` (the entity
			// defeats the sentence-casing, which compares against uppercase).
			if ( str_contains( $name, '&' ) && mb_strtoupper( $name, 'UTF-8' ) === $name ) {
				$name = str_replace( '&', '&amp;', $name );
			}
			$groups[ (int) $i ] = array( 'name' => $name, 'items' => array() );
		}
	}
	foreach ( ls_all( $s, '.dc__card' ) as $card ) {
		$g      = (int) $card->getAttribute( 'data-doc-group' );
		$title  = ls_t( $card, '.dc__title' );
		$source = ls_t( $card, '.dc__source' );
		$year   = ls_t( $card, '.dc__year' );
		if ( '' !== $year ) {
			$title .= ' (' . ( '' !== $source ? $source . ', ' : '' ) . $year . ')';
		}
		$dl   = ls_one( $card, '.dc__dl' ) ?? ls_one( $card, '.dc__view' );
		$href = $dl ? $dl->getAttribute( 'href' ) : '';
		$file = '';
		if ( '' !== $href ) {
			$path = ls_site_path( $href );
			$file = null !== $path ? $path : $href;
		}
		$groups[ $g ]['items'][] = array(
			'title' => $title,
			'size'  => ls_t( $card, '.dc__size' ),
			'file'  => $file,
		);
	}
	ksort( $groups );
	$fields['groups']       = array_values( $groups );
	$fields['custom_class'] = implode( ' ', array_diff( ls_classes( $s ), array( 'block', 'container', 'lasanmarine-document-center' ) ) );
	return $fields;
};
