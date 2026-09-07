<?php
/**
 * Capability Matrix — drawn as a hairline mesh.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Starter_Flexible_Block_Capability_Matrix extends Starter_Flexible_Abstract_Block {
	protected function defaults(): array {
		return array(
			'label'        => 'CAPABILITY MATRIX',
			'heading'      => '',
			'items'        => array(),
			'custom_class' => '',
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

			$link = isset( $item['link'] ) && is_array( $item['link'] ) ? $item['link'] : array();

			$items[] = array(
				'index'    => isset( $item['index'] ) ? (string) $item['index'] : '',
				'icon'     => isset( $item['icon'] ) ? (string) $item['icon'] : 'ship',
				'name'     => $name,
				'desc'     => isset( $item['desc'] ) ? (string) $item['desc'] : '',
				'url'      => isset( $link['url'] ) ? (string) $link['url'] : '',
				'cta'      => isset( $link['title'] ) ? (string) $link['title'] : '',
				'target'   => ! empty( $link['target'] ) ? (string) $link['target'] : '_self',
				'children' => $children,
			);
		}

		$data['items']         = $items;
		$data['has_heading']   = '' !== trim( (string) $data['heading'] );
		$data['should_render'] = ! empty( $items );

		$data['has_label'] = $this->has_text( $data['label'] );

		foreach ( $data['items'] as &$item ) { $item['has_cta'] = $this->has_text( $item['cta'] ); }
		unset( $item );

		return $data;
	}
}

function starter_flexible_block_data_capability_matrix( array $block ) {
	return ( new Starter_Flexible_Block_Capability_Matrix( $block ) )->data();
}
