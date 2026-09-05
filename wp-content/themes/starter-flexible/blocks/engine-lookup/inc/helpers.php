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

function starter_flexible_block_data_engine_lookup( array $block ) {
	$data = array_merge(
		array( 'custom_class' => '' ),
		starter_flexible_get_block_fields( $block )
	);

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
	$data['module_class']  = starter_flexible_build_module_class( 'pc el', (string) $data['custom_class'] );
	$data['should_render'] = ! empty( $rows );

	return (object) $data;
}
