<?php
/**
 * Insights. Articles come from a WP query on posts (category field, else the
 * `bai-viet` category), so only the block's settings are parsed.
 *
 * Index layout (`in--index`): heading only; view_all / read_more /
 * posts_per_page / featured_post are not rendered (kept from the existing doc).
 * Category is left to its fallback (`bai-viet`), which is what the export used:
 * every card's terms include `bai-viet` and it is the one term not offered as
 * a filter.
 *
 * Row layout: heading, the "view all" link and read-more label are read; the
 * featured post is given by slug when it is the one shown.
 */

return static function ( DOMElement $s, array $page ): array {
	$fields = array( 'heading' => ls_t( $s, '.in__heading' ) );

	if ( ls_has_class( $s, 'in--index' ) ) {
		$fields['layout'] = 'index';
	} else {
		$fields['layout'] = 'row';
		$more             = ls_one( $s, '.in__more a' );
		if ( $more ) {
			$fields['view_all'] = ls_text( $more );
			$link               = ls_link( $more );
			// The block falls back to /tin-tuc/ itself; only store other targets.
			$fields['view_all_link'] = '/tin-tuc/' === ( $link['url'] ?? '' ) ? array() : $link;
		} else {
			$fields['view_all'] = '';
		}
		$cta = ls_one( $s, '.in__featured .in__cta' ) ?? ls_one( $s, '.in__card-more' );
		if ( $cta ) {
			$fields['read_more'] = ls_text( $cta );
		}
		$feat = ls_one( $s, '.in__featured .in__cta' );
		if ( $feat && preg_match( '#/([^/]+)/?$#', (string) ls_site_path( $feat->getAttribute( 'href' ) ), $m ) ) {
			$fields['featured_post'] = $m[1];
		}
		$cards = count( ls_all( $s, '.in__row > .in__card' ) );
		if ( $cards ) {
			$fields['posts_per_page'] = $cards;
		}
	}
	$fields['custom_class'] = implode( ' ', array_diff( ls_classes( $s ), array( 'block', 'container', 'in--index', 'lasanmarine-insights' ) ) );
	return $fields;
};
