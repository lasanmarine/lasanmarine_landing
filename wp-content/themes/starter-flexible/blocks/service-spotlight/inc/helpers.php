<?php
/**
 * Service Spotlight — one service, half image half navy panel.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function starter_flexible_block_data_service_spotlight( array $block ) {
	$data = array_merge(
		array(
			'label'        => '',
			'image'        => 0,
			'placeholder'  => '',
			'caption'      => '',
			'heading'      => '',
			'body'         => '',
			'items'        => array(),
			'cta'          => array(),
			'custom_class' => '',
		),
		starter_flexible_get_block_fields( $block )
	);

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
	$data['module_class']  = starter_flexible_build_module_class( 'block', (string) $data['custom_class'] );
	$data['should_render'] = '' !== trim( (string) $data['heading'] ) || '' !== trim( (string) $data['body'] ) || ! empty( $items );

	return (object) $data;
}
