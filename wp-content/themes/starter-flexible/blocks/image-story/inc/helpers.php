<?php
/**
 * Image Story — the field gallery, with a lightbox.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Starter_Flexible_Block_Image_Story extends Starter_Flexible_Abstract_Block {
	protected function defaults(): array {
		return array( 'label' => 'IMAGE STORY', 'items' => array(), 'note' => '', 'custom_class' => '' );
	}

	protected function base_class(): string {
		return 'block container';
	}

	protected function prepare( array $data ): array {

		$items = array();
		foreach ( (array) $data['items'] as $item ) {
			$image_id    = isset( $item['image'] ) ? (int) $item['image'] : 0;
			$placeholder = isset( $item['placeholder'] ) ? (string) $item['placeholder'] : '';
			$caption     = isset( $item['caption'] ) ? (string) $item['caption'] : '';

			if ( ! $image_id && '' === trim( $placeholder ) && '' === trim( $caption ) ) {
				continue;
			}

			$items[] = array(
				'thumb'       => $image_id ? (string) wp_get_attachment_image_url( $image_id, 'large' ) : '',
				'full'        => $image_id ? (string) wp_get_attachment_image_url( $image_id, 'full' ) : '',
				'placeholder' => $placeholder,
				'caption'     => $caption,
			);
		}

		$data['items']         = $items;
		$data['has_note']      = '' !== trim( (string) $data['note'] );
		$data['should_render'] = ! empty( $items );

		return $data;
	}
}

function starter_flexible_block_data_image_story( array $block ) {
	return ( new Starter_Flexible_Block_Image_Story( $block ) )->data();
}
