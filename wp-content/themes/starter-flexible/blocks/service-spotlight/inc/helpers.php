<?php
/**
 * Service Spotlight — one service, half image half navy panel.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Starter_Flexible_Block_Service_Spotlight extends Starter_Flexible_Abstract_Block {
	protected function defaults(): array {
		return array(
			'label'        => '',
			'image'        => 0,
			'placeholder'  => '',
			'caption'      => '',
			'heading'      => '',
			'body'         => '',
			'items'        => array(),
			'cta'          => array(),
			'custom_class' => '',
		);
	}

	protected function base_class(): string {
		return 'block';
	}

	protected function prepare( array $data ): array {

		$items = array();
		foreach ( (array) $data['items'] as $item ) {
			$text = isset( $item['text'] ) ? (string) $item['text'] : '';
			if ( '' !== trim( $text ) ) {
				$items[] = $text;
			}
		}

		$image_id = (int) $data['image'];
		$cta      = is_array( $data['cta'] ) ? $data['cta'] : array();
		$cta_url  = isset( $cta['url'] ) ? (string) $cta['url'] : '';

		$data['items']     = $items;
		$data['image_url'] = $image_id ? (string) wp_get_attachment_image_url( $image_id, 'large' ) : '';
		$data['cta']       = array(
			'url'    => $cta_url,
			'label'  => isset( $cta['title'] ) ? (string) $cta['title'] : '',
			'target' => ! empty( $cta['target'] ) ? (string) $cta['target'] : '_self',
		);
		$data['has_cta']       = '' !== $cta_url && '' !== $data['cta']['label'];
		$data['has_label']     = '' !== trim( (string) $data['label'] );
		$data['should_render'] = '' !== trim( (string) $data['heading'] ) || '' !== trim( (string) $data['body'] ) || ! empty( $items );

		return $data;
	}
}

function starter_flexible_block_data_service_spotlight( array $block ) {
	return ( new Starter_Flexible_Block_Service_Spotlight( $block ) )->data();
}
