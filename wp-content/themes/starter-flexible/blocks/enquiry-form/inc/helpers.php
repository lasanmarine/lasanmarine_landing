<?php
/**
 * Enquiry Form — the enquiry / application form. It validates and confirms in
 * the page, and posts nowhere until an endpoint is configured.
 *
 * TODO: wire the submit to a real handler (admin-post.php or Contact Form 7).
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function starter_flexible_block_data_enquiry_form( array $block ) {
	$data = array_merge(
		array(
			'label'        => '',
			'heading'      => '',
			'note'         => '',
			'fields'       => array(),
			'choices'      => array(),
			'error_text'   => 'Vui lòng điền đầy đủ các trường bắt buộc.',
			'toast_text'   => 'Đã gửi yêu cầu',
			'custom_class' => '',
		),
		starter_flexible_get_block_fields( $block )
	);

	$fields = is_array( $data['fields'] ) ? $data['fields'] : array();

	$choices = array();
	foreach ( (array) $data['choices'] as $choice ) {
		$text = isset( $choice['text'] ) ? (string) $choice['text'] : '';
		if ( '' !== trim( $text ) ) {
			$choices[] = $text;
		}
	}

	$data['fields'] = array(
		'name'        => isset( $fields['name'] ) ? (string) $fields['name'] : '',
		'company'     => isset( $fields['company'] ) ? (string) $fields['company'] : '',
		'email'       => isset( $fields['email'] ) ? (string) $fields['email'] : '',
		'phone'       => isset( $fields['phone'] ) ? (string) $fields['phone'] : '',
		'interest'    => isset( $fields['interest'] ) ? (string) $fields['interest'] : '',
		'message'     => isset( $fields['message'] ) ? (string) $fields['message'] : '',
		'attach'      => isset( $fields['attach'] ) ? (string) $fields['attach'] : '',
		'attach_hint' => isset( $fields['attach_hint'] ) ? (string) $fields['attach_hint'] : '',
		'submit'      => isset( $fields['submit'] ) ? (string) $fields['submit'] : '',
	);

	$data['choices']       = $choices;
	$data['has_note']      = '' !== trim( (string) $data['note'] );
	$data['module_class']  = starter_flexible_build_module_class( 'block container', (string) $data['custom_class'] );
	$data['should_render'] = '' !== trim( (string) $data['heading'] ) || '' !== trim( $data['fields']['name'] );

	return (object) $data;
}
