<?php
/**
 * Project Showcase — a cinematic carousel on the deepest navy.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function starter_flexible_block_data_project_showcase( array $block ) {
	$data = array_merge(
		array( 'label' => 'PROJECT SHOWCASE', 'items' => array(), 'custom_class' => '' ),
		starter_flexible_get_block_fields( $block )
	);

	$items = array();
	foreach ( (array) $data['items'] as $item ) {
		$name = isset( $item['name'] ) ? (string) $item['name'] : '';
		if ( '' === trim( $name ) ) {
			continue;
		}

		$image_id = isset( $item['image'] ) ? (int) $item['image'] : 0;

		$items[] = array(
			'name'        => $name,
			'tag'         => isset( $item['tag'] ) ? (string) $item['tag'] : '',
			'location'    => isset( $item['location'] ) ? (string) $item['location'] : '',
			'year'        => isset( $item['year'] ) ? (string) $item['year'] : '',
			'service'     => isset( $item['service'] ) ? (string) $item['service'] : '',
			'placeholder' => isset( $item['placeholder'] ) ? (string) $item['placeholder'] : '',
			'image_url'   => $image_id ? (string) wp_get_attachment_image_url( $image_id, 'full' ) : '',
		);
	}

	$data['items']         = $items;
	$data['first']         = $items[0] ?? array( 'name' => '', 'tag' => '', 'location' => '', 'year' => '', 'service' => '' );
	$data['count_label']   = '01 / ' . str_pad( (string) count( $items ), 2, '0', STR_PAD_LEFT );
	$data['module_class']  = starter_flexible_build_module_class( 'block', (string) $data['custom_class'] );
	$data['should_render'] = ! empty( $items );

	return (object) $data;
}
