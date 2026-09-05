<?php
/**
 * Design Brief — default appearance.
 *
 * @var object $data
 * @var array  $block
 * @var bool   $is_preview
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$anchor   = ! empty( $block['anchor'] ) ? ' id="' . esc_attr( (string) $block['anchor'] ) . '"' : '';
$catalogs = $data->catalogs;

/**
 * One labelled control. `unit` prints a suffix inside the field, `hint` a line
 * under it; everything else is forwarded to the input.
 *
 * @param array<string, mixed> $args
 */
$field = static function ( array $args ): void {
	$name  = (string) ( $args['name'] ?? '' );
	$type  = (string) ( $args['type'] ?? 'text' );
	$id    = 'db-' . $name;
	$unit  = (string) ( $args['unit'] ?? '' );
	$hint  = (string) ( $args['hint'] ?? '' );
	$value = (string) ( $args['value'] ?? '' );
	$attrs = '';
	foreach ( (array) ( $args['attrs'] ?? array() ) as $key => $val ) {
		$attrs .= true === $val ? ' ' . esc_attr( (string) $key ) : sprintf( ' %s="%s"', esc_attr( (string) $key ), esc_attr( (string) $val ) );
	}
	?>
	<div class="field db__field<?php echo ! empty( $args['wide'] ) ? ' db__field--wide' : ''; ?>">
		<label class="field__label" for="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( (string) ( $args['label'] ?? '' ) ); ?></label>

		<?php if ( 'select' === $type ) : ?>
			<select class="field__control" id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name ); ?>"<?php echo $attrs; // phpcs:ignore ?>>
				<option value=""><?php echo esc_html( (string) ( $args['placeholder'] ?? '— Chọn —' ) ); ?></option>
				<?php foreach ( (array) ( $args['options'] ?? array() ) as $option ) : ?>
					<?php
					$opt_value = is_array( $option ) ? (string) $option['value'] : (string) $option;
					$opt_label = is_array( $option ) ? (string) $option['label'] : (string) $option;
					$opt_data  = '';
					foreach ( (array) ( is_array( $option ) ? ( $option['data'] ?? array() ) : array() ) as $dk => $dv ) {
						$opt_data .= sprintf( ' data-%s="%s"', esc_attr( (string) $dk ), esc_attr( (string) $dv ) );
					}
					?>
					<option value="<?php echo esc_attr( $opt_value ); ?>"<?php echo $opt_data; // phpcs:ignore ?>><?php echo esc_html( $opt_label ); ?></option>
				<?php endforeach; ?>
			</select>

		<?php elseif ( 'textarea' === $type ) : ?>
			<textarea class="field__control" id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name ); ?>" rows="3"<?php echo $attrs; // phpcs:ignore ?>><?php echo esc_textarea( $value ); ?></textarea>

		<?php else : ?>
			<div class="db__control<?php echo '' !== $unit ? ' db__control--unit' : ''; ?>">
				<input
					class="field__control"
					id="<?php echo esc_attr( $id ); ?>"
					name="<?php echo esc_attr( $name ); ?>"
					type="<?php echo esc_attr( $type ); ?>"
					value="<?php echo esc_attr( $value ); ?>"
					<?php echo 'number' === $type ? 'step="any" inputmode="decimal"' : ''; ?>
					<?php echo $attrs; // phpcs:ignore ?>
				/>
				<?php if ( '' !== $unit ) : ?>
					<span class="db__unit"><?php echo esc_html( $unit ); ?></span>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( '' !== $hint ) : ?>
			<span class="field__hint"><?php echo esc_html( $hint ); ?></span>
		<?php endif; ?>
	</div>
	<?php
};

