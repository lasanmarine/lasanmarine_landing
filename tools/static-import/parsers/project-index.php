<?php
/**
 * Project Index. Cards come from the Project post type (WP query), so only
 * the block's own settings are parsed. The label is not rendered and `limit`
 * cannot be told from the markup (kept from the existing doc / default 24).
 * The filter taxonomy is the one whose terms carry the filter button slugs.
 */

return static function ( DOMElement $s, array $page ): array {
	$fields = array(
		'all_label'  => ls_t( $s, '.pi__filter[aria-pressed=true]' ),
		'empty_text' => ls_t( $s, '.pi__empty' ),
	);
	$slugs = array();
	foreach ( ls_all( $s, '.pi__filter' ) as $b ) {
		if ( '' !== $b->getAttribute( 'data-pi-filter' ) ) {
			$slugs[] = $b->getAttribute( 'data-pi-filter' );
		}
	}
	if ( ! ls_one( $s, '.pi__filters' ) ) {
		if ( ls_one( $s, '.pi__list [data-pi-item]' ) ) {
			$fields['filter_by'] = 'none';
		}
		unset( $fields['all_label'] );
	} elseif ( $slugs ) {
		$best = '';
		$hits = 0;
		foreach ( array( 'project_material', 'project_work', 'project_use' ) as $tax ) {
			$n = count( array_filter( $slugs, static fn( $slug ) => (bool) get_term_by( 'slug', $slug, $tax ) ) );
			if ( $n > $hits ) {
				$best = $tax;
				$hits = $n;
			}
		}
		if ( '' !== $best ) {
			$fields['filter_by'] = $best;
		}
	}
	$fields['custom_class'] = implode( ' ', array_diff( ls_classes( $s ), array( 'block', 'container', 'pi', 'lasanmarine-project-index' ) ) );
	return $fields;
};
