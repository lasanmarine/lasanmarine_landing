<?php
/**
 * Image + Text — default appearance.
 *
 * @var object $data
 * @var bool   $is_preview
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( empty( $data->should_render ) ) {
	if ( $is_preview ) {
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Chọn ảnh và nhập nội dung ở thanh bên.', 'starter-flexible' ) );
	}
	return;
}

?>
<section class="<?php echo esc_attr( $data->module_class ); ?>" data-reveal<?php if ( $data->anchor ) : ?> id="<?php echo esc_attr( $data->anchor ); ?>"<?php endif; ?>>
	<?php if ( $data->has_label ) : ?>
		<?php get_template_part( 'template-parts/components/block-head', null, array( 'label' => $data->label ) ); ?>
	<?php endif; ?>
	<div class="<?php echo esc_attr( $data->grid_class ); ?>">
		<div class="it__media">
			<?php
			get_template_part(
				'template-parts/components/frame',
				null,
				array(
					'ratio'            => $data->ratio,
					'class'            => 'frame--zoom',
					'src'              => $data->image_url,
					'alt'              => $data->image_alt,
					'placeholder'      => $data->placeholder,
					'caption'          => $data->caption,
					'caption_position' => 'tr',
				)
			);
			?>
		</div>
		<div class="it__body">
			<?php if ( $data->has_heading ) : ?>
				<h2 class="h4 it__heading"><?php echo esc_html( $data->heading ); ?></h2>
			<?php endif; ?>
			<?php if ( $data->has_content ) : ?>
				<div class="prose"><?php echo wp_kses_post( $data->content ); ?></div>
			<?php endif; ?>
			<?php
			if ( $data->has_cta ) {
				get_template_part(
					'template-parts/components/button',
					null,
					array(
						'href'    => $data->cta['url'],
						'label'   => $data->cta['label'],
						'variant' => 'secondary',
						'class'   => 'it__cta',
						'attrs'   => '_blank' === $data->cta['target'] ? array( 'target' => '_blank', 'rel' => 'noopener' ) : array(),
					)
				);
			}
			?>
		</div>
	</div>
</section>
