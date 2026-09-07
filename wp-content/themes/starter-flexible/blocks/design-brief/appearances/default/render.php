<?php
/**
 * Design Brief — default appearance.
 *
 * The form is laid out row by row: each row holds the fields a person fills in
 * together, so the eye never has to reassemble a measurement from two columns.
 *
 * @var object $data
 * @var bool   $is_preview
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<section class="<?php echo esc_attr( $data->module_class ); ?>" data-reveal<?php if ( $data->anchor ) : ?> id="<?php echo esc_attr( $data->anchor ); ?>"<?php endif; ?>>
	<?php get_template_part( 'template-parts/components/block-head', null, array( 'label' => $data->label ) ); ?>

	<form class="db__form" data-design-brief novalidate>
		<header class="db__intro">
			<h2 class="h3"><?php echo esc_html( $data->heading ); ?></h2>
			<?php if ( $data->has_intro ) : ?>
				<p class="copy"><?php echo esc_html( $data->intro ); ?></p>
			<?php endif; ?>
		</header>

		<!-- Khách hàng -->
		<fieldset class="db__section">
			<legend class="db__legend"><?php esc_html_e( 'Khách hàng', 'starter-flexible' ); ?></legend>
			<p class="db__note"><?php esc_html_e( 'Chưa nhập CCCD / mã số thuế. Nhập thông tin để tạo khách hàng mới.', 'starter-flexible' ); ?></p>

			<?php
			starter_flexible_design_brief_row(
				array(
					array( 'name' => 'customer_id', 'label' => 'CCCD / Mã số thuế' ),
					array( 'name' => 'customer_name', 'label' => 'Họ và tên' ),
				),
				array( 'cols' => 2, 'title' => 'Định danh' )
			);
			starter_flexible_design_brief_row(
				array(
					array( 'name' => 'customer_phone', 'label' => 'Số điện thoại', 'type' => 'tel' ),
					array( 'name' => 'customer_email', 'label' => 'Email', 'type' => 'email' ),
				),
				array( 'cols' => 2, 'title' => 'Liên hệ' )
			);
			starter_flexible_design_brief_row(
				array( array( 'name' => 'customer_address', 'label' => 'Địa chỉ' ) ),
				array( 'cols' => 1 )
			);
			?>
		</fieldset>

		<!-- Thông tin chung -->
		<fieldset class="db__section">
			<legend class="db__legend"><?php esc_html_e( 'Thông tin chung', 'starter-flexible' ); ?></legend>

			<?php
			starter_flexible_design_brief_row(
				array(
					array( 'name' => 'request_no', 'label' => 'Số đơn đề nghị' ),
					array( 'name' => 'request_date', 'label' => 'Ngày nộp đơn đề nghị', 'type' => 'date' ),
				),
				array( 'cols' => 2, 'title' => 'Đơn đề nghị' )
			);
			starter_flexible_design_brief_row(
				array(
					array( 'name' => 'vessel_no', 'label' => 'Số đăng ký (số hiệu tàu)' ),
					array( 'name' => 'vessel_template', 'label' => 'Mẫu tàu' ),
				),
				array( 'cols' => 2, 'title' => 'Nhận dạng tàu' )
			);
			starter_flexible_design_brief_row(
				array(
					array(
						'name'    => 'design_type',
						'label'   => 'Loại hình thiết kế',
						'type'    => 'combo',
						'options' => $data->catalog_options['design_types'],
					),
				),
				array( 'cols' => 1, 'title' => 'Phân loại hồ sơ' )
			);
			starter_flexible_design_brief_row(
				array(
					array(
						'name'    => 'region',
						'label'   => 'Vùng hoạt động',
						'type'    => 'combo',
						'options' => (array) $data->catalogs['regions'],
					),
					array(
						'name'    => 'province',
						'label'   => 'Tỉnh',
						'type'    => 'combo',
						'options' => $data->catalog_options['provinces'],
					),
				),
				array( 'cols' => 1, 'title' => 'Địa bàn hoạt động' )
			);
			starter_flexible_design_brief_row(
				array(
					array(
						'name'    => 'registry',
						'label'   => 'Trung tâm đăng kiểm',
						'type'    => 'combo',
						'options' => $data->catalog_options['registries'],
					),
				),
				array( 'cols' => 1, 'title' => 'Cơ quan đăng kiểm' )
			);
			starter_flexible_design_brief_row(
				array(
					array(
						'name'  => 'design_code',
						'label' => 'Ký hiệu thiết kế',
						'hint'  => 'Ghép từ Tỉnh – số – Loại hình thiết kế. Sửa được phần số ở giữa.',
						'attrs' => array( 'data-db-code' => true ),
					),
					array( 'name' => 'handler', 'label' => 'Người phụ trách (nếu có)' ),
				),
				array( 'cols' => 2, 'title' => 'Hồ sơ thiết kế' )
			);
			starter_flexible_design_brief_row(
				array(
					array( 'name' => 'fee', 'label' => 'Số tiền cần thanh toán', 'unit' => 'đ', 'attrs' => array( 'data-db-money' => true ) ),
				),
				array( 'cols' => 2, 'title' => 'Thanh toán' )
			);
			starter_flexible_design_brief_row(
				array( array( 'name' => 'general_note', 'label' => 'Ghi chú', 'type' => 'textarea' ) ),
				array( 'cols' => 1 )
			);
			?>
		</fieldset>

		<!-- Kích thước tàu -->
		<fieldset class="db__section">
			<legend class="db__legend"><?php esc_html_e( 'Kích thước tàu', 'starter-flexible' ); ?></legend>

			<?php
			$dimension_titles = array( 'Kích thước chính', 'Cabin tầng 1', 'Cabin tầng 2' );
			foreach ( $data->dimension_rows as $i => $row ) {
				starter_flexible_design_brief_row(
					array_map(
						static fn( array $dim ): array => array( 'name' => $dim[0], 'label' => $dim[1], 'type' => 'number', 'unit' => $dim[2] ),
						$row
					),
					array( 'cols' => count( $row ), 'title' => $dimension_titles[ $i ] ?? '' )
				);
			}

			starter_flexible_design_brief_row(
				array(
					array( 'name' => 'hold_count', 'label' => 'Số lượng khoang', 'type' => 'number' ),
					array( 'name' => 'hold_layout', 'label' => 'Bố trí khoang', 'hint' => 'Ví dụ: 1NC+3H' ),
					array( 'name' => 'cabin_actual', 'label' => 'Cabin thực tế' ),
				),
				array( 'cols' => 3, 'title' => 'Khoang & cabin' )
			);
			starter_flexible_design_brief_row(
				array( array( 'name' => 'size_note', 'label' => 'Ghi chú', 'type' => 'textarea' ) ),
				array( 'cols' => 1 )
			);
			?>
		</fieldset>

		<!-- Kết cấu thân tàu -->
		<fieldset class="db__section">
			<legend class="db__legend"><?php esc_html_e( 'Kết cấu thân tàu', 'starter-flexible' ); ?></legend>
			<p class="db__note"><?php esc_html_e( 'Ghi quy cách từng cơ cấu, ví dụ 60 × 120. Để trống nếu tàu không có cơ cấu đó.', 'starter-flexible' ); ?></p>

			<?php
			foreach ( $data->hull_groups as $group ) {
				starter_flexible_design_brief_row(
					$group['fields'],
					array( 'cols' => min( 4, count( $group['fields'] ) ), 'title' => $group['title'] )
				);
			}
			starter_flexible_design_brief_row(
				array( array( 'name' => 'hull_note', 'label' => 'Ghi chú', 'type' => 'textarea' ) ),
				array( 'cols' => 1 )
			);
			?>
		</fieldset>

		<!-- Khai thác & trang thiết bị -->
		<fieldset class="db__section">
			<legend class="db__legend"><?php esc_html_e( 'Khai thác & Trang thiết bị', 'starter-flexible' ); ?></legend>

			<?php
			starter_flexible_design_brief_row(
				array(
					array( 'name' => 'trade_1', 'label' => 'Nghề 1 (khai thác chính)' ),
					array( 'name' => 'trade_2', 'label' => 'Nghề 2 (nghề phụ)' ),
				),
				array( 'cols' => 2, 'title' => 'Nghề khai thác' )
			);
			starter_flexible_design_brief_row(
				array(
					array( 'name' => 'trip_days', 'label' => 'Thời gian chuyến biển', 'unit' => 'ngày' ),
					array( 'name' => 'crew', 'label' => 'Số lượng thuyền viên', 'type' => 'number' ),
					array( 'name' => 'gear_weight', 'label' => 'Khối lượng lưới/ngư cụ', 'type' => 'number', 'unit' => 'kg' ),
				),
				array( 'cols' => 3, 'title' => 'Chuyến biển' )
			);
			starter_flexible_design_brief_row(
				array(
					array( 'name' => 'store_fuel', 'label' => 'Dầu', 'type' => 'number', 'unit' => 'kg' ),
					array( 'name' => 'store_water', 'label' => 'Nước ngọt', 'type' => 'number', 'unit' => 'kg' ),
					array( 'name' => 'store_ice', 'label' => 'Đá', 'type' => 'number', 'unit' => 'kg' ),
					array( 'name' => 'store_fish', 'label' => 'Cá', 'type' => 'number', 'unit' => 'kg' ),
				),
				array( 'cols' => 4, 'title' => 'Dự trữ & sản lượng' )
			);
			starter_flexible_design_brief_row(
				array(
					array( 'name' => 'crane_count', 'label' => 'Số lượng cẩu', 'type' => 'number' ),
					array( 'name' => 'crane_type', 'label' => 'Loại cẩu' ),
					array( 'name' => 'winch_count', 'label' => 'Số lượng tời', 'type' => 'number' ),
					array( 'name' => 'winch_type', 'label' => 'Loại tời' ),
				),
				array( 'cols' => 4, 'title' => 'Cẩu & tời' )
			);
			starter_flexible_design_brief_row(
				array(
					array( 'name' => 'rudder', 'label' => 'Bánh lái', 'type' => 'combo', 'options' => (array) $data->catalogs['rudders'] ),
					array( 'name' => 'steering', 'label' => 'Hệ thống lái', 'type' => 'combo', 'options' => (array) $data->catalogs['steering'] ),
				),
				array( 'cols' => 2, 'title' => 'Thiết bị lái' )
			);
			starter_flexible_design_brief_row(
				array(
					array( 'name' => 'power_source', 'label' => 'Hình thức phát điện', 'type' => 'combo', 'options' => (array) $data->catalogs['power_sources'] ),
				),
				array( 'cols' => 1, 'title' => 'Nguồn điện' )
			);
			starter_flexible_design_brief_row(
				array(
					array( 'name' => 'genset_count', 'label' => 'Số lượng máy phát điện', 'type' => 'number' ),
					array( 'name' => 'genset_kw', 'label' => 'Công suất máy phát điện', 'type' => 'number', 'unit' => 'kW' ),
				),
				array( 'cols' => 2 )
			);
			starter_flexible_design_brief_row(
				array( array( 'name' => 'ops_note', 'label' => 'Ghi chú', 'type' => 'textarea' ) ),
				array( 'cols' => 1 )
			);
			?>
		</fieldset>

		<!-- Máy -->
		<fieldset class="db__section">
			<legend class="db__legend"><?php esc_html_e( 'Máy', 'starter-flexible' ); ?></legend>
			<div class="db__engines" data-db-engines></div>
			<button type="button" class="btn btn--secondary btn--sm db__add" data-db-add-engine>
				<?php esc_html_e( 'Thêm máy', 'starter-flexible' ); ?>
				<?php echo starter_flexible_icon( 'plus', 17 ); // phpcs:ignore ?>
			</button>
		</fieldset>

		<footer class="db__actions">
			<button type="button" class="btn" data-db-copy>
				<?php esc_html_e( 'Sao chép nhiệm vụ thư', 'starter-flexible' ); ?>
				<?php echo starter_flexible_icon_swap( 'arrow', 20 ); // phpcs:ignore ?>
			</button>
			<button type="button" class="btn btn--secondary" data-db-print><?php esc_html_e( 'In / Lưu PDF', 'starter-flexible' ); ?></button>
			<?php if ( $data->cf7_id ) : ?>
				<button type="button" class="btn btn--secondary" data-db-send><?php esc_html_e( 'Gửi về công ty', 'starter-flexible' ); ?></button>
			<?php endif; ?>
			<button type="reset" class="btn btn--ghost"><?php esc_html_e( 'Xoá hết', 'starter-flexible' ); ?></button>
			<span class="db__saved" data-db-saved hidden><?php esc_html_e( 'Đã lưu nháp trên máy này', 'starter-flexible' ); ?></span>
		</footer>
	</form>

	<?php /* One engine block, cloned by script.js for "Thêm máy". */ ?>
	<template data-db-engine-template>
		<fieldset class="db__engine" data-db-engine>
			<legend class="db__engine-title"><?php esc_html_e( 'Máy', 'starter-flexible' ); ?> <span data-db-engine-no>1</span></legend>
			<button type="button" class="db__engine-remove" data-db-remove-engine aria-label="<?php esc_attr_e( 'Xoá máy này', 'starter-flexible' ); ?>">
				<?php echo starter_flexible_icon( 'close', 16 ); // phpcs:ignore ?>
			</button>

			<h4 class="db__sub"><?php esc_html_e( 'Nhận dạng máy', 'starter-flexible' ); ?></h4>
			<?php
			starter_flexible_design_brief_row(
				array(
					array( 'name' => 'engine_position', 'label' => 'Vị trí máy (nhìn về mũi)', 'type' => 'combo', 'options' => (array) $data->catalogs['engine_positions'] ),
				),
				array( 'cols' => 1, 'title' => 'Vị trí lắp đặt' )
			);
			starter_flexible_design_brief_row(
				array(
					array(
						'name'    => 'engine_make',
						'label'   => 'Hãng',
						'type'    => 'combo',
						'options' => $data->make_options,
						'attrs'   => array( 'data-db-make' => true ),
					),
				),
				array( 'cols' => 1, 'title' => 'Dòng máy' )
			);
			starter_flexible_design_brief_row(
				array(
					array(
						'name'        => 'engine_model',
						'label'       => 'Mã hiệu máy',
						'type'        => 'combo',
						'options'     => array(),
						'scroll'      => true,
						'attrs'       => array( 'data-db-model' => true ),
						'empty'       => 'Nhập hoặc chọn hãng ở trên để thấy danh sách mã hiệu.',
						'hint'        => 'Chọn từ danh mục Mẫu máy; công suất và số vòng quay lấy theo dòng máy này.',
					),
				),
				array( 'cols' => 1 )
			);
			starter_flexible_design_brief_row(
				array( array( 'name' => 'engine_serial', 'label' => 'Số máy' ) ),
				array( 'cols' => 2 )
			);

			echo '<h4 class="db__sub">' . esc_html__( 'Thông số máy', 'starter-flexible' ) . '</h4>';
			starter_flexible_design_brief_row(
				array(
					array( 'name' => 'engine_kw', 'label' => 'Công suất', 'type' => 'number', 'unit' => 'kW', 'attrs' => array( 'data-db-kw' => true ) ),
					array( 'name' => 'engine_rpm', 'label' => 'Số vòng quay', 'type' => 'number', 'unit' => 'rpm', 'attrs' => array( 'data-db-rpm' => true ) ),
					array( 'name' => 'gear_ratio', 'label' => 'Tỉ số truyền', 'type' => 'number', 'attrs' => array( 'data-db-ratio' => true ) ),
				),
				array( 'cols' => 3, 'title' => 'Công suất & vòng quay' )
			);

			echo '<h4 class="db__sub">' . esc_html__( 'Trục chân vịt', 'starter-flexible' ) . '</h4>';
			starter_flexible_design_brief_row(
				array(
					array(
						'name'    => 'shaft_material',
						'label'   => 'Vật liệu trục chân vịt',
						'type'    => 'combo',
						'options' => $data->material_options,
						'attrs'   => array( 'data-db-material' => true ),
					),
				),
				array( 'cols' => 1, 'title' => 'Vật liệu' )
			);
			starter_flexible_design_brief_row(
				array(
					array( 'name' => 'k3', 'label' => 'Hệ số K3', 'type' => 'number', 'attrs' => array( 'data-db-k3' => true ) ),
					array( 'name' => 'prop_rpm', 'label' => 'Số vòng quay chân vịt', 'type' => 'number', 'unit' => 'rpm', 'attrs' => array( 'data-db-prop-rpm' => true, 'readonly' => true ) ),
				),
				array( 'cols' => 2, 'title' => 'Hệ số tính toán' )
			);
			starter_flexible_design_brief_row(
				array(
					array( 'name' => 'shaft_length', 'label' => 'Chiều dài trục chân vịt', 'type' => 'number', 'unit' => 'mm' ),
					array( 'name' => 'shaft_dmin', 'label' => 'Đường kính tối thiểu trục chân vịt', 'type' => 'number', 'unit' => 'mm', 'attrs' => array( 'data-db-dmin' => true, 'readonly' => true ) ),
					array( 'name' => 'shaft_dreal', 'label' => 'Đường kính trục thực tế', 'type' => 'number', 'unit' => 'mm' ),
				),
				array( 'cols' => 3, 'title' => 'Kích thước trục' )
			);

			echo '<h4 class="db__sub">' . esc_html__( 'Chân vịt', 'starter-flexible' ) . '</h4>';
			starter_flexible_design_brief_row(
				array(
					array( 'name' => 'prop_material', 'label' => 'Vật liệu chân vịt', 'type' => 'combo', 'options' => (array) $data->catalogs['propeller_materials'] ),
				),
				array( 'cols' => 1, 'title' => 'Vật liệu' )
			);
			starter_flexible_design_brief_row(
				array(
					array( 'name' => 'prop_blades', 'label' => 'Số cánh chân vịt', 'type' => 'number' ),
					array( 'name' => 'prop_diameter', 'label' => 'Đường kính chân vịt', 'type' => 'number', 'unit' => 'm' ),
					array( 'name' => 'prop_weight', 'label' => 'Khối lượng chân vịt', 'type' => 'number', 'unit' => 'kg' ),
				),
				array( 'cols' => 3, 'title' => 'Kích thước & khối lượng' )
			);

			echo '<h4 class="db__sub">' . esc_html__( 'Bệ máy', 'starter-flexible' ) . '</h4>';
			starter_flexible_design_brief_row(
				array(
					array( 'name' => 'bed_gearbox_bolt', 'label' => 'Chân hộp số (bu lông)', 'type' => 'number', 'unit' => 'mm' ),
					array( 'name' => 'bed_engine_bolt', 'label' => 'Chân máy chính (bu lông)', 'type' => 'number', 'unit' => 'mm' ),
				),
				array( 'cols' => 2, 'title' => 'Bu lông liên kết' )
			);
			starter_flexible_design_brief_row(
				array_map(
					static fn( string $mark ): array => array( 'name' => 'bed_' . strtolower( $mark ), 'label' => $mark, 'type' => 'number', 'unit' => 'mm' ),
					array( 'L1', 'L2', 'L3', 'L4', 'L5' )
				),
				array( 'cols' => 5, 'title' => 'Kích thước dọc' )
			);
			starter_flexible_design_brief_row(
				array_map(
					static fn( string $mark ): array => array( 'name' => 'bed_' . strtolower( $mark ), 'label' => $mark, 'type' => 'number', 'unit' => 'mm' ),
					array( 'B1', 'B2', 'B3', 'B4' )
				),
				array( 'cols' => 4, 'title' => 'Kích thước ngang' )
			);
			starter_flexible_design_brief_row(
				array( array( 'name' => 'engine_note', 'label' => 'Ghi chú', 'type' => 'textarea' ) ),
				array( 'cols' => 1 )
			);
			?>
		</fieldset>
	</template>

	<?php if ( $data->cf7_id ) : ?>
		<?php /* Contact Form 7 does the sending: the brief is written into its
		         hidden fields and its own submit button is clicked. */ ?>
		<div class="db__cf7" data-db-cf7>
			<?php echo $data->form_html; ?>
		</div>
	<?php endif; ?>

	<script type="application/json" data-db-engines-data><?php echo $data->engines_json; ?></script>
	<script type="application/json" data-db-doc-data><?php echo $data->doc_json; ?></script>
</section>
