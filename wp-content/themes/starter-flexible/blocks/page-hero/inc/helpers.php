<?php
/**
 * Page Hero — the compact hero every inner page opens with.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Starter_Flexible_Block_Page_Hero extends Starter_Flexible_Abstract_Block {
	protected function defaults(): array {
		return array(
			'headline'      => '',
			'lead'          => '',
			'image'         => 0,
			'placeholder'   => '',
			'heading_level' => 'h1',
			'height'        => 420,
			'custom_class'  => '',
		);
	}

	protected function base_class(): string {
		return 'phero band--navy';
	}

	protected function prepare( array $data ): array {

		$image_id = (int) $data['image'];

		$data['image_url']     = $image_id ? (string) wp_get_attachment_image_url( $image_id, 'full' ) : '';
		$data['heading_level'] = in_array( $data['heading_level'], array( 'h1', 'h2' ), true ) ? $data['heading_level'] : 'h1';
		$data['height']        = $data['height'] > 0 ? min( 800, max( 200, (int) $data['height'] ) ) : 420;
		$data['has_media']     = '' !== $data['image_url'] || '' !== trim( (string) $data['placeholder'] );
		$data['has_lead']      = '' !== trim( wp_strip_all_tags( (string) $data['lead'] ) );
		$data['should_render'] = '' !== trim( wp_strip_all_tags( (string) $data['headline'] ) ) || $data['has_lead'];

		return $data;
	}
}

function starter_flexible_block_data_page_hero( array $block ) {
	return ( new Starter_Flexible_Block_Page_Hero( $block ) )->data();
}
