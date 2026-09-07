<?php
/**
 * Use Case — the customer's situation first, the service second.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Starter_Flexible_Block_Use_Case extends Starter_Flexible_Abstract_Block {
	protected function defaults(): array {
		return array(
			'label'        => '',
			'heading'      => '',
			'intro'        => '',
			'items'        => array(),
			'custom_class' => '',
		);
	}

	protected function base_class(): string {
		return 'block container';
	}

	protected function prepare( array $data ): array {
		$items = array();

		foreach ( (array) $data['items'] as $item ) {
			$problem = isset( $item['problem'] ) ? (string) $item['problem'] : '';
			if ( ! $this->has_text( $problem ) ) {
				continue;
			}

			$link     = isset( $item['link'] ) && is_array( $item['link'] ) ? $item['link'] : array();
			$link_url = isset( $link['url'] ) ? (string) $link['url'] : '';

			$items[] = array(
				'problem'      => $problem,
				'context'      => isset( $item['context'] ) ? (string) $item['context'] : '',
				'solution'     => isset( $item['solution'] ) ? (string) $item['solution'] : '',
				'has_context'  => $this->has_text( $item['context'] ?? '' ),
				'has_solution' => $this->has_text( $item['solution'] ?? '' ),
				'link_url'     => $link_url,
				'link_label'   => isset( $link['title'] ) ? (string) $link['title'] : '',
				'link_target'  => ! empty( $link['target'] ) ? (string) $link['target'] : '_self',
				'has_link'     => '' !== $link_url,
			);
		}

		$data['items']         = $items;
		$data['has_label']     = $this->has_text( $data['label'] );
		$data['has_heading']   = $this->has_text( $data['heading'] );
		$data['has_intro']     = $this->has_text( $data['intro'] );
		$data['should_render'] = ! empty( $items );

		return $data;
	}
}

function starter_flexible_block_data_use_case( array $block ) {
	return ( new Starter_Flexible_Block_Use_Case( $block ) )->data();
}
