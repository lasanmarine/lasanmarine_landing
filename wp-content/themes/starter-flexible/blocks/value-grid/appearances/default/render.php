<?php
/**
 * Value Grid — default appearance.
 *
 * @var object $data
 * @var bool   $is_preview
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( empty( $data->should_render ) ) {
	if ( $is_preview ) {
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Thêm ít nhất một giá trị ở thanh bên.', 'starter-flexible' ) );
	}
	return;
}

?>
<section class="<?php echo esc_attr( $data->module_class ); ?>" data-reveal<?php if ( $data->anchor ) : ?> id="<?php echo esc_attr( $data->anchor ); ?>"<?php endif; ?>>
	<?php get_template_part( 'template-parts/components/block-head', null, array( 'label' => $data->label ) ); ?>
	<div class="mesh vg" data-reveal-stagger>
		<?php foreach ( $data->items as $item ) : ?>
			<article class="vg__cell">
				<span class="vg__icon"><?php echo starter_flexible_icon( $item['icon'], 40 ); // phpcs:ignore ?></span>
				<h3 class="vg__title"><?php echo esc_html( $item['title'] ); ?></h3>
				<p class="vg__desc"><?php echo esc_html( $item['desc'] ); ?></p>
				<?php if ( $item['has_link'] ) : ?>
					<a
						class="vg__link"
						href="<?php echo esc_url( $item['link_url'] ); ?>"
						<?php echo '_blank' === $item['link_target'] ? 'target="_blank" rel="noopener"' : ''; ?>
					>
						<?php echo esc_html( '' !== $item['link_label'] ? $item['link_label'] : __( 'Tìm hiểu thêm', 'starter-flexible' ) ); ?>
						<?php echo starter_flexible_icon_swap( 'arrow', 17 ); // phpcs:ignore ?>
					</a>
				<?php endif; ?>
			</article>
		<?php endforeach; ?>
	</div>
</section>
