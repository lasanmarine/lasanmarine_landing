<?php
/**
 * Tool Shell — the shared frame every calculator sits in.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function starter_flexible_block_data_tool_shell( array $block ) {
	$data = array_merge(
		array( 'custom_class' => '' ),
		starter_flexible_get_block_fields( $block )
	);

	$data['module_class']  = starter_flexible_build_module_class( 'block container', (string) $data['custom_class'] );
	$data['should_render'] = true;

	return (object) $data;
}
