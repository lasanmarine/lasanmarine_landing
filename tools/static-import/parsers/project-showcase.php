<?php
/**
 * Project Showcase. The cards are Dự án posts, so only the picked projects
 * (by slug, from each card's link) are recovered; name, photo and specs come
 * from the project records. `label` is not rendered and is kept; `limit` only
 * matters when nothing is picked.
 */

return static function ( DOMElement $s, array $page ): array {
	$projects = array();
	foreach ( ls_all( $s, '.ps__card' ) as $card ) {
		$path = ls_site_path( $card->getAttribute( 'href' ) );
		if ( null !== $path && preg_match( '#/([^/?\#]+)/?(?:[?\#].*)?$#', $path, $m ) ) {
			$projects[] = urldecode( $m[1] );
		}
	}
	$all    = ls_one( $s, '.ps__all' );
	$fields = array(
		'heading'  => ls_t( $s, '.ps__heading' ),
		'intro'    => ls_t( $s, '.ps__intro' ),
		'view_all' => $all ? ls_link( $all ) : array(),
		'projects' => $projects,
	);
	$custom = array_diff( ls_classes( $s ), array( 'block', 'lasanmarine-project-showcase' ) );
	if ( $custom ) {
		$fields['custom_class'] = implode( ' ', $custom );
	}
	return $fields;
};
