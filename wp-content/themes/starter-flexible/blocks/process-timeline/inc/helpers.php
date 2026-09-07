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

final class Starter_Flexible_Block_Process_Timeline extends Starter_Flexible_Abstract_Block {
	protected function defaults(): array {
		return array( 'label' => 'PROCESS TIMELINE', 'steps' => array(), 'custom_class' => '' );
	}

	protected function base_class(): string {
		return 'block container';
	}

	protected function prepare( array $data ): array {

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
		$data['should_render'] = ! empty( $steps );

		return $data;
	}
}

function starter_flexible_block_data_process_timeline( array $block ) {
	return ( new Starter_Flexible_Block_Process_Timeline( $block ) )->data();
}
