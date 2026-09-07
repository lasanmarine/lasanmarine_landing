<?php
/**
 * Accordion — ruled rows that open one answer at a time, never cards.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Starter_Flexible_Block_Accordion extends Starter_Flexible_Abstract_Block {
	protected function defaults(): array {
		return array(
			'label'        => '',
			'heading'      => '',
			'intro'        => '',
			'items'        => array(),
			'open_first'   => true,
			'custom_class' => '',
		);
	}

	protected function base_class(): string {
		return 'block container';
	}

	protected function prepare( array $data ): array {
		$uid   = $this->unique_id( 'ac-' );
		$items = array();

		foreach ( (array) $data['items'] as $index => $item ) {
			$title   = isset( $item['title'] ) ? (string) $item['title'] : '';
			$content = isset( $item['content'] ) ? (string) $item['content'] : '';

			if ( ! $this->has_text( $title ) ) {
				continue;
			}

			$items[] = array(
				'title'      => $title,
				'content'    => $content,
				'has_body'   => $this->has_text( wp_strip_all_tags( $content ) ),
				'panel_id'   => $uid . '-panel-' . $index,
				'button_id'  => $uid . '-button-' . $index,
				'is_open'    => ! empty( $data['open_first'] ) && empty( $items ),
			);
		}

		$data['items']         = $items;
		$data['has_label']     = $this->has_text( $data['label'] );
		$data['has_heading']   = $this->has_text( $data['heading'] );
		$data['has_intro']     = $this->has_text( $data['intro'] );
		$data['should_render'] = ! empty( $items );

		return $data;
	}
}

function starter_flexible_block_data_accordion( array $block ) {
	return ( new Starter_Flexible_Block_Accordion( $block ) )->data();
}
