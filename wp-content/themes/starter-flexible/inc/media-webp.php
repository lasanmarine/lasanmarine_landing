<?php
/**
 * Upload pipeline tuning: keep uploads sharp and store raster images as WebP.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Keep large uploads at full resolution instead of the 2560px core downscale. */
function starter_flexible_big_image_threshold( $threshold ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter
	return (int) apply_filters( 'starter_flexible_big_image_threshold', 3840 );
}
add_filter( 'big_image_size_threshold', 'starter_flexible_big_image_threshold', 10, 1 );

/** Raise the re-encode quality WordPress uses for generated sizes. */
function starter_flexible_image_quality( int $quality, string $mime = '' ): int { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter
	return (int) apply_filters( 'starter_flexible_image_quality', 90 );
}
add_filter( 'jpeg_quality', 'starter_flexible_image_quality', 10, 2 );
add_filter( 'wp_editor_set_quality', 'starter_flexible_image_quality', 10, 2 );

/** Formats converted to WebP on upload. */
function starter_flexible_webp_source_mimes(): array {
	return (array) apply_filters(
		'starter_flexible_webp_source_mimes',
		array( 'image/jpeg', 'image/png' )
	);
}

/** True when the current PHP build can write WebP. */
function starter_flexible_can_write_webp(): bool {
	if ( class_exists( 'Imagick' ) && in_array( 'WEBP', array_map( 'strtoupper', (array) Imagick::queryFormats( 'WEBP' ) ), true ) ) {
		return true;
	}

	return function_exists( 'imagewebp' );
}

/**
 * Convert a freshly uploaded JPEG/PNG to WebP and point the attachment at it.
 *
 * Runs after WordPress moved the temp file into uploads, so every generated
 * size, and the attachment metadata, are produced from the WebP original.
 *
 * @param array  $upload  { file, url, type }.
 * @param string $context 'upload' or 'sideload'.
 * @return array
 */
function starter_flexible_convert_upload_to_webp( array $upload, string $context = 'upload' ): array { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter
	if ( empty( $upload['file'] ) || empty( $upload['type'] ) || ! empty( $upload['error'] ) ) {
		return $upload;
	}

	if ( ! in_array( $upload['type'], starter_flexible_webp_source_mimes(), true ) ) {
		return $upload;
	}

	if ( ! apply_filters( 'starter_flexible_convert_to_webp', true, $upload ) ) {
		return $upload;
	}

	if ( ! starter_flexible_can_write_webp() ) {
		return $upload;
	}

	$source = $upload['file'];
	if ( ! is_file( $source ) ) {
		return $upload;
	}

	$directory = dirname( $source );
	$target    = trailingslashit( $directory ) . wp_unique_filename(
		$directory,
		pathinfo( $source, PATHINFO_FILENAME ) . '.webp'
	);

	$editor = wp_get_image_editor( $source );
	if ( is_wp_error( $editor ) ) {
		return $upload;
	}

	$editor->set_quality( (int) apply_filters( 'starter_flexible_webp_quality', 88 ) );
	$saved = $editor->save( $target, 'image/webp' );
	if ( is_wp_error( $saved ) || empty( $saved['path'] ) || ! is_file( $saved['path'] ) ) {
		return $upload;
	}

	wp_delete_file( $source );

	$upload['file'] = $saved['path'];
	$upload['url']  = str_replace( wp_basename( $source ), wp_basename( $saved['path'] ), $upload['url'] );
	$upload['type'] = 'image/webp';

	return $upload;
}
add_filter( 'wp_handle_upload', 'starter_flexible_convert_upload_to_webp', 10, 2 );
add_filter( 'wp_handle_sideload', 'starter_flexible_convert_upload_to_webp', 10, 2 );
