<?php
/**
 * Engine Lookup — a filterable, sortable, paginated table over the engine
 * dataset.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Load the bundled engine dataset, cached for the request.
 *
 * @return array<int, array<string, mixed>>
 */
function starter_flexible_engine_rows(): array {
	static $rows = null;

	if ( null !== $rows ) {
		return $rows;
	}

	$json = file_get_contents( __DIR__ . '/engines.json' ); // phpcs:ignore WordPress.WP.AlternativeFunctions
	$rows = false !== $json ? (array) json_decode( $json, true ) : array();

	return $rows;
}

function starter_flexible_block_data_engine_lookup( array $block ) {
	$data = array_merge(
		array( 'per_page' => 12, 'columns' => array(), 'labels' => array(), 'custom_class' => '' ),
		starter_flexible_get_block_fields( $block )
	);

	$columns = is_array( $data['columns'] ) ? $data['columns'] : array();
	$labels  = is_array( $data['labels'] ) ? $data['labels'] : array();
	$rows    = starter_flexible_engine_rows();

	// Column order drives the sort keys, so the two lists stay paired.
	$data['columns'] = array(
		array( 'key' => 'make', 'label' => (string) ( $columns['make'] ?? '' ) ),
		array( 'key' => 'model', 'label' => (string) ( $columns['model'] ?? '' ) ),
		array( 'key' => 'kw', 'label' => (string) ( $columns['kw'] ?? '' ) ),
		array( 'key' => 'rpm', 'label' => (string) ( $columns['rpm'] ?? '' ) ),
		array( 'key' => 'cylinders', 'label' => (string) ( $columns['cylinders'] ?? '' ) ),
	);

	$data['labels'] = array(
		'search'     => (string) ( $labels['search'] ?? 'TÌM KIẾM' ),
		'all_makes'  => (string) ( $labels['all_makes'] ?? 'Tất cả hãng' ),
		'min_power'  => (string) ( $labels['min_power'] ?? 'CÔNG SUẤT TỐI THIỂU (kW)' ),
		'rows_found' => (string) ( $labels['rows_found'] ?? 'kết quả' ),
		'no_results' => (string) ( $labels['no_results'] ?? 'Không có kết quả.' ),
	);

	$makes = array_values( array_unique( array_column( $rows, 'make' ) ) );
	sort( $makes );

	$data['rows']          = $rows;
	$data['makes']         = $makes;
	$data['per_page']      = max( 1, (int) $data['per_page'] );
	$data['module_class']  = starter_flexible_build_module_class( 'el', (string) $data['custom_class'] );
	$data['should_render'] = ! empty( $rows );

	return (object) $data;
}
