<?php
/**
 * Proof Strip — a glanceable row of evidence between two sections.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Starter_Flexible_Block_Proof_Strip extends Starter_Flexible_Abstract_Block {
	protected function defaults(): array {
		return array( 'items' => array(), 'custom_class' => '' );
	}

	protected function base_class(): string {
		return 'block';
	}

	protected function prepare( array $data ): array {
		$items = array();

		foreach ( (array) $data['items'] as $item ) {
			$value = isset( $item['value'] ) ? (string) $item['value'] : '';
			$label = isset( $item['label'] ) ? (string) $item['label'] : '';

			if ( ! $this->has_text( $value ) && ! $this->has_text( $label ) ) {
				continue;
			}

			$link     = isset( $item['link'] ) && is_array( $item['link'] ) ? $item['link'] : array();
			$link_url = isset( $link['url'] ) ? (string) $link['url'] : '';

			$items[] = array(
				'value'       => $value,
				'label'       => $label,
				'note'        => isset( $item['note'] ) ? (string) $item['note'] : '',
				'has_note'    => $this->has_text( $item['note'] ?? '' ),
				'link_url'    => $link_url,
				'link_target' => ! empty( $link['target'] ) ? (string) $link['target'] : '_self',
				'has_link'    => '' !== $link_url,
			);
		}

		$data['items']         = $items;
		$data['should_render'] = ! empty( $items );

		return $data;
	}
}

function starter_flexible_block_data_proof_strip( array $block ) {
	return ( new Starter_Flexible_Block_Proof_Strip( $block ) )->data();
}
