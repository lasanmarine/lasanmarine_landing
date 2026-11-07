<?php
/**
 * CF7 service select migration — adds R&D and unifies naming.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function starter_flexible_fix_cf7_service_options(): void {
	if ( get_transient( 'starter_flexible_cf7_fix_done' ) ) {
		return;
	}
		if ( ! function_exists( 'get_posts' ) ) {
			return;
		}
		$forms = get_posts(
			array(
				'post_type'      => 'wpcf7',
				'post_status'    => 'publish',
				'posts_per_page' => 20,
				'fields'         => 'ids',
			)
		);
		foreach ( $forms as $id ) {
			$post = get_post( $id );
			if ( ! $post ) {
				continue;
			}
			$content = $post->post_content;
			if ( false === strpos( $content, 'Dịch vụ CNTT' ) && false === strpos( $content, '"Thiết kế tàu"' ) ) {
				continue;
			}
			// Replace select lines containing service/interest options.
			$new_options = '"Thiết kế tàu — Hồ sơ kỹ thuật" "Thiết kế tàu — Cải hoán" "Thiết kế tàu — Đóng mới" "Nghiên cứu và phát triển (R&D)" "Giải pháp số / Công nghệ thông tin" "Khác"';
			$content = preg_replace(
				'/\[(select|radio|checkbox)\*?\s+(service|interest|dich-vu|need)[^\]]*\]/',
				'[select* service ' . $new_options . ']',
				$content
			);
			if ( $content !== $post->post_content ) {
				wp_update_post(
					array(
						'ID'           => $id,
						'post_content' => $content,
					)
				);
			}
		}
		set_transient( 'starter_flexible_cf7_fix_done', 1, DAY_IN_SECONDS );
}
add_action( 'init', 'starter_flexible_fix_cf7_service_options', 30 );
