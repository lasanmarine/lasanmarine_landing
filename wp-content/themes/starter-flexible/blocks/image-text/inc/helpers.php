<?php
/**
 * Image + Text — a column of copy beside one framed picture.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Starter_Flexible_Block_Image_Text extends Starter_Flexible_Abstract_Block {
	protected function defaults(): array {
		return array(
			'label'          => '',
			'heading'        => '',
			'content'        => '',
			'image'          => 0,
			'placeholder'    => '',
			'caption'        => '',
			'image_position' => 'right',
			'split'          => 'even',
			'ratio'          => 'ratio-4-3',
			'cta'            => array(),
			'custom_class'   => '',
		);
	}

	protected function base_class(): string {
		return 'block container';
	}

	protected function prepare( array $data ): array {
		$image_id = (int) $data['image'];
		$cta      = is_array( $data['cta'] ) ? $data['cta'] : array();
		$cta_url  = isset( $cta['url'] ) ? (string) $cta['url'] : '';

		$position = 'left' === $data['image_position'] ? 'left' : 'right';
		$split    = in_array( $data['split'], array( 'even', 'text', 'media' ), true ) ? (string) $data['split'] : 'even';
		$ratio    = in_array( $data['ratio'], array( 'ratio-4-3', 'ratio-3-2', 'ratio-16-9', 'ratio-1-1', 'ratio-4-5' ), true ) ? (string) $data['ratio'] : 'ratio-4-3';

		$data['grid_class'] = trim( 'it it--' . $split . ( 'left' === $position ? ' it--flip' : '' ) );
		$data['ratio']      = $ratio;
		$data['image_url']  = $image_id ? (string) wp_get_attachment_image_url( $image_id, 'large' ) : '';
		$data['image_alt']  = $image_id ? (string) get_post_meta( $image_id, '_wp_attachment_image_alt', true ) : '';
		$data['cta']        = array(
			'url'    => $cta_url,
			'label'  => isset( $cta['title'] ) ? (string) $cta['title'] : '',
			'target' => ! empty( $cta['target'] ) ? (string) $cta['target'] : '_self',
		);

		$data['has_cta']       = '' !== $cta_url && '' !== $data['cta']['label'];
		$data['has_label']     = $this->has_text( $data['label'] );
		$data['has_heading']   = $this->has_text( $data['heading'] );
		$data['has_content']   = $this->has_text( wp_strip_all_tags( (string) $data['content'] ) );
		$data['should_render'] = $data['has_heading'] || $data['has_content'] || '' !== $data['image_url'];

		return $data;
	}
}

function starter_flexible_block_data_image_text( array $block ) {
	return ( new Starter_Flexible_Block_Image_Text( $block ) )->data();
}
