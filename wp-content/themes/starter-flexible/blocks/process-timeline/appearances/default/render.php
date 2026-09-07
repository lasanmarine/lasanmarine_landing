<?php
/**
 * Process Timeline — default appearance.
 *
 * @var object $data
 * @var bool   $is_preview
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( empty( $data->should_render ) ) {
	if ( $is_preview ) {
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Thêm các bước quy trình ở thanh bên.', 'starter-flexible' ) );
	}
	return;
}

?>
<section class="<?php echo esc_attr( $data->module_class ); ?>" data-reveal<?php if ( $data->anchor ) : ?> id="<?php echo esc_attr( $data->anchor ); ?>"<?php endif; ?>>
	<?php get_template_part( 'template-parts/components/block-head', null, array( 'label' => $data->label ) ); ?>
	<div class="pt" data-timeline>
		<span class="pt__rail"></span>
		<span class="pt__fill" data-timeline-fill></span>
		<div class="pt__steps" data-reveal-stagger>
			<?php foreach ( $data->steps as $step ) : ?>
				<div class="pt__step">
					<span class="pt__dot"></span>
					<div class="pt__index"><?php echo esc_html( $step['index'] ); ?></div>
					<div class="pt__title"><?php echo esc_html( $step['title'] ); ?></div>
					<div class="pt__desc"><?php echo esc_html( $step['desc'] ); ?></div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
