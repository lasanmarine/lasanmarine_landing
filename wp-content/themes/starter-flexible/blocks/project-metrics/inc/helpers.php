<?php
/**
 * Project Metrics — the project fact row plus its measured outcomes.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function starter_flexible_block_data_project_metrics( array $block ) {
	$data = array_merge(
		array( 'label' => 'PROJECT METRICS', 'rows' => array(), 'stats' => array(), 'custom_class' => '' ),
		starter_flexible_get_block_fields( $block )
	);

	$rows = array();
	foreach ( (array) $data['rows'] as $row ) {
		$label = isset( $row['label'] ) ? (string) $row['label'] : '';
		$value = isset( $row['value'] ) ? (string) $row['value'] : '';
		if ( '' === trim( $label ) && '' === trim( $value ) ) {
			continue;
		}
		$rows[] = array( 'label' => $label, 'value' => $value );
	}

	$stats = array();
	foreach ( (array) $data['stats'] as $stat ) {
		$value = isset( $stat['value'] ) ? (string) $stat['value'] : '';
		if ( '' === trim( $value ) ) {
			continue;
		}
		$stats[] = array(
			'value'  => $value,
			'suffix' => isset( $stat['suffix'] ) ? (string) $stat['suffix'] : '',
			'note'   => isset( $stat['note'] ) ? (string) $stat['note'] : '',
		);
	}

	$data['rows']          = $rows;
	$data['stats']         = $stats;
	$data['module_class']  = starter_flexible_build_module_class( 'block container', (string) $data['custom_class'] );
	$data['should_render'] = ! empty( $rows ) || ! empty( $stats );

	return (object) $data;
}
