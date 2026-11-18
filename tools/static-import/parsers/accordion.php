<?php
/**
 * Accordion. `label` is not rendered and is kept from the existing doc.
 * `open_first` is read from the first trigger's aria-expanded.
 */

return static function ( DOMElement $s, array $page ): array {
	$fields = array(
		'heading' => ls_t( $s, '.ac__intro h2' ),
		'intro'   => ls_t( $s, '.ac__intro .copy' ),
		'items'   => array(),
	);
	$first = ls_one( $s, '.ac__trigger' );
	$fields['open_first'] = $first && 'true' === $first->getAttribute( 'aria-expanded' ) ? 1 : 0;
	foreach ( ls_all( $s, '.ac__item' ) as $it ) {
		$body = ls_one( $it, '.ac__body' );
		$html = $body ? ls_inner_html( $body ) : '';
		// Old-style page links: resolve to plain site paths.
		$html = (string) preg_replace_callback(
			'/href="([^"]*)"/',
			static function ( $m ) {
				$path = ls_site_path( html_entity_decode( $m[1] ) );
				return null === $path ? $m[0] : 'href="' . esc_attr( ls_resolve_old_id( $path ) ) . '"';
			},
			$html
		);
		$fields['items'][] = array(
			'title'   => ls_t( $it, '.ac__title' ),
			'content' => $html,
		);
	}
	$custom = array_diff( ls_classes( $s ), array( 'block', 'container', 'lasanmarine-accordion' ) );
	$fields['custom_class'] = implode( ' ', $custom );
	return $fields;
};
