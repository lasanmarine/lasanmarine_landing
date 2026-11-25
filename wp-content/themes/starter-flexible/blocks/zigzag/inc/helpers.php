<?php
/**
 * Zigzag — cases set alternately left and right of a vertical spine, each
 * with a numbered node on it: the situation as a short title, what it needs
 * as the text. One column with the spine on the left on narrow screens.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Starter_Flexible_Block_Zigzag extends Starter_Flexible_Abstract_Block {
	protected function defaults(): array {
		return array( 'heading' => '', 'heading_level' => 'h2', 'intro' => '', 'items' => array(), 'custom_class' => '' );
	}

	protected function base_class(): string {
		return 'block container';
	}

	protected function prepare( array $data ): array {
		$items = array();
		foreach ( (array) $data['items'] as $item ) {
			$title = trim( (string) ( $item['title'] ?? '' ) );
			$text  = trim( (string) ( $item['text'] ?? '' ) );
			if ( '' === $title && '' === $text ) {
				continue;
			}
			$items[] = array( 'title' => $title, 'text' => $text );
		}

		$data['heading_tag']   = 'h1' === $data['heading_level'] ? 'h1' : 'h2';
		$data['items']         = $items;
		$data['has_intro']     = $this->has_text( $data['intro'] );
		$data['should_render'] = ! empty( $items );

		return $data;
	}
}

function starter_flexible_block_data_zigzag( array $block ) {
	return ( new Starter_Flexible_Block_Zigzag( $block ) )->data();
}
