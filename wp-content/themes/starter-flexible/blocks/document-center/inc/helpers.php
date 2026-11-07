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
			'heading'      => '',
			'view_all'     => array(),
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
				// "Title (Journal, 2024)": the source and year read as the
				// card's meta line, the title on its own.
				$source = '';
				$year   = '';
				if ( preg_match( '/^(.*\S)\s*\(([^()]*?)[,\s]+((?:19|20)\d{2})\)\s*$/u', $title, $m ) ) {
					$title  = $m[1];
					$source = trim( $m[2], " ,	" );
					$year   = $m[3];
				}
				$rows[] = array(
					'title'  => $title,
					'source' => $source,
					'year'   => $year,
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
			$filters[] = starter_flexible_document_center_sentence_case( $name );
			foreach ( $rows as $row ) {
				$row['group'] = $index;
				$items[]      = $row;
			}
		}

		$data['all_label']     = starter_flexible_document_center_sentence_case( '' !== trim( (string) $data['all_label'] ) ? (string) $data['all_label'] : 'Tất cả' );
		$data['contact_url']   = (string) home_url( function_exists( 'pll_current_language' ) && 'en' === pll_current_language( 'slug' ) ? '/en/contact/' : '/lien-he/' );
		$data['filters']       = $filters;
		$data['items']         = $items;
		$data['has_label']     = '' !== trim( (string) $data['label'] );
		$data['heading']       = trim( (string) $data['heading'] );
		$view_all              = is_array( $data['view_all'] ) ? $data['view_all'] : array();
		$data['view_all_url']  = isset( $view_all['url'] ) ? (string) $view_all['url'] : '';
		$data['view_all_text'] = isset( $view_all['title'] ) ? (string) $view_all['title'] : '';
		$data['should_render'] = ! empty( $items );

		return $data;
	}
}

function starter_flexible_block_data_document_center( array $block ) {
	return ( new Starter_Flexible_Block_Document_Center( $block ) )->data();
}

/** Labels typed in capitals read as sentence case, like every other filter. */
function starter_flexible_document_center_sentence_case( string $text ): string {
	$text = trim( $text );
	if ( $text !== mb_strtoupper( $text, 'UTF-8' ) ) {
		return $text;
	}
	$lower = mb_strtolower( $text, 'UTF-8' );
	$keep  = array( 'r&d' => 'R&D', 'cfd' => 'CFD' );
	$lower = str_replace( array_keys( $keep ), array_values( $keep ), $lower );
	return mb_strtoupper( mb_substr( $lower, 0, 1, 'UTF-8' ), 'UTF-8' ) . mb_substr( $lower, 1, null, 'UTF-8' );
}
