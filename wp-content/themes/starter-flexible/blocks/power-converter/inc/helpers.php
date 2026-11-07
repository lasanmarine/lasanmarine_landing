<?php
/**
 * Power Converter — kW / HP / PS conversion. One input, every other unit
 * derived from it. Rendered by the Svelte island in assets/island.svelte;
 * this builds its props.
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
		$units = starter_flexible_power_units();

		$data['should_render'] = ! empty( $units );
		$data['props']         = array(
			'moduleClass'      => '', // filled in below, once the base class is merged.
			'inputId'          => wp_unique_id( 'power-value-' ),
			'initialValue'     => 1000,
			'defaultPrecision' => 2,
			'units'            => array_values( $units ),
			'labels'           => array(
				'input'     => __( 'Công suất', 'starter-flexible' ),
				'unit'      => __( 'Đơn vị đầu vào', 'starter-flexible' ),
				'reset'     => __( 'Đặt lại', 'starter-flexible' ),
				'results'   => __( 'Kết quả quy đổi', 'starter-flexible' ),
				'notePre'   => __( 'Kết quả làm tròn tối đa', 'starter-flexible' ),
				'notePost'  => __( 'chữ số thập phân.', 'starter-flexible' ),
				'precision' => __( 'Số chữ số thập phân', 'starter-flexible' ),
				'copy'      => __( 'Sao chép kết quả', 'starter-flexible' ),
				'error'     => __( 'Vui lòng nhập công suất hợp lệ, lớn hơn hoặc bằng 0.', 'starter-flexible' ),
			),
			'icons'            => starter_flexible_island_icons(
				array(
					'arrow' => array( 'arrow', 17 ),
					'copy'  => array( 'copy', 20, 'pc__copy-icon' ),
					'check' => array( 'check', 20, 'pc__copy-icon pc__copy-icon--done' ),
				)
			),
		);

		return $data;
	}
}

function starter_flexible_block_data_power_converter( array $block ) {
	$data                       = ( new Starter_Flexible_Block_Power_Converter( $block ) )->data();
	$data->props['moduleClass'] = $data->module_class;
	return $data;
}
