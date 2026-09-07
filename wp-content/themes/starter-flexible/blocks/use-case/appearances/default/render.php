<?php
/**
 * Use Case — default appearance.
 *
 * @var object $data
 * @var bool   $is_preview
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( empty( $data->should_render ) ) {
	if ( $is_preview ) {
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Thêm ít nhất một tình huống khách hàng ở thanh bên.', 'starter-flexible' ) );
	}
	return;
}

?>
<section class="<?php echo esc_attr( $data->module_class ); ?>" data-reveal<?php if ( $data->anchor ) : ?> id="<?php echo esc_attr( $data->anchor ); ?>"<?php endif; ?>>
	<?php if ( $data->has_label ) : ?>
		<?php get_template_part( 'template-parts/components/block-head', null, array( 'label' => $data->label ) ); ?>
	<?php endif; ?>
	<?php if ( $data->has_heading || $data->has_intro ) : ?>
		<div class="uc__intro">
			<?php if ( $data->has_heading ) : ?>
				<h2 class="h4"><?php echo esc_html( $data->heading ); ?></h2>
			<?php endif; ?>
			<?php if ( $data->has_intro ) : ?>
				<p class="copy"><?php echo esc_html( $data->intro ); ?></p>
			<?php endif; ?>
		</div>
	<?php endif; ?>
	<div class="uc" data-reveal-stagger>
		<?php foreach ( $data->items as $item ) : ?>
			<article class="uc__case">
				<h3 class="uc__problem"><?php echo esc_html( $item['problem'] ); ?></h3>
				<?php if ( $item['has_context'] ) : ?>
					<p class="uc__context"><?php echo esc_html( $item['context'] ); ?></p>
				<?php endif; ?>
				<?php if ( $item['has_solution'] ) : ?>
					<div class="uc__solution">
						<span class="meta uc__solution-label"><?php esc_html_e( 'Hướng xử lý', 'starter-flexible' ); ?></span>
						<p><?php echo esc_html( $item['solution'] ); ?></p>
					</div>
				<?php endif; ?>
				<?php if ( $item['has_link'] ) : ?>
					<a
						class="uc__link"
						href="<?php echo esc_url( $item['link_url'] ); ?>"
						<?php echo '_blank' === $item['link_target'] ? 'target="_blank" rel="noopener"' : ''; ?>
					>
						<?php echo esc_html( '' !== $item['link_label'] ? $item['link_label'] : __( 'Xem dịch vụ liên quan', 'starter-flexible' ) ); ?>
						<?php echo starter_flexible_icon_swap( 'arrow', 17 ); // phpcs:ignore ?>
					</a>
				<?php endif; ?>
			</article>
		<?php endforeach; ?>
	</div>
</section>
