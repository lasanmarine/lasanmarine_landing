<?php
/**
 * Service Architecture — the service index. Hovering a row swaps the figure
 * beside it.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Starter_Flexible_Block_Service_Architecture extends Starter_Flexible_Abstract_Block {
	protected function defaults(): array {
		return array(
			'label'         => '',
			'heading'       => '',
			'caption'       => '',
			'view_all'      => '',
			'view_all_link' => array(),
			'items'         => array(),
			'custom_class'  => '',
		);
	}

	protected function base_class(): string {
		return 'block container';
	}

	protected function prepare( array $data ): array {

		$items = array();
		foreach ( (array) $data['items'] as $item ) {
			$name = isset( $item['name'] ) ? (string) $item['name'] : '';
			if ( '' === trim( $name ) ) {
				continue;
			}

			$children = array();
			foreach ( (array) ( $item['children'] ?? array() ) as $child ) {
				$child_name = isset( $child['name'] ) ? (string) $child['name'] : '';
				if ( '' !== trim( $child_name ) ) {
					$children[] = $child_name;
				}
			}

			$link     = isset( $item['link'] ) && is_array( $item['link'] ) ? $item['link'] : array();
			$image_id = isset( $item['image'] ) ? (int) $item['image'] : 0;

			$items[] = array(
				'index'     => isset( $item['index'] ) ? (string) $item['index'] : '',
				'name'      => $name,
				'desc'      => isset( $item['desc'] ) ? (string) $item['desc'] : '',
				'url'       => isset( $link['url'] ) ? (string) $link['url'] : '',
				'target'    => ! empty( $link['target'] ) ? (string) $link['target'] : '_self',
				'image_url' => $image_id ? (string) wp_get_attachment_image_url( $image_id, 'large' ) : '',
				'children'  => $children,
			);
		}

		$view_all_link = is_array( $data['view_all_link'] ) ? $data['view_all_link'] : array();

		$data['items']         = $items;
		$data['has_label']     = '' !== trim( (string) $data['label'] );
		$data['view_all_url']  = isset( $view_all_link['url'] ) ? (string) $view_all_link['url'] : '';
		$data['has_view_all']  = '' !== trim( (string) $data['view_all'] ) && '' !== $data['view_all_url'];
		$data['has_caption']   = '' !== trim( (string) $data['caption'] );
		$data['should_render'] = ! empty( $items );

		$data['has_label'] = $this->has_text( $data['label'] );

		return $data;
	}
}

function starter_flexible_block_data_service_architecture( array $block ) {
	return ( new Starter_Flexible_Block_Service_Architecture( $block ) )->data();
}
