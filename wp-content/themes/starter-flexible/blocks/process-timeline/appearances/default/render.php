<?php
/**
 * Process Timeline — default appearance.
 *
 * @var object $data
 * @var bool   $is_preview
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( empty( $data->should_render ) ) {
	if ( $is_preview ) {
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Thêm các bước quy trình ở thanh bên.', 'starter-flexible' ) );
	}
	return;
}

?>
<section class="<?php echo esc_attr( $data->module_class ); ?>" data-reveal<?php if ( $data->anchor ) : ?> id="<?php echo esc_attr( $data->anchor ); ?>"<?php endif; ?>>
	<?php
	/*
	 * Heading on the left, held in view; the steps run down the right on a
	 * rail that fills as the page scrolls, and the step being read lights up
	 * (behaviour.js marks it is-active, the ones above it is-done).
	 */
	$pt_total = count( $data->steps );
	?>
	<div class="pt pt--flow" data-timeline style="--n:<?php echo (int) $pt_total; ?>">
		<div class="pt__aside">
			<div class="pt__head">
				<?php if ( '' !== $data->heading ) : ?>
					<h2 class="h3 pt__heading"><?php echo esc_html( $data->heading ); ?></h2>
				<?php endif; ?>
				<?php if ( '' !== $data->intro ) : ?>
					<p class="copy pt__intro"><?php echo esc_html( $data->intro ); ?></p>
				<?php endif; ?>
				<p class="pt__progress" aria-hidden="true">
					<?php echo esc_html( function_exists( 'pll_current_language' ) && 'en' === pll_current_language( 'slug' ) ? 'Step' : 'Bước' ); ?>
					<span data-timeline-current>1</span> / <?php echo (int) $pt_total; ?>
				</p>
			</div>
		</div>

		<div class="pt__track">
			<span class="pt__rail"></span>
			<span class="pt__fill" data-timeline-fill></span>
			<ol class="pt__steps">
				<?php foreach ( $data->steps as $step ) : ?>
					<li class="pt__step" data-timeline-step>
						<span class="pt__dot"></span>
						<div class="pt__title"><?php echo esc_html( $step['title'] ); ?></div>
						<div class="pt__desc"><?php echo esc_html( $step['desc'] ); ?></div>
					</li>
				<?php endforeach; ?>
			</ol>
		</div>
	</div>
</section>
