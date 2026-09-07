<?php
/**
 * Section Intro — default appearance.
 *
 * @var object $data
 * @var bool   $is_preview
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( empty( $data->should_render ) ) {
	if ( $is_preview ) {
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Nhập tiêu đề và đoạn mở của section ở thanh bên.', 'starter-flexible' ) );
	}
	return;
}

?>
<section class="<?php echo esc_attr( $data->module_class ); ?>" data-reveal<?php if ( $data->anchor ) : ?> id="<?php echo esc_attr( $data->anchor ); ?>"<?php endif; ?>>
	<div class="si <?php echo esc_attr( $data->width_class ); ?>">
		<?php if ( $data->has_label ) : ?>
			<p class="meta si__label"><?php echo esc_html( $data->label ); ?></p>
		<?php endif; ?>
		<h2 class="h3 si__heading"><?php echo esc_html( $data->heading ); ?></h2>
		<?php if ( $data->has_content ) : ?>
			<div class="prose si__body"><?php echo wp_kses_post( $data->content ); ?></div>
		<?php endif; ?>
		<?php
		if ( $data->has_cta ) {
			get_template_part(
				'template-parts/components/button',
				null,
				array(
					'href'  => $data->cta['url'],
					'label' => $data->cta['label'],
					'class' => 'si__cta',
					'attrs' => '_blank' === $data->cta['target'] ? array( 'target' => '_blank', 'rel' => 'noopener' ) : array(),
				)
			);
		}
		?>
	</div>
</section>
