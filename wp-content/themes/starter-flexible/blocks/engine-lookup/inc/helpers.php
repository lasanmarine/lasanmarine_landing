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
		'search'     => 'TÌM KIẾM',
		'all_makes'  => 'Tất cả hãng',
		'min_power'  => 'CÔNG SUẤT TỐI THIỂU (kW)',
		'rows_found' => 'kết quả',
		'no_results' => 'Không có kết quả.',
	);

	$makes = array_values( array_unique( array_column( $rows, 'make' ) ) );
	sort( $makes );

	$data['rows']          = $rows;
	$data['makes']         = $makes;
	$data['per_page']      = 12;
	$data['module_class']  = starter_flexible_build_module_class( 'el', (string) $data['custom_class'] );
	$data['should_render'] = ! empty( $rows );

	return (object) $data;
}
