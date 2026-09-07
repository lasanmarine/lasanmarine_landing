<?php
/**
 * Rich Text — one column of editorial copy at a chosen measure.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Starter_Flexible_Block_Rich_Text extends Starter_Flexible_Abstract_Block {
	protected function defaults(): array {
		return array(
			'label'        => '',
			'heading'      => '',
			'content'      => '',
			'align'        => 'left',
			'width'        => 'medium',
			'custom_class' => '',
		);
	}

	protected function base_class(): string {
		return 'block container';
	}

	protected function prepare( array $data ): array {
		$align = 'center' === $data['align'] ? 'center' : 'left';
		$width = in_array( $data['width'], array( 'narrow', 'medium', 'wide' ), true ) ? (string) $data['width'] : 'medium';

		$data['column_class']  = trim( 'rt__column rt--' . $width . ( 'center' === $align ? ' rt--center' : '' ) );
		$data['has_label']     = $this->has_text( $data['label'] );
		$data['has_heading']   = $this->has_text( $data['heading'] );
		$data['has_content']   = $this->has_text( wp_strip_all_tags( (string) $data['content'] ) );
		$data['should_render'] = $data['has_heading'] || $data['has_content'];

		return $data;
	}
}

function starter_flexible_block_data_rich_text( array $block ) {
	return ( new Starter_Flexible_Block_Rich_Text( $block ) )->data();
}
