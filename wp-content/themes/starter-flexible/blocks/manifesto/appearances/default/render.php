<?php
/**
 * Manifesto — default appearance.
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
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Nhập nội dung Manifesto ở thanh bên.', 'starter-flexible' ) );
	}
	return;
}

$anchor = ! empty( $block['anchor'] ) ? ' id="' . esc_attr( (string) $block['anchor'] ) . '"' : '';
?>
<section class="<?php echo esc_attr( $data->module_class ); ?>" data-reveal<?php echo $anchor; // phpcs:ignore ?>>
	<div class="grid grid--auto manifesto">
		<h2 class="h3"><?php echo esc_html( $data->heading ); ?></h2>
		<div class="manifesto__body">
			<?php if ( $data->has_lead ) : ?>
				<p class="lead"><?php echo esc_html( $data->lead ); ?></p>
			<?php endif; ?>
			<?php foreach ( $data->body as $paragraph ) : ?>
				<p class="copy"><?php echo esc_html( $paragraph ); ?></p>
			<?php endforeach; ?>
			<?php
			if ( $data->has_cta ) {
				get_template_part(
					'template-parts/components/button',
					null,
					array(
						'href'  => $data->cta['url'],
						'label' => $data->cta['label'],
						'size'  => 'lg',
						'attrs' => '_blank' === $data->cta['target'] ? array( 'target' => '_blank', 'rel' => 'noopener' ) : array(),
					)
				);
			}
			?>
		</div>
	</div>
</section>
