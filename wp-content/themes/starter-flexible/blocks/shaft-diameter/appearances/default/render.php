<?php
/**
 * Shaft Diameter — default appearance.
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
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Thêm ít nhất một vật liệu ở thanh bên.', 'starter-flexible' ) );
	}
	return;
}
?>
<form class="<?php echo esc_attr( $data->module_class ); ?>" data-shaft novalidate data-error-text="<?php echo esc_attr( $data->error_text ); ?>">
	<div class="sd__inputs">
		<?php
		get_template_part(
			'template-parts/components/input',
			null,
			array(
				'label' => $data->label_power,
				'name'  => 'power',
				'type'  => 'number',
				'attrs' => array( 'step' => 'any', 'min' => '0', 'value' => '750', 'data-shaft-power' => true ),
			)
		);
		get_template_part(
			'template-parts/components/input',
			null,
			array(
				'label' => $data->label_rpm,
				'name'  => 'rpm',
				'type'  => 'number',
				'attrs' => array( 'step' => 'any', 'min' => '1', 'value' => '1800', 'data-shaft-rpm' => true ),
			)
		);
		?>
	</div>

	<fieldset class="sd__materials">
		<legend><?php echo esc_html( $data->label_material ); ?></legend>
		<div class="sd__options">
			<?php foreach ( $data->materials as $i => $material ) : ?>
				<label class="sd__option">
					<input type="radio" name="material" value="<?php echo esc_attr( (string) $material['strength'] ); ?>" <?php checked( 0, $i ); ?> data-shaft-material />
					<span>
						<strong><?php echo esc_html( $material['name'] ); ?></strong>
						<em><?php echo esc_html( $material['note'] ); ?></em>
					</span>
				</label>
			<?php endforeach; ?>
		</div>
	</fieldset>

	<div class="sd__result">
		<span class="meta"><?php echo esc_html( $data->result_label ); ?></span>
		<span class="sd__value" data-shaft-result>—</span>
	</div>

	<p class="sd__error" data-shaft-error hidden></p>

	<button type="reset" class="btn btn--ghost sd__reset">
		<?php echo esc_html( $data->reset_label ); ?>
		<?php echo starter_flexible_icon( 'arrow', 17 ); // phpcs:ignore ?>
	</button>
</form>
