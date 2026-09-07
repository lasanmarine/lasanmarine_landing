<?php
require_once '/var/www/html/wp-load.php';
/** Mọi chuỗi trong block data, theo thứ tự. */
function lasan_all( string $content ): array {
	$out = array();
	if ( ! preg_match_all( '#<!-- wp:acf/([a-z0-9-]+) (\{.*?\}) /?-->#s', $content, $m, PREG_SET_ORDER ) ) { return $out; }
	foreach ( $m as $hit ) {
		$data = json_decode( $hit[2], true )['data'] ?? array();
		foreach ( $data as $k => $v ) {
			if ( is_string( $v ) && '' !== trim( $v ) && '_' !== $k[0] && ! preg_match( '#^field_#', $v ) ) {
				$out[ $hit[1] . '|' . $k ] = $v;
			}
		}
	}
	return $out;
}
// [trang, bản của tool lúc 07:56, bản mới nhất trước 09:39]
$sets = array(
	array( 'home', 807, 824 ), array( 'about', 808, 876 ), array( 'capabilities', 813, 813 ),
	array( 'service_01', 809, 831 ), array( 'service_03', 810, 870 ), array( 'projects', 812, 833 ),
	array( 'tools', 764, 869 ), array( 'service_rnd', 811, 867 ), array( 'design_brief', 774, 838 ),
);
foreach ( $sets as list( $key, $mine, $later ) ) {
	if ( $mine === $later ) { printf( "\n=== %s: không có bản nào sau lần apply 07:56 → anh không sửa trang này\n", $key ); continue; }
	$a = lasan_all( get_post( $mine )->post_content );
	$b = lasan_all( get_post( $later )->post_content );
	$changed = array();
	foreach ( $b as $k => $v ) { if ( ! isset( $a[ $k ] ) || $a[ $k ] !== $v ) { $changed[ $k ] = array( $a[ $k ] ?? '(mới)', $v ); } }
	printf( "\n=== %s — %d trường khác giữa bản tool (#%d) và bản sau đó (#%d) ===\n", $key, count( $changed ), $mine, $later );
	$i = 0;
	foreach ( $changed as $k => $pair ) {
		if ( $i++ >= 5 ) { echo "   … còn ", count( $changed ) - 5, " trường\n"; break; }
		printf( "  [%s]\n    tool : %s\n    sau  : %s\n", $k, mb_substr( $pair[0], 0, 80 ), mb_substr( $pair[1], 0, 80 ) );
	}
}
