<?php
/**
 * Engine Lookup — a filterable, sortable, paginated table over the engine
 * dataset from Site Settings → Tools → Machine List.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Starter_Flexible_Block_Engine_Lookup extends Starter_Flexible_Abstract_Block {
	protected function defaults(): array {
		return array( 'custom_class' => '' );
	}

	protected function base_class(): string {
		return 'pc el';
	}

	protected function prepare( array $data ): array {

		$rows = starter_flexible_machines();

		// Column order drives the sort keys, so the two lists stay paired.
		$data['columns'] = array(
			array( 'key' => 'make', 'label' => 'Hãng' ),
			array( 'key' => 'model', 'label' => 'Model' ),
			array( 'key' => 'kw', 'label' => 'kW' ),
			array( 'key' => 'rpm', 'label' => 'RPM' ),
		);

		$data['labels'] = array(
			'search'       => 'Tìm kiếm',
			'search_hint'  => 'Tìm kiếm hãng, tên model hoặc bất kỳ thông tin nào khác…',
			'make'         => 'Hãng',
			'model'        => 'Model',
			'all_makes'    => 'Tất cả hãng',
			'all_models'   => 'Tất cả model',
			'search_make'  => 'Tìm hãng…',
			'search_model' => 'Tìm model…',
			// Đuôi khi chỗ hiển thị không đủ tên; %d là số mục còn lại.
			'more_makes'   => 'và %d hãng khác',
			'more_models'  => 'và %d model khác',
			// Khi hẹp tới mức không hiện nổi một tên nào; %d là tổng đã chọn.
			'count_makes'  => '%d hãng đã chọn',
			'count_models' => '%d model đã chọn',
			'copy'         => 'Sao chép',
			'clear'        => 'Bỏ chọn hết',
			'none_found'   => 'Không tìm thấy.',
			'model_hint'   => 'Đang hiển thị một vài model ngẫu nhiên. Chọn hãng để xem đầy đủ model của các hãng đó.',
			'power_range'  => 'Khoảng công suất',
			'rpm_range'    => 'Khoảng RPM (số vòng quay trục khuỷu mỗi phút)',
			'from'         => 'Từ',
			'to'           => 'Đến',
			'results'      => 'Kết quả',
			'rows_found'   => 'kết quả',
			'no_results'   => 'Không có kết quả.',
			'reset'        => 'Đặt lại',
		);

		// `factor` normalises a filter value back to the dataset's own units — kW
		// for power, rpm for speed.
		$data['power_units'] = starter_flexible_power_units();
		$data['rpm_units']   = array(
			array( 'id' => 'rpm', 'label' => 'rpm', 'factor' => 1.0, 'is_default' => true ),
			array( 'id' => 'rps', 'label' => 'rps', 'factor' => 60.0, 'is_default' => false ),
		);

		$makes = array_values( array_unique( array_column( $rows, 'make' ) ) );
		sort( $makes );

		$data['rows']          = $rows;
		$data['makes']         = $makes;
		$data['per_page']      = 12;
		// Number of models sampled at random before a make is picked.
		$data['model_sample']  = 8;
		// Shares the Power Converter's shell (`pc`); `el` carries the table only.
		$data['should_render'] = ! empty( $rows );

		$labels    = $data['labels'];
		$data['search_id'] = wp_unique_id( 'el-search-' );

		/**
		 * A from/to pair sharing one unit select — the unit's `value` is the factor
		 * back to the dataset's units, applied in script.js.
		 */
		$data['ranges'] = array(
			array(
				'label'      => $labels['power_range'],
				'min_hook'   => 'data-el-kw-min',
				'max_hook'   => 'data-el-kw-max',
				'unit_hook'  => 'data-el-kw-unit',
				'unit_label' => __( 'Đơn vị công suất', 'starter-flexible' ),
				'units'      => $data['power_units'],
			),
			array(
				'label'      => $labels['rpm_range'],
				'min_hook'   => 'data-el-rpm-min',
				'max_hook'   => 'data-el-rpm-max',
				'unit_hook'  => 'data-el-rpm-unit',
				'unit_label' => __( 'Đơn vị vòng quay', 'starter-flexible' ),
				'units'      => $data['rpm_units'],
			),
		);
					$data['multis'] = array(
			array(
				'key'         => 'make',
				'label'       => $labels['make'],
				'placeholder' => $labels['all_makes'],
				'search'      => $labels['search_make'],
				'more'        => $labels['more_makes'],
				'count'       => $labels['count_makes'],
			),
			array(
				'key'         => 'model',
				'label'       => $labels['model'],
				'placeholder' => $labels['all_models'],
				'search'      => $labels['search_model'],
				'more'        => $labels['more_models'],
				'count'       => $labels['count_models'],
			),
		);

		foreach ( $data['multis'] as &$multi ) { $multi['id'] = $this->unique_id( 'el-' . $multi['key'] . '-' ); }
		unset( $multi );

		$data['rows_json'] = $this->json( $data['rows'] );

		return $data;
	}
}

function starter_flexible_block_data_engine_lookup( array $block ) {
	return ( new Starter_Flexible_Block_Engine_Lookup( $block ) )->data();
}
