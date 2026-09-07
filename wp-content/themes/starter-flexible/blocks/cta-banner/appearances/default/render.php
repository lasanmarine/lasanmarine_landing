<?php
/**
 * CTA Banner — default appearance.
 *
 * @var object $data
 * @var bool   $is_preview
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( empty( $data->should_render ) ) {
	if ( $is_preview ) {
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Nhập lời kêu gọi và ít nhất một nút ở thanh bên.', 'starter-flexible' ) );
	}
	return;
}

?>
<section class="<?php echo esc_attr( $data->module_class ); ?>" data-reveal<?php if ( $data->anchor ) : ?> id="<?php echo esc_attr( $data->anchor ); ?>"<?php endif; ?>>
	<div class="band cb cb--<?php echo esc_attr( $data->theme ); ?> <?php echo esc_attr( $data->band_class ); ?>">
		<div class="container cb__inner">
			<div class="cb__body">
				<?php if ( $data->has_label ) : ?>
					<p class="meta cb__label"><?php echo esc_html( $data->label ); ?></p>
				<?php endif; ?>
				<h2 class="cb__heading"><?php echo esc_html( $data->heading ); ?></h2>
				<?php if ( $data->has_content ) : ?>
					<p class="copy cb__content"><?php echo esc_html( $data->content ); ?></p>
				<?php endif; ?>
			</div>
			<?php if ( $data->has_actions ) : ?>
				<div class="cb__actions">
					<?php
					if ( $data->primary_cta['has'] ) {
						get_template_part(
							'template-parts/components/button',
							null,
							array(
								'href'  => $data->primary_cta['url'],
								'label' => $data->primary_cta['label'],
								'size'  => 'lg',
								'attrs' => '_blank' === $data->primary_cta['target'] ? array( 'target' => '_blank', 'rel' => 'noopener' ) : array(),
							)
						);
					}
					if ( $data->secondary_cta['has'] ) {
						get_template_part(
							'template-parts/components/button',
							null,
							array(
								'href'    => $data->secondary_cta['url'],
								'label'   => $data->secondary_cta['label'],
								'size'    => 'lg',
								'variant' => 'secondary',
								'attrs'   => '_blank' === $data->secondary_cta['target'] ? array( 'target' => '_blank', 'rel' => 'noopener' ) : array(),
							)
						);
					}
					?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
