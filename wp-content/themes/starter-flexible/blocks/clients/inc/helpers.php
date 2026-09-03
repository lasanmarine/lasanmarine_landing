<?php
/**
 * Clients — the client wall.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function starter_flexible_block_data_clients( array $block ) {
	$data = array_merge(
		array( 'label' => 'CLIENTS & PARTNERS', 'items' => array(), 'custom_class' => '' ),
		starter_flexible_get_block_fields( $block )
	);

	$items = array();
	foreach ( (array) $data['items'] as $item ) {
		$name = isset( $item['name'] ) ? (string) $item['name'] : '';
		if ( '' !== trim( $name ) ) {
			$items[] = $name;
		}
	}

	$data['items']         = $items;
	$data['module_class']  = starter_flexible_build_module_class( 'block container', (string) $data['custom_class'] );
	$data['should_render'] = ! empty( $items );

	return (object) $data;
}
