<?php
/**
 * Document Center — default appearance.
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
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Thêm nhóm và tài liệu ở thanh bên.', 'starter-flexible' ) );
	}
	return;
}

$anchor = ! empty( $block['anchor'] ) ? ' id="' . esc_attr( (string) $block['anchor'] ) . '"' : '';
?>
<section class="<?php echo esc_attr( $data->module_class ); ?>" data-reveal<?php echo $anchor; // phpcs:ignore ?>>
	<?php
	if ( $data->has_label ) {
		get_template_part( 'template-parts/components/block-head', null, array( 'label' => $data->label ) );
	}
	?>
	<div class="dc__filters" role="tablist" data-doc-filters>
		<button type="button" class="dc__filter" data-doc-filter="all" data-active="true">
			<?php echo esc_html( $data->all_label ); ?>
		</button>
		<?php foreach ( $data->filters as $i => $filter ) : ?>
			<button type="button" class="dc__filter" data-doc-filter="<?php echo esc_attr( (string) $i ); ?>" data-active="false">
				<?php echo esc_html( $filter ); ?>
			</button>
		<?php endforeach; ?>
	</div>
	<div data-doc-list data-reveal-stagger="[data-doc-group]">
		<?php foreach ( $data->items as $item ) : ?>
			<div class="dc__row" data-doc-group="<?php echo esc_attr( (string) $item['group'] ); ?>">
				<span class="dc__icon">
					<?php echo starter_flexible_icon( 'file', 26 ); // phpcs:ignore ?>
				</span>
				<span class="dc__title"><?php echo esc_html( $item['title'] ); ?></span>
				<span class="dc__size"><?php echo esc_html( $item['size'] ); ?></span>
				<span class="dc__actions">
					<?php if ( $item['is_pdf'] ) : ?>
						<a class="btn btn--sm btn--secondary dc__view" href="<?php echo esc_url( $item['file'] ); ?>" target="_blank" rel="noopener">
							<?php echo starter_flexible_icon( 'scan', 20 ); // phpcs:ignore ?>
							<?php esc_html_e( 'Xem PDF', 'starter-flexible' ); ?>
						</a>
					<?php endif; ?>
					<?php if ( '' !== $item['file'] ) : ?>
						<a class="btn btn--sm dc__dl" href="<?php echo esc_url( $item['file'] ); ?>" download>
							<?php echo starter_flexible_icon_swap( 'download', 20 ); // phpcs:ignore ?>
							<?php esc_html_e( 'Tải xuống', 'starter-flexible' ); ?>
						</a>
					<?php else : ?>
						<?php /* No file attached yet — keep the slot, drop the affordance. */ ?>
						<button type="button" class="btn btn--sm dc__dl is-inert" disabled>
							<?php echo starter_flexible_icon( 'download', 20 ); // phpcs:ignore ?>
							<?php esc_html_e( 'Tải xuống', 'starter-flexible' ); ?>
						</button>
					<?php endif; ?>
				</span>
			</div>
		<?php endforeach; ?>
		<p class="dc__empty" data-doc-empty hidden><?php echo esc_html( $data->empty_text ); ?></p>
	</div>
</section>
