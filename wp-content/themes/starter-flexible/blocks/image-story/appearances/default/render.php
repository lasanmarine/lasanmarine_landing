<?php
/**
 * Image Story — default appearance.
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
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Thêm ảnh cho Image Story ở thanh bên.', 'starter-flexible' ) );
	}
	return;
}

$anchor = ! empty( $block['anchor'] ) ? ' id="' . esc_attr( (string) $block['anchor'] ) . '"' : '';
?>
<section class="<?php echo esc_attr( $data->module_class ); ?>" data-reveal<?php echo $anchor; // phpcs:ignore ?>>
	<?php get_template_part( 'template-parts/components/block-head', null, array( 'label' => $data->label ) ); ?>
	<div class="is__grid" data-reveal-stagger>
		<?php foreach ( $data->items as $item ) : ?>
			<figure class="is__item">
				<?php
				get_template_part(
					'template-parts/components/frame',
					null,
					array(
						'ratio'       => 'ratio-4-3',
						'class'       => 'frame--zoom',
						'src'         => $item['thumb'],
						'alt'         => $item['caption'],
						'placeholder' => $item['placeholder'],
					)
				);
				?>
				<figcaption class="is__caption"><?php echo esc_html( $item['caption'] ); ?></figcaption>
			</figure>
		<?php endforeach; ?>
	</div>
	<?php if ( $data->has_note ) : ?>
		<p class="copy is__note"><?php echo esc_html( $data->note ); ?></p>
	<?php endif; ?>
</section>
