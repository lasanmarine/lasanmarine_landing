<?php
/**
 * Key Numbers — the statistics band.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function starter_flexible_block_data_key_numbers( array $block ) {
	$data = array_merge(
		array(
			'label'        => 'KEY NUMBERS',
			'stats'        => array(),
			'custom_class' => '',
		),
		starter_flexible_get_block_fields( $block )
	);

	$stats = array();
	foreach ( (array) $data['stats'] as $stat ) {
		$value = isset( $stat['value'] ) ? (string) $stat['value'] : '';
		if ( '' === trim( $value ) ) {
			continue;
		}
		$stats[] = array(
			'value'  => $value,
			'suffix' => isset( $stat['suffix'] ) ? (string) $stat['suffix'] : '',
			'label'  => isset( $stat['label'] ) ? (string) $stat['label'] : '',
			'note'   => isset( $stat['note'] ) ? (string) $stat['note'] : '',
		);
	}

	$data['stats']         = $stats;
	$data['has_label']     = '' !== trim( (string) $data['label'] );
	$data['module_class']  = starter_flexible_build_module_class( 'block', (string) $data['custom_class'] );
	$data['should_render'] = ! empty( $stats );

	return (object) $data;
}
