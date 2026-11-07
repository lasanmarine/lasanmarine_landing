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
	<?php
	/*
	 * A stack of project cards. Each card pins under the header as the page
	 * scrolls and the next one slides up over it, so the projects are read
	 * one at a time without a slider to operate.
	 */
	?>
	<div class="container ps ps--stack" data-showcase-stack>
		<?php if ( $data->has_head ) : ?>
			<div class="ps__bar ps__bar--head">
				<div class="ps__head">
					<?php if ( '' !== $data->heading ) : ?>
						<h2 class="h3 ps__heading"><?php echo esc_html( $data->heading ); ?></h2>
					<?php endif; ?>
					<?php if ( '' !== $data->intro ) : ?>
						<p class="copy ps__intro"><?php echo esc_html( $data->intro ); ?></p>
					<?php endif; ?>
				</div>
				<?php if ( '' !== $data->view_all_url ) : ?>
					<a class="btn btn--secondary ps__all" href="<?php echo esc_url( $data->view_all_url ); ?>">
						<?php echo esc_html( '' !== $data->view_all_label ? $data->view_all_label : __( 'Xem tất cả dự án', 'starter-flexible' ) ); ?>
						<?php echo starter_flexible_icon_swap( 'arrow', 18 ); // phpcs:ignore ?>
					</a>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<div class="ps__stack">
			<?php foreach ( $data->items as $i => $item ) : ?>
				<article class="ps__card" style="--i:<?php echo (int) $i; ?>" data-ps-card>
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
						<span class="ps__count"><?php echo esc_html( sprintf( '%d / %d', $i + 1, count( $data->items ) ) ); ?></span>
						<h3 class="ps__name"><?php echo esc_html( $item['name'] ); ?></h3>

						<dl class="ps__specs">
							<?php foreach ( $item['specs'] as $label => $value ) : ?>
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
</section>
