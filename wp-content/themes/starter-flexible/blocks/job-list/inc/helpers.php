<?php
/**
 * Job List — the open-positions list. Same row grammar as the service index;
 * each row leads to the application form, so the arrow is a real affordance.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function starter_flexible_block_data_job_list( array $block ) {
	$data = array_merge(
		array( 'label' => 'OPEN POSITIONS', 'apply_link' => array(), 'items' => array(), 'custom_class' => '' ),
		starter_flexible_get_block_fields( $block )
	);

	$items = array();
	foreach ( (array) $data['items'] as $item ) {
		$role = isset( $item['role'] ) ? (string) $item['role'] : '';
		if ( '' === trim( $role ) ) {
			continue;
		}
		$items[] = array(
			'role'     => $role,
			'location' => isset( $item['location'] ) ? (string) $item['location'] : '',
			'type'     => isset( $item['type'] ) ? (string) $item['type'] : '',
		);
	}

	$apply = is_array( $data['apply_link'] ) ? $data['apply_link'] : array();

	$data['items']         = $items;
	$data['apply_href']    = isset( $apply['url'] ) ? (string) $apply['url'] : '';
	$data['module_class']  = starter_flexible_build_module_class( 'block container', (string) $data['custom_class'] );
	$data['should_render'] = ! empty( $items );

	return (object) $data;
}
