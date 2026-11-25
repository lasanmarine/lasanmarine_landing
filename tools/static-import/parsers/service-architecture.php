<?php
/**
 * Service Architecture. `label` and `caption` are not rendered and are kept
 * from the existing doc. Item `index` is not rendered either. Images come
 * from the figure column (absent entirely when no item has one: `sa--text`).
 */

return static function ( DOMElement $s, array $page ): array {
	$view   = ls_one( $s, '.sa__head > a' );
	$fields = array(
		'heading'       => ls_t( $s, '.sa__head h2' ),
		'view_all'      => $view ? ls_text( $view ) : '',
		'view_all_link' => $view ? ls_link( $view ) : array(),
		'items'         => array(),
	);
	$slides = ls_all( $s, '.sa__slide' );
	foreach ( ls_all( $s, '.sa__row' ) as $i => $a ) {
		$children = array();
		$box      = ls_one( $a, '.sa__children' );
		if ( $box ) {
			foreach ( ls_children( $box ) as $c ) {
				$children[] = array( 'name' => ls_text( $c ) );
			}
		}
		$img = isset( $slides[ $i ] ) ? ls_one( $slides[ $i ], 'img' ) : null;
		$fields['items'][] = array(
			'name'     => ls_t( $a, '.sa__name' ),
			'desc'     => ls_t( $a, '.sa__desc' ),
			'note'     => ls_t( $a, '.sa__note' ),
			'link'     => ls_link( $a, '' ),
			'image'    => $img ? ls_image( $img ) : '',
			'children' => $children,
		);
	}
	$custom = array_diff( ls_classes( $s ), array( 'block', 'container', 'lasanmarine-service-architecture' ) );
	$fields['custom_class'] = implode( ' ', $custom );
	return $fields;
};
