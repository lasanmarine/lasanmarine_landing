<?php
/**
 * Job List — the open-positions list. Same row grammar as the service index;
 * each row leads to the application form, so the arrow is a real affordance.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Starter_Flexible_Block_Job_List extends Starter_Flexible_Abstract_Block {
	protected function defaults(): array {
		return array( 'label' => 'OPEN POSITIONS', 'apply_link' => array(), 'items' => array(), 'custom_class' => '' );
	}

	protected function base_class(): string {
		return 'block container';
	}

	protected function prepare( array $data ): array {

		$items = array();
		foreach ( (array) $data['items'] as $item ) {
			$role = isset( $item['role'] ) ? (string) $item['role'] : '';
			if ( '' === trim( $role ) ) {
				continue;
			}
			$items[] = array(
				'role'     => $role,
				'location' => isset( $item['location'] ) ? (string) $item['location'] : '',
				'type'     => isset( $item['type'] ) ? (string) $item['type'] : '',
			);
		}

		$apply = is_array( $data['apply_link'] ) ? $data['apply_link'] : array();

		$data['items']         = $items;
		$data['apply_href']    = isset( $apply['url'] ) ? (string) $apply['url'] : '';
		$data['should_render'] = ! empty( $items );

		return $data;
	}
}

function starter_flexible_block_data_job_list( array $block ) {
	return ( new Starter_Flexible_Block_Job_List( $block ) )->data();
}
