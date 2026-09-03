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
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Thêm tài liệu ở thanh bên.', 'starter-flexible' ) );
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
		<?php foreach ( $data->filters as $i => $filter ) : ?>
			<button type="button" class="dc__filter" data-doc-filter="<?php echo esc_attr( $filter ); ?>" data-active="<?php echo 0 === $i ? 'true' : 'false'; ?>">
				<?php echo esc_html( $filter ); ?>
			</button>
		<?php endforeach; ?>
	</div>
	<div data-doc-list data-reveal-stagger="[data-doc-group]">
		<?php foreach ( $data->items as $item ) : ?>
			<div class="dc__row" data-doc-group="<?php echo esc_attr( $item['group'] ); ?>">
				<span class="dc__icon">
					<?php echo starter_flexible_icon( 'file', 26 ); // phpcs:ignore ?>
				</span>
				<span class="dc__title"><?php echo esc_html( $item['title'] ); ?></span>
				<span class="dc__size"><?php echo esc_html( $item['size'] ); ?></span>
				<?php if ( '' !== $item['file'] ) : ?>
					<a class="icon-btn icon-btn--sm dc__dl" href="<?php echo esc_url( $item['file'] ); ?>" download aria-label="<?php esc_attr_e( 'Tải xuống', 'starter-flexible' ); ?>">
						<?php echo starter_flexible_icon( 'download', 19 ); // phpcs:ignore ?>
					</a>
				<?php else : ?>
					<?php /* No file attached yet — keep the slot, drop the affordance. */ ?>
					<button type="button" class="icon-btn icon-btn--sm dc__dl is-inert" aria-label="<?php esc_attr_e( 'Tải xuống', 'starter-flexible' ); ?>" disabled>
						<?php echo starter_flexible_icon( 'download', 19 ); // phpcs:ignore ?>
					</button>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
		<p class="dc__empty" data-doc-empty hidden><?php echo esc_html( $data->empty_text ); ?></p>
	</div>
</section>
