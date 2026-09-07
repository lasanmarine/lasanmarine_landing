<?php
/**
 * CTA Banner — one ask, at most two buttons, no contact details.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Starter_Flexible_Block_Cta_Banner extends Starter_Flexible_Abstract_Block {
	protected function defaults(): array {
		return array(
			'label'         => '',
			'heading'       => '',
			'content'       => '',
			'primary_cta'   => array(),
			'secondary_cta' => array(),
			'theme'         => 'navy',
			'custom_class'  => '',
		);
	}

	protected function base_class(): string {
		return 'block';
	}

	/** @param mixed $link */
	private function link( $link ): array {
		$link = is_array( $link ) ? $link : array();
		$url  = isset( $link['url'] ) ? (string) $link['url'] : '';

		return array(
			'url'    => $url,
			'label'  => isset( $link['title'] ) ? (string) $link['title'] : '',
			'target' => ! empty( $link['target'] ) ? (string) $link['target'] : '_self',
			'has'    => '' !== $url && $this->has_text( $link['title'] ?? '' ),
		);
	}

	protected function prepare( array $data ): array {
		$theme = in_array( $data['theme'], array( 'navy', 'pale', 'outline' ), true ) ? (string) $data['theme'] : 'navy';

		$band = array(
			'navy'    => 'band--navy-mid',
			'pale'    => 'band--pale',
			'outline' => 'cb--outline',
		);

		$data['theme']         = $theme;
		$data['band_class']    = $band[ $theme ];
		$data['is_dark']       = 'navy' === $theme;
		$data['primary_cta']   = $this->link( $data['primary_cta'] );
		$data['secondary_cta'] = $this->link( $data['secondary_cta'] );
		$data['has_label']     = $this->has_text( $data['label'] );
		$data['has_content']   = $this->has_text( $data['content'] );
		$data['has_actions']   = $data['primary_cta']['has'] || $data['secondary_cta']['has'];
		$data['should_render'] = $this->has_text( $data['heading'] ) || $data['has_actions'];

		return $data;
	}
}

function starter_flexible_block_data_cta_banner( array $block ) {
	return ( new Starter_Flexible_Block_Cta_Banner( $block ) )->data();
}
