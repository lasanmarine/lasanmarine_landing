<?php
require_once '/var/www/html/wp-load.php';
// Các lần `apply` của tool ghi hàng loạt trong vài giây; sửa tay thì rải rác.
$pages = array( 12 => 'home', 13 => 'about', 14 => 'capabilities', 15 => 'service_01', 17 => 'service_03', 18 => 'projects', 22 => 'tools', 493 => 'service_rnd', 769 => 'design_brief' );
$cut   = '2026-09-07 09:39:00'; // ngay trước lần apply cuối của tool
foreach ( $pages as $id => $key ) {
	$revs = wp_get_post_revisions( $id, array( 'posts_per_page' => -1, 'orderby' => 'date', 'order' => 'DESC' ) );
	$pick = null;
	foreach ( $revs as $r ) { if ( $r->post_date < $cut ) { $pick = $r; break; } }
	if ( ! $pick ) { echo "$key: không có bản nào trước $cut\n"; continue; }
	$now = get_post( $id );
	// Lấy vài dòng chữ đầu để so
	$txt = static function ( $s ) {
		$s = wp_strip_all_tags( preg_replace( '/<!--.*?-->/s', ' ', $s ) );
		$s = trim( preg_replace( '/\s+/u', ' ', $s ) );
		return mb_substr( $s, 0, 150 );
	};
	printf( "\n=== %s (#%d) ===\n", $key, $id );
	printf( "  bản khôi phục  #%-5d %s  (%d ký tự)\n", $pick->ID, $pick->post_date, strlen( $pick->post_content ) );
	printf( "    → %s\n", $txt( $pick->post_content ) );
	printf( "  đang hiển thị           %s  (%d ký tự)\n", $now->post_modified, strlen( $now->post_content ) );
	printf( "    → %s\n", $txt( $now->post_content ) );
	printf( "  KHÁC NHAU: %s\n", $pick->post_content === $now->post_content ? 'không' : 'CÓ' );
}
