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
		array( 'custom_class' => '' ),
		starter_flexible_get_block_fields( $block )
	);

	$data['label_power']    = 'CÔNG SUẤT (kW)';
	$data['label_rpm']      = 'VÒNG QUAY (rpm)';
	$data['label_material'] = 'VẬT LIỆU TRỤC';
	$data['result_label']   = 'ĐƯỜNG KÍNH TRỤC TỐI THIỂU';
	$data['reset_label']    = 'Đặt lại';
	$data['error_text']     = 'Nhập công suất lớn hơn 0 kW và vòng quay lớn hơn 0 rpm.';

	$materials = starter_flexible_shaft_materials();

	$data['materials']     = $materials;
	$data['module_class']  = starter_flexible_build_module_class( 'sd', (string) $data['custom_class'] );
	$data['should_render'] = ! empty( $materials );

	return (object) $data;
}
