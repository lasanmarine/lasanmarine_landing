<?php
/**
 * Shaft Diameter — indicative minimum propeller shaft diameter, per the common
 * class formula. Rendered by the Svelte island in assets/island.svelte; this
 * builds its props.
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
		// Shares the Power Converter's shell (`pc`); `sd` carries what is its own.
		return 'pc sd';
	}

	protected function prepare( array $data ): array {
		$materials = array();
		foreach ( starter_flexible_shaft_materials() as $material ) {
			$materials[] = array(
				'name'    => (string) $material['name'],
				'note'    => trim( (string) $material['note'] ),
				'k3'      => (float) $material['k3'],
				'k3Label' => rtrim( rtrim( number_format( (float) $material['k3'], 3, '.', '' ), '0' ), '.' ),
			);
		}

		// `factor` normalises each choice back to the formula's own units — kW
		// for the power input, rpm for the speed input.
		$rpm_units = array(
			array( 'id' => 'rpm', 'label' => 'rpm', 'factor' => 1.0, 'is_default' => true ),
			array( 'id' => 'rps', 'label' => 'rps', 'factor' => 60.0, 'is_default' => false ),
		);

		$data['should_render'] = ! empty( $materials );
		$data['props']         = array(
			'moduleClass' => '',
			'ids'         => array(
				'power' => wp_unique_id( 'shaft-power-' ),
				'rpm'   => wp_unique_id( 'shaft-rpm-' ),
				'ratio' => wp_unique_id( 'shaft-ratio-' ),
			),
			'combos'      => array(
				array(
					'key'       => 'power',
					'label'     => __( 'Công suất máy chính', 'starter-flexible' ),
					'value'     => 750,
					'unitLabel' => __( 'Đơn vị công suất', 'starter-flexible' ),
					'units'     => array_values( starter_flexible_power_units() ),
				),
				array(
					'key'       => 'rpm',
					'label'     => __( 'Số vòng quay', 'starter-flexible' ),
					'value'     => 1800,
					'unitLabel' => __( 'Đơn vị vòng quay', 'starter-flexible' ),
					'units'     => $rpm_units,
				),
			),
			'materials'   => $materials,
			'labels'      => array(
				'ratio'    => __( 'Tỉ số truyền', 'starter-flexible' ),
				'material' => __( 'Hệ số K3, chọn', 'starter-flexible' ),
				'propRpm'  => __( 'Vòng quay chân vịt', 'starter-flexible' ),
				'result'   => __( 'Đường kính trục tối thiểu', 'starter-flexible' ),
				'results'  => __( 'Kết quả tính toán', 'starter-flexible' ),
				'reset'    => __( 'Đặt lại', 'starter-flexible' ),
				'copy'     => __( 'Sao chép kết quả', 'starter-flexible' ),
				'error'    => __( 'Nhập công suất, vòng quay và tỷ số truyền lớn hơn 0.', 'starter-flexible' ),
			),
			'icons'       => starter_flexible_island_icons(
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

function starter_flexible_block_data_shaft_diameter( array $block ) {
	$data                       = ( new Starter_Flexible_Block_Shaft_Diameter( $block ) )->data();
	$data->props['moduleClass'] = $data->module_class;
	return $data;
}
