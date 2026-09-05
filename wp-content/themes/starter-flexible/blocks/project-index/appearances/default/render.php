<?php
/**
 * Project Index — default appearance.
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
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Chưa có dự án nào trong post type Dự án.', 'starter-flexible' ) );
	}
	return;
}

$anchor = ! empty( $block['anchor'] ) ? ' id="' . esc_attr( (string) $block['anchor'] ) . '"' : '';
?>
<section class="<?php echo esc_attr( $data->module_class ); ?>" data-reveal data-project-index<?php echo $anchor; // phpcs:ignore ?>>
	<?php if ( $data->has_label ) : ?>
		<?php get_template_part( 'template-parts/components/block-head', null, array( 'label' => $data->label ) ); ?>
	<?php endif; ?>

	<?php if ( $data->filters ) : ?>
		<div class="pi__filters" role="group" aria-label="<?php esc_attr_e( 'Lọc dự án', 'starter-flexible' ); ?>">
			<button type="button" class="pi__filter" data-pi-filter="" aria-pressed="true"><?php echo esc_html( $data->all_label ); ?></button>
			<?php foreach ( $data->filters as $filter ) : ?>
				<button type="button" class="pi__filter" data-pi-filter="<?php echo esc_attr( $filter['slug'] ); ?>" aria-pressed="false">
					<?php echo esc_html( $filter['name'] ); ?>
				</button>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<div class="pi__grid" data-reveal-stagger>
		<?php foreach ( $data->items as $item ) : ?>
			<?php get_template_part( 'template-parts/components/project-card', null, array( 'item' => $item, 'filter_key' => $data->filter_key ) ); ?>
		<?php endforeach; ?>
	</div>

	<p class="pi__empty" data-pi-empty hidden><?php echo esc_html( $data->empty_text ); ?></p>
</section>
