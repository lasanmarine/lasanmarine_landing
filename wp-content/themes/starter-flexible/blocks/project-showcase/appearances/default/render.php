<?php
/**
 * Project Showcase — default appearance.
 *
 * A slider on white: one project per view, photograph beside its spec lines,
 * each slide carrying its own way into the full record.
 *
 * @var object $data
 * @var bool   $is_preview
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( empty( $data->should_render ) ) {
	if ( $is_preview ) {
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Tích chọn dự án cho Showcase ở thanh bên.', 'starter-flexible' ) );
	}
	return;
}


?>
<section class="<?php echo esc_attr( $data->module_class ); ?>" data-reveal<?php if ( $data->anchor ) : ?> id="<?php echo esc_attr( $data->anchor ); ?>"<?php endif; ?>>
	<div class="container ps" data-showcase>
		<div class="ps__bar">
			<?php get_template_part( 'template-parts/components/block-head', null, array( 'label' => $data->label ) ); ?>
			<?php if ( $data->has_navigation ) : ?>
				<div class="ps__nav">
					<span class="meta" data-ps-counter><?php echo esc_html( $data->count_label ); ?></span>
					<button type="button" class="icon-btn icon-btn--sm" data-ps-prev aria-label="<?php esc_attr_e( 'Dự án trước', 'starter-flexible' ); ?>">
						<?php echo starter_flexible_icon( 'chevronLeft', 20 ); // phpcs:ignore ?>
					</button>
					<button type="button" class="icon-btn icon-btn--sm" data-ps-next aria-label="<?php esc_attr_e( 'Dự án sau', 'starter-flexible' ); ?>">
						<?php echo starter_flexible_icon( 'chevronRight', 20 ); // phpcs:ignore ?>
					</button>
				</div>
			<?php endif; ?>
		</div>

		<div class="ps__viewport">
			<div class="ps__track" data-ps-track>
				<?php foreach ( $data->items as $i => $item ) : ?>
					<article class="ps__slide" data-ps-slide aria-hidden="<?php echo 0 === $i ? 'false' : 'true'; ?>">
						<div class="ps__media">
							<?php
							get_template_part(
								'template-parts/components/frame',
								null,
								array(
									'ratio'       => 'ratio-4-3',
									'class'       => 'frame--zoom',
									'src'         => $item['image_url'],
									'alt'         => $item['name'],
									'placeholder' => $item['placeholder'],
								)
							);
							?>
						</div>

						<div class="ps__body">
							<h3 class="ps__name"><?php echo esc_html( $item['name'] ); ?></h3>

							<dl class="ps__specs">
								<?php
								foreach ( $item['specs'] as $label => $value ) :
									?>
									<div>
										<dt><?php echo esc_html( $label ); ?></dt>
										<dd><?php echo esc_html( $value ); ?></dd>
									</div>
								<?php endforeach; ?>
							</dl>

							<?php if ( '' !== (string) $item['url'] ) : ?>
								<a class="btn ps__cta" href="<?php echo esc_url( (string) $item['url'] ); ?>">
									<?php esc_html_e( 'Xem chi tiết', 'starter-flexible' ); ?>
									<?php echo starter_flexible_icon_swap( 'arrow', 20 ); // phpcs:ignore ?>
								</a>
							<?php endif; ?>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		</div>

		<?php if ( $data->has_navigation ) : ?>
			<div class="ps__dots" role="tablist" aria-label="<?php esc_attr_e( 'Chọn dự án', 'starter-flexible' ); ?>">
				<?php foreach ( $data->items as $i => $item ) : ?>
					<button
						type="button"
						class="ps__dot"
						role="tab"
						data-ps-dot="<?php echo esc_attr( (string) $i ); ?>"
						aria-label="<?php echo esc_attr( $item['name'] ); ?>"
						aria-selected="<?php echo 0 === $i ? 'true' : 'false'; ?>"
					></button>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
