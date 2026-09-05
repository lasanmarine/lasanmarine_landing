<?php
/**
 * Service Architecture — default appearance.
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
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Thêm ít nhất một dịch vụ ở thanh bên.', 'starter-flexible' ) );
	}
	return;
}

$anchor = ! empty( $block['anchor'] ) ? ' id="' . esc_attr( (string) $block['anchor'] ) . '"' : '';
?>
<section class="<?php echo esc_attr( $data->module_class ); ?>" data-reveal<?php echo $anchor; // phpcs:ignore ?>>
	<?php
	if ( '' !== trim( (string) $data->label ) ) {
		get_template_part( 'template-parts/components/block-head', null, array( 'label' => $data->label ) );
	}
	?>
	<div class="sa__head">
		<h2 class="h3"><?php echo esc_html( $data->heading ); ?></h2>
		<?php if ( $data->has_view_all ) : ?>
			<a href="<?php echo esc_url( $data->view_all_url ); ?>" class="link link--fixed link--lg">
				<?php echo esc_html( $data->view_all ); ?> <?php echo starter_flexible_icon( 'arrow' ); // phpcs:ignore ?>
			</a>
		<?php endif; ?>
	</div>

	<div class="sa" data-service-arch>
		<div class="sa__list" data-reveal-stagger>
			<?php foreach ( $data->items as $i => $item ) : ?>
				<a
					href="<?php echo esc_url( $item['url'] ); ?>"
					class="sa__row"
					data-service-row
					data-i="<?php echo esc_attr( (string) $i ); ?>"
					<?php echo '_blank' === $item['target'] ? 'target="_blank" rel="noopener"' : ''; ?>
				>
					<span>
						<span class="sa__name"><?php echo esc_html( $item['name'] ); ?></span>
						<span class="sa__desc"><?php echo esc_html( $item['desc'] ); ?></span>
						<?php if ( ! empty( $item['children'] ) ) : ?>
							<span class="sa__children">
								<?php foreach ( $item['children'] as $child ) : ?>
									<span><?php echo esc_html( $child ); ?></span>
								<?php endforeach; ?>
							</span>
						<?php endif; ?>
					</span>
					<span class="sa__arrow">
						<?php echo starter_flexible_icon( 'arrow', 30 ); // phpcs:ignore ?>
					</span>
				</a>
			<?php endforeach; ?>
		</div>

		<div class="sa__figure">
			<?php foreach ( $data->items as $i => $item ) : ?>
				<div class="sa__slide" data-service-slide data-i="<?php echo esc_attr( (string) $i ); ?>" data-active="<?php echo 0 === $i ? 'true' : 'false'; ?>">
					<?php
					get_template_part(
						'template-parts/components/frame',
						null,
						array(
							'ratio'       => 'ratio-3-2',
							'src'         => $item['image_url'],
							'placeholder' => $item['name'],
						)
					);
					?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
