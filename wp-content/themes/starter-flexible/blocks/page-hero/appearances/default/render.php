<?php
/**
 * Page Hero — default appearance.
 *
 * @var object $data
 * @var bool   $is_preview
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( empty( $data->should_render ) ) {
	if ( $is_preview ) {
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Nhập tiêu đề cho Page Hero ở thanh bên.', 'starter-flexible' ) );
	}
	return;
}

?>
<section class="<?php echo esc_attr( $data->module_class ); ?>" style="--phero-h:<?php echo esc_attr( (string) $data->height ); ?>px"<?php if ( $data->anchor ) : ?> id="<?php echo esc_attr( $data->anchor ); ?>"<?php endif; ?>>
	<?php if ( $data->has_media ) : ?>
		<div class="phero__media">
			<?php if ( '' !== $data->image_url ) : ?>
				<img src="<?php echo esc_url( $data->image_url ); ?>" alt="" decoding="async" />
			<?php else : ?>
				<span class="frame__placeholder"><?php echo esc_html( $data->placeholder ); ?></span>
			<?php endif; ?>
		</div>
	<?php endif; ?>
	<span class="phero__scrim"></span>
	<div class="container phero__body">
		<div data-enter style="--enter-i:0">
			<<?php echo esc_attr( $data->heading_level ); ?> class="phero__headline"><?php echo esc_html( $data->headline ); ?></<?php echo esc_attr( $data->heading_level ); ?>>
		</div>
		<?php if ( $data->has_lead ) : ?>
			<p class="copy phero__lead" data-enter style="--enter-i:1"><?php echo esc_html( $data->lead ); ?></p>
		<?php endif; ?>
	</div>
	<?php get_template_part( 'template-parts/components/wave' ); ?>
</section>
