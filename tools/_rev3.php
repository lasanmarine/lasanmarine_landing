<?php
require_once '/var/www/html/wp-load.php';
$pairs = array(
	array( 12, 824, 'home' ), array( 13, 876, 'about' ), array( 14, 813, 'capabilities' ),
	array( 15, 831, 'service_01' ), array( 17, 870, 'service_03' ), array( 18, 833, 'projects' ),
	array( 22, 869, 'tools' ), array( 493, 867, 'service_rnd' ), array( 769, 838, 'design_brief' ),
);
/** Kéo các chuỗi người đọc được ra khỏi block data. */
function lasan_texts( string $content ): array {
	$out = array();
	if ( ! preg_match_all( '#<!-- wp:acf/([a-z0-9-]+) (\{.*?\}) /?-->#s', $content, $m, PREG_SET_ORDER ) ) { return $out; }
	foreach ( $m as $hit ) {
		$data = json_decode( $hit[2], true )['data'] ?? array();
		foreach ( array( 'headline', 'heading', 'lead', 'label', 'caption', 'title' ) as $f ) {
			if ( ! empty( $data[ $f ] ) && is_string( $data[ $f ] ) ) { $out[] = $hit[1] . '.' . $f . ': ' . mb_substr( $data[ $f ], 0, 90 ); }
		}
	}
	return $out;
}
foreach ( $pairs as list( $id, $rev, $key ) ) {
	$old = lasan_texts( get_post( $rev )->post_content );
	$new = lasan_texts( get_post( $id )->post_content );
	$diff = array();
	foreach ( $old as $i => $line ) { if ( ( $new[ $i ] ?? '' ) !== $line ) { $diff[] = array( $line, $new[ $i ] ?? '(không có)' ); } }
	printf( "\n=== %s — %d dòng khác ===\n", $key, count( $diff ) );
	foreach ( array_slice( $diff, 0, 4 ) as $d ) {
		printf( "  BẢN ANH SỬA : %s\n  BỊ THAY BẰNG: %s\n", $d[0], $d[1] );
	}
}
