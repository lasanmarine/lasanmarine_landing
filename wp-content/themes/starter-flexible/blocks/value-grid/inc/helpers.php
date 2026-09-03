<?php
/**
 * Value Grid — a numbered three-up used for values and principles.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function starter_flexible_block_data_value_grid( array $block ) {
	$data = array_merge(
		array( 'label' => '', 'items' => array(), 'custom_class' => '' ),
		starter_flexible_get_block_fields( $block )
	);

	$items = array();
	foreach ( (array) $data['items'] as $item ) {
		$title = isset( $item['title'] ) ? (string) $item['title'] : '';
		if ( '' === trim( $title ) ) {
			continue;
		}
		$items[] = array(
			'index' => isset( $item['index'] ) ? (string) $item['index'] : '',
			'title' => $title,
			'desc'  => isset( $item['desc'] ) ? (string) $item['desc'] : '',
		);
	}

	$data['items']         = $items;
	$data['module_class']  = starter_flexible_build_module_class( 'block container', (string) $data['custom_class'] );
	$data['should_render'] = ! empty( $items );

	return (object) $data;
}
