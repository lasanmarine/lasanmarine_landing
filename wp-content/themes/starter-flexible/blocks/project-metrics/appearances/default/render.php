<?php
/**
 * Project Metrics — default appearance.
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
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Thêm dữ kiện hoặc kết quả ở thanh bên.', 'starter-flexible' ) );
	}
	return;
}

$anchor = ! empty( $block['anchor'] ) ? ' id="' . esc_attr( (string) $block['anchor'] ) . '"' : '';
?>
<section class="<?php echo esc_attr( $data->module_class ); ?>" data-reveal<?php echo $anchor; // phpcs:ignore ?>>
	<?php get_template_part( 'template-parts/components/block-head', null, array( 'label' => $data->label ) ); ?>
	<div class="pm__facts" data-reveal-stagger>
		<?php foreach ( $data->rows as $row ) : ?>
			<div>
				<div class="meta"><?php echo esc_html( $row['label'] ); ?></div>
				<div class="pm__value"><?php echo esc_html( $row['value'] ); ?></div>
			</div>
		<?php endforeach; ?>
	</div>
	<div class="pm__stats" data-reveal-stagger>
		<?php foreach ( $data->stats as $stat ) : ?>
			<div class="stat pm__stat">
				<div class="stat__value">
					<?php echo esc_html( $stat['value'] ); ?>
					<span><?php echo esc_html( $stat['suffix'] ); ?></span>
				</div>
				<div class="pm__note"><?php echo esc_html( $stat['note'] ); ?></div>
			</div>
		<?php endforeach; ?>
	</div>
</section>
