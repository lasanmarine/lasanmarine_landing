<?php
/**
 * Manifesto — the statement block. Heading left, argument right.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function starter_flexible_block_data_manifesto( array $block ) {
	$data = array_merge(
		array(
			'label'        => '',
			'heading'      => '',
			'lead'         => '',
			'body'         => array(),
			'cta'          => array(),
			'custom_class' => '',
		),
		starter_flexible_get_block_fields( $block )
	);

	$body = array();
	foreach ( (array) $data['body'] as $row ) {
		$text = isset( $row['text'] ) ? (string) $row['text'] : '';
		if ( '' !== trim( $text ) ) {
			$body[] = $text;
		}
	}

	$cta     = is_array( $data['cta'] ) ? $data['cta'] : array();
	$cta_url = isset( $cta['url'] ) ? (string) $cta['url'] : '';

	$data['body']         = $body;
	$data['cta']          = array(
		'url'    => $cta_url,
		'label'  => isset( $cta['title'] ) ? (string) $cta['title'] : '',
		'target' => ! empty( $cta['target'] ) ? (string) $cta['target'] : '_self',
	);
	$data['has_cta']      = '' !== $cta_url && '' !== $data['cta']['label'];
	$data['has_label']    = '' !== trim( (string) $data['label'] );
	$data['has_lead']     = '' !== trim( wp_strip_all_tags( (string) $data['lead'] ) );
	$data['module_class'] = starter_flexible_build_module_class( 'block container', (string) $data['custom_class'] );
	$data['should_render'] = '' !== trim( (string) $data['heading'] ) || $data['has_lead'] || ! empty( $body );

	return (object) $data;
}
