<?php
/**
 * Process Timeline — the process rail. A marine line fills as the block
 * scrolls past.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function starter_flexible_block_data_process_timeline( array $block ) {
	$data = array_merge(
		array( 'label' => 'PROCESS TIMELINE', 'heading' => '', 'steps' => array(), 'custom_class' => '' ),
		starter_flexible_get_block_fields( $block )
	);

	$steps = array();
	foreach ( (array) $data['steps'] as $step ) {
		$title = isset( $step['title'] ) ? (string) $step['title'] : '';
		if ( '' === trim( $title ) ) {
			continue;
		}
		$steps[] = array(
			'index' => isset( $step['index'] ) ? (string) $step['index'] : '',
			'title' => $title,
			'desc'  => isset( $step['desc'] ) ? (string) $step['desc'] : '',
		);
	}

	$data['steps']         = $steps;
	$data['module_class']  = starter_flexible_build_module_class( 'block container', (string) $data['custom_class'] );
	$data['should_render'] = ! empty( $steps );

	return (object) $data;
}
