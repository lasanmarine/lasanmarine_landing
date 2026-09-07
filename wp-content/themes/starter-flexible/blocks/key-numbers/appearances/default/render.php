<?php
/**
 * Key Numbers — default appearance.
 *
 * @var object $data
 * @var bool   $is_preview
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( empty( $data->should_render ) ) {
	if ( $is_preview ) {
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Thêm ít nhất một số liệu ở thanh bên.', 'starter-flexible' ) );
	}
	return;
}

?>
<section class="<?php echo esc_attr( $data->module_class ); ?>" data-reveal<?php if ( $data->anchor ) : ?> id="<?php echo esc_attr( $data->anchor ); ?>"<?php endif; ?>>
	<div class="band band--pale">
		<?php if ( $data->has_label ) : ?>
			<div class="container">
				<?php get_template_part( 'template-parts/components/block-head', null, array( 'label' => $data->label ) ); ?>
			</div>
		<?php endif; ?>
		<div class="container stats" data-reveal-stagger>
			<?php foreach ( $data->stats as $stat ) : ?>
				<div class="stat">
					<div class="stat__value">
						<?php echo esc_html( $stat['value'] ); ?>
						<span><?php echo esc_html( $stat['suffix'] ); ?></span>
					</div>
					<div class="stat__label"><?php echo esc_html( $stat['label'] ); ?></div>
					<div class="stat__note"><?php echo esc_html( $stat['note'] ); ?></div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
