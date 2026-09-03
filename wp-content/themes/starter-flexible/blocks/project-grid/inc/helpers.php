<?php
/**
 * Project Grid — the 12-column project grid.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function starter_flexible_block_data_project_grid( array $block ) {
	$data = array_merge(
		array( 'label' => 'PROJECT GRID', 'items' => array(), 'custom_class' => '' ),
		starter_flexible_get_block_fields( $block )
	);

	$items = array();
	foreach ( (array) $data['items'] as $item ) {
		$name = isset( $item['name'] ) ? (string) $item['name'] : '';
		if ( '' === trim( $name ) ) {
			continue;
		}

		$span     = isset( $item['span'] ) ? (int) $item['span'] : 4;
		$span     = min( 12, max( 1, $span ) );
		$link     = isset( $item['link'] ) && is_array( $item['link'] ) ? $item['link'] : array();
		$image_id = isset( $item['image'] ) ? (int) $item['image'] : 0;

		$items[] = array(
			'name'      => $name,
			'tag'       => isset( $item['tag'] ) ? (string) $item['tag'] : '',
			'meta'      => isset( $item['meta'] ) ? (string) $item['meta'] : '',
			'span'      => $span,
			'url'       => isset( $link['url'] ) ? (string) $link['url'] : '',
			'target'    => ! empty( $link['target'] ) ? (string) $link['target'] : '_self',
			'image_url' => $image_id ? (string) wp_get_attachment_image_url( $image_id, 'large' ) : '',
		);
	}

	$data['items']         = $items;
	$data['module_class']  = starter_flexible_build_module_class( 'block container', (string) $data['custom_class'] );
	$data['should_render'] = ! empty( $items );

	return (object) $data;
}
