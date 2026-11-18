<?php
/**
 * App Embed. The app slug is the theme apps/<slug>/ folder in the iframe src;
 * the frame title falls back to a stock label when the field is empty.
 */

return static function ( DOMElement $s, array $page ): array {
	$iframe = ls_one( $s, 'iframe' );
	$src    = $iframe ? $iframe->getAttribute( 'src' ) : '';
	$title  = $iframe ? $iframe->getAttribute( 'title' ) : '';
	$fields = array(
		'app'   => preg_match( '#/apps/([a-z0-9_-]+)/#', $src, $m ) ? $m[1] : '',
		'title' => 'Công cụ mô phỏng' === $title ? '' : $title,
	);
	$custom = array_diff( ls_classes( $s ), array( 'block', 'container', 'lasanmarine-app-embed' ) );
	$fields['custom_class'] = implode( ' ', $custom );
	return $fields;
};
