<?php
/**
 * Hero — default appearance.
 *
 * The photograph, the headline and the lead each live in their own stack, all
 * three driven by the same slide index. With one slide the stacks hold a
 * single panel and the hero reads exactly as it did before.
 *
 * @var object $data
 * @var bool   $is_preview
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( empty( $data->should_render ) ) {
	if ( $is_preview ) {
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Nhập headline cho Hero ở thanh bên.', 'starter-flexible' ) );
	}
	return;
}

$slide_label = __( 'Slide %d', 'starter-flexible' );

?>
<section
	class="<?php echo esc_attr( $data->module_class ); ?>"
	<?php if ( $data->anchor ) : ?> id="<?php echo esc_attr( $data->anchor ); ?>"<?php endif; ?>
	<?php if ( $data->is_slider ) : ?> data-hero data-hero-autoplay="<?php echo esc_attr( (string) $data->autoplay ); ?>"<?php endif; ?>
>
	<?php if ( $data->has_media ) : ?>
		<div class="hero__media">
			<?php foreach ( $data->slides as $i => $slide ) : ?>
				<?php if ( '' !== $slide['image_html'] ) : ?>
					<div class="hero__frame<?php echo 0 === $i ? ' is-current' : ''; ?>" data-hero-panel="<?php echo esc_attr( (string) $i ); ?>" aria-hidden="<?php echo 0 === $i ? 'false' : 'true'; ?>">
						<?php echo $slide['image_html']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
	<span class="hero__scrim"></span>

	<div class="container hero__body">
		<div class="hero__headlines" data-enter style="--enter-i:0">
			<?php foreach ( $data->slides as $i => $slide ) : ?>
				<?php
				// One h1 to a page: the slides behind the first are the same
				// line of type without the heading role.
				$tag = 0 === $i ? $data->heading_level : 'p';
				?>
				<<?php echo esc_attr( $tag ); ?> class="hero__headline<?php echo 0 === $i ? ' is-current' : ''; ?>" data-hero-panel="<?php echo esc_attr( (string) $i ); ?>" aria-hidden="<?php echo 0 === $i ? 'false' : 'true'; ?>"><?php
					// Only the parts that were filled in, so a slide without an
					// accent or a tail does not trail spaces behind it.
					$parts = array();
					if ( '' !== $slide['headline'] ) {
						$parts[] = esc_html( $slide['headline'] );
					}
					if ( '' !== $slide['headline_accent'] ) {
						$parts[] = '<span>' . esc_html( $slide['headline_accent'] ) . '</span>';
					}
					if ( '' !== $slide['headline_tail'] ) {
						$parts[] = esc_html( $slide['headline_tail'] );
					}
					echo implode( ' ', $parts ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped above.
				?></<?php echo esc_attr( $tag ); ?>>
			<?php endforeach; ?>
		</div>

		<div class="hero__foot">
			<?php if ( $data->has_lead ) : ?>
				<div class="hero__leads" data-enter style="--enter-i:1">
					<?php foreach ( $data->slides as $i => $slide ) : ?>
						<p class="copy hero__lead<?php echo 0 === $i ? ' is-current' : ''; ?>" data-hero-panel="<?php echo esc_attr( (string) $i ); ?>" aria-hidden="<?php echo 0 === $i ? 'false' : 'true'; ?>"><?php echo esc_html( $slide['lead'] ); ?></p>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<?php if ( $data->has_actions ) : ?>
				<div class="hero__actions" data-enter style="--enter-i:2">
					<?php
					starter_flexible_render_hero_button( $data->primary, 'primary', 'arrow' );
					starter_flexible_render_hero_button( $data->secondary, 'secondary', 'arrowUpRight' );
					?>
				</div>
			<?php endif; ?>
		</div>

		<?php if ( $data->is_slider ) : ?>
			<div class="hero__dots" role="tablist" aria-label="<?php esc_attr_e( 'Chọn slide', 'starter-flexible' ); ?>" data-enter style="--enter-i:3">
				<?php foreach ( $data->slides as $i => $slide ) : ?>
					<button
						type="button"
						class="hero__dot<?php echo 0 === $i ? ' is-current' : ''; ?>"
						role="tab"
						data-hero-dot="<?php echo esc_attr( (string) $i ); ?>"
						aria-selected="<?php echo 0 === $i ? 'true' : 'false'; ?>"
						aria-label="<?php echo esc_attr( '' !== $slide['headline'] ? $slide['headline'] : sprintf( $slide_label, $i + 1 ) ); ?>"
					>
						<span class="hero__dot-fill"></span>
					</button>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>

	<?php get_template_part( 'template-parts/components/wave' ); ?>
</section>
