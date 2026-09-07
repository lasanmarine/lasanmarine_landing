<?php
/**
 * Engine Lookup — default appearance.
 *
 * Built on the Power Converter's shell: same `pc__*` grid, inputs, radio pills
 * and result panel, so the three tools read as one family.
 *
 * @var object $data
 * @var bool   $is_preview
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( empty( $data->should_render ) ) {
	if ( $is_preview ) {
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Không đọc được dữ liệu động cơ.', 'starter-flexible' ) );
	}
	return;
}

?>
<div
	class="<?php echo esc_attr( $data->module_class ); ?>"
	data-engines
	data-per-page="<?php echo esc_attr( (string) $data->per_page ); ?>"
	data-model-sample="<?php echo esc_attr( (string) $data->model_sample ); ?>"
	data-model-hint="<?php echo esc_attr( $data->labels['model_hint'] ); ?>"
	data-none-found="<?php echo esc_attr( $data->labels['none_found'] ); ?>"
	data-copy-label="<?php echo esc_attr( $data->labels['copy'] ); ?>"
>
	<div class="pc__grid el__grid">
		<div class="pc__inputs" data-aos="fade-right">
			<div class="field">
				<label class="field__label sr-only" for="<?php echo esc_attr( $data->search_id ); ?>"><?php echo esc_html( $data->labels['search'] ); ?></label>
				<input
					class="field__control"
					id="<?php echo esc_attr( $data->search_id ); ?>"
					type="search"
					placeholder="<?php echo esc_attr( $data->labels['search_hint'] ); ?>"
					data-el-search
				/>
			</div>


			<?php foreach ( $data->multis as $multi ) : ?>
				<div class="field">
					<span class="field__label" id="<?php echo esc_attr( $multi['id'] ); ?>-label"><?php echo esc_html( $multi['label'] ); ?></span>
					<div
						class="pc__multi"
						data-ms="<?php echo esc_attr( $multi['key'] ); ?>"
						data-ms-placeholder="<?php echo esc_attr( $multi['placeholder'] ); ?>"
						data-ms-more="<?php echo esc_attr( $multi['more'] ); ?>"
						data-ms-count="<?php echo esc_attr( $multi['count'] ); ?>"
					>
						<button
							type="button"
							class="field__control pc__multi-trigger is-empty"
							id="<?php echo esc_attr( $multi['id'] ); ?>"
							aria-expanded="false"
							aria-haspopup="dialog"
							aria-labelledby="<?php echo esc_attr( $multi['id'] ); ?>-label <?php echo esc_attr( $multi['id'] ); ?>"
							data-ms-trigger
						>
							<span class="pc__multi-value" data-ms-value><?php echo esc_html( $multi['placeholder'] ); ?></span>
							<span class="pc__multi-caret" aria-hidden="true"><?php echo starter_flexible_icon( 'chevronDown', 16 ); // phpcs:ignore ?></span>
						</button>
						<div class="pc__multi-pop" role="dialog" aria-label="<?php echo esc_attr( $multi['label'] ); ?>" data-ms-pop hidden>
							<input
								class="field__control pc__multi-search"
								type="search"
								placeholder="<?php echo esc_attr( $multi['search'] ); ?>"
								aria-label="<?php echo esc_attr( $multi['search'] ); ?>"
								data-ms-search
							/>
							<p class="pc__multi-note" data-ms-note hidden></p>
							<div class="pc__multi-list" data-ms-list></div>
							<div class="pc__multi-foot">
								<button type="button" class="pc__multi-clear" data-ms-clear><?php echo esc_html( $data->labels['clear'] ); ?></button>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach; ?>

			<?php foreach ( $data->ranges as $range ) : ?>
				<div class="field">
					<span class="field__label"><?php echo esc_html( $range['label'] ); ?></span>
					<div class="pc__range">
						<input
							class="field__control"
							type="number"
							min="0"
							step="any"
							inputmode="decimal"
							placeholder="<?php echo esc_attr( $data->labels['from'] ); ?>"
							aria-label="<?php echo esc_attr( $range['label'] . ' — ' . $data->labels['from'] ); ?>"
							<?php echo esc_attr( $range['min_hook'] ); ?>
						/>
						<span class="pc__range-sep" aria-hidden="true">–</span>
						<input
							class="field__control"
							type="number"
							min="0"
							step="any"
							inputmode="decimal"
							placeholder="<?php echo esc_attr( $data->labels['to'] ); ?>"
							aria-label="<?php echo esc_attr( $range['label'] . ' — ' . $data->labels['to'] ); ?>"
							<?php echo esc_attr( $range['max_hook'] ); ?>
						/>
						<select class="field__control pc__unit" <?php echo esc_attr( $range['unit_hook'] ); ?> aria-label="<?php echo esc_attr( $range['unit_label'] ); ?>">
							<?php foreach ( $range['units'] as $unit ) : ?>
								<option value="<?php echo esc_attr( (string) $unit['factor'] ); ?>" <?php selected( ! empty( $unit['is_default'] ) ); ?>><?php echo esc_html( $unit['label'] ); ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
			<?php endforeach; ?>

			<button type="button" class="btn pc__reset" data-el-reset>
				<?php echo esc_html( $data->labels['reset'] ); ?>
				<?php echo starter_flexible_icon( 'arrow', 17 ); // phpcs:ignore ?>
			</button>
		</div>

		<div class="pc__results" data-aos="fade-left" data-aos-delay="100">
			<div class="el__head">
				<h3 class="pc__heading"><?php echo esc_html( $data->labels['results'] ); ?></h3>
				<span class="meta"><span data-el-count>0</span> <?php echo esc_html( $data->labels['rows_found'] ); ?></span>
			</div>

			<div class="el__scroll">
				<table class="el__table">
					<thead>
						<tr>
							<?php foreach ( $data->columns as $column ) : ?>
								<th scope="col">
									<button type="button" data-el-sort="<?php echo esc_attr( $column['key'] ); ?>">
										<?php echo esc_html( $column['label'] ); ?>
										<span class="el__arrow" aria-hidden="true">
											<?php echo starter_flexible_icon( 'sort', 15, 'el__arrow-icon el__arrow-icon--idle' ); // phpcs:ignore ?>
											<?php echo starter_flexible_icon( 'arrowUp', 15, 'el__arrow-icon el__arrow-icon--asc' ); // phpcs:ignore ?>
											<?php echo starter_flexible_icon( 'arrowDown', 15, 'el__arrow-icon el__arrow-icon--desc' ); // phpcs:ignore ?>
										</span>
									</button>
								</th>
							<?php endforeach; ?>
						</tr>
					</thead>
					<tbody data-el-body></tbody>
				</table>
			</div>

			<p class="el__empty" data-el-empty hidden><?php echo esc_html( $data->labels['no_results'] ); ?></p>

			<div class="el__pager" data-el-pager>
				<button type="button" class="icon-btn icon-btn--sm" data-el-prev aria-label="<?php esc_attr_e( 'Trước', 'starter-flexible' ); ?>">
					<?php echo starter_flexible_icon( 'chevronLeft', 18 ); // phpcs:ignore ?>
				</button>
				<span class="meta" data-el-page></span>
				<button type="button" class="icon-btn icon-btn--sm" data-el-next aria-label="<?php esc_attr_e( 'Sau', 'starter-flexible' ); ?>">
					<?php echo starter_flexible_icon( 'chevronRight', 18 ); // phpcs:ignore ?>
				</button>
			</div>
		</div>
	</div>

	<script type="application/json" data-el-rows><?php echo $data->rows_json; ?></script>
</div>
