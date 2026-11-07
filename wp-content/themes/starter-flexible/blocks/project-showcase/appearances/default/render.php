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
	 * Heading on the left, a row of project cards on the right. On a desktop
	 * the block pins under the header and the page scroll slides the row
	 * sideways until the last card is in place (behaviour.js); elsewhere the
	 * row is swiped. Each card carries only what tells projects apart — use,
	 * hull, the three headline numbers — the full sheet is one click away.
	 */
	$ps_en = function_exists( 'pll_current_language' ) && 'en' === pll_current_language( 'slug' );
	?>
	<div class="container ps ps--rail" data-showcase-stack>
		<div class="ps__pin" data-ps-pin>
			<?php if ( $data->has_head ) : ?>
				<div class="ps__aside">
					<?php if ( '' !== $data->heading ) : ?>
						<h2 class="h3 ps__heading"><?php echo esc_html( $data->heading ); ?></h2>
					<?php endif; ?>
					<?php if ( '' !== $data->intro ) : ?>
						<p class="copy ps__intro"><?php echo esc_html( $data->intro ); ?></p>
					<?php endif; ?>
					<?php if ( '' !== $data->view_all_url ) : ?>
						<a class="btn btn--secondary ps__all" href="<?php echo esc_url( $data->view_all_url ); ?>">
							<?php echo esc_html( '' !== $data->view_all_label ? $data->view_all_label : __( 'Xem tất cả dự án', 'starter-flexible' ) ); ?>
							<?php echo starter_flexible_icon_swap( 'arrow', 18 ); // phpcs:ignore ?>
						</a>
					<?php endif; ?>
					<span class="ps__progress" aria-hidden="true"><span></span></span>
				</div>
			<?php endif; ?>

			<div class="ps__stack">
				<?php foreach ( $data->items as $i => $item ) : ?>
					<?php
					$ps_tag   = '' !== (string) $item['url'] ? 'a' : 'div';
					$ps_kind  = implode( ' · ', array_filter( array( $item['uses_str'], $item['materials_str'] ) ) );
					$ps_foot  = implode( ' · ', array_filter( array( $item['location'], $item['year'] ) ) );
					$ps_stats = array_filter(
						array(
							$ps_en ? 'L×B×D' : 'Kích thước' => $item['dims'],
							$ps_en ? 'Tonnage' : 'Trọng tải' => $item['tonnage'],
							$ps_en ? 'Power' : 'Công suất' => $item['power'],
						),
						static fn( $v ): bool => '' !== trim( (string) $v )
					);
					?>
					<<?php echo $ps_tag; // phpcs:ignore ?> class="ps__card"<?php echo 'a' === $ps_tag ? ' href="' . esc_url( (string) $item['url'] ) . '"' : ''; ?> data-ps-card>
						<span class="ps__media">
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
									'sizes'       => '(max-width: 1023px) 84vw, 420px',
								)
							);
							?>
						</span>
						<span class="ps__body">
							<?php if ( '' !== $ps_kind ) : ?>
								<span class="ps__kind"><?php echo esc_html( $ps_kind ); ?></span>
							<?php endif; ?>
							<span class="ps__name"><?php echo esc_html( $item['name'] ); ?></span>
							<?php if ( $ps_stats ) : ?>
								<span class="ps__stats">
									<?php foreach ( $ps_stats as $label => $value ) : ?>
										<span class="ps__stat"><b><?php echo esc_html( $value ); ?></b><small><?php echo esc_html( $label ); ?></small></span>
									<?php endforeach; ?>
								</span>
							<?php endif; ?>
							<span class="ps__foot">
								<span><?php echo esc_html( $ps_foot ); ?></span>
								<?php if ( 'a' === $ps_tag ) : ?>
									<span class="ps__more"><?php echo esc_html( $ps_en ? 'View project' : 'Xem dự án' ); ?><?php echo starter_flexible_icon_swap( 'arrow', 16 ); // phpcs:ignore ?></span>
								<?php endif; ?>
							</span>
						</span>
					</<?php echo $ps_tag; // phpcs:ignore ?>>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
