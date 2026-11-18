<?php
/**
 * Input / Output. The label is not rendered, so it is kept from the existing
 * doc. A column with no items is not rendered; its title is then kept too.
 */

return static function ( DOMElement $s, array $page ): array {
	$fields = array(
		'heading' => ls_t( $s, '.io__intro h2' ),
		'intro'   => ls_t( $s, '.io__intro .copy' ),
	);
	foreach ( array( 'input', 'process', 'output' ) as $kind ) {
		$col = ls_one( $s, '.io__col--' . $kind );
		if ( ! $col ) {
			$fields[ $kind ] = array();
			continue;
		}
		$fields[ $kind . '_title' ] = ls_t( $col, '.io__title' );
		$fields[ $kind ]            = array_map( static fn( $li ) => array( 'text' => ls_text( $li ) ), ls_all( $col, '.io__items > li' ) );
	}
	$fields['custom_class'] = implode( ' ', array_diff( ls_classes( $s ), array( 'block', 'container', 'lasanmarine-input-output' ) ) );
	return $fields;
};
