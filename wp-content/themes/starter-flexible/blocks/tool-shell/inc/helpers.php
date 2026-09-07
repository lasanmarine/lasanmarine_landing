<?php
/**
 * Tool Shell — the shared frame every calculator sits in.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Starter_Flexible_Block_Tool_Shell extends Starter_Flexible_Abstract_Block {
	protected function defaults(): array {
		return array( 'custom_class' => '' );
	}

	protected function base_class(): string {
		return 'block container';
	}

	protected function prepare( array $data ): array {

		$data['should_render'] = true;

		$data['allowed'] = wp_json_encode( array( 'acf/engine-lookup', 'acf/power-converter', 'acf/shaft-diameter' ) );
		$data['template'] = wp_json_encode( array() );

		return $data;
	}
}

function starter_flexible_block_data_tool_shell( array $block ) {
	return ( new Starter_Flexible_Block_Tool_Shell( $block ) )->data();
}
