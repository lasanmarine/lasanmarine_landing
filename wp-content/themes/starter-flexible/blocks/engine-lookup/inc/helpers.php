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

		$labels = $data['labels'];

		// The copy buttons in the table are smaller than the calculators' ones.
		$copy_sm  = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="pc__copy-icon" style="flex:none" aria-hidden="true"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"></rect><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"></path></svg>';
		$check_sm = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="pc__copy-icon pc__copy-icon--done" style="flex:none" aria-hidden="true"><path d="M21.801 10A10 10 0 1 1 17 3.335"></path><path d="m9 11 3 3L22 4"></path></svg>';

		$multi = static fn( string $key, string $label, string $plural ): array => array(
			'key'         => $key,
			'id'          => wp_unique_id( 'el-' . $key . '-' ),
			'label'       => $labels[ $key ],
			'placeholder' => $labels[ 'all_' . $plural ],
			'search'      => $labels[ 'search_' . $key ],
			'more'        => $labels[ 'more_' . $plural ],
			'count'       => $labels[ 'count_' . $plural ],
		);

		// Rendered by the Svelte island in assets/island.svelte.
		$data['props'] = array(
			'moduleClass' => '',
			'searchId'    => wp_unique_id( 'el-search-' ),
			'rows'        => array_values( $rows ),
			'perPage'     => $data['per_page'],
			'modelSample' => $data['model_sample'],
			'columns'     => $data['columns'],
			'multis'      => array( $multi( 'make', $labels['make'], 'makes' ), $multi( 'model', $labels['model'], 'models' ) ),
			// A from/to pair sharing one unit select; the unit's factor brings a
			// filter value back to the dataset's units.
			'ranges'      => array(
				array(
					'key'       => 'kw',
					'label'     => $labels['power_range'],
					'unitLabel' => __( 'Đơn vị công suất', 'starter-flexible' ),
					'units'     => array_values( $data['power_units'] ),
				),
				array(
					'key'       => 'rpm',
					'label'     => $labels['rpm_range'],
					'unitLabel' => __( 'Đơn vị vòng quay', 'starter-flexible' ),
					'units'     => $data['rpm_units'],
				),
			),
			'labels'      => $labels + array(
				'prev' => __( 'Trước', 'starter-flexible' ),
				'next' => __( 'Sau', 'starter-flexible' ),
			),
			'icons'       => starter_flexible_island_icons(
				array(
					'caret' => array( 'chevronDown', 16 ),
					'arrow' => array( 'arrow', 17 ),
					'sort'  => array( 'sort', 15, 'el__arrow-icon el__arrow-icon--idle' ),
					'asc'   => array( 'arrowUp', 15, 'el__arrow-icon el__arrow-icon--asc' ),
					'desc'  => array( 'arrowDown', 15, 'el__arrow-icon el__arrow-icon--desc' ),
					'prev'  => array( 'chevronLeft', 18 ),
					'next'  => array( 'chevronRight', 18 ),
				)
			) + array(
				'copySm'  => $copy_sm,
				'checkSm' => $check_sm,
			),
		);

		return $data;
	}
}

function starter_flexible_block_data_engine_lookup( array $block ) {
	$data                       = ( new Starter_Flexible_Block_Engine_Lookup( $block ) )->data();
	$data->props['moduleClass'] = $data->module_class;
	return $data;
}
