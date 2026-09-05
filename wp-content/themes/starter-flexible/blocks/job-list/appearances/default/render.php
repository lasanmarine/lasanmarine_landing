<?php
/**
 * Job List — default appearance.
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
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Thêm vị trí tuyển dụng ở thanh bên.', 'starter-flexible' ) );
	}
	return;
}

$anchor = ! empty( $block['anchor'] ) ? ' id="' . esc_attr( (string) $block['anchor'] ) . '"' : '';
?>
<section class="<?php echo esc_attr( $data->module_class ); ?>" data-reveal<?php echo $anchor; // phpcs:ignore ?>>
	<?php get_template_part( 'template-parts/components/block-head', null, array( 'label' => $data->label ) ); ?>
	<div class="jl" data-reveal-stagger>
		<?php foreach ( $data->items as $job ) : ?>
			<a class="jl__row" href="<?php echo esc_url( $data->apply_href ); ?>">
				<span class="jl__role"><?php echo esc_html( $job['role'] ); ?></span>
				<span class="jl__location"><?php echo esc_html( $job['location'] ); ?></span>
				<span class="tag"><?php echo esc_html( $job['type'] ); ?></span>
				<span class="jl__arrow">
					<?php echo starter_flexible_icon_swap( 'arrow', 20 ); // phpcs:ignore ?>
				</span>
			</a>
		<?php endforeach; ?>
	</div>
</section>
