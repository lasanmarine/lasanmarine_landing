<?php
/**
 * Key Numbers — the statistics band.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Starter_Flexible_Block_Key_Numbers extends Starter_Flexible_Abstract_Block {
	protected function defaults(): array {
		return array(
			'label'        => 'KEY NUMBERS',
			'stats'        => array(),
			'custom_class' => '',
		);
	}

	protected function base_class(): string {
		return 'block';
	}

	protected function prepare( array $data ): array {

		$stats = array();
		foreach ( (array) $data['stats'] as $stat ) {
			$value = isset( $stat['value'] ) ? (string) $stat['value'] : '';
			if ( '' === trim( $value ) ) {
				continue;
			}
			$stats[] = array(
				'value'  => $value,
				'suffix' => isset( $stat['suffix'] ) ? (string) $stat['suffix'] : '',
				'label'  => isset( $stat['label'] ) ? (string) $stat['label'] : '',
				'note'   => isset( $stat['note'] ) ? (string) $stat['note'] : '',
			);
		}

		$data['stats']         = $stats;
		$data['has_label']     = '' !== trim( (string) $data['label'] );
		$data['should_render'] = ! empty( $stats );

		return $data;
	}
}

function starter_flexible_block_data_key_numbers( array $block ) {
	return ( new Starter_Flexible_Block_Key_Numbers( $block ) )->data();
}
