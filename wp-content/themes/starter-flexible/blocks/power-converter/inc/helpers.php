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

final class Starter_Flexible_Block_Power_Converter extends Starter_Flexible_Abstract_Block {
	protected function defaults(): array {
		return array( 'custom_class' => '' );
	}

	protected function base_class(): string {
		return 'pc';
	}

	protected function prepare( array $data ): array {

		$data['input_label'] = __( 'Công suất', 'starter-flexible' );
		$data['unit_label']  = __( 'Đơn vị đầu vào', 'starter-flexible' );
		$data['reset_label'] = 'Đặt lại';

		$units = starter_flexible_power_units();

		$data['units']         = $units;
		$data['input_id'] = wp_unique_id( 'power-value-' );
		$data['results_label']    = __( 'Kết quả quy đổi', 'starter-flexible' );
		$data['result_note_pre']  = __( 'Kết quả làm tròn tối đa', 'starter-flexible' );
		$data['result_note_post'] = __( 'chữ số thập phân.', 'starter-flexible' );
		$data['default_precision'] = 2;
		$data['error_text'] = __( 'Vui lòng nhập công suất hợp lệ, lớn hơn hoặc bằng 0.', 'starter-flexible' );
		$data['should_render'] = ! empty( $units );

		$data['units_json'] = $this->json( $data['units'] );
		foreach ( $data['units'] as $i => &$unit ) { $unit['delay'] = 150 + $i * 70; }
		unset( $unit );

		return $data;
	}
}

function starter_flexible_block_data_power_converter( array $block ) {
	return ( new Starter_Flexible_Block_Power_Converter( $block ) )->data();
}
