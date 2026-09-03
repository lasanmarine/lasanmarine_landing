<?php
/**
 * Project Grid — default appearance.
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
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Thêm dự án ở thanh bên.', 'starter-flexible' ) );
	}
	return;
}

$anchor = ! empty( $block['anchor'] ) ? ' id="' . esc_attr( (string) $block['anchor'] ) . '"' : '';
?>
<section class="<?php echo esc_attr( $data->module_class ); ?>" data-reveal<?php echo $anchor; // phpcs:ignore ?>>
	<?php get_template_part( 'template-parts/components/block-head', null, array( 'label' => $data->label ) ); ?>
	<div class="grid grid--12 pg" data-reveal-stagger>
		<?php foreach ( $data->items as $item ) : ?>
			<a
				href="<?php echo esc_url( $item['url'] ); ?>"
				class="pg__item"
				style="grid-column:span <?php echo esc_attr( (string) $item['span'] ); ?>"
				<?php echo '_blank' === $item['target'] ? 'target="_blank" rel="noopener"' : ''; ?>
			>
				<?php
				get_template_part(
					'template-parts/components/frame',
					null,
					array(
						'ratio'       => 'ratio-16-9',
						'src'         => $item['image_url'],
						'alt'         => $item['name'],
						'placeholder' => $item['name'],
					)
				);
				?>
				<div class="pg__text">
					<span class="pg__tag"><?php echo esc_html( $item['tag'] ); ?></span>
					<span class="pg__name"><?php echo esc_html( $item['name'] ); ?></span>
					<span class="pg__meta"><?php echo esc_html( $item['meta'] ); ?></span>
				</div>
			</a>
		<?php endforeach; ?>
	</div>
</section>
