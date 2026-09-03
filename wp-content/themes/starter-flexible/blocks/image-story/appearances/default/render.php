<?php
/**
 * Image Story — default appearance.
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
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Thêm ảnh cho Image Story ở thanh bên.', 'starter-flexible' ) );
	}
	return;
}

$anchor = ! empty( $block['anchor'] ) ? ' id="' . esc_attr( (string) $block['anchor'] ) . '"' : '';
?>
<section class="<?php echo esc_attr( $data->module_class ); ?>" data-reveal<?php echo $anchor; // phpcs:ignore ?>>
	<?php get_template_part( 'template-parts/components/block-head', null, array( 'label' => $data->label ) ); ?>
	<div class="is__grid" data-gallery data-reveal-stagger>
		<?php foreach ( $data->items as $i => $item ) : ?>
			<button type="button" class="is__item" data-gallery-open data-i="<?php echo esc_attr( (string) $i ); ?>">
				<?php
				get_template_part(
					'template-parts/components/frame',
					null,
					array(
						'ratio'       => 'ratio-4-3',
						'class'       => 'frame--zoom',
						'src'         => $item['thumb'],
						'alt'         => $item['caption'],
						'placeholder' => $item['placeholder'],
					)
				);
				?>
				<span class="is__caption"><?php echo esc_html( $item['caption'] ); ?></span>
			</button>
		<?php endforeach; ?>
	</div>
	<?php if ( $data->has_note ) : ?>
		<p class="copy is__note"><?php echo esc_html( $data->note ); ?></p>
	<?php endif; ?>
</section>

<div class="lightbox" data-lightbox hidden>
	<div class="lightbox__bar">
		<span data-lightbox-counter></span>
		<button type="button" class="icon-btn" data-lightbox-close aria-label="<?php esc_attr_e( 'Đóng', 'starter-flexible' ); ?>">
			<?php echo starter_flexible_icon( 'close', 20 ); // phpcs:ignore ?>
		</button>
	</div>
	<div class="lightbox__stage" data-lightbox-label></div>
	<div class="lightbox__bar">
		<span data-lightbox-caption></span>
		<span class="lightbox__nav">
			<button type="button" class="icon-btn" data-lightbox-prev aria-label="<?php esc_attr_e( 'Trước', 'starter-flexible' ); ?>">
				<?php echo starter_flexible_icon( 'chevronLeft', 20 ); // phpcs:ignore ?>
			</button>
			<button type="button" class="icon-btn" data-lightbox-next aria-label="<?php esc_attr_e( 'Sau', 'starter-flexible' ); ?>">
				<?php echo starter_flexible_icon( 'chevronRight', 20 ); // phpcs:ignore ?>
			</button>
		</span>
	</div>
	<script type="application/json" data-lightbox-data><?php echo wp_json_encode( $data->items ); ?></script>
</div>
