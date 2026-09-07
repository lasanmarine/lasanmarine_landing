<?php
/**
 * Contact Statement — default appearance.
 *
 * @var object $data
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

?>
<section class="<?php echo esc_attr( $data->module_class ); ?>" data-reveal<?php if ( $data->anchor ) : ?> id="<?php echo esc_attr( $data->anchor ); ?>"<?php endif; ?>>
	<div class="band cs band--navy-mid">
		<svg viewBox="0 0 1200 400" preserveAspectRatio="none" class="cs__waves" data-wave="1" aria-hidden="true">
			<?php foreach ( $data->waves as $wave ) : ?>
				<path d="<?php echo esc_attr( $wave['d'] ); ?>" fill="none" stroke="#4DA3E8" stroke-width="<?php echo esc_attr( (string) $wave['w'] ); ?>" stroke-opacity="<?php echo esc_attr( (string) $wave['o'] ); ?>" />
			<?php endforeach; ?>
		</svg>

		<div class="container cs__layout<?php echo $data->has_contact ? '' : ' cs__layout--solo'; ?>">
			<div class="cs__inner<?php echo $data->has_mascot ? '' : ' cs__inner--solo'; ?>">
				<?php if ( $data->has_mascot ) : ?>
					<figure class="cs__mascot">
						<img src="<?php echo esc_url( $data->mascot_url ); ?>" alt="" loading="lazy" decoding="async" />
					</figure>
				<?php endif; ?>

				<div class="cs__body">
					<h2 class="cs__heading"><?php echo wp_kses_post( $data->heading ); ?></h2>

					<?php if ( $data->has_description ) : ?>
						<p class="cs__description"><?php echo wp_kses_post( $data->description ); ?></p>
					<?php endif; ?>

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

			<?php if ( $data->has_contact ) : ?>
				<div class="cs__contact" data-reveal-stagger>
					<?php foreach ( $data->contacts as $contact ) : ?>
						<div class="spec">
							<span class="spec__label"><?php echo esc_html( $contact['label'] ); ?></span>
							<span class="spec__leader"></span>
							<a class="spec__value" href="<?php echo esc_attr( $contact['href'] ); ?>"><?php echo esc_html( $contact['value'] ); ?></a>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
