<?php
/**
 * Design Brief — the form an engineer fills in to open a design job.
 *
 * Lookup lists come from two places: the ones that are already maintained in
 * Site Settings → Tools (engines, shaft materials) are read from there so the
 * form never drifts from the calculators, and the rest live in
 * blocks/design-brief/inc/catalogs.json.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** @return array<string, mixed> */
function starter_flexible_design_brief_catalogs(): array {
	static $cache = null;
	if ( null !== $cache ) {
		return $cache;
	}
	$file = __DIR__ . '/catalogs.json';
	$json = is_file( $file ) ? json_decode( (string) file_get_contents( $file ), true ) : null;

	return $cache = is_array( $json ) ? $json : array();
}

function starter_flexible_block_data_design_brief( array $block ) {
	$data = array_merge(
		array(
			'label'        => 'NHIỆM VỤ THƯ',
			'heading'      => 'Xây dựng nhiệm vụ thư thiết kế',
			'intro'        => '',
			'cf7_form'     => 0,
			'custom_class' => '',
		),
		starter_flexible_get_block_fields( $block )
	);

	$catalogs = starter_flexible_design_brief_catalogs();

	// Engines drive three fields at once: picking a model fills in power and
	// rpm, which the shaft diameter is then computed from.
	$engines = array();
	foreach ( starter_flexible_machines() as $row ) {
		$make  = (string) ( $row['make'] ?? '' );
		$model = (string) ( $row['model'] ?? '' );
		if ( '' === trim( $make ) || '' === trim( $model ) ) {
			continue;
		}
		$engines[] = array(
			'make'  => $make,
			'model' => $model,
			'kw'    => isset( $row['kw'] ) ? (float) $row['kw'] : 0.0,
			'rpm'   => isset( $row['rpm'] ) ? (float) $row['rpm'] : 0.0,
		);
	}

	$materials = array();
	foreach ( starter_flexible_shaft_materials() as $i => $material ) {
		$materials[] = array(
			'code' => sprintf( 'VL-%03d', $i + 1 ),
			'name' => (string) $material['name'],
			'note' => (string) $material['note'],
			'k3'   => (float) $material['k3'],
		);
	}

	$cf7 = is_object( $data['cf7_form'] ) ? (int) $data['cf7_form']->ID : (int) $data['cf7_form'];

	$data['cf7_id']        = $cf7 && 'wpcf7_contact_form' === get_post_type( $cf7 ) ? $cf7 : 0;
	$data['catalogs']      = $catalogs;
	$data['engines']       = $engines;
	$data['materials']     = $materials;
	$data['hull_members']  = (array) ( $catalogs['hull_members'] ?? array() );
	$data['has_intro']     = '' !== trim( (string) $data['intro'] );
	$data['module_class']  = starter_flexible_build_module_class( 'block container db', (string) $data['custom_class'] );
	$data['should_render'] = true;

	return (object) $data;
}
