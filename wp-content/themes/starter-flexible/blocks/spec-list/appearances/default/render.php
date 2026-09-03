<?php
/**
 * Spec List — default appearance.
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
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Nhập tiêu đề và các dòng thông số ở thanh bên.', 'starter-flexible' ) );
	}
	return;
}

$anchor = ! empty( $block['anchor'] ) ? ' id="' . esc_attr( (string) $block['anchor'] ) . '"' : '';
?>
<section class="<?php echo esc_attr( $data->module_class ); ?>" data-reveal<?php echo $anchor; // phpcs:ignore ?>>
	<?php
	if ( $data->has_label ) {
		get_template_part( 'template-parts/components/block-head', null, array( 'label' => $data->label ) );
	}
	?>
	<div class="sl">
		<div class="sl__intro">
			<h2 class="h4"><?php echo esc_html( $data->heading ); ?></h2>
			<?php if ( $data->has_note ) : ?>
				<p class="sl__note"><?php echo esc_html( $data->note ); ?></p>
			<?php endif; ?>
		</div>
		<div data-reveal-stagger>
			<?php foreach ( $data->rows as $row ) : ?>
				<div class="spec">
					<span class="spec__label"><?php echo esc_html( $row['label'] ); ?></span>
					<span class="spec__leader"></span>
					<span class="spec__value"><?php echo esc_html( $row['value'] ); ?></span>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
