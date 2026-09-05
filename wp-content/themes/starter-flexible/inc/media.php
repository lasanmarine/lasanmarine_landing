<?php
/**
 * Safe SVG and ICO upload support for Media Library and ACF image fields.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Allow administrators to upload the two brand-asset formats. */
function starter_flexible_brand_asset_mimes( array $mimes ): array {
	if ( current_user_can( 'manage_options' ) ) {
		$mimes['svg'] = 'image/svg+xml';
		$mimes['ico'] = 'image/x-icon';
	}

	return $mimes;
}
add_filter( 'upload_mimes', 'starter_flexible_brand_asset_mimes' );

/** Correct WordPress/fileinfo extension detection for sanitized SVG and ICO. */
function starter_flexible_brand_asset_filetype( $checked, $file, $filename, $mimes = null ): array { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter
	$checked = is_array( $checked ) ? $checked : array();

	if ( ! current_user_can( 'manage_options' ) ) {
		return $checked;
	}

	$extension = strtolower( (string) pathinfo( (string) $filename, PATHINFO_EXTENSION ) );
	if ( 'svg' === $extension ) {
		$checked['ext']             = 'svg';
		$checked['type']            = 'image/svg+xml';
		$checked['proper_filename'] = false;
	} elseif ( 'ico' === $extension ) {
		$checked['ext']             = 'ico';
		$checked['type']            = 'image/x-icon';
		$checked['proper_filename'] = false;
	}

	return $checked;
}
add_filter( 'wp_check_filetype_and_ext', 'starter_flexible_brand_asset_filetype', 10, 4 );

/**
 * Remove executable and remotely loaded content from SVG before WordPress moves
 * the temporary upload into the media directory.
 */
function starter_flexible_sanitize_svg_upload( array $file ): array {
	if ( ! current_user_can( 'manage_options' ) || empty( $file['tmp_name'] ) || empty( $file['name'] ) ) {
		return $file;
	}

	if ( 'svg' !== strtolower( (string) pathinfo( $file['name'], PATHINFO_EXTENSION ) ) ) {
		return $file;
	}

	$source = file_get_contents( $file['tmp_name'] ); // phpcs:ignore WordPress.WP.AlternativeFunctions
	if ( false === $source || preg_match( '/<!DOCTYPE|<!ENTITY/i', $source ) ) {
		$file['error'] = __( 'SVG không hợp lệ hoặc chứa khai báo không an toàn.', 'starter-flexible' );
		return $file;
	}

	$previous = libxml_use_internal_errors( true );
	$document = new DOMDocument();
	$loaded   = $document->loadXML( $source, LIBXML_NONET | LIBXML_NOBLANKS );
	libxml_clear_errors();
	libxml_use_internal_errors( $previous );

	if ( ! $loaded || ! $document->documentElement || 'svg' !== strtolower( $document->documentElement->localName ) ) {
		$file['error'] = __( 'Không thể đọc file SVG này.', 'starter-flexible' );
		return $file;
	}

	$xpath = new DOMXPath( $document );
	foreach ( array( 'script', 'foreignObject', 'iframe', 'object', 'embed', 'audio', 'video' ) as $tag ) {
		$nodes = $xpath->query( '//*[local-name()="' . $tag . '"]' );
		if ( $nodes ) {
			foreach ( iterator_to_array( $nodes ) as $node ) {
				if ( $node->parentNode ) {
					$node->parentNode->removeChild( $node );
				}
			}
		}
	}

	$elements = $xpath->query( '//*' );
	if ( $elements ) {
		foreach ( iterator_to_array( $elements ) as $element ) {
			if ( ! $element instanceof DOMElement ) {
				continue;
			}
			foreach ( iterator_to_array( $element->attributes ) as $attribute ) {
				$name  = strtolower( $attribute->nodeName );
				$value = trim( $attribute->nodeValue );
				$unsafe_link = in_array( $name, array( 'href', 'xlink:href', 'src' ), true )
					&& '' !== $value
					&& '#' !== $value[0]
					&& 0 !== stripos( $value, 'data:image/' );
				$unsafe_value = preg_match( '/javascript:|data:text\/html|expression\s*\(|url\s*\(\s*["\']?https?:/i', $value );
				if ( 0 === strpos( $name, 'on' ) || $unsafe_link || $unsafe_value ) {
					$element->removeAttributeNode( $attribute );
				}
			}
		}
	}

	$clean = $document->saveXML( $document->documentElement );
	if ( ! is_string( $clean ) || false === file_put_contents( $file['tmp_name'], $clean ) ) { // phpcs:ignore WordPress.WP.AlternativeFunctions
		$file['error'] = __( 'Không thể làm sạch file SVG.', 'starter-flexible' );
	}

	return $file;
}
add_filter( 'wp_handle_upload_prefilter', 'starter_flexible_sanitize_svg_upload' );

/** Make vector/icon attachments usable by wp_get_attachment_image_url() and ACF previews. */
function starter_flexible_brand_asset_downsize( $downsize, int $attachment_id, $size ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter
	$mime = get_post_mime_type( $attachment_id );
	if ( ! in_array( $mime, array( 'image/svg+xml', 'image/x-icon' ), true ) ) {
		return $downsize;
	}

	$url = wp_get_attachment_url( $attachment_id );
	if ( ! $url ) {
		return $downsize;
	}

	$width  = 512;
	$height = 512;
	if ( 'image/svg+xml' === $mime ) {
		$path = get_attached_file( $attachment_id );
		if ( is_string( $path ) && is_file( $path ) ) {
			$svg = file_get_contents( $path ); // phpcs:ignore WordPress.WP.AlternativeFunctions
			if ( is_string( $svg ) && preg_match( '/<svg[^>]*\bviewBox=["\']\s*[-0-9.]+\s+[-0-9.]+\s+([0-9.]+)\s+([0-9.]+)["\']/i', $svg, $matches ) ) {
				$width  = max( 1, (int) round( (float) $matches[1] ) );
				$height = max( 1, (int) round( (float) $matches[2] ) );
			}
		}
	}

	return array( $url, $width, $height, false );
}
add_filter( 'image_downsize', 'starter_flexible_brand_asset_downsize', 10, 3 );

/** Display SVG thumbnails at a predictable size in the Media Library. */
function starter_flexible_svg_admin_style(): void {
	echo '<style>.media-icon img[src$=".svg"], .attachment-preview img[src$=".svg"]{width:100%;height:100%;object-fit:contain}</style>';
}
add_action( 'admin_head', 'starter_flexible_svg_admin_style' );
