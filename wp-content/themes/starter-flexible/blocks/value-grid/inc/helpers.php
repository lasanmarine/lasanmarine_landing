<?php
/**
 * Value Grid — an icon-led three-up used for values and principles.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Starter_Flexible_Block_Value_Grid extends Starter_Flexible_Abstract_Block {
	protected function defaults(): array {
		return array( 'label' => '', 'items' => array(), 'custom_class' => '' );
	}

	protected function base_class(): string {
		return 'block container';
	}

	protected function prepare( array $data ): array {

		$items = array();
		foreach ( (array) $data['items'] as $item ) {
			$title = isset( $item['title'] ) ? (string) $item['title'] : '';
			if ( '' === trim( $title ) ) {
				continue;
			}

			$link     = isset( $item['link'] ) && is_array( $item['link'] ) ? $item['link'] : array();
			$link_url = isset( $link['url'] ) ? (string) $link['url'] : '';

			$items[] = array(
				'icon'        => isset( $item['icon'] ) ? (string) $item['icon'] : 'ship',
				'title'       => $title,
				'desc'        => isset( $item['desc'] ) ? (string) $item['desc'] : '',
				'has_link'    => '' !== trim( $link_url ),
				'link_url'    => $link_url,
				'link_label'  => isset( $link['title'] ) ? (string) $link['title'] : '',
				'link_target' => ! empty( $link['target'] ) ? (string) $link['target'] : '_self',
			);
		}

		$data['items']         = $items;
		$data['should_render'] = ! empty( $items );

		return $data;
	}
}

function starter_flexible_block_data_value_grid( array $block ) {
	return ( new Starter_Flexible_Block_Value_Grid( $block ) )->data();
}
