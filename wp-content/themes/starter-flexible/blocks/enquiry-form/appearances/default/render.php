<?php
/**
 * Enquiry Form — default appearance. Renders the chosen Contact Form 7 form.
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
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Chọn form Contact Form 7 ở thanh bên.', 'starter-flexible' ) );
	}
	return;
}

$anchor = ! empty( $block['anchor'] ) ? (string) $block['anchor'] : 'apply';
?>
<section id="<?php echo esc_attr( $anchor ); ?>" class="<?php echo esc_attr( $data->module_class ); ?>" data-reveal>
	<div class="ef">
		<?php if ( '' !== $data->heading || $data->has_note ) : ?>
			<div class="ef__intro">
				<?php if ( '' !== $data->heading ) : ?>
					<h2 class="h4"><?php echo esc_html( $data->heading ); ?></h2>
				<?php endif; ?>
				<?php if ( $data->has_note ) : ?>
					<p class="copy ef__note"><?php echo esc_html( $data->note ); ?></p>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<div class="ef__form">
			<?php
			if ( $data->cf7_id > 0 ) {
				echo do_shortcode( sprintf( '[contact-form-7 id="%d"]', (int) $data->cf7_id ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			} elseif ( $is_preview ) {
				printf( '<p class="ef__hint">%s</p>', esc_html__( 'Chưa chọn form Contact Form 7.', 'starter-flexible' ) );
			}
			?>
		</div>
	</div>
</section>
