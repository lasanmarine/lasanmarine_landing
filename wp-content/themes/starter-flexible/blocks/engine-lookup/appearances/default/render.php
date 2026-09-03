<?php
/**
 * Engine Lookup — default appearance.
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

$labels = $data->labels;
?>
<div class="<?php echo esc_attr( $data->module_class ); ?>" data-engines data-per-page="<?php echo esc_attr( (string) $data->per_page ); ?>">
	<div class="el__controls">
		<?php
		get_template_part(
			'template-parts/components/input',
			null,
			array(
				'label' => $labels['search'],
				'type'  => 'search',
				'attrs' => array( 'placeholder' => $data->columns[1]['label'], 'data-el-search' => true ),
			)
		);
		get_template_part(
			'template-parts/components/select',
			null,
			array(
				'label'       => $data->columns[0]['label'],
				'options'     => $data->makes,
				'placeholder' => $labels['all_makes'],
				'attrs'       => array( 'data-el-make' => true ),
			)
		);
		get_template_part(
			'template-parts/components/input',
			null,
			array(
				'label' => $labels['min_power'],
				'type'  => 'number',
				'attrs' => array( 'min' => '0', 'step' => '10', 'data-el-min' => true ),
			)
		);
		?>
	</div>

	<div class="el__meta">
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
								<span class="el__arrow" aria-hidden="true">↕</span>
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

	<script type="application/json" data-el-rows><?php echo wp_json_encode( $data->rows ); ?></script>
</div>
