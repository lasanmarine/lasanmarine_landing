<?php
/**
 * Geo Operations — the operating map.
 *
 * The outline is real geometry: Natural Earth 10m admin-0 (public domain),
 * Web Mercator, Douglas–Peucker simplified. Hoàng Sa and Trường Sa are far too
 * small to read at national scale, so each is marked and labelled instead of
 * being drawn to shape.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Load the shared map geometry, cached for the request.
 *
 * @return array<string, mixed>
 */
function starter_flexible_geo_map(): array {
	static $map = null;

	if ( null !== $map ) {
		return $map;
	}

	$json = file_get_contents( __DIR__ . '/vietnam-map.json' ); // phpcs:ignore WordPress.WP.AlternativeFunctions
	$map  = false !== $json ? (array) json_decode( $json, true ) : array();

	return $map;
}

final class Starter_Flexible_Block_Geo_Operations extends Starter_Flexible_Abstract_Block {
	protected function defaults(): array {
		return array( 'label' => '', 'heading' => '', 'note' => '', 'provinces' => array(), 'custom_class' => '' );
	}

	protected function base_class(): string {
		return 'block';
	}

	protected function prepare( array $data ): array {

		$provinces = array();
		foreach ( (array) $data['provinces'] as $province ) {
			$name = isset( $province['name'] ) ? (string) $province['name'] : '';
			if ( '' === trim( $name ) ) {
				continue;
			}
			$provinces[] = array(
				'name' => $name,
				'x'    => isset( $province['x'] ) ? (float) $province['x'] : 0.0,
				'y'    => isset( $province['y'] ) ? (float) $province['y'] : 0.0,
			);
		}

		$map = starter_flexible_geo_map();

		$data['provinces']     = $provinces;
		$data['map_width']     = isset( $map['width'] ) ? (int) $map['width'] : 1000;
		$data['map_height']    = isset( $map['height'] ) ? (int) $map['height'] : 1017;
		$data['map_outline']   = isset( $map['outline'] ) ? (string) $map['outline'] : '';
		$data['islands']       = array_values(
			array_filter(
				array( $map['paracel'] ?? null, $map['spratly'] ?? null )
			)
		);
		$data['has_label']     = '' !== trim( (string) $data['label'] );
		$data['has_note']      = '' !== trim( (string) $data['note'] );
		$data['should_render'] = '' !== trim( (string) $data['heading'] ) || ! empty( $provinces );

		$data['grid_x'] = array();
		$data['grid_y'] = array();
		for ( $i = 1; $i <= 7; $i++ ) {
		 $data['grid_x'][] = $i * $data['map_width'] / 8;
		 $data['grid_y'][] = $i * $data['map_height'] / 8;
		}
		foreach ( $data['islands'] as &$island ) {
		 $island['rect_x'] = $island['x'] - 22;
		 $island['rect_y'] = $island['y'] - 16;
		 $island['label_y'] = $island['y'] + 34;
		}
		unset( $island );

		return $data;
	}
}

function starter_flexible_block_data_geo_operations( array $block ) {
	return ( new Starter_Flexible_Block_Geo_Operations( $block ) )->data();
}
