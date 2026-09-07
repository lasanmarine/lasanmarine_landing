<?php
/**
 * Quote — default appearance.
 *
 * @var object $data
 * @var bool   $is_preview
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( empty( $data->should_render ) ) {
	if ( $is_preview ) {
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Nhập câu phát biểu và người nói ở thanh bên.', 'starter-flexible' ) );
	}
	return;
}

?>
<section class="<?php echo esc_attr( $data->module_class ); ?>" data-reveal<?php if ( $data->anchor ) : ?> id="<?php echo esc_attr( $data->anchor ); ?>"<?php endif; ?>>
	<figure class="qt">
		<blockquote class="qt__quote"><?php echo esc_html( $data->quote ); ?></blockquote>
		<?php if ( $data->has_author || $data->image_url ) : ?>
			<figcaption class="qt__by">
				<?php if ( '' !== $data->image_url ) : ?>
					<img class="qt__photo" src="<?php echo esc_url( $data->image_url ); ?>" alt="" loading="lazy" decoding="async" width="56" height="56" />
				<?php endif; ?>
				<span class="qt__who">
					<?php if ( $data->has_author ) : ?>
						<span class="qt__author"><?php echo esc_html( $data->author ); ?></span>
					<?php endif; ?>
					<?php if ( $data->has_meta ) : ?>
						<span class="qt__role"><?php echo esc_html( $data->attribution ); ?></span>
					<?php endif; ?>
				</span>
			</figcaption>
		<?php endif; ?>
	</figure>
</section>
