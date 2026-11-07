<?php
/**
 * Vessel Finder — "which vessel do you need designed?" cards, each leading to
 * its landing page. The first card is the featured (larger) one.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Starter_Flexible_Block_Vessel_Finder extends Starter_Flexible_Abstract_Block {
	protected function defaults(): array {
		return array( 'heading' => '', 'intro' => '', 'items' => array(), 'custom_class' => '' );
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
			$link     = is_array( $item['link'] ?? null ) ? $item['link'] : array();
			$items[]  = array(
				'title'    => $title,
				'desc'     => (string) ( $item['desc'] ?? '' ),
				'icon'     => (string) ( $item['icon'] ?? 'ship' ),
				'image_id' => (int) ( $item['image'] ?? 0 ),
				'url'      => (string) ( $link['url'] ?? '' ),
				'target'   => ! empty( $link['target'] ) ? (string) $link['target'] : '_self',
			);
		}
		$data['items']         = $items;
		$data['should_render'] = ! empty( $items );
		return $data;
	}
}

function starter_flexible_block_data_vessel_finder( array $block ) {
	return ( new Starter_Flexible_Block_Vessel_Finder( $block ) )->data();
}
