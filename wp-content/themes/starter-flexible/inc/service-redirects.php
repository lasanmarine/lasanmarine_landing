<?php
/** Preserve incoming links when service pages are consolidated. */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'template_redirect', function () {
	if ( is_preview() || ! in_array( $_SERVER['REQUEST_METHOD'] ?? 'GET', array( 'GET', 'HEAD' ), true ) ) {
		return;
	}
	$redirects = get_option( 'lasan_service_redirects', array() );
	$path = untrailingslashit( (string) wp_parse_url( wp_unslash( $_SERVER['REQUEST_URI'] ?? '/' ), PHP_URL_PATH ) );
	$target = $redirects['paths'][ $path ] ?? 0;
	if ( ! $target && isset( $_GET['page_id'] ) ) {
		$target = $redirects['ids'][ absint( $_GET['page_id'] ) ] ?? 0;
	}
	// Merged categories: old archive path → the term it was folded into.
	$term_id = $redirects['terms'][ $path ] ?? 0;
	if ( $term_id ) {
		$link = get_term_link( (int) $term_id );
		if ( ! is_wp_error( $link ) ) {
			wp_safe_redirect( $link, 301, 'Lasan Category Merge' );
			exit;
		}
	}
	if ( $target && 'publish' === get_post_status( $target ) ) {
		$url = get_permalink( $target );
		if ( untrailingslashit( (string) wp_parse_url( $url, PHP_URL_PATH ) ) !== $path ) {
			wp_safe_redirect( $url, 301, 'Lasan Service Merge' );
			exit;
		}
	}
}, 0 );
