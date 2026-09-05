<?php
/**
 * Project Index — the Dự án post type, listed and filtered on the page.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function starter_flexible_block_data_project_index( array $block ) {
	$data = array_merge(
		array(
			'label'        => 'DỰ ÁN',
			'all_label'    => 'TẤT CẢ',
			'filter_by'    => 'project_material',
			'limit'        => 24,
			'empty_text'   => 'Không có dự án nào.',
			'custom_class' => '',
		),
		starter_flexible_get_block_fields( $block )
	);

	$posts = get_posts(
		array(
			'post_type'      => 'project',
			'post_status'    => 'publish',
			'posts_per_page' => max( 1, (int) $data['limit'] ),
			'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
		)
	);

	$items = array_map( 'starter_flexible_project_card', $posts );

	// Only offer a filter for terms that actually have projects on this page.
	$taxonomy = (string) $data['filter_by'];
	$filters  = array();
	if ( 'none' !== $taxonomy && $items ) {
		$key  = 'project_use' === $taxonomy ? 'uses' : 'materials';
		$seen = array();
		foreach ( $items as $item ) {
			foreach ( $item[ $key ] as $slug ) {
				$seen[ $slug ] = true;
			}
		}
		foreach ( array_keys( $seen ) as $slug ) {
			$term = get_term_by( 'slug', $slug, $taxonomy );
			if ( $term instanceof WP_Term ) {
				$filters[] = array( 'slug' => $slug, 'name' => $term->name );
			}
		}
		usort( $filters, static fn( array $a, array $b ): int => strcmp( $a['name'], $b['name'] ) );
	}

	$data['items']         = $items;
	$data['filters']       = $filters;
	$data['filter_key']    = 'project_use' === $taxonomy ? 'uses' : 'materials';
	$data['has_label']     = '' !== trim( (string) $data['label'] );
	$data['module_class']  = starter_flexible_build_module_class( 'block container pi', (string) $data['custom_class'] );
	$data['should_render'] = ! empty( $items );

	return (object) $data;
}
