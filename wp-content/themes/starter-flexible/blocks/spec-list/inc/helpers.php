<?php
/**
 * Spec List — technical data as ruled rows, never an office table.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Starter_Flexible_Block_Spec_List extends Starter_Flexible_Abstract_Block {
	protected function defaults(): array {
		return array( 'heading' => '', 'note' => '', 'rows' => array(), 'custom_class' => '' );
	}

	protected function base_class(): string {
		return 'block container';
	}

	protected function prepare( array $data ): array {

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
		$data['has_note']      = '' !== trim( (string) $data['note'] );
		$data['should_render'] = ! empty( $rows ) || '' !== trim( (string) $data['heading'] );

		return $data;
	}
}

function starter_flexible_block_data_spec_list( array $block ) {
	return ( new Starter_Flexible_Block_Spec_List( $block ) )->data();
}
