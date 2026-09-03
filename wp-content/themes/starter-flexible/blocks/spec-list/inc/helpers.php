<?php
/**
 * Spec List — technical data as ruled rows, never an office table.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function starter_flexible_block_data_spec_list( array $block ) {
	$data = array_merge(
		array( 'label' => '', 'heading' => '', 'note' => '', 'rows' => array(), 'custom_class' => '' ),
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

	$data['rows']          = $rows;
	$data['has_label']     = '' !== trim( (string) $data['label'] );
	$data['has_note']      = '' !== trim( (string) $data['note'] );
	$data['module_class']  = starter_flexible_build_module_class( 'block container', (string) $data['custom_class'] );
	$data['should_render'] = ! empty( $rows ) || '' !== trim( (string) $data['heading'] );

	return (object) $data;
}
