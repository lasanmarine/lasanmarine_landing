<?php
/**
 * Image Story — the field gallery, with a lightbox.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function starter_flexible_block_data_image_story( array $block ) {
	$data = array_merge(
		array( 'label' => 'IMAGE STORY', 'items' => array(), 'note' => '', 'custom_class' => '' ),
		starter_flexible_get_block_fields( $block )
	);

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
	$data['module_class']  = starter_flexible_build_module_class( 'block container', (string) $data['custom_class'] );
	$data['should_render'] = ! empty( $items );

	return (object) $data;
}
