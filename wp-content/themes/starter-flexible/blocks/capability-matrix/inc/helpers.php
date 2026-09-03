<?php
/**
 * Capability Matrix — drawn as a hairline mesh.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function starter_flexible_block_data_capability_matrix( array $block ) {
	$data = array_merge(
		array(
			'label'        => 'CAPABILITY MATRIX',
			'heading'      => '',
			'items'        => array(),
			'custom_class' => '',
		),
		starter_flexible_get_block_fields( $block )
	);

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
			'target'   => ! empty( $link['target'] ) ? (string) $link['target'] : '_self',
			'children' => $children,
		);
	}

	$data['items']         = $items;
	$data['has_heading']   = '' !== trim( (string) $data['heading'] );
	$data['module_class']  = starter_flexible_build_module_class( 'block container', (string) $data['custom_class'] );
	$data['should_render'] = ! empty( $items );

	return (object) $data;
}
