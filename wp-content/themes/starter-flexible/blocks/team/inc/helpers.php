<?php
/**
 * Team — the people list beside a documentary portrait.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Starter_Flexible_Block_Team extends Starter_Flexible_Abstract_Block {
	protected function defaults(): array {
		return array(
			'heading'      => '',
			'image'        => 0,
			'placeholder'  => '',
			'people'       => array(),
			'custom_class' => '',
		);
	}

	protected function base_class(): string {
		return 'block container';
	}

	protected function prepare( array $data ): array {

		$people = array();
		foreach ( (array) $data['people'] as $person ) {
			$name = isset( $person['name'] ) ? (string) $person['name'] : '';
			if ( '' === trim( $name ) ) {
				continue;
			}
			$people[] = array(
				'name'     => $name,
				'position' => isset( $person['position'] ) ? trim( (string) $person['position'] ) : '',
				'role'     => isset( $person['role'] ) ? (string) $person['role'] : '',
				'group'    => isset( $person['group'] ) ? trim( (string) $person['group'] ) : '',
			);
		}

		$image_id = (int) $data['image'];

		// Consecutive people sharing a group sit under one subheading.
		$groups = array();
		foreach ( $people as $person ) {
			$last = count( $groups ) - 1;
			if ( $last >= 0 && $groups[ $last ]['name'] === $person['group'] ) {
				$groups[ $last ]['people'][] = $person;
			} else {
				$groups[] = array( 'name' => $person['group'], 'people' => array( $person ) );
			}
		}

		$data['people']        = $people;
		$data['groups']        = $groups;
		$data['image_url']     = $image_id ? (string) wp_get_attachment_image_url( $image_id, 'large' ) : '';
		$data['should_render'] = ! empty( $people ) || '' !== trim( (string) $data['heading'] );

		return $data;
	}
}

function starter_flexible_block_data_team( array $block ) {
	return ( new Starter_Flexible_Block_Team( $block ) )->data();
}
