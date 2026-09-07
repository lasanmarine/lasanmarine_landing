<?php
/**
 * Rich Text — default appearance.
 *
 * @var object $data
 * @var bool   $is_preview
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( empty( $data->should_render ) ) {
	if ( $is_preview ) {
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Nhập nội dung biên tập ở thanh bên.', 'starter-flexible' ) );
	}
	return;
}

?>
<section class="<?php echo esc_attr( $data->module_class ); ?>" data-reveal<?php if ( $data->anchor ) : ?> id="<?php echo esc_attr( $data->anchor ); ?>"<?php endif; ?>>
	<?php if ( $data->has_label ) : ?>
		<?php get_template_part( 'template-parts/components/block-head', null, array( 'label' => $data->label ) ); ?>
	<?php endif; ?>
	<div class="<?php echo esc_attr( $data->column_class ); ?>">
		<?php if ( $data->has_heading ) : ?>
			<h2 class="h4 rt__heading"><?php echo esc_html( $data->heading ); ?></h2>
		<?php endif; ?>
		<?php if ( $data->has_content ) : ?>
			<div class="prose rt__body"><?php echo wp_kses_post( $data->content ); ?></div>
		<?php endif; ?>
	</div>
</section>
