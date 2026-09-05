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
			'all_label'    => 'TẤT CẢ',
			'groups'       => array(),
			'empty_text'   => 'Không có kết quả.',
			'custom_class' => '',
		),
		starter_flexible_get_block_fields( $block )
	);

	$filters = array();
	$items   = array();

	foreach ( (array) $data['groups'] as $group ) {
		$name = isset( $group['name'] ) ? trim( (string) $group['name'] ) : '';
		if ( '' === $name ) {
			continue;
		}

		$rows = array();
		foreach ( (array) ( $group['items'] ?? array() ) as $item ) {
			$title = isset( $item['title'] ) ? (string) $item['title'] : '';
			if ( '' === trim( $title ) ) {
				continue;
			}
			$file = isset( $item['file'] ) ? (string) $item['file'] : '';
			$rows[] = array(
				'title'  => $title,
				'size'   => isset( $item['size'] ) ? (string) $item['size'] : '',
				'file'   => $file,
				// Only a PDF can be handed to the browser's own viewer.
				'is_pdf' => '' !== $file && 'pdf' === strtolower( (string) pathinfo( wp_parse_url( $file, PHP_URL_PATH ) ?? '', PATHINFO_EXTENSION ) ),
			);
		}

		if ( empty( $rows ) ) {
			continue;
		}

		$index     = count( $filters );
		$filters[] = $name;
		foreach ( $rows as $row ) {
			$row['group'] = $index;
			$items[]      = $row;
		}
	}

	$data['all_label']     = '' !== trim( (string) $data['all_label'] ) ? (string) $data['all_label'] : 'TẤT CẢ';
	$data['filters']       = $filters;
	$data['items']         = $items;
	$data['has_label']     = '' !== trim( (string) $data['label'] );
	$data['module_class']  = starter_flexible_build_module_class( 'block container', (string) $data['custom_class'] );
	$data['should_render'] = ! empty( $items );

	return (object) $data;
}
