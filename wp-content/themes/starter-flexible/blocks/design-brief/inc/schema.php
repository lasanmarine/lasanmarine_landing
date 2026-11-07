<?php
/**
 * Design Brief — the form's definition, as data.
 *
 * The Svelte island (assets/island.svelte) draws the form from this: sections
 * hold rows, a row holds the fields a person fills in together (so the eye
 * never has to reassemble a measurement from two columns), and the engine
 * section repeats `engine` once per engine. Field names are what the brief's
 * JSON is keyed by — keep them stable, saved drafts depend on them.
 *
 * Field keys: name, label, type (text|number|date|tel|email|textarea|combo),
 * unit, hint, options (combo), scroll, empty, readonly.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * One row of fields, optionally titled.
 *
 * @param array<int, array<string, mixed>> $fields Field definitions.
 * @return array<string, mixed>
 */
function starter_flexible_design_brief_schema_row( array $fields, int $cols = 0, string $title = '' ): array {
	$fields = array_values( array_filter( $fields ) );
	$cols   = max( 1, min( 5, $cols > 0 ? $cols : count( $fields ) ) );

	return array(
		'title'  => $title,
		'cols'   => $cols,
		'fields' => array_map(
			static function ( array $field ): array {
				$field['type'] = (string) ( $field['type'] ?? 'text' );
				if ( 'combo' === $field['type'] ) {
					$field['options'] = array_map( 'starter_flexible_design_brief_option', (array) ( $field['options'] ?? array() ) );
				}
				return $field;
			},
			$fields
		),
	);
}

/**
 * The whole form.
 *
 * @param array<string, mixed> $data Prepared block data (catalogues, options).
 * @return array{sections: array<int, array<string, mixed>>, engine: array<int, array<string, mixed>>}
 */
