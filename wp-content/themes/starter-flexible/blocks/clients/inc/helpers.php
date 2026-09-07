<?php
/**
 * Clients — the client wall.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Starter_Flexible_Block_Clients extends Starter_Flexible_Abstract_Block {
	protected function defaults(): array {
		return array( 'label' => 'CLIENTS & PARTNERS', 'logo_size' => 54, 'items' => array(), 'custom_class' => '' );
	}

	protected function base_class(): string {
		return 'block container';
	}

	protected function prepare( array $data ): array {

		$items = array();
		foreach ( (array) $data['items'] as $item ) {
			$name    = isset( $item['name'] ) ? (string) $item['name'] : '';
			$logo_id = isset( $item['logo'] ) ? (int) $item['logo'] : 0;
			$logo    = $logo_id ? (string) wp_get_attachment_image_url( $logo_id, 'medium' ) : '';
			if ( '' !== trim( $name ) || '' !== $logo ) {
				$items[] = array( 'name' => $name, 'logo' => $logo );
			}
		}

		$logo_size             = (int) $data['logo_size'];
		$data['logo_size']     = $logo_size > 0 ? min( 400, max( 8, $logo_size ) ) : 54;
		$data['items']         = $items;
		$data['should_render'] = ! empty( $items );

		return $data;
	}
}

function starter_flexible_block_data_clients( array $block ) {
	return ( new Starter_Flexible_Block_Clients( $block ) )->data();
}
