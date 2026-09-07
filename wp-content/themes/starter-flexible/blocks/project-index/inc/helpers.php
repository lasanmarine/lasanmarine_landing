<?php
/**
 * Project Index — the Dự án post type, listed and filtered on the page.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Starter_Flexible_Block_Project_Index extends Starter_Flexible_Abstract_Block {
	protected function defaults(): array {
		return array(
			'label'        => 'DỰ ÁN',
			'all_label'    => 'TẤT CẢ',
			'filter_by'    => 'project_material',
			'limit'        => 24,
			'empty_text'   => 'Không có dự án nào.',
			'custom_class' => '',
		);
	}

	protected function base_class(): string {
		return 'block container pi';
	}

	protected function prepare( array $data ): array {

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

		$data['count_label']   = __( 'dự án', 'starter-flexible' );
		$data['items']         = $items;
		$data['filters']       = $filters;
		$data['filter_key']    = 'project_use' === $taxonomy ? 'uses' : 'materials';
		$data['has_label']     = '' !== trim( (string) $data['label'] );
		$data['should_render'] = ! empty( $items );

		return $data;
	}
}

function starter_flexible_block_data_project_index( array $block ) {
	return ( new Starter_Flexible_Block_Project_Index( $block ) )->data();
}
