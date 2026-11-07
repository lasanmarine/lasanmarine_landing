<?php
/**
 * Vessel Finder — default appearance.
 *
 * @var object $data
 * @var bool   $is_preview
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( empty( $data->should_render ) ) {
	if ( $is_preview ) {
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Thêm ít nhất một loại tàu ở thanh bên.', 'starter-flexible' ) );
	}
	return;
}

?>
<section class="<?php echo esc_attr( $data->module_class ); ?>" data-reveal<?php if ( $data->anchor ) : ?> id="<?php echo esc_attr( $data->anchor ); ?>"<?php endif; ?>>
	<?php if ( '' !== trim( (string) $data->heading ) || '' !== trim( (string) $data->intro ) ) : ?>
		<header class="vf__head">
			<?php if ( '' !== trim( (string) $data->heading ) ) : ?>
				<h2 class="h3 vf__heading"><?php echo esc_html( $data->heading ); ?></h2>
			<?php endif; ?>
			<?php if ( '' !== trim( (string) $data->intro ) ) : ?>
				<p class="copy vf__intro"><?php echo esc_html( $data->intro ); ?></p>
			<?php endif; ?>
		</header>
	<?php endif; ?>

	<div class="vf" data-reveal-stagger>
		<?php foreach ( $data->items as $i => $item ) : ?>
			<?php
			$is_link = '' !== $item['url'];
			$classes = 'vf__card' . ( 0 === $i ? ' vf__card--lead' : '' ) . ( $item['image_id'] ? ' vf__card--photo' : '' );
			?>
			<?php if ( $is_link ) : ?>
				<a class="<?php echo esc_attr( $classes ); ?>" href="<?php echo esc_url( $item['url'] ); ?>"<?php echo '_blank' === $item['target'] ? ' target="_blank" rel="noopener"' : ''; ?>>
			<?php else : ?>
				<div class="<?php echo esc_attr( $classes ); ?>">
			<?php endif; ?>
				<span class="vf__media">
					<?php if ( $item['image_id'] ) : ?>
						<?php echo wp_get_attachment_image( $item['image_id'], 'large', false, array( 'loading' => 'lazy', 'decoding' => 'async', 'sizes' => 0 === $i ? '(max-width: 760px) 100vw, 50vw' : '(max-width: 760px) 50vw, 25vw' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<?php else : ?>
						<span class="vf__icon"><?php echo starter_flexible_icon( $item['icon'], 28 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<?php endif; ?>
				</span>
				<span class="vf__body">
					<span class="vf__title"><?php echo esc_html( $item['title'] ); ?></span>
					<?php if ( '' !== trim( $item['desc'] ) ) : ?>
						<span class="vf__desc"><?php echo esc_html( $item['desc'] ); ?></span>
					<?php endif; ?>
				</span>
				<?php if ( $is_link ) : ?>
					<span class="vf__go" aria-hidden="true"><?php echo starter_flexible_icon_swap( 'arrowUpRight', 18 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
				</a>
			<?php else : ?>
				</div>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
</section>
