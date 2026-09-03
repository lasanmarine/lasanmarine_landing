<?php
/**
 * Power Converter — kW / HP / PS conversion. One input, every other unit
 * derived from it.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function starter_flexible_block_data_power_converter( array $block ) {
	$data = array_merge(
		array(
			'input_label'  => '',
			'unit_label'   => '',
			'units'        => array(),
			'reset_label'  => 'Đặt lại',
			'custom_class' => '',
		),
		starter_flexible_get_block_fields( $block )
	);

	$units = array();
	foreach ( (array) $data['units'] as $unit ) {
		$id = isset( $unit['id'] ) ? (string) $unit['id'] : '';
		if ( '' === trim( $id ) ) {
			continue;
		}
		$units[] = array(
			'id'     => $id,
			'label'  => isset( $unit['label'] ) ? (string) $unit['label'] : $id,
			'factor' => isset( $unit['factor'] ) ? (float) $unit['factor'] : 1.0,
		);
	}

	$data['units']         = $units;
	$data['unit_options']  = array_map(
		static fn( array $unit ): array => array( 'value' => $unit['id'], 'label' => $unit['label'] ),
		$units
	);
	$data['module_class']  = starter_flexible_build_module_class( 'pc', (string) $data['custom_class'] );
	$data['should_render'] = ! empty( $units );

	return (object) $data;
}
