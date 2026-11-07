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
		return array( 'label' => 'DỰ ÁN TIÊU BIỂU', 'heading' => '', 'intro' => '', 'view_all' => array(), 'projects' => array(), 'limit' => 5, 'custom_class' => '' );
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
				'name'          => $card['title'],
				'dims'          => $card['dims'] ?? '',
				'tonnage'       => $card['tonnage'] ?? '',
				'power'         => $card['power'] ?? '',
				'materials_str' => $card['materials_str'] ?? '',
				'uses_str'      => $card['uses_str'] ?? '',
				'location'      => $card['location'] ?? '',
				'year'          => $card['year'] ?? '',
				'scope'         => $card['scope'] ?? '',
				'service'       => trim( implode( ' · ', array_filter( array( $card['work'], $card['scope'] ) ) ) ) ?: $card['tag'],
				'placeholder'   => $card['placeholder'],
				'image_url'     => $card['image_url'],
				'url'           => $card['url'],
			);
		}

		$data['items']         = $items;
		$data['first']         = $items[0] ?? array( 'name' => '', 'location' => '', 'year' => '', 'service' => '', 'url' => '' );
		$data['count_label']   = '01 / ' . str_pad( (string) count( $items ), 2, '0', STR_PAD_LEFT );
		$data['should_render'] = ! empty( $items );

		$data['has_navigation'] = count( $data['items'] ) > 1;
		$data['heading']        = trim( (string) $data['heading'] );
		$data['intro']          = trim( (string) $data['intro'] );
		$view_all               = is_array( $data['view_all'] ) ? $data['view_all'] : array();
		$data['view_all_url']   = isset( $view_all['url'] ) ? (string) $view_all['url'] : '';
		$data['view_all_label'] = isset( $view_all['title'] ) ? (string) $view_all['title'] : '';
		$data['has_head']       = '' !== $data['heading'] || '' !== $data['intro'] || '' !== $data['view_all_url'];
		$is_english             = function_exists( 'pll_current_language' ) && 'en' === pll_current_language( 'slug' );
		foreach ( $data['items'] as &$item ) {
		$rows = array(
			( $is_english ? 'Dimensions (L×B×D)' : __( 'Kích thước (Dài×Rộng×Cao)', 'starter-flexible' ) ) => $item['dims'] ?? '',
			( $is_english ? 'Tonnage' : __( 'Trọng tải', 'starter-flexible' ) ) => $item['tonnage'] ?? '',
			( $is_english ? 'Main engine power' : __( 'Công suất máy chính', 'starter-flexible' ) ) => $item['power'] ?? '',
			( $is_english ? 'Use / Function' : __( 'Công dụng', 'starter-flexible' ) ) => $item['uses_str'] ?? '',
			( $is_english ? 'Hull material' : __( 'Vật liệu vỏ', 'starter-flexible' ) ) => $item['materials_str'] ?? '',
			( $is_english ? 'Location' : __( 'Địa phương', 'starter-flexible' ) ) => $item['location'] ?? '',
			( $is_english ? 'Year' : __( 'Năm thực hiện', 'starter-flexible' ) ) => $item['year'] ?? '',
			( $is_english ? 'Scope carried out by LASAN MARINE' : __( 'Phạm vi LASAN MARINE thực hiện', 'starter-flexible' ) ) => $item['scope'] ?? '',
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
