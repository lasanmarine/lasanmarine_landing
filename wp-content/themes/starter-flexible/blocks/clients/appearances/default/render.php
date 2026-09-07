<?php
/**
 * Clients — default appearance.
 *
 * @var object $data
 * @var bool   $is_preview
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( empty( $data->should_render ) ) {
	if ( $is_preview ) {
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Thêm tên khách hàng ở thanh bên.', 'starter-flexible' ) );
	}
	return;
}

?>
<section class="<?php echo esc_attr( $data->module_class ); ?>" data-reveal<?php if ( $data->anchor ) : ?> id="<?php echo esc_attr( $data->anchor ); ?>"<?php endif; ?>>
	<?php get_template_part( 'template-parts/components/block-head', null, array( 'label' => $data->label ) ); ?>
	<div class="cl" data-reveal-stagger style="--cl-logo-h:<?php echo esc_attr( (string) $data->logo_size ); ?>px">
		<?php foreach ( $data->items as $item ) : ?>
			<div class="cl__cell">
				<?php if ( '' !== $item['logo'] ) : ?>
					<img class="cl__logo" src="<?php echo esc_url( $item['logo'] ); ?>" alt="<?php echo esc_attr( $item['name'] ); ?>" loading="lazy" decoding="async" />
				<?php else : ?>
					<?php echo starter_flexible_icon( 'ship', 34, '', 1.4 ); // phpcs:ignore ?>
					<span class="cl__name"><?php echo esc_html( $item['name'] ); ?></span>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	</div>
</section>
