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
		array( 'custom_class' => '' ),
		starter_flexible_get_block_fields( $block )
	);

	$data['input_label'] = __( 'Công suất', 'starter-flexible' );
	$data['unit_label']  = __( 'Đơn vị đầu vào', 'starter-flexible' );
	$data['reset_label'] = 'Đặt lại';

	// kW = giá trị × hệ số. kW dùng hệ số 1.
	$units = array(
		array( 'id' => 'kw', 'label' => 'kW', 'factor' => 1.0, 'is_default' => true ),
		array( 'id' => 'hp', 'label' => 'HP', 'factor' => 0.7457, 'is_default' => false ),
		array( 'id' => 'ps', 'label' => 'PS (mã lực)', 'factor' => 0.735499, 'is_default' => false ),
	);

	$data['units']         = $units;
	$data['input_id'] = wp_unique_id( 'power-value-' );
	$data['results_label'] = __( 'Kết quả quy đổi', 'starter-flexible' );
	$data['result_note'] = __( 'Kết quả làm tròn tối đa 2 chữ số thập phân.', 'starter-flexible' );
	$data['error_text'] = __( 'Vui lòng nhập công suất hợp lệ, lớn hơn hoặc bằng 0.', 'starter-flexible' );
	$data['module_class']  = starter_flexible_build_module_class( 'pc', (string) $data['custom_class'] );
	$data['should_render'] = ! empty( $units );

	return (object) $data;
}
