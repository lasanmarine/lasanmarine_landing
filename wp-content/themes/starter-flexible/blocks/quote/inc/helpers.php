<?php
/**
 * Quote — one real statement, set large.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Starter_Flexible_Block_Quote extends Starter_Flexible_Abstract_Block {
	protected function defaults(): array {
		return array(
			'quote'        => '',
			'author'       => '',
			'role'         => '',
			'company'      => '',
			'image'        => 0,
			'custom_class' => '',
		);
	}

	protected function base_class(): string {
		return 'block container';
	}

	protected function prepare( array $data ): array {
		$image_id = (int) $data['image'];

		// Role and company read as one line: "Giám đốc kỹ thuật · Công ty X".
		$attribution = array_filter(
			array( trim( (string) $data['role'] ), trim( (string) $data['company'] ) ),
			static function ( string $part ): bool {
				return '' !== $part;
			}
		);

		$data['image_url']     = $image_id ? (string) wp_get_attachment_image_url( $image_id, 'medium' ) : '';
		$data['attribution']   = implode( ' · ', $attribution );
		$data['has_author']    = $this->has_text( $data['author'] );
		$data['has_meta']      = '' !== $data['attribution'];
		$data['should_render'] = $this->has_text( $data['quote'] );

		return $data;
	}
}

function starter_flexible_block_data_quote( array $block ) {
	return ( new Starter_Flexible_Block_Quote( $block ) )->data();
}
