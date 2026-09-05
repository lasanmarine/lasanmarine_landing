<?php
/**
 * Engine Lookup — default appearance.
 *
 * Built on the Power Converter's shell: same `pc__*` grid, inputs, radio pills
 * and result panel, so the three tools read as one family.
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
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Không đọc được dữ liệu động cơ.', 'starter-flexible' ) );
	}
	return;
}

$labels    = $data->labels;
$search_id = wp_unique_id( 'el-search-' );

/**
 * A from/to pair sharing one unit select — the unit's `value` is the factor
 * back to the dataset's units, applied in script.js.
 */
$ranges = array(
	array(
		'label'      => $labels['power_range'],
		'min_hook'   => 'data-el-kw-min',
		'max_hook'   => 'data-el-kw-max',
		'unit_hook'  => 'data-el-kw-unit',
		'unit_label' => __( 'Đơn vị công suất', 'starter-flexible' ),
		'units'      => $data->power_units,
	),
	array(
		'label'      => $labels['rpm_range'],
		'min_hook'   => 'data-el-rpm-min',
		'max_hook'   => 'data-el-rpm-max',
		'unit_hook'  => 'data-el-rpm-unit',
		'unit_label' => __( 'Đơn vị vòng quay', 'starter-flexible' ),
		'units'      => $data->rpm_units,
	),
);
?>
<div
	class="<?php echo esc_attr( $data->module_class ); ?>"
	data-engines
	data-per-page="<?php echo esc_attr( (string) $data->per_page ); ?>"
	data-model-sample="<?php echo esc_attr( (string) $data->model_sample ); ?>"
	data-model-hint="<?php echo esc_attr( $labels['model_hint'] ); ?>"
	data-none-found="<?php echo esc_attr( $labels['none_found'] ); ?>"
	data-copy-label="<?php echo esc_attr( $labels['copy'] ); ?>"
>
	<div class="pc__grid el__grid">
		<div class="pc__inputs" data-aos="fade-right">
			<div class="field">
				<label class="field__label sr-only" for="<?php echo esc_attr( $search_id ); ?>"><?php echo esc_html( $labels['search'] ); ?></label>
				<input
					class="field__control"
					id="<?php echo esc_attr( $search_id ); ?>"
					type="search"
					placeholder="<?php echo esc_attr( $labels['search_hint'] ); ?>"
					data-el-search
				/>
			</div>

			<?php
			$multis = array(
				array(
					'key'         => 'make',
					'label'       => $labels['make'],
					'placeholder' => $labels['all_makes'],
					'search'      => $labels['search_make'],
					'more'        => $labels['more_makes'],
					'count'       => $labels['count_makes'],
				),
				array(
					'key'         => 'model',
					'label'       => $labels['model'],
					'placeholder' => $labels['all_models'],
					'search'      => $labels['search_model'],
					'more'        => $labels['more_models'],
					'count'       => $labels['count_models'],
				),
			);
			?>
			<?php foreach ( $multis as $multi ) : ?>
				<?php $multi_id = wp_unique_id( 'el-' . $multi['key'] . '-' ); ?>
				<div class="field">
					<span class="field__label" id="<?php echo esc_attr( $multi_id ); ?>-label"><?php echo esc_html( $multi['label'] ); ?></span>
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
							id="<?php echo esc_attr( $multi_id ); ?>"
							aria-expanded="false"
							aria-haspopup="dialog"
							aria-labelledby="<?php echo esc_attr( $multi_id ); ?>-label <?php echo esc_attr( $multi_id ); ?>"
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
								<button type="button" class="pc__multi-clear" data-ms-clear><?php echo esc_html( $labels['clear'] ); ?></button>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach; ?>

			<?php foreach ( $ranges as $range ) : ?>
				<div class="field">
					<span class="field__label"><?php echo esc_html( $range['label'] ); ?></span>
					<div class="pc__range">
						<input
							class="field__control"
							type="number"
							min="0"
							step="any"
							inputmode="decimal"
							placeholder="<?php echo esc_attr( $labels['from'] ); ?>"
							aria-label="<?php echo esc_attr( $range['label'] . ' — ' . $labels['from'] ); ?>"
							<?php echo esc_attr( $range['min_hook'] ); ?>
						/>
						<span class="pc__range-sep" aria-hidden="true">–</span>
						<input
							class="field__control"
							type="number"
							min="0"
							step="any"
							inputmode="decimal"
							placeholder="<?php echo esc_attr( $labels['to'] ); ?>"
							aria-label="<?php echo esc_attr( $range['label'] . ' — ' . $labels['to'] ); ?>"
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
				<?php echo esc_html( $labels['reset'] ); ?>
				<?php echo starter_flexible_icon( 'arrow', 17 ); // phpcs:ignore ?>
			</button>
		</div>

		<div class="pc__results" data-aos="fade-left" data-aos-delay="100">
			<div class="el__head">
				<h3 class="pc__heading"><?php echo esc_html( $labels['results'] ); ?></h3>
				<span class="meta"><span data-el-count>0</span> <?php echo esc_html( $labels['rows_found'] ); ?></span>
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

			<p class="el__empty" data-el-empty hidden><?php echo esc_html( $labels['no_results'] ); ?></p>

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

	<script type="application/json" data-el-rows><?php echo wp_json_encode( $data->rows ); ?></script>
</div>
