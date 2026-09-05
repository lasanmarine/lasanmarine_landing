<?php
/**
 * Project Showcase — default appearance.
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
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Thêm dự án cho Showcase ở thanh bên.', 'starter-flexible' ) );
	}
	return;
}

$anchor = ! empty( $block['anchor'] ) ? ' id="' . esc_attr( (string) $block['anchor'] ) . '"' : '';
$first  = $data->first;
?>
<section class="<?php echo esc_attr( $data->module_class ); ?>" data-reveal<?php echo $anchor; // phpcs:ignore ?>>
	<div class="band band--navy ps" data-showcase>
		<div class="container">
			<div class="ps__bar">
				<?php get_template_part( 'template-parts/components/block-head', null, array( 'label' => $data->label ) ); ?>
				<div class="ps__nav">
					<span class="meta" data-ps-counter><?php echo esc_html( $data->count_label ); ?></span>
					<button type="button" class="icon-btn" data-ps-prev aria-label="<?php esc_attr_e( 'Trước', 'starter-flexible' ); ?>">
						<?php echo starter_flexible_icon( 'chevronLeft', 20 ); // phpcs:ignore ?>
					</button>
					<button type="button" class="icon-btn" data-ps-next aria-label="<?php esc_attr_e( 'Sau', 'starter-flexible' ); ?>">
						<?php echo starter_flexible_icon( 'chevronRight', 20 ); // phpcs:ignore ?>
					</button>
				</div>
			</div>

			<div class="ps__stage ratio-21-9">
				<?php foreach ( $data->items as $i => $item ) : ?>
					<div class="ps__slide" data-ps-slide data-active="<?php echo 0 === $i ? 'true' : 'false'; ?>">
						<?php
						get_template_part(
							'template-parts/components/frame',
							null,
							array(
								'ratio'       => '',
								'src'         => $item['image_url'],
								'alt'         => $item['name'],
								'placeholder' => $item['placeholder'],
							)
						);
						?>
					</div>
				<?php endforeach; ?>
				<span class="ps__scrim"></span>
				<div class="ps__caption">
					<h3 class="ps__name" data-ps-name><?php echo esc_html( $first['name'] ); ?></h3>
					<div class="ps__meta">
						<span data-ps-location><?php echo esc_html( $first['location'] ); ?></span>
						<span data-ps-year><?php echo esc_html( $first['year'] ); ?></span>
						<span data-ps-service><?php echo esc_html( $first['service'] ); ?></span>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script type="application/json" data-ps-data><?php echo wp_json_encode( $data->items ); ?></script>
</section>
