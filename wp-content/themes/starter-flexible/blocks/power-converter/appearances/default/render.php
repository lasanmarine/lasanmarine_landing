<?php
/**
 * Power Converter — default appearance.
 *
 * @var object $data
 * @var array  $block
 * @var bool   $is_preview
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( empty( $data->should_render ) ) {
	if ( $is_preview ) {
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Thêm các đơn vị quy đổi ở thanh bên.', 'starter-flexible' ) );
	}
	return;
}
?>
<form class="<?php echo esc_attr( $data->module_class ); ?>" data-power novalidate>
	<div class="pc__inputs">
		<?php
		get_template_part(
			'template-parts/components/input',
			null,
			array(
				'label' => $data->input_label,
				'name'  => 'value',
				'type'  => 'number',
				'attrs' => array( 'step' => 'any', 'min' => '0', 'value' => '1000', 'data-power-value' => true ),
			)
		);
		get_template_part(
			'template-parts/components/select',
			null,
			array(
				'label'   => $data->unit_label,
				'name'    => 'unit',
				'options' => $data->unit_options,
				'attrs'   => array( 'data-power-unit' => true ),
			)
		);
		?>
	</div>

	<div class="pc__results" data-power-results>
		<?php foreach ( $data->units as $unit ) : ?>
			<div class="spec">
				<span class="spec__label"><?php echo esc_html( $unit['label'] ); ?></span>
				<span class="spec__leader"></span>
				<span class="spec__value" data-power-out="<?php echo esc_attr( $unit['id'] ); ?>">—</span>
			</div>
		<?php endforeach; ?>
	</div>

	<button type="reset" class="btn btn--ghost pc__reset">
		<?php echo esc_html( $data->reset_label ); ?>
		<?php echo starter_flexible_icon( 'arrow', 17 ); // phpcs:ignore ?>
	</button>

	<script type="application/json" data-power-units><?php echo wp_json_encode( $data->units ); ?></script>
</form>
