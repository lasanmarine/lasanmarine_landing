<?php
/**
 * Value Grid — default appearance.
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
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Thêm ít nhất một giá trị ở thanh bên.', 'starter-flexible' ) );
	}
	return;
}

$anchor = ! empty( $block['anchor'] ) ? ' id="' . esc_attr( (string) $block['anchor'] ) . '"' : '';
?>
<section class="<?php echo esc_attr( $data->module_class ); ?>" data-reveal<?php echo $anchor; // phpcs:ignore ?>>
	<?php get_template_part( 'template-parts/components/block-head', null, array( 'label' => $data->label ) ); ?>
	<div class="mesh vg" data-reveal-stagger>
		<?php foreach ( $data->items as $item ) : ?>
			<article class="vg__cell">
				<span class="vg__index"><?php echo esc_html( $item['index'] ); ?></span>
				<h3 class="vg__title"><?php echo esc_html( $item['title'] ); ?></h3>
				<p class="vg__desc"><?php echo esc_html( $item['desc'] ); ?></p>
			</article>
		<?php endforeach; ?>
	</div>
</section>
