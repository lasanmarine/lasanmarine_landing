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

final class Starter_Flexible_Block_Shaft_Diameter extends Starter_Flexible_Abstract_Block {
	protected function defaults(): array {
		return array( 'custom_class' => '' );
	}

	protected function base_class(): string {
		return 'pc sd';
	}

	protected function prepare( array $data ): array {

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
		$data['should_render'] = ! empty( $materials );

		$power_id = wp_unique_id( 'shaft-power-' );
		$rpm_id   = wp_unique_id( 'shaft-rpm-' );
		$data['ratio_id'] = wp_unique_id( 'shaft-ratio-' );

		$data['combos'] = array(
			array(
				'id'         => $power_id,
				'label'      => $data['label_power'],
				'name'       => 'power',
				'value'      => '750',
				'min'        => '0',
				'hook'       => 'data-shaft-power',
				'unit_hook'  => 'data-shaft-power-unit',
				'unit_label' => __( 'Đơn vị công suất', 'starter-flexible' ),
				'units'      => $data['power_units'],
			),
			array(
				'id'         => $rpm_id,
				'label'      => $data['label_rpm'],
				'name'       => 'rpm',
				'value'      => '1800',
				'min'        => '0',
				'hook'       => 'data-shaft-rpm',
				'unit_hook'  => 'data-shaft-rpm-unit',
				'unit_label' => __( 'Đơn vị vòng quay', 'starter-flexible' ),
				'units'      => $data['rpm_units'],
			),
		);

		$data['rows'] = array(
			array( 'id' => 'prop-rpm', 'label' => $data['prop_rpm_label'], 'attr' => 'data-shaft-prop-rpm' ),
			array( 'id' => 'result', 'label' => $data['result_label'], 'attr' => 'data-shaft-result' ),
		);

		foreach ( $data['materials'] as &$material ) {
		 $material['has_note'] = $this->has_text( $material['note'] );
		 $material['k3_label'] = rtrim( rtrim( number_format( (float) $material['k3'], 3, '.', '' ), '0' ), '.' );
		}
		unset( $material );
		foreach ( $data['rows'] as $i => &$row ) { $row['delay'] = 150 + $i * 70; }
		unset( $row );

		return $data;
	}
}

function starter_flexible_block_data_shaft_diameter( array $block ) {
	return ( new Starter_Flexible_Block_Shaft_Diameter( $block ) )->data();
}
