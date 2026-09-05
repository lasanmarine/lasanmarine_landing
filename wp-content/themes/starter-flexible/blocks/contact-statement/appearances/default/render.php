<?php
/**
 * Contact Statement — default appearance.
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
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Nhập lời kết và thông tin liên hệ ở thanh bên.', 'starter-flexible' ) );
	}
	return;
}

$anchor = ! empty( $block['anchor'] ) ? ' id="' . esc_attr( (string) $block['anchor'] ) . '"' : '';
?>
<section class="<?php echo esc_attr( $data->module_class ); ?>" data-reveal<?php echo $anchor; // phpcs:ignore ?>>
	<div class="band cs band--navy-mid">
		<svg viewBox="0 0 1200 400" preserveAspectRatio="none" class="cs__waves" data-wave="1" aria-hidden="true">
			<?php foreach ( $data->waves as $wave ) : ?>
				<path d="<?php echo esc_attr( $wave['d'] ); ?>" fill="none" stroke="#4DA3E8" stroke-width="<?php echo esc_attr( (string) $wave['w'] ); ?>" stroke-opacity="<?php echo esc_attr( (string) $wave['o'] ); ?>" />
			<?php endforeach; ?>
		</svg>

		<div class="container cs__inner">
			<figure class="cs__mascot">
				<img src="<?php echo esc_url( $data->mascot_url ); ?>" alt="" loading="lazy" decoding="async" />
			</figure>

			<div class="cs__body">
				<h2 class="cs__heading"><?php echo wp_kses_post( $data->heading ); ?></h2>

				<?php if ( $data->has_description ) : ?>
					<p class="cs__description"><?php echo wp_kses_post( $data->description ); ?></p>
				<?php endif; ?>

				<div class="cs__details">
					<?php if ( $data->has_phone ) : ?>
						<a href="<?php echo esc_attr( $data->phone_href ); ?>" class="cs__line">
							<?php echo starter_flexible_icon( 'phone', 20, 'cs__icon' ); // phpcs:ignore ?>
							<span><?php echo esc_html( $data->phone ); ?></span>
						</a>
					<?php endif; ?>
					<?php if ( $data->has_email ) : ?>
						<a href="mailto:<?php echo esc_attr( $data->email ); ?>" class="cs__line">
							<?php echo starter_flexible_icon( 'mail', 20, 'cs__icon' ); // phpcs:ignore ?>
							<span><?php echo esc_html( $data->email ); ?></span>
						</a>
					<?php endif; ?>
				</div>

				<?php
				if ( $data->has_cta ) {
					get_template_part(
						'template-parts/components/button',
						null,
						array(
							'href'  => $data->cta['url'],
							'label' => $data->cta['label'],
							'size'  => 'lg',
							'class' => 'cs__cta',
							'attrs' => '_blank' === $data->cta['target'] ? array( 'target' => '_blank', 'rel' => 'noopener' ) : array(),
						)
					);
				}
				?>
			</div>
		</div>
	</div>
</section>
