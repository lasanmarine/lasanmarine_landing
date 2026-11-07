<?php
/**
 * Design Brief — the form an engineer fills in to open a design job.
 *
 * Lookup lists come from two places: the ones that are already maintained in
 * Site Settings → Tools (engines, shaft materials) are read from there so the
 * form never drifts from the calculators, and the rest live in
 * blocks/design-brief/inc/catalogs.json.
 *
 * Nothing is stored on the server: the brief is one JSON object — whatever was
 * typed, keyed by field name — kept in the browser while it is being written
 * and posted through Contact Form 7 when it is sent.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/schema.php';

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

final class Starter_Flexible_Block_Design_Brief extends Starter_Flexible_Abstract_Block {
	protected function defaults(): array {
		return array(
			'label'        => 'NHIỆM VỤ THƯ',
			'heading'      => 'Xây dựng nhiệm vụ thư thiết kế',
			'intro'        => '',
			'cf7_form'     => 0,
			'doc_org'      => '',
			'doc_place'    => 'Khánh Hòa',
			'doc_symbol'   => 'NVT-LSM',
			'custom_class' => '',
		);
	}

	protected function base_class(): string {
		return 'block container db';
	}

	protected function prepare( array $data ): array {

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
		$data['has_intro']     = '' !== trim( (string) $data['intro'] );
		$data['should_render'] = true;

				$data['form_html'] = $data['cf7_id'] > 0 ? do_shortcode( sprintf( '[contact-form-7 id="%d"]', $data['cf7_id'] ) ) : '';

		// Dimensions are read one family at a time — hull, then each cabin deck —
		// so a row on screen is a row a surveyor measures in one go.
		$data['dimension_rows'] = array(
			array(
				array( 'lmax', 'Chiều dài Lmax', 'm' ),
				array( 'bmax', 'Chiều rộng Bmax', 'm' ),
				array( 'depth', 'Chiều cao mạn D', 'm' ),
				array( 'frame_space', 'Khoảng cách sườn', 'mm' ),
			),
			array(
				array( 'cabin1_l', 'Cabin tầng 1 — dài', 'm' ),
				array( 'cabin1_b', 'Cabin tầng 1 — rộng', 'm' ),
				array( 'cabin1_h', 'Cabin tầng 1 — cao', 'm' ),
			),
			array(
				array( 'cabin2_l', 'Cabin tầng 2 — dài', 'm' ),
				array( 'cabin2_b', 'Cabin tầng 2 — rộng', 'm' ),
				array( 'cabin2_h', 'Cabin tầng 2 — cao', 'm' ),
			),
		);

		// Hull members keep their old hull_0…hull_35 names: the catalogue groups
		// them for the eye, the running index keeps drafts readable.
		$data['hull_groups'] = array();
		$index               = 0;
		foreach ( (array) ( $catalogs['hull_members'] ?? array() ) as $title => $members ) {
			$fields = array();
			foreach ( (array) $members as $member ) {
				$fields[] = array( 'name' => 'hull_' . $index, 'label' => (string) $member );
				++$index;
			}
			$data['hull_groups'][] = array( 'title' => (string) $title, 'fields' => $fields );
		}

		$data['catalog_options']['design_types'] = starter_flexible_design_brief_options( (array) $catalogs['design_types'] );
		$data['catalog_options']['provinces']    = starter_flexible_design_brief_options( (array) $catalogs['provinces'] );
		$data['catalog_options']['registries']   = starter_flexible_design_brief_options( (array) $catalogs['registries'] );

		$data['material_options'] = array_map(
			static fn( array $m ): array => array(
				'value' => $m['code'],
				'label' => $m['code'] . ' · ' . $m['name'],
				'data'  => array( 'k3' => $m['k3'] ),
			),
			$data['materials']
		);

		$data['make_options'] = array_values( array_unique( array_column( $data['engines'], 'make' ) ) );

		// Letterhead for the printed brief. Kept out of the DOM the form uses so
		// the document can be assembled without reading the page's chrome.
		// Blocks saved before these fields existed hand back null, so each one
		// falls back rather than printing an empty letterhead.
		$fallback = static fn( $value, string $default ): string => '' !== trim( (string) $value ) ? trim( (string) $value ) : $default;

		$data['doc'] = array(
			'org'     => $fallback( $data['doc_org'], $fallback( starter_flexible_setting( 'legal_name', '' ), 'CÔNG TY TNHH LASAN MARINE' ) ),
			'place'   => $fallback( $data['doc_place'], 'Khánh Hòa' ),
			'symbol'  => $fallback( $data['doc_symbol'], 'NVT-LSM' ),
			'address' => (string) starter_flexible_setting( 'address', '' ),
			'phone'   => (string) starter_flexible_setting( 'phone', '' ),
			'email'   => (string) starter_flexible_setting( 'email', '' ),
			'tax'     => (string) starter_flexible_setting( 'tax_code', '' ),
		);

		// Rendered by the Svelte island in assets/island.svelte.
		$data['props'] = array(
			'heading'   => (string) $data['heading'],
			'intro'     => $data['has_intro'] ? (string) $data['intro'] : '',
			'schema'    => starter_flexible_design_brief_schema( $data ),
			'catalogue' => $data['engines'],
			'letterhead' => $data['doc'],
			'canSend'   => $data['cf7_id'] > 0,
			'labels'    => array(
				'engine'        => __( 'Máy', 'starter-flexible' ),
				'removeEngine'  => __( 'Xoá máy này', 'starter-flexible' ),
				'addEngine'     => __( 'Thêm máy', 'starter-flexible' ),
				'copy'          => __( 'Sao chép nhiệm vụ thư', 'starter-flexible' ),
				'print'         => __( 'In / Lưu PDF', 'starter-flexible' ),
				'send'          => __( 'Gửi về công ty', 'starter-flexible' ),
				'clear'         => __( 'Xoá hết', 'starter-flexible' ),
				'saved'         => __( 'Đã lưu nháp trên máy này', 'starter-flexible' ),
				'comboHint'     => __( 'Nhập hoặc chọn bên dưới', 'starter-flexible' ),
				'noPresets'     => __( 'Chưa có gợi ý.', 'starter-flexible' ),
				'pickMakeFirst' => 'Nhập hoặc chọn hãng ở trên để thấy danh sách mã hiệu.',
				'noModels'      => 'Không có mã hiệu nào cho hãng này — nhập tay ở ô trên.',
			),
			'icons'     => array(
				'plus'  => starter_flexible_icon( 'plus', 17 ),
				'close' => starter_flexible_icon( 'close', 16 ),
				'arrow' => starter_flexible_icon_swap( 'arrow', 20 ),
			),
		);

		return $data;
	}
}

function starter_flexible_block_data_design_brief( array $block ) {
	return ( new Starter_Flexible_Block_Design_Brief( $block ) )->data();
}

/**
 * Normalise one option into value / label / data, so callers may pass a plain
 * string, or an array carrying data-attributes for the script to read.
 *
 * @param mixed $option Raw option.
 * @return array{value: string, label: string, data: array<string, mixed>}
 */
function starter_flexible_design_brief_option( $option ): array {
	if ( ! is_array( $option ) ) {
		return array( 'value' => (string) $option, 'label' => (string) $option, 'data' => array() );
	}

	return array(
		'value' => (string) ( $option['value'] ?? '' ),
		'label' => (string) ( $option['label'] ?? $option['value'] ?? '' ),
		'data'  => (array) ( $option['data'] ?? array() ),
	);
}

function starter_flexible_design_brief_options( array $rows, string $sep = ' · ' ): array {
	return array_map(
		static fn( array $row ): array => array(
			'value' => $row['code'],
			'label' => $row['code'] . $sep . $row['name'],
		),
		$rows
	);
}
