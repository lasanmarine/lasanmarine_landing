<?php
/**
 * Enquiry Form — a heading/intro wrapper around a Contact Form 7 form chosen
 * in the block sidebar.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Starter_Flexible_Block_Enquiry_Form extends Starter_Flexible_Abstract_Block {
	protected function defaults(): array {
		return array(
			'heading'      => '',
			'note'         => '',
			'cf7_form'     => 0,
			'custom_class' => '',
		);
	}

	protected function base_class(): string {
		return 'block container';
	}

	protected function prepare( array $data ): array {

		$cf7_id = is_object( $data['cf7_form'] ) ? (int) $data['cf7_form']->ID : (int) $data['cf7_form'];

		$data['cf7_id']        = $cf7_id;
		$data['has_note']      = '' !== trim( (string) $data['note'] );
		$data['should_render'] = $cf7_id > 0 || '' !== trim( (string) $data['heading'] );

		$data['form_html'] = $data['cf7_id'] > 0 ? do_shortcode( sprintf( '[contact-form-7 id="%d"]', $data['cf7_id'] ) ) : '';

		$data['anchor'] = 'apply';

		return $data;
	}
}

function starter_flexible_block_data_enquiry_form( array $block ) {
	return ( new Starter_Flexible_Block_Enquiry_Form( $block ) )->data();
}
