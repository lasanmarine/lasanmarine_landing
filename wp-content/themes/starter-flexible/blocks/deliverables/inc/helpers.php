<?php
/**
 * Deliverables — what the customer receives, item by item, with the format of
 * each file and one note (typically lead time). Speaks to "fast and clear".
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Starter_Flexible_Block_Deliverables extends Starter_Flexible_Abstract_Block {
	protected function defaults(): array {
		return array( 'heading' => '', 'intro' => '', 'note_label' => '', 'note' => '', 'items' => array(), 'custom_class' => '' );
	}

	protected function base_class(): string {
		return 'block container';
	}

	protected function prepare( array $data ): array {
		$items = array();
		foreach ( (array) $data['items'] as $item ) {
			$title = trim( (string) ( $item['title'] ?? '' ) );
			if ( '' === $title ) {
				continue;
			}
			$items[] = array(
				'title'  => $title,
				'desc'   => trim( (string) ( $item['desc'] ?? '' ) ),
				'format' => trim( (string) ( $item['format'] ?? '' ) ),
			);
		}
		$data['items']         = $items;
		$data['has_note']      = $this->has_text( $data['note'] );
		$data['should_render'] = ! empty( $items );
		return $data;
	}
}

function starter_flexible_block_data_deliverables( array $block ) {
	return ( new Starter_Flexible_Block_Deliverables( $block ) )->data();
}
