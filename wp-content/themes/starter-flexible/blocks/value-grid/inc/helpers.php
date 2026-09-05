<?php
/**
 * Value Grid — an icon-led three-up used for values and principles.
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
	$data['module_class']  = starter_flexible_build_module_class( 'block container', (string) $data['custom_class'] );
	$data['should_render'] = ! empty( $items );

	return (object) $data;
}
