<?php
/**
 * Section Intro — the centred sentence that opens a section.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Starter_Flexible_Block_Section_Intro extends Starter_Flexible_Abstract_Block {
	protected function defaults(): array {
		return array(
			'label'        => '',
			'heading'      => '',
			'content'      => '',
			'width'        => 'narrow',
			'cta'          => array(),
			'custom_class' => '',
		);
	}

	protected function base_class(): string {
		return 'block container';
	}

	protected function prepare( array $data ): array {
		$cta     = is_array( $data['cta'] ) ? $data['cta'] : array();
		$cta_url = isset( $cta['url'] ) ? (string) $cta['url'] : '';

		$width = in_array( $data['width'], array( 'narrow', 'medium' ), true ) ? (string) $data['width'] : 'narrow';

		$data['width_class']   = 'si--' . $width;
		$data['has_label']     = $this->has_text( $data['label'] );
		$data['has_content']   = $this->has_text( wp_strip_all_tags( (string) $data['content'] ) );
		$data['cta']           = array(
			'url'    => $cta_url,
			'label'  => isset( $cta['title'] ) ? (string) $cta['title'] : '',
			'target' => ! empty( $cta['target'] ) ? (string) $cta['target'] : '_self',
		);
		$data['has_cta']       = '' !== $cta_url && '' !== $data['cta']['label'];
		$data['should_render'] = $this->has_text( $data['heading'] ) || $data['has_content'];

		return $data;
	}
}

function starter_flexible_block_data_section_intro( array $block ) {
	return ( new Starter_Flexible_Block_Section_Intro( $block ) )->data();
}