function starter_flexible_design_brief_schema( array $data ): array {
	$row      = 'starter_flexible_design_brief_schema_row';
	$catalogs = (array) $data['catalogs'];
	$options  = (array) $data['catalog_options'];
	$note     = static fn( string $name ): array => array( 'name' => $name, 'label' => 'Ghi chú', 'type' => 'textarea' );

	$sections = array();

	// Khách hàng.
	$sections[] = array(
		'title' => __( 'Khách hàng', 'starter-flexible' ),
		'note'  => __( 'Chưa nhập CCCD / mã số thuế. Nhập thông tin để tạo khách hàng mới.', 'starter-flexible' ),
		'rows'  => array(
			$row(
				array(
					array( 'name' => 'customer_id', 'label' => 'CCCD / Mã số thuế' ),
					array( 'name' => 'customer_name', 'label' => 'Họ và tên' ),
				),
				2,
				'Định danh'
			),
			$row(
				array(
					array( 'name' => 'customer_phone', 'label' => 'Số điện thoại', 'type' => 'tel' ),
					array( 'name' => 'customer_email', 'label' => 'Email', 'type' => 'email' ),
				),
				2,
				'Liên hệ'
			),
			$row( array( array( 'name' => 'customer_address', 'label' => 'Địa chỉ' ) ), 1 ),
		),
	);

	// Thông tin chung.
	$sections[] = array(
		'title' => __( 'Thông tin chung', 'starter-flexible' ),
		'rows'  => array(
			$row(
				array(
					array( 'name' => 'request_no', 'label' => 'Số đơn đề nghị' ),
					array( 'name' => 'request_date', 'label' => 'Ngày nộp đơn đề nghị', 'type' => 'date' ),
				),
				2,
				'Đơn đề nghị'
			),
			$row(
				array(
					array( 'name' => 'vessel_no', 'label' => 'Số đăng ký (số hiệu tàu)' ),
					array( 'name' => 'vessel_template', 'label' => 'Mẫu tàu' ),
				),
				2,
				'Nhận dạng tàu'
			),
			$row(
				array( array( 'name' => 'design_type', 'label' => 'Loại hình thiết kế', 'type' => 'combo', 'options' => $options['design_types'] ) ),
				1,
				'Phân loại hồ sơ'
			),
			$row(
				array(
					array( 'name' => 'region', 'label' => 'Vùng hoạt động', 'type' => 'combo', 'options' => (array) ( $catalogs['regions'] ?? array() ) ),
					array( 'name' => 'province', 'label' => 'Tỉnh', 'type' => 'combo', 'options' => $options['provinces'] ),
				),
				1,
				'Địa bàn hoạt động'
			),
			$row(
				array( array( 'name' => 'registry', 'label' => 'Trung tâm đăng kiểm', 'type' => 'combo', 'options' => $options['registries'] ) ),
				1,
				'Cơ quan đăng kiểm'
			),
			$row(
				array(
					array(
						'name'  => 'design_code',
						'label' => 'Ký hiệu thiết kế',
						'hint'  => 'Ghép từ Tỉnh – số – Loại hình thiết kế. Sửa được phần số ở giữa.',
					),
					array( 'name' => 'handler', 'label' => 'Người phụ trách (nếu có)' ),
				),
				2,
				'Hồ sơ thiết kế'
			),
			$row( array( array( 'name' => 'fee', 'label' => 'Số tiền cần thanh toán', 'unit' => 'đ' ) ), 2, 'Thanh toán' ),
			$row( array( $note( 'general_note' ) ), 1 ),
		),
	);

	// Kích thước tàu: one family at a time — hull, then each cabin deck — so a
	// row on screen is a row a surveyor measures in one go.
	$dimension_titles = array( 'Kích thước chính', 'Cabin tầng 1', 'Cabin tầng 2' );
	$dimension_rows   = array();
	foreach ( (array) $data['dimension_rows'] as $i => $dims ) {
		$dimension_rows[] = $row(
			array_map(
				static fn( array $dim ): array => array( 'name' => $dim[0], 'label' => $dim[1], 'type' => 'number', 'unit' => $dim[2] ),
				$dims
			),
			count( $dims ),
			$dimension_titles[ $i ] ?? ''
		);
	}
	$dimension_rows[] = $row(
		array(
			array( 'name' => 'hold_count', 'label' => 'Số lượng khoang', 'type' => 'number' ),
			array( 'name' => 'hold_layout', 'label' => 'Bố trí khoang', 'hint' => 'Ví dụ: 1NC+3H' ),
			array( 'name' => 'cabin_actual', 'label' => 'Cabin thực tế' ),
		),
		3,
		'Khoang & cabin'
	);
	$dimension_rows[] = $row( array( $note( 'size_note' ) ), 1 );
	$sections[]       = array(
		'title' => __( 'Kích thước tàu', 'starter-flexible' ),
		'rows'  => $dimension_rows,
	);

	// Kết cấu thân tàu.
	$hull_rows = array();
	foreach ( (array) $data['hull_groups'] as $group ) {
		$hull_rows[] = $row( $group['fields'], min( 4, count( $group['fields'] ) ), $group['title'] );
	}
	$hull_rows[] = $row( array( $note( 'hull_note' ) ), 1 );
	$sections[]  = array(
		'title' => __( 'Kết cấu thân tàu', 'starter-flexible' ),
		'note'  => __( 'Ghi quy cách từng cơ cấu, ví dụ 60 × 120. Để trống nếu tàu không có cơ cấu đó.', 'starter-flexible' ),
		'rows'  => $hull_rows,
	);

	// Khai thác & trang thiết bị.
	$sections[] = array(
		'title' => __( 'Khai thác & Trang thiết bị', 'starter-flexible' ),
		'rows'  => array(
			$row(
				array(
					array( 'name' => 'trade_1', 'label' => 'Nghề 1 (khai thác chính)' ),
					array( 'name' => 'trade_2', 'label' => 'Nghề 2 (nghề phụ)' ),
				),
				2,
				'Nghề khai thác'
			),
			$row(
				array(
					array( 'name' => 'trip_days', 'label' => 'Thời gian chuyến biển', 'unit' => 'ngày' ),
					array( 'name' => 'crew', 'label' => 'Số lượng thuyền viên', 'type' => 'number' ),
					array( 'name' => 'gear_weight', 'label' => 'Khối lượng lưới/ngư cụ', 'type' => 'number', 'unit' => 'kg' ),
				),
				3,
				'Chuyến biển'
			),
			$row(
				array(
					array( 'name' => 'store_fuel', 'label' => 'Dầu', 'type' => 'number', 'unit' => 'kg' ),
					array( 'name' => 'store_water', 'label' => 'Nước ngọt', 'type' => 'number', 'unit' => 'kg' ),
					array( 'name' => 'store_ice', 'label' => 'Đá', 'type' => 'number', 'unit' => 'kg' ),
					array( 'name' => 'store_fish', 'label' => 'Cá', 'type' => 'number', 'unit' => 'kg' ),
				),
				4,
				'Dự trữ & sản lượng'
			),
			$row(
				array(
					array( 'name' => 'crane_count', 'label' => 'Số lượng cẩu', 'type' => 'number' ),
					array( 'name' => 'crane_type', 'label' => 'Loại cẩu' ),
					array( 'name' => 'winch_count', 'label' => 'Số lượng tời', 'type' => 'number' ),
					array( 'name' => 'winch_type', 'label' => 'Loại tời' ),
				),
				4,
				'Cẩu & tời'
			),
			$row(
				array(
					array( 'name' => 'rudder', 'label' => 'Bánh lái', 'type' => 'combo', 'options' => (array) ( $catalogs['rudders'] ?? array() ) ),
					array( 'name' => 'steering', 'label' => 'Hệ thống lái', 'type' => 'combo', 'options' => (array) ( $catalogs['steering'] ?? array() ) ),
				),
				2,
				'Thiết bị lái'
			),
			$row(
				array( array( 'name' => 'power_source', 'label' => 'Hình thức phát điện', 'type' => 'combo', 'options' => (array) ( $catalogs['power_sources'] ?? array() ) ) ),
				1,
				'Nguồn điện'
			),
			$row(
				array(
					array( 'name' => 'genset_count', 'label' => 'Số lượng máy phát điện', 'type' => 'number' ),
					array( 'name' => 'genset_kw', 'label' => 'Công suất máy phát điện', 'type' => 'number', 'unit' => 'kW' ),
				),
				2
			),
			$row( array( $note( 'ops_note' ) ), 1 ),
		),
	);

	// Máy: the engine block below, repeated per engine.
	$sections[] = array(
		'title'   => __( 'Máy', 'starter-flexible' ),
		'engines' => true,
		'rows'    => array(),
	);

	$bed = static fn( array $marks ): array => array_map(
		static fn( string $mark ): array => array( 'name' => 'bed_' . strtolower( $mark ), 'label' => $mark, 'type' => 'number', 'unit' => 'mm' ),
		$marks
	);

	$engine = array(
		array(
			'title' => __( 'Nhận dạng máy', 'starter-flexible' ),
			'rows'  => array(
				$row(
					array( array( 'name' => 'engine_position', 'label' => 'Vị trí máy (nhìn về mũi)', 'type' => 'combo', 'options' => (array) ( $catalogs['engine_positions'] ?? array() ) ) ),
					1,
					'Vị trí lắp đặt'
				),
				$row( array( array( 'name' => 'engine_make', 'label' => 'Hãng', 'type' => 'combo', 'options' => (array) $data['make_options'] ) ), 1, 'Dòng máy' ),
				$row(
					array(
						array(
							'name'   => 'engine_model',
							'label'  => 'Mã hiệu máy',
							'type'   => 'combo',
							'scroll' => true,
							'hint'   => 'Chọn từ danh mục Mẫu máy; công suất và số vòng quay lấy theo dòng máy này.',
						),
					),
					1
				),
				$row( array( array( 'name' => 'engine_serial', 'label' => 'Số máy' ) ), 2 ),
			),
		),
		array(
			'title' => __( 'Thông số máy', 'starter-flexible' ),
			'rows'  => array(
				$row(
					array(
						array( 'name' => 'engine_kw', 'label' => 'Công suất', 'type' => 'number', 'unit' => 'kW' ),
						array( 'name' => 'engine_rpm', 'label' => 'Số vòng quay', 'type' => 'number', 'unit' => 'rpm' ),
						array( 'name' => 'gear_ratio', 'label' => 'Tỉ số truyền', 'type' => 'number' ),
					),
					3,
					'Công suất & vòng quay'
				),
			),
		),
		array(
			'title' => __( 'Trục chân vịt', 'starter-flexible' ),
			'rows'  => array(
				$row( array( array( 'name' => 'shaft_material', 'label' => 'Vật liệu trục chân vịt', 'type' => 'combo', 'options' => (array) $data['material_options'] ) ), 1, 'Vật liệu' ),
				$row(
					array(
						array( 'name' => 'k3', 'label' => 'Hệ số K3', 'type' => 'number' ),
						array( 'name' => 'prop_rpm', 'label' => 'Số vòng quay chân vịt', 'type' => 'number', 'unit' => 'rpm', 'readonly' => true ),
					),
					2,
					'Hệ số tính toán'
				),
				$row(
					array(
						array( 'name' => 'shaft_length', 'label' => 'Chiều dài trục chân vịt', 'type' => 'number', 'unit' => 'mm' ),
						array( 'name' => 'shaft_dmin', 'label' => 'Đường kính tối thiểu trục chân vịt', 'type' => 'number', 'unit' => 'mm', 'readonly' => true ),
						array( 'name' => 'shaft_dreal', 'label' => 'Đường kính trục thực tế', 'type' => 'number', 'unit' => 'mm' ),
					),
					3,
					'Kích thước trục'
				),
			),
		),
		array(
			'title' => __( 'Chân vịt', 'starter-flexible' ),
			'rows'  => array(
				$row( array( array( 'name' => 'prop_material', 'label' => 'Vật liệu chân vịt', 'type' => 'combo', 'options' => (array) ( $catalogs['propeller_materials'] ?? array() ) ) ), 1, 'Vật liệu' ),
				$row(
					array(
						array( 'name' => 'prop_blades', 'label' => 'Số cánh chân vịt', 'type' => 'number' ),
						array( 'name' => 'prop_diameter', 'label' => 'Đường kính chân vịt', 'type' => 'number', 'unit' => 'm' ),
						array( 'name' => 'prop_weight', 'label' => 'Khối lượng chân vịt', 'type' => 'number', 'unit' => 'kg' ),
					),
					3,
					'Kích thước & khối lượng'
				),
			),
		),
		array(
			'title' => __( 'Bệ máy', 'starter-flexible' ),
			'rows'  => array(
				$row(
					array(
						array( 'name' => 'bed_gearbox_bolt', 'label' => 'Chân hộp số (bu lông)', 'type' => 'number', 'unit' => 'mm' ),
						array( 'name' => 'bed_engine_bolt', 'label' => 'Chân máy chính (bu lông)', 'type' => 'number', 'unit' => 'mm' ),
					),
					2,
					'Bu lông liên kết'
				),
				$row( $bed( array( 'L1', 'L2', 'L3', 'L4', 'L5' ) ), 5, 'Kích thước dọc' ),
				$row( $bed( array( 'B1', 'B2', 'B3', 'B4' ) ), 4, 'Kích thước ngang' ),
				$row( array( $note( 'engine_note' ) ), 1 ),
			),
		),
	);

	return array(
		'sections' => $sections,
		'engine'   => $engine,
	);
}
