<?php
/**
 * Document Center — the document list, filtered client-side.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function starter_flexible_block_data_document_center( array $block ) {
	$data = array_merge(
		array(
			'label'        => '',
			'filters'      => array(),
			'items'        => array(),
			'empty_text'   => 'Không có kết quả.',
			'custom_class' => '',
		),
		starter_flexible_get_block_fields( $block )
	);

	$filters = array();
	foreach ( (array) $data['filters'] as $filter ) {
		$name = isset( $filter['name'] ) ? (string) $filter['name'] : '';
		if ( '' !== trim( $name ) ) {
			$filters[] = $name;
		}
	}

	$items = array();
	foreach ( (array) $data['items'] as $item ) {
		$title = isset( $item['title'] ) ? (string) $item['title'] : '';
		if ( '' === trim( $title ) ) {
			continue;
		}
		$items[] = array(
			'title' => $title,
			'group' => isset( $item['group'] ) ? (string) $item['group'] : '',
			'size'  => isset( $item['size'] ) ? (string) $item['size'] : '',
			'file'  => isset( $item['file'] ) ? (string) $item['file'] : '',
		);
	}

	$data['filters']       = $filters;
	$data['items']         = $items;
	$data['has_label']     = '' !== trim( (string) $data['label'] );
	$data['module_class']  = starter_flexible_build_module_class( 'block container', (string) $data['custom_class'] );
	$data['should_render'] = ! empty( $items );

	return (object) $data;
}
