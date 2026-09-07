<?php
/**
 * Shaft Diameter — default appearance.
 *
 * Built on the Power Converter's shell: same `pc__*` grid, inputs, radio pills
 * and result panel, so the two calculators read as one tool.
 *
 * @var object $data
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
	<div class="pc__grid">
		<div class="pc__inputs" data-aos="fade-right">

			<?php foreach ( $data->combos as $combo ) : ?>
				<div class="field">
					<label class="field__label" for="<?php echo esc_attr( $combo['id'] ); ?>"><?php echo esc_html( $combo['label'] ); ?></label>
					<div class="pc__combo">
						<input
							class="field__control"
							id="<?php echo esc_attr( $combo['id'] ); ?>"
							name="<?php echo esc_attr( $combo['name'] ); ?>"
							type="number"
							step="any"
							min="<?php echo esc_attr( $combo['min'] ); ?>"
							value="<?php echo esc_attr( $combo['value'] ); ?>"
							inputmode="decimal"
							<?php echo esc_attr( $combo['hook'] ); ?>
						/>
						<select class="field__control pc__unit" <?php echo esc_attr( $combo['unit_hook'] ); ?> aria-label="<?php echo esc_attr( $combo['unit_label'] ); ?>">
							<?php foreach ( $combo['units'] as $unit ) : ?>
								<option value="<?php echo esc_attr( (string) $unit['factor'] ); ?>" <?php selected( ! empty( $unit['is_default'] ) ); ?>><?php echo esc_html( $unit['label'] ); ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
			<?php endforeach; ?>

			<div class="field">
				<label class="field__label" for="<?php echo esc_attr( $data->ratio_id ); ?>"><?php echo esc_html( $data->label_ratio ); ?></label>
				<input
					class="field__control"
					id="<?php echo esc_attr( $data->ratio_id ); ?>"
					name="ratio"
					type="number"
					step="any"
					min="0.01"
					value="1"
					inputmode="decimal"
					data-shaft-ratio
				/>
			</div>

			<p class="pc__error" data-shaft-error hidden></p>

			<fieldset class="pc__units">
				<legend class="field__label"><?php echo esc_html( $data->label_material ); ?></legend>
				<div class="pc__choices">
					<?php foreach ( $data->materials as $i => $material ) : ?>
						<label class="pc__choice">
							<input type="radio" name="material" value="<?php echo esc_attr( (string) $material['k3'] ); ?>" <?php checked( 0, $i ); ?> data-shaft-material />
							<span class="sd__choice-text">
								<strong><?php echo esc_html( $material['name'] ); ?></strong>
								<?php if ( $material['has_note'] ) : ?>
									<em><?php echo esc_html( $material['note'] ); ?></em>
								<?php endif; ?>
							</span>
							<span class="sd__choice-k">k = <?php echo esc_html( $material['k3_label'] ); ?></span>
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
			<div class="pc__result-list" aria-live="polite" aria-atomic="true">

				<?php foreach ( $data->rows as $row ) : ?>
					<div class="pc__result" data-shaft-row="<?php echo esc_attr( $row['id'] ); ?>" data-aos="fade-up" data-aos-delay="<?php echo esc_attr( (string) $row['delay'] ); ?>">
						<span class="pc__result-label"><?php echo esc_html( $row['label'] ); ?></span>
						<output class="pc__result-value" aria-label="<?php echo esc_attr( $row['label'] ); ?>" <?php echo esc_attr( $row['attr'] ); ?>>—</output>
						<button type="button" class="pc__copy" data-shaft-copy="<?php echo esc_attr( $row['id'] ); ?>" aria-label="<?php esc_attr_e( 'Sao chép kết quả', 'starter-flexible' ); ?>">
							<?php echo starter_flexible_icon( 'copy', 20, 'pc__copy-icon' ); // phpcs:ignore ?>
							<?php echo starter_flexible_icon( 'check', 20, 'pc__copy-icon pc__copy-icon--done' ); // phpcs:ignore ?>
						</button>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</form>
