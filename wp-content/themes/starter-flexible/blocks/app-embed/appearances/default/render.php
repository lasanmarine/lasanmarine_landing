<?php
/**
 * App Embed — default appearance.
 *
 * @var object $data
 * @var bool   $is_preview
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( empty( $data->should_render ) ) {
	if ( $is_preview ) {
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Chọn ứng dụng ở thanh bên.', 'starter-flexible' ) );
	}
	return;
}

?>
<section class="<?php echo esc_attr( $data->module_class ); ?>"<?php if ( $data->anchor ) : ?> id="<?php echo esc_attr( $data->anchor ); ?>"<?php endif; ?>>
	<div class="ae">
		<iframe
			class="ae__frame"
			src="<?php echo esc_url( $data->src ); ?>"
			title="<?php echo esc_attr( $data->frame_title ); ?>"
			loading="lazy"
			allow="fullscreen; clipboard-write"
		></iframe>
		<a class="link ae__open" href="<?php echo esc_url( $data->src ); ?>" target="_blank" rel="noopener">
			<?php esc_html_e( 'Mở toàn màn hình', 'starter-flexible' ); ?>
			<?php echo starter_flexible_icon_swap( 'arrowUpRight', 18 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</a>
	</div>
</section>
