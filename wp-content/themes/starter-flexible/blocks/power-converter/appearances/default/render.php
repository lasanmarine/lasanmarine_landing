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
	<div class="pc__grid">
		<div class="pc__inputs" data-aos="fade-right">
			<?php
			get_template_part(
				'template-parts/components/input',
				null,
				array(
					'label' => $data->input_label,
					'name'  => 'value',
					'id'    => $data->input_id,
					'type'  => 'number',
					'attrs' => array( 'step' => 'any', 'min' => '0', 'value' => '1000', 'inputmode' => 'decimal', 'data-power-value' => true, 'aria-describedby' => $data->input_id . '-error' ),
				)
			);
			?>
			<p class="pc__error" id="<?php echo esc_attr( $data->input_id ); ?>-error" data-power-error hidden><?php echo esc_html( $data->error_text ); ?></p>
			<fieldset class="pc__units">
				<legend class="field__label"><?php echo esc_html( $data->unit_label ); ?></legend>
				<div class="pc__choices">
					<?php foreach ( $data->units as $unit ) : ?>
						<label class="pc__choice">
							<input type="radio" name="unit" value="<?php echo esc_attr( $unit['id'] ); ?>" data-power-unit <?php checked( $unit['is_default'] ); ?> />
							<span><?php echo esc_html( $unit['label'] ); ?></span>
						</label>
					<?php endforeach; ?>
				</div>
			</fieldset>

			<button type="reset" class="btn pc__reset">
				<?php echo esc_html( $data->reset_label ); ?>
				<?php echo starter_flexible_icon( 'arrow', 17 ); // phpcs:ignore ?>
			</button>
		</div>

		<div class="pc__results" data-aos="fade-left" data-aos-delay="100">
			<h3 class="pc__heading"><?php echo esc_html( $data->results_label ); ?></h3>
			<div class="pc__result-list" data-power-results aria-live="polite" aria-atomic="true">
				<?php foreach ( $data->units as $i => $unit ) : ?>
					<div class="pc__result" data-power-row="<?php echo esc_attr( $unit['id'] ); ?>" data-aos="fade-up" data-aos-delay="<?php echo esc_attr( (string) ( 150 + $i * 70 ) ); ?>">
						<span class="pc__result-label"><?php echo esc_html( $unit['label'] ); ?></span>
						<output class="pc__result-value" for="<?php echo esc_attr( $data->input_id ); ?>" aria-label="<?php echo esc_attr( $unit['label'] ); ?>" data-power-out="<?php echo esc_attr( $unit['id'] ); ?>">—</output>
						<button type="button" class="pc__copy" data-power-copy="<?php echo esc_attr( $unit['id'] ); ?>" aria-label="<?php esc_attr_e( 'Sao chép kết quả', 'starter-flexible' ); ?>">
							<?php echo starter_flexible_icon( 'copy', 20, 'pc__copy-icon' ); // phpcs:ignore ?>
							<?php echo starter_flexible_icon( 'check', 20, 'pc__copy-icon pc__copy-icon--done' ); // phpcs:ignore ?>
						</button>
					</div>
				<?php endforeach; ?>
			</div>
			<p class="field__hint pc__note">
				<?php echo esc_html( $data->result_note_pre ); ?>
				<input
					type="number"
					class="pc__precision"
					data-power-precision
					min="0"
					max="6"
					step="1"
					value="<?php echo esc_attr( (string) $data->default_precision ); ?>"
					aria-label="<?php esc_attr_e( 'Số chữ số thập phân', 'starter-flexible' ); ?>"
				/>
				<?php echo esc_html( $data->result_note_post ); ?>
			</p>
		</div>
	</div>

	<script type="application/json" data-power-units><?php echo wp_json_encode( $data->units, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT ); ?></script>
</form>
