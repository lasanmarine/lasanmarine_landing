<?php
/**
 * Project Showcase — a cinematic carousel on the deepest navy.
 *
 * The slides are Dự án posts picked in the sidebar, so the photograph, name
 * and specs come straight from each project's own record; nothing is retyped
 * into the block. With nothing picked it falls back to the newest projects.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Starter_Flexible_Block_Project_Showcase extends Starter_Flexible_Abstract_Block {
	protected function defaults(): array {
		return array( 'label' => 'DỰ ÁN TIÊU BIỂU', 'projects' => array(), 'limit' => 5, 'custom_class' => '' );
	}

	protected function base_class(): string {
		return 'block';
	}

	protected function prepare( array $data ): array {

		$ids = array_values( array_filter( array_map( 'intval', (array) $data['projects'] ) ) );

		$posts = $ids
			? get_posts(
				array(
					'post_type'      => 'project',
					'post_status'    => 'publish',
					'posts_per_page' => count( $ids ),
					'post__in'       => $ids,
					'orderby'        => 'post__in',
				)
			)
			: get_posts(
				array(
					'post_type'      => 'project',
					'post_status'    => 'publish',
					'posts_per_page' => max( 1, (int) $data['limit'] ),
					'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
				)
			);

		$items = array();
		foreach ( $posts as $post ) {
			$card = starter_flexible_project_card( $post );

			// The carousel's three caption slots, filled from the spec sheet:
			// dimensions, weight and power, then where and in what state.
			$items[] = array(
				'name'        => $card['title'],
				'location'    => $card['meta'],
				'year'        => trim( implode( ' · ', array_filter( array( $card['location'], $card['year'] ) ) ) ),
				'service'     => '' !== $card['status'] ? $card['status'] : $card['tag'],
				'placeholder' => $card['placeholder'],
				'image_url'   => $card['image_url'],
				'url'         => $card['url'],
			);
		}

		$data['items']         = $items;
		$data['first']         = $items[0] ?? array( 'name' => '', 'location' => '', 'year' => '', 'service' => '', 'url' => '' );
		$data['count_label']   = '01 / ' . str_pad( (string) count( $items ), 2, '0', STR_PAD_LEFT );
		$data['should_render'] = ! empty( $items );

		$data['has_navigation'] = count( $data['items'] ) > 1;
		foreach ( $data['items'] as &$item ) {
		$rows = array(
			__( 'Kích thước', 'starter-flexible' ) => $item['location'],
			__( 'Địa bàn', 'starter-flexible' )    => $item['year'],
			__( 'Trạng thái', 'starter-flexible' ) => $item['service'],
		);
		$item['specs'] = array_filter( $rows, fn( $value ): bool => $this->has_text( $value ) );
		}
		unset( $item );

		return $data;
	}
}

function starter_flexible_block_data_project_showcase( array $block ) {
	return ( new Starter_Flexible_Block_Project_Showcase( $block ) )->data();
}
