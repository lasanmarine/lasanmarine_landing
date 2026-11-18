<?php
/**
 * Service Spotlight — default appearance.
 *
 * @var object $data
 * @var bool   $is_preview
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( empty( $data->should_render ) ) {
	if ( $is_preview ) {
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Nhập nội dung Service Spotlight ở thanh bên.', 'starter-flexible' ) );
	}
	return;
}

?>
<section class="<?php echo esc_attr( $data->module_class ); ?>" data-reveal<?php if ( $data->anchor ) : ?> id="<?php echo esc_attr( $data->anchor ); ?>"<?php endif; ?>>
	<div class="band spotlight">
		<div class="spotlight__media">
			<?php
			get_template_part(
				'template-parts/components/frame',
				null,
				array(
					'ratio'       => '',
					'class'       => 'frame--zoom',
					'src'         => $data->image_url,
					'alt'         => $data->heading,
					'placeholder' => $data->placeholder,
					'caption'     => $data->caption,
				)
			);
			?>
			<?php if ( '' !== trim( (string) $data->caption ) ) : ?>
				<p class="spotlight__caption"><?php echo esc_html( $data->caption ); ?></p>
			<?php endif; ?>
			<?php if ( '' !== trim( (string) $data->label ) ) : ?>
				<p class="spotlight__label"><?php echo esc_html( $data->label ); ?></p>
			<?php endif; ?>
		</div>
		<div class="spotlight__panel band--navy-mid" data-reveal-stagger="<?php echo esc_attr( ':scope > :not(ul), .spotlight__items > li' ); ?>">
			<h3 class="h4 spotlight__heading"><?php echo esc_html( $data->heading ); ?></h3>
			<?php if ( '' !== trim( (string) $data->body ) ) : ?>
				<p class="copy"><?php echo esc_html( $data->body ); ?></p>
			<?php endif; ?>
			<ul class="spotlight__items">
				<?php foreach ( $data->items as $item ) : ?>
					<li><?php echo esc_html( $item ); ?></li>
				<?php endforeach; ?>
			</ul>
			<?php
			if ( $data->has_cta ) {
				// Wrapped: the wrapper makes the entrance, so the button's own
				// hover and press transforms stay its own.
				echo '<div class="spotlight__cta">';
				get_template_part(
					'template-parts/components/button',
					null,
					array(
						'href'  => $data->cta['url'],
						'label' => $data->cta['label'],
						'attrs' => '_blank' === $data->cta['target'] ? array( 'target' => '_blank', 'rel' => 'noopener' ) : array(),
					)
				);
				echo '</div>';
			}
			?>
		</div>
	</div>
</section>