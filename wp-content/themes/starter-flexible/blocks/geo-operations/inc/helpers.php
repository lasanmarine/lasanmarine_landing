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

function starter_flexible_block_data_geo_operations( array $block ) {
	$data = array_merge(
		array( 'label' => '', 'heading' => '', 'note' => '', 'provinces' => array(), 'custom_class' => '' ),
		starter_flexible_get_block_fields( $block )
	);

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
	$data['module_class']  = starter_flexible_build_module_class( 'block', (string) $data['custom_class'] );
	$data['should_render'] = '' !== trim( (string) $data['heading'] ) || ! empty( $provinces );

	return (object) $data;
}
