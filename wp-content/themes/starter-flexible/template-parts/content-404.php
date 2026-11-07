<?php
/**
 * 404 — the page that is not there.
 *
 * One navy band over the swell: the number, a single line saying the page does
 * not exist, and the way home.
 *
 * @package Starter_Flexible
 * @since 1.0.0
 */

$is_english = function_exists( 'pll_current_language' ) && 'en' === pll_current_language( 'slug' );
$home       = function_exists( 'pll_home_url' ) ? pll_home_url() : home_url( '/' );
?>

<section class="e404">
	<div class="e404__ground" aria-hidden="true">
		<svg viewBox="0 0 1440 620" preserveAspectRatio="none" class="e404__wave">
			<?php for ( $i = 0; $i < 8; $i++ ) : ?>
				<?php $y = 90 + $i * 64; ?>
				<path
					d="M-60 <?php echo esc_attr( (string) $y ); ?> C300 <?php echo esc_attr( (string) ( $y + 48 ) ); ?> 560 <?php echo esc_attr( (string) ( $y - 34 ) ); ?> 860 <?php echo esc_attr( (string) ( $y + 8 ) ); ?> C1120 <?php echo esc_attr( (string) ( $y + 44 ) ); ?> 1300 <?php echo esc_attr( (string) ( $y + 56 ) ); ?> 1520 <?php echo esc_attr( (string) ( $y + 30 ) ); ?>"
					fill="none"
					stroke="#0066FF"
					stroke-width="<?php echo esc_attr( number_format( max( 2 - $i * 0.14, 0.8 ), 2, '.', '' ) ); ?>"
					stroke-opacity="<?php echo esc_attr( number_format( max( 0.46 - $i * 0.05, 0.08 ), 3, '.', '' ) ); ?>"
				/>
			<?php endfor; ?>
		</svg>
	</div>

	<div class="container e404__inner">
		<p class="e404__code" aria-hidden="true">404</p>
		<h1 class="e404__title"><?php echo esc_html( $is_english ? 'Page not found' : 'Trang không tồn tại' ); ?></h1>
		<a class="btn btn--lg" href="<?php echo esc_url( $home ); ?>">
			<?php echo esc_html( $is_english ? 'Back to home' : 'Về trang chủ' ); ?>
			<?php echo starter_flexible_icon_swap( 'arrow', 18 ); // phpcs:ignore ?>
		</a>
	</div>
</section>

