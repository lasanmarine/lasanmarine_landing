<?php
/**
 * Document Center — the document list, filtered client-side.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Starter_Flexible_Block_Document_Center extends Starter_Flexible_Abstract_Block {
	protected function defaults(): array {
		return array(
			'label'        => '',
			'all_label'    => 'TẤT CẢ',
			'groups'       => array(),
			'empty_text'   => 'Không có kết quả.',
			'custom_class' => '',
		);
	}

	protected function base_class(): string {
		return 'block container';
	}

	protected function prepare( array $data ): array {

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
		$data['should_render'] = ! empty( $items );

		return $data;
	}
}

function starter_flexible_block_data_document_center( array $block ) {
	return ( new Starter_Flexible_Block_Document_Center( $block ) )->data();
}
