<?php
/**
 * Team — the people list beside a documentary portrait.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function starter_flexible_block_data_team( array $block ) {
	$data = array_merge(
		array(
			'label'        => 'ENGINEERING TEAM',
			'heading'      => '',
			'image'        => 0,
			'placeholder'  => '',
			'people'       => array(),
			'custom_class' => '',
		),
		starter_flexible_get_block_fields( $block )
	);

	$people = array();
	foreach ( (array) $data['people'] as $person ) {
		$name = isset( $person['name'] ) ? (string) $person['name'] : '';
		if ( '' === trim( $name ) ) {
			continue;
		}
		$people[] = array(
			'name' => $name,
			'role' => isset( $person['role'] ) ? (string) $person['role'] : '',
		);
	}

	$image_id = (int) $data['image'];

	$data['people']        = $people;
	$data['image_url']     = $image_id ? (string) wp_get_attachment_image_url( $image_id, 'large' ) : '';
	$data['module_class']  = starter_flexible_build_module_class( 'block container', (string) $data['custom_class'] );
	$data['should_render'] = ! empty( $people ) || '' !== trim( (string) $data['heading'] );

	return (object) $data;
}
