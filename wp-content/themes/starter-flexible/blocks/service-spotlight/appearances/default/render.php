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
	<?php if ( $data->has_label ) : ?>
		<?php /* The band below is full-bleed, so the label needs its own gutter. */ ?>
		<div class="container">
			<?php get_template_part( 'template-parts/components/block-head', null, array( 'label' => $data->label ) ); ?>
		</div>
	<?php endif; ?>
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
					'placeholder' => $data->placeholder,
					'caption'     => $data->caption,
				)
			);
			?>
		</div>
		<div class="spotlight__panel band--navy-mid">
			<h3 class="h4 spotlight__heading"><?php echo esc_html( $data->heading ); ?></h3>
			<p class="copy"><?php echo esc_html( $data->body ); ?></p>
			<ul class="spotlight__items" data-reveal-stagger>
				<?php foreach ( $data->items as $item ) : ?>
					<li><?php echo esc_html( $item ); ?></li>
				<?php endforeach; ?>
			</ul>
			<?php
			if ( $data->has_cta ) {
				get_template_part(
					'template-parts/components/button',
					null,
					array(
						'href'  => $data->cta['url'],
						'label' => $data->cta['label'],
						'attrs' => '_blank' === $data->cta['target'] ? array( 'target' => '_blank', 'rel' => 'noopener' ) : array(),
					)
				);
			}
			?>
		</div>
	</div>
</section>