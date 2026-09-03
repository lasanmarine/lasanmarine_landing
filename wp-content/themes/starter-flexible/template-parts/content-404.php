<?php
/**
 * Template part for displaying 404 pages.
 *
 * @package Starter_Flexible
 * @since 1.0.0
 */
?>

<section class="err-page">
	<h1 class="err-page__code">404</h1>
	
	<h2 class="err-page__title"><?php esc_html_e( 'Không tìm thấy trang.', 'starter-flexible' ); ?></h2>
	
	<p class="err-page__subtitle"><?php esc_html_e( 'Đường dẫn có thể đã thay đổi hoặc trang đã được gỡ.', 'starter-flexible' ); ?></p>

	<div class="err-page__actions">
		<a class="err-page__home-link" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php esc_html_e( 'Về trang chủ', 'starter-flexible' ); ?>
		</a>
	</div>
</section>
