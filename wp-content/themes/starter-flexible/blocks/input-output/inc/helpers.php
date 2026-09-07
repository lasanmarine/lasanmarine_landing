<?php
/**
 * Input / Output — what we need, what we do, what you get.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Starter_Flexible_Block_Input_Output extends Starter_Flexible_Abstract_Block {
	protected function defaults(): array {
		return array(
			'label'         => '',
			'heading'       => '',
			'intro'         => '',
			'input_title'   => '',
			'input'         => array(),
			'process_title' => '',
			'process'       => array(),
			'output_title'  => '',
			'output'        => array(),
			'custom_class'  => '',
		);
	}

	protected function base_class(): string {
		return 'block container';
	}

	/**
	 * @param mixed $rows
	 *
	 * @return string[]
	 */
	private function texts( $rows ): array {
		$out = array();

		foreach ( (array) $rows as $row ) {
			$text = isset( $row['text'] ) ? (string) $row['text'] : '';
			if ( $this->has_text( $text ) ) {
				$out[] = $text;
			}
		}

		return $out;
	}

	protected function prepare( array $data ): array {
		$columns  = array();
		$defaults = array(
			'input'   => __( 'Đầu vào', 'starter-flexible' ),
			'process' => __( 'Xử lý', 'starter-flexible' ),
			'output'  => __( 'Đầu ra', 'starter-flexible' ),
		);

		foreach ( $defaults as $key => $default_title ) {
			$items = $this->texts( $data[ $key ] );
			if ( ! $items ) {
				continue;
			}

			$title = (string) $data[ $key . '_title' ];

			$columns[] = array(
				'kind'  => $key,
				'title' => $this->has_text( $title ) ? $title : $default_title,
				'items' => $items,
			);
		}

		$data['columns']       = $columns;
		$data['has_label']     = $this->has_text( $data['label'] );
		$data['has_heading']   = $this->has_text( $data['heading'] );
		$data['has_intro']     = $this->has_text( $data['intro'] );
		$data['should_render'] = ! empty( $columns );

		return $data;
	}
}

function starter_flexible_block_data_input_output( array $block ) {
	return ( new Starter_Flexible_Block_Input_Output( $block ) )->data();
}
