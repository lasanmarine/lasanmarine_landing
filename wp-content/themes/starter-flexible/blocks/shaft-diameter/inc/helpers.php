<?php
/**
 * Shaft Diameter — indicative minimum propeller shaft diameter, per the common
 * class formula.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function starter_flexible_block_data_shaft_diameter( array $block ) {
	$data = array_merge(
		array(
			'label_power'    => '',
			'label_rpm'      => '',
			'label_material' => '',
			'result_label'   => '',
			'materials'      => array(),
			'reset_label'    => 'Đặt lại',
			'error_text'     => 'Nhập công suất lớn hơn 0 kW và vòng quay lớn hơn 0 rpm.',
			'custom_class'   => '',
		),
		starter_flexible_get_block_fields( $block )
	);

	$materials = array();
	foreach ( (array) $data['materials'] as $material ) {
		$name = isset( $material['name'] ) ? (string) $material['name'] : '';
		if ( '' === trim( $name ) ) {
			continue;
		}
		$materials[] = array(
			'name'     => $name,
			'note'     => isset( $material['note'] ) ? (string) $material['note'] : '',
			'strength' => isset( $material['strength'] ) ? (float) $material['strength'] : 0.0,
		);
	}

	$data['materials']     = $materials;
	$data['module_class']  = starter_flexible_build_module_class( 'sd', (string) $data['custom_class'] );
	$data['should_render'] = ! empty( $materials );

	return (object) $data;
}
