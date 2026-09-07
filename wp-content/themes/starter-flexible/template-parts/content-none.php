<?php
/**
 * Nothing found — the empty state for a search or an archive with no posts.
 *
 * @package Starter_Flexible
 * @since 1.0.0
 */
?>

<div class="err__empty">
	<p class="err__empty-title">
		<?php
		if ( is_search() ) {
			esc_html_e( 'Không có kết quả nào khớp với từ khóa.', 'starter-flexible' );
		} else {
			esc_html_e( 'Chưa có nội dung trong mục này.', 'starter-flexible' );
		}
		?>
	</p>
	<p class="err__empty-note"><?php esc_html_e( 'Thử một từ khóa khác, hoặc quay lại trang chủ.', 'starter-flexible' ); ?></p>
	<a class="btn btn--secondary" href="<?php echo esc_url( home_url( '/' ) ); ?>">
		<?php esc_html_e( 'Về trang chủ', 'starter-flexible' ); ?>
		<?php echo starter_flexible_icon_swap( 'arrow', 18 ); // phpcs:ignore ?>
	</a>
</div>
