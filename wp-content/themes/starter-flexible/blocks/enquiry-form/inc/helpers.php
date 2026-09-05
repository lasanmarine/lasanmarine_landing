<?php
/**
 * Enquiry Form — a heading/intro wrapper around a Contact Form 7 form chosen
 * in the block sidebar.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function starter_flexible_block_data_enquiry_form( array $block ) {
	$data = array_merge(
		array(
			'heading'      => '',
			'note'         => '',
			'cf7_form'     => 0,
			'custom_class' => '',
		),
		starter_flexible_get_block_fields( $block )
	);

	$cf7_id = is_object( $data['cf7_form'] ) ? (int) $data['cf7_form']->ID : (int) $data['cf7_form'];

	$data['cf7_id']        = $cf7_id;
	$data['has_note']      = '' !== trim( (string) $data['note'] );
	$data['module_class']  = starter_flexible_build_module_class( 'block container', (string) $data['custom_class'] );
	$data['should_render'] = $cf7_id > 0 || '' !== trim( (string) $data['heading'] );

	return (object) $data;
}
