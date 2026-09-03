<?php
/**
 * Standards — certifications on the tinted band.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function starter_flexible_block_data_standards( array $block ) {
	$data = array_merge(
		array(
			'label'        => 'STANDARDS & CERTIFICATIONS',
			'heading'      => '',
			'items'        => array(),
			'note'         => '',
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
		$items[] = array(
			'name'   => $name,
			'issuer' => isset( $item['issuer'] ) ? (string) $item['issuer'] : '',
			'year'   => isset( $item['year'] ) ? (string) $item['year'] : '',
		);
	}

	$data['items']         = $items;
	$data['has_note']      = '' !== trim( (string) $data['note'] );
	$data['module_class']  = starter_flexible_build_module_class( 'block', (string) $data['custom_class'] );
	$data['should_render'] = ! empty( $items ) || '' !== trim( (string) $data['heading'] );

	return (object) $data;
}
