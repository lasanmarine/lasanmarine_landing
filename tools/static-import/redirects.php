<?php
/**
 * Rebuild the `lasan_service_redirects` option (read by
 * inc/service-redirects.php) from the static export: every redirect stub
 * (<meta http-equiv="refresh">) becomes path → target post or term, and every
 * old WordPress id seen in the export maps `?page_id=N` to the new page.
 *
 *   docker exec -u www-data lasan_wp php /var/www/html/tools/static-import/redirects.php
 *
 * @package Starter_Flexible
 */

$_SERVER['HTTP_HOST']   = $_SERVER['HTTP_HOST'] ?? ( parse_url( getenv( 'WP_HOME' ) ?: 'http://localhost', PHP_URL_HOST ) . ( parse_url( getenv( 'WP_HOME' ) ?: '', PHP_URL_PORT ) ? ':' . parse_url( getenv( 'WP_HOME' ), PHP_URL_PORT ) : '' ) );
$_SERVER['REQUEST_URI'] = '/';
error_reporting( E_ALL & ~E_DEPRECATED & ~E_NOTICE & ~E_WARNING );
require ( getenv( 'WP_PATH' ) ?: dirname( __DIR__, 2 ) ) . '/wp-load.php';
require_once dirname( __DIR__ ) . '/lib/content.php';
require_once __DIR__ . '/lib.php';

/** New post id or term id for a site path. @return array{0:string,1:int} */
function ls_redirect_target( string $path ): array {
	$path = (string) preg_replace( '/[?#].*$/', '', $path );
	if ( preg_match( '#/category/(.+?)/?$#', $path, $m ) ) {
		$slug = basename( $m[1] );
		$term = get_term_by( 'slug', $slug, 'category' );
		return $term ? array( 'term', (int) $term->term_id ) : array( '', 0 );
	}
	$key = ls_page_key_for_path( $path );
	if ( '' !== $key ) {
		lasan_content_lang( str_starts_with( $path, '/en/' ) ? 'en' : 'vi' );
		return array( 'post', lasan_content_find_page( $key ) );
	}
	$id = url_to_postid( home_url( $path ) );
	return array( $id ? 'post' : '', (int) $id );
}

$out  = array( 'paths' => array(), 'ids' => array(), 'terms' => array() );
$iter = new RecursiveIteratorIterator( new RecursiveDirectoryIterator( ls_docs(), FilesystemIterator::SKIP_DOTS ) );
foreach ( $iter as $f ) {
	if ( 'index.html' !== $f->getFilename() ) {
		continue;
	}
	$head = (string) file_get_contents( (string) $f, false, null, 0, 3000 );
	if ( ! preg_match( '/http-equiv="refresh" content="0;url=([^"]+)"/', $head, $m ) ) {
		continue;
	}
	$from = untrailingslashit( substr( dirname( (string) $f ), strlen( ls_docs() ) ) );
	$to   = (string) ls_site_path( html_entity_decode( $m[1] ) );
	if ( '' === $from || '/en' === $from ) {
		continue; // the language home is Polylang's own redirect
	}
	list( $kind, $id ) = ls_redirect_target( $to );
	if ( ! $id ) {
		echo "  ! {$from} → {$to}: không tìm thấy đích\n";
		continue;
	}
	if ( 'term' === $kind ) {
		$out['terms'][ $from ] = $id;
	} else {
		$out['paths'][ $from ] = $id;
	}
	echo "  ✓ {$from} → {$to}\n";
}

foreach ( ls_old_ids() as $old => $path ) {
	list( $kind, $id ) = ls_redirect_target( $path );
	if ( 'post' === $kind && $id && $id !== $old ) {
		$out['ids'][ $old ] = $id;
	}
}

update_option( 'lasan_service_redirects', $out );
printf( "Xong: %d đường dẫn, %d danh mục, %d id cũ\n", count( $out['paths'] ), count( $out['terms'] ), count( $out['ids'] ) );
