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

	$data['label_power']    = 'Công suất máy chính';
	$data['label_rpm']      = 'Số vòng quay';
	$data['label_ratio']    = 'Tỉ số truyền';
	$data['label_material'] = 'Hệ số K3, chọn';
	$data['prop_rpm_label'] = 'Vòng quay chân vịt';
	$data['result_label']   = 'Đường kính trục tối thiểu';
	$data['results_label']  = __( 'Kết quả tính toán', 'starter-flexible' );
	$data['reset_label']    = 'Đặt lại';
	$data['error_text']     = 'Nhập công suất, vòng quay và tỷ số truyền lớn hơn 0.';

	$materials = starter_flexible_shaft_materials();

	// `factor` normalises each choice back to the formula's own units — kW for
	// the power input, rpm for the speed input.
	$data['power_units'] = starter_flexible_power_units();
	$data['rpm_units']   = array(
		array( 'id' => 'rpm', 'label' => 'rpm', 'factor' => 1.0, 'is_default' => true ),
		array( 'id' => 'rps', 'label' => 'rps', 'factor' => 60.0, 'is_default' => false ),
	);

	$data['materials']     = $materials;
	// Shares the Power Converter's shell (`pc`) — same grid, inputs, radio
	// pills and result panel; `sd` only carries what is specific to it.
	$data['module_class']  = starter_flexible_build_module_class( 'pc sd', (string) $data['custom_class'] );
	$data['should_render'] = ! empty( $materials );

	return (object) $data;
}
