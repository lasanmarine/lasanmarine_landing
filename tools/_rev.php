<?php
require_once '/var/www/html/wp-load.php';
$pages = array( 12 => 'home', 13 => 'about', 14 => 'capabilities', 15 => 'service_01', 17 => 'service_03', 18 => 'projects', 22 => 'tools', 493 => 'service_rnd', 769 => 'design_brief' );
foreach ( $pages as $id => $key ) {
	$revs = wp_get_post_revisions( $id, array( 'posts_per_page' => -1, 'orderby' => 'date', 'order' => 'DESC' ) );
	printf( "\n=== #%d %s — %d revision ===\n", $id, $key, count( $revs ) );
	$i = 0;
	foreach ( $revs as $r ) {
		if ( $i++ >= 8 ) { echo "   … còn ", count( $revs ) - 8, " bản nữa\n"; break; }
		printf( "  #%-6d %s  %6d ký tự  %s\n", $r->ID, $r->post_date, strlen( $r->post_content ), get_the_author_meta( 'display_name', $r->post_author ) );
	}
}