$options_from = static function ( array $rows, string $sep = ' · ' ): array {
	return array_map(
		static fn( array $row ): array => array(
			'value' => $row['code'],
			'label' => $row['code'] . $sep . $row['name'],
		),
		$rows
	);
};
?>
<section class="<?php echo esc_attr( $data->module_class ); ?>" data-reveal<?php echo $anchor; // phpcs:ignore ?>>
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
			<div class="db__grid">
				<?php
				$field( array( 'name' => 'customer_id', 'label' => 'CCCD / Mã số thuế' ) );
				$field( array( 'name' => 'customer_name', 'label' => 'Họ và tên' ) );
				$field( array( 'name' => 'customer_phone', 'label' => 'Số điện thoại', 'type' => 'tel' ) );
				$field( array( 'name' => 'customer_email', 'label' => 'Email', 'type' => 'email' ) );
				$field( array( 'name' => 'customer_address', 'label' => 'Địa chỉ', 'wide' => true ) );
				?>
			</div>
		</fieldset>

		<!-- Thông tin chung -->
		<fieldset class="db__section">
			<legend class="db__legend"><?php esc_html_e( 'Thông tin chung', 'starter-flexible' ); ?></legend>
			<div class="db__grid">
				<?php
				$field( array( 'name' => 'request_no', 'label' => 'Số đơn đề nghị' ) );
				$field( array( 'name' => 'request_date', 'label' => 'Ngày nộp đơn đề nghị', 'type' => 'date' ) );
				$field( array( 'name' => 'vessel_no', 'label' => 'Số đăng ký (số hiệu tàu)' ) );
				$field(
					array(
						'name'    => 'design_type',
						'label'   => 'Loại hình thiết kế',
						'type'    => 'select',
						'options' => $options_from( (array) $catalogs['design_types'] ),
					)
				);
				$field(
					array(
						'name'    => 'region',
						'label'   => 'Vùng hoạt động',
						'type'    => 'select',
						'options' => (array) $catalogs['regions'],
					)
				);
				$field(
					array(
						'name'    => 'province',
						'label'   => 'Tỉnh',
						'type'    => 'select',
						'options' => $options_from( (array) $catalogs['provinces'] ),
					)
				);
				$field(
					array(
						'name'  => 'design_code',
						'label' => 'Ký hiệu thiết kế',
						'hint'  => 'Ghép từ Tỉnh – số – Loại hình thiết kế. Sửa được phần số ở giữa.',
						'attrs' => array( 'data-db-code' => true ),
					)
				);
				$field( array( 'name' => 'vessel_template', 'label' => 'Mẫu tàu' ) );
				$field(
					array(
						'name'    => 'registry',
						'label'   => 'Trung tâm đăng kiểm',
						'type'    => 'select',
						'options' => $options_from( (array) $catalogs['registries'] ),
					)
				);
				$field( array( 'name' => 'handler', 'label' => 'Người phụ trách (nếu có)' ) );
				$field( array( 'name' => 'fee', 'label' => 'Số tiền cần thanh toán', 'unit' => 'đ', 'attrs' => array( 'data-db-money' => true ) ) );
				$field( array( 'name' => 'general_note', 'label' => 'Ghi chú', 'type' => 'textarea', 'wide' => true ) );
				?>
			</div>
		</fieldset>

		<!-- Kích thước tàu -->
		<fieldset class="db__section">
			<legend class="db__legend"><?php esc_html_e( 'Kích thước tàu', 'starter-flexible' ); ?></legend>
			<div class="db__grid db__grid--tight">
				<?php
				$dims = array(
					array( 'lmax', 'Chiều dài Lmax', 'm' ),
					array( 'bmax', 'Chiều rộng Bmax', 'm' ),
					array( 'depth', 'Chiều cao mạn D', 'm' ),
					array( 'frame_space', 'Khoảng cách sườn', 'mm' ),
					array( 'cabin1_l', 'Chiều dài cabin tầng 1', 'm' ),
					array( 'cabin1_b', 'Chiều rộng cabin tầng 1', 'm' ),
					array( 'cabin1_h', 'Chiều cao cabin tầng 1', 'm' ),
					array( 'cabin2_l', 'Chiều dài cabin tầng 2', 'm' ),
					array( 'cabin2_b', 'Chiều rộng cabin tầng 2', 'm' ),
					array( 'cabin2_h', 'Chiều cao cabin tầng 2', 'm' ),
				);
				foreach ( $dims as $dim ) {
					$field( array( 'name' => $dim[0], 'label' => $dim[1], 'type' => 'number', 'unit' => $dim[2] ) );
				}
				$field( array( 'name' => 'hold_count', 'label' => 'Số lượng khoang', 'type' => 'number' ) );
				$field( array( 'name' => 'hold_layout', 'label' => 'Bố trí khoang', 'hint' => 'Ví dụ: 1NC+3H' ) );
				$field( array( 'name' => 'cabin_actual', 'label' => 'Cabin thực tế' ) );
				$field( array( 'name' => 'size_note', 'label' => 'Ghi chú', 'type' => 'textarea', 'wide' => true ) );
				?>
			</div>
		</fieldset>

		<!-- Kết cấu thân tàu -->
		<fieldset class="db__section">
			<legend class="db__legend"><?php esc_html_e( 'Kết cấu thân tàu', 'starter-flexible' ); ?></legend>
			<p class="db__note"><?php esc_html_e( 'Ghi quy cách từng cơ cấu, ví dụ 60 × 120. Để trống nếu tàu không có cơ cấu đó.', 'starter-flexible' ); ?></p>
			<div class="db__grid db__grid--members">
				<?php foreach ( $data->hull_members as $i => $member ) : ?>
					<?php $field( array( 'name' => 'hull_' . $i, 'label' => $member ) ); ?>
				<?php endforeach; ?>
			</div>
			<div class="db__grid">
				<?php $field( array( 'name' => 'hull_note', 'label' => 'Ghi chú', 'type' => 'textarea', 'wide' => true ) ); ?>
			</div>
		</fieldset>

		<!-- Khai thác & trang thiết bị -->
		<fieldset class="db__section">
			<legend class="db__legend"><?php esc_html_e( 'Khai thác & Trang thiết bị', 'starter-flexible' ); ?></legend>
			<div class="db__grid">
				<?php
				$field( array( 'name' => 'trade_1', 'label' => 'Nghề 1 (khai thác chính)' ) );
				$field( array( 'name' => 'trade_2', 'label' => 'Nghề 2 (nghề phụ)' ) );
				$field( array( 'name' => 'trip_days', 'label' => 'Thời gian chuyến biển', 'unit' => 'ngày' ) );
				$field( array( 'name' => 'crew', 'label' => 'Số lượng thuyền viên', 'type' => 'number' ) );
				$field( array( 'name' => 'gear_weight', 'label' => 'Khối lượng lưới/ngư cụ', 'type' => 'number', 'unit' => 'kg' ) );
				$field( array( 'name' => 'store_fuel', 'label' => 'Dầu', 'type' => 'number', 'unit' => 'kg' ) );
				$field( array( 'name' => 'store_water', 'label' => 'Nước ngọt', 'type' => 'number', 'unit' => 'kg' ) );
				$field( array( 'name' => 'store_ice', 'label' => 'Đá', 'type' => 'number', 'unit' => 'kg' ) );
				$field( array( 'name' => 'store_fish', 'label' => 'Cá', 'type' => 'number', 'unit' => 'kg' ) );
				$field( array( 'name' => 'crane_count', 'label' => 'Số lượng cẩu', 'type' => 'number' ) );
				$field( array( 'name' => 'crane_type', 'label' => 'Loại cẩu' ) );
				$field( array( 'name' => 'winch_count', 'label' => 'Số lượng tời', 'type' => 'number' ) );
				$field( array( 'name' => 'winch_type', 'label' => 'Loại tời' ) );
				$field( array( 'name' => 'rudder', 'label' => 'Bánh lái', 'type' => 'select', 'options' => (array) $catalogs['rudders'] ) );
				$field( array( 'name' => 'steering', 'label' => 'Hệ thống lái', 'type' => 'select', 'options' => (array) $catalogs['steering'] ) );
				$field( array( 'name' => 'power_source', 'label' => 'Hình thức phát điện', 'type' => 'select', 'options' => (array) $catalogs['power_sources'] ) );
				$field( array( 'name' => 'genset_count', 'label' => 'Số lượng máy phát điện', 'type' => 'number' ) );
				$field( array( 'name' => 'genset_kw', 'label' => 'Công suất máy phát điện', 'type' => 'number', 'unit' => 'kW' ) );
				$field( array( 'name' => 'ops_note', 'label' => 'Ghi chú', 'type' => 'textarea', 'wide' => true ) );
				?>
			</div>
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
			<div class="db__grid db__grid--tight">
				<?php
				$field( array( 'name' => 'engine_position', 'label' => 'Vị trí máy (nhìn về mũi)', 'type' => 'select', 'options' => (array) $catalogs['engine_positions'] ) );
				$field(
					array(
						'name'        => 'engine_make',
						'label'       => 'Hãng',
						'type'        => 'select',
						'options'     => array_values( array_unique( array_column( $data->engines, 'make' ) ) ),
						'attrs'       => array( 'data-db-make' => true ),
						'placeholder' => '— Chọn hãng —',
					)
				);
				$field(
					array(
						'name'        => 'engine_model',
						'label'       => 'Mã hiệu máy',
						'type'        => 'select',
						'options'     => array(),
						'attrs'       => array( 'data-db-model' => true ),
						'placeholder' => '— Chọn mã hiệu —',
						'hint'        => 'Chọn từ danh mục Mẫu máy; công suất và số vòng quay lấy theo dòng máy này.',
					)
				);
				$field( array( 'name' => 'engine_serial', 'label' => 'Số máy' ) );
				?>
			</div>

			<h4 class="db__sub"><?php esc_html_e( 'Thông số máy', 'starter-flexible' ); ?></h4>
			<div class="db__grid db__grid--tight">
				<?php
				$field( array( 'name' => 'engine_kw', 'label' => 'Công suất', 'type' => 'number', 'unit' => 'kW', 'attrs' => array( 'data-db-kw' => true ) ) );
				$field( array( 'name' => 'engine_rpm', 'label' => 'Số vòng quay', 'type' => 'number', 'unit' => 'rpm', 'attrs' => array( 'data-db-rpm' => true ) ) );
				$field( array( 'name' => 'gear_ratio', 'label' => 'Tỉ số truyền', 'type' => 'number', 'attrs' => array( 'data-db-ratio' => true ) ) );
				?>
			</div>

			<h4 class="db__sub"><?php esc_html_e( 'Trục chân vịt', 'starter-flexible' ); ?></h4>
			<div class="db__grid db__grid--tight">
				<?php
				$field(
					array(
						'name'    => 'shaft_material',
						'label'   => 'Vật liệu trục chân vịt',
						'type'    => 'select',
						'options' => array_map(
							static fn( array $m ): array => array(
								'value' => $m['code'],
								'label' => $m['code'] . ' · ' . $m['name'],
								'data'  => array( 'k3' => $m['k3'] ),
							),
							$data->materials
						),
						'attrs'   => array( 'data-db-material' => true ),
					)
				);
				$field( array( 'name' => 'k3', 'label' => 'Hệ số K3', 'type' => 'number', 'attrs' => array( 'data-db-k3' => true ) ) );
				$field( array( 'name' => 'prop_rpm', 'label' => 'Số vòng quay chân vịt', 'type' => 'number', 'unit' => 'rpm', 'attrs' => array( 'data-db-prop-rpm' => true, 'readonly' => true ) ) );
				$field( array( 'name' => 'shaft_length', 'label' => 'Chiều dài trục chân vịt', 'type' => 'number', 'unit' => 'mm' ) );
				$field( array( 'name' => 'shaft_dmin', 'label' => 'Đường kính tối thiểu trục chân vịt', 'type' => 'number', 'unit' => 'mm', 'attrs' => array( 'data-db-dmin' => true, 'readonly' => true ) ) );
				$field( array( 'name' => 'shaft_dreal', 'label' => 'Đường kính trục thực tế', 'type' => 'number', 'unit' => 'mm' ) );
				?>
			</div>

			<h4 class="db__sub"><?php esc_html_e( 'Chân vịt', 'starter-flexible' ); ?></h4>
			<div class="db__grid db__grid--tight">
				<?php
				$field( array( 'name' => 'prop_material', 'label' => 'Vật liệu chân vịt', 'type' => 'select', 'options' => (array) $catalogs['propeller_materials'] ) );
				$field( array( 'name' => 'prop_blades', 'label' => 'Số cánh chân vịt', 'type' => 'number' ) );
				$field( array( 'name' => 'prop_diameter', 'label' => 'Đường kính chân vịt', 'type' => 'number', 'unit' => 'm' ) );
				$field( array( 'name' => 'prop_weight', 'label' => 'Khối lượng chân vịt', 'type' => 'number', 'unit' => 'kg' ) );
				?>
			</div>

			<h4 class="db__sub"><?php esc_html_e( 'Bệ máy', 'starter-flexible' ); ?></h4>
			<div class="db__grid db__grid--tight">
				<?php
				$field( array( 'name' => 'bed_gearbox_bolt', 'label' => 'Chân hộp số (bu lông)', 'type' => 'number', 'unit' => 'mm' ) );
				$field( array( 'name' => 'bed_engine_bolt', 'label' => 'Chân máy chính (bu lông)', 'type' => 'number', 'unit' => 'mm' ) );
				foreach ( array( 'L1', 'L2', 'L3', 'L4', 'L5', 'B1', 'B2', 'B3', 'B4' ) as $mark ) {
					$field( array( 'name' => 'bed_' . strtolower( $mark ), 'label' => $mark, 'type' => 'number', 'unit' => 'mm' ) );
				}
				$field( array( 'name' => 'engine_note', 'label' => 'Ghi chú', 'type' => 'textarea', 'wide' => true ) );
				?>
			</div>
		</fieldset>
	</template>

	<?php if ( $data->cf7_id ) : ?>
		<?php /* Contact Form 7 does the sending: the brief is written into its
		         hidden fields and its own submit button is clicked. */ ?>
		<div class="db__cf7" data-db-cf7>
			<?php echo do_shortcode( sprintf( '[contact-form-7 id="%d"]', $data->cf7_id ) ); ?>
		</div>
	<?php endif; ?>

	<script type="application/json" data-db-engines-data><?php echo wp_json_encode( $data->engines ); ?></script>
</section>
