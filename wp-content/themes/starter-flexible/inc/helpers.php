<?php
/**
 * Small helpers used across modules.
 *
 * @package Starter_Flexible
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return a stable version string for a local file (cache-busting).
 *
 * Falls back to theme version when the file doesn't exist.
 */
function starter_flexible_file_version( string $absolute_path ): string {
	if ( is_file( $absolute_path ) ) {
		return (string) filemtime( $absolute_path );
	}

	if ( defined( 'STARTER_FLEXIBLE_THEME_VERSION' ) ) {
		return (string) STARTER_FLEXIBLE_THEME_VERSION;
	}

	return '1.0.0';
}

function starter_flexible_get_option_field( string $key, $default = '' ) {
	if ( function_exists( 'get_field' ) ) {
		$value = get_field( $key, 'option' );
		if ( null !== $value && '' !== $value ) {
			return $value;
		}
	}

	return $default;
}

/**
 * Merge block classes from ACF field and editor-assigned className.
 */
function starter_flexible_merge_block_classes( ...$sources ): string {
	$classes = array();

	foreach ( $sources as $source ) {
		if ( ! is_string( $source ) || '' === trim( $source ) ) {
			continue;
		}

		$parts = preg_split( '/\s+/', trim( $source ) );
		if ( ! is_array( $parts ) ) {
			continue;
		}

		foreach ( $parts as $part ) {
			$part = sanitize_html_class( $part );
			if ( '' !== $part ) {
				$classes[] = $part;
			}
		}
	}

	$classes = array_values( array_unique( $classes ) );

	return implode( ' ', $classes );
}

function starter_flexible_build_module_class( string $base_class, string $custom_class = '' ): string {
	$merged = starter_flexible_merge_block_classes( $base_class, $custom_class );

	return '' !== $merged ? $merged : $base_class;
}

/**
 * Return normalized block fields shared by all flexible blocks.
 */
function starter_flexible_get_block_fields( array $block ): array {
	$fields = function_exists( 'get_fields' ) ? get_fields() : array();
	$fields = is_array( $fields ) ? $fields : array();

	unset( $fields['full_html'] );

	$block_slug = str_replace( 'acf/', '', (string) ( $block['name'] ?? '' ) );
	if ( '' !== $block_slug ) {
		$field_defs = starter_flexible_get_block_field_definitions( $block_slug );
		if ( $field_defs ) {
			$fields = array_replace(
				starter_flexible_extract_block_data_fields( $block, $field_defs ),
				$fields
			);
		}

	}

	$fields['custom_class'] = starter_flexible_merge_block_classes(
		isset( $fields['custom_class'] ) ? (string) $fields['custom_class'] : '',
		isset( $block['className'] ) ? (string) $block['className'] : ''
	);

	return $fields;
}

/**
 * Load top-level ACF field definitions for a block from its JSON config.
 *
 * @return array<int, array<string, mixed>>
 */
function starter_flexible_get_block_field_definitions( string $block_slug ): array {
	$theme_dir   = defined( 'STARTER_FLEXIBLE_THEME_DIR' ) ? STARTER_FLEXIBLE_THEME_DIR : get_template_directory();
	$block_dir   = $theme_dir . '/blocks/' . $block_slug;
	$json_files  = glob( $block_dir . '/*.json' );

	if ( ! is_array( $json_files ) ) {
		return array();
	}

	foreach ( $json_files as $json_file ) {
		if ( 'block.json' === basename( $json_file ) || ! is_file( $json_file ) ) {
			continue;
		}

		$json = file_get_contents( $json_file );
		if ( false === $json ) {
			continue;
		}

		$config = json_decode( $json, true );
		if ( ! is_array( $config ) || empty( $config['fields'] ) || ! is_array( $config['fields'] ) ) {
			continue;
		}

		return $config['fields'];
	}

	return array();
}

/**
 * Extract current editor block data, including repeater rows, from $block['data'].
 *
 * @param array<int, array<string, mixed>> $field_defs Top-level field definitions.
 *
 * @return array<string, mixed>
 */
function starter_flexible_extract_block_data_fields( array $block, array $field_defs ): array {
	$block_data = isset( $block['data'] ) && is_array( $block['data'] ) ? $block['data'] : array();
	if ( ! $block_data ) {
		return array();
	}

	$extracted = array();

	foreach ( $field_defs as $field_def ) {
		$name = isset( $field_def['name'] ) ? (string) $field_def['name'] : '';
		$type = isset( $field_def['type'] ) ? (string) $field_def['type'] : '';

		if ( '' === $name ) {
			continue;
		}

		if ( 'repeater' === $type ) {
			if ( array_key_exists( $name, $block_data ) || starter_flexible_block_data_has_repeater_rows( $block_data, $name ) ) {
				$extracted[ $name ] = starter_flexible_extract_repeater_block_data( $block_data, $field_def );
			}
			continue;
		}

		if ( array_key_exists( $name, $block_data ) ) {
			$extracted[ $name ] = $block_data[ $name ];
		}
	}

	return $extracted;
}

function starter_flexible_block_data_has_repeater_rows( array $block_data, string $field_name ): bool {
	foreach ( $block_data as $key => $value ) {
		if ( ! is_string( $key ) ) {
			continue;
		}

		if ( 0 === strpos( $key, $field_name . '_' ) ) {
			return true;
		}
	}

	return false;
}

/**
 * @param array<string, mixed> $block_data
 * @param array<string, mixed> $field_def
 *
 * @return array<int, array<string, mixed>>
 */
function starter_flexible_extract_repeater_block_data( array $block_data, array $field_def ): array {
	$name       = isset( $field_def['name'] ) ? (string) $field_def['name'] : '';
	$sub_fields = isset( $field_def['sub_fields'] ) && is_array( $field_def['sub_fields'] ) ? $field_def['sub_fields'] : array();

	if ( '' === $name ) {
		return array();
	}

	if ( isset( $block_data[ $name ] ) && is_array( $block_data[ $name ] ) ) {
		return $block_data[ $name ];
	}

	$row_count = isset( $block_data[ $name ] ) ? absint( $block_data[ $name ] ) : 0;
	$rows      = array();

	for ( $index = 0; $index < $row_count; $index++ ) {
		$row = array();

		foreach ( $sub_fields as $sub_field ) {
			$sub_name = isset( $sub_field['name'] ) ? (string) $sub_field['name'] : '';
			if ( '' === $sub_name ) {
				continue;
			}

			$compound_key = $name . '_' . $index . '_' . $sub_name;
			if ( array_key_exists( $compound_key, $block_data ) ) {
				$row[ $sub_name ] = $block_data[ $compound_key ];
			}
		}

		if ( $row ) {
			$rows[] = $row;
		}
	}

	return $rows;
}

/**
 * Recursively find files by extension inside a directory (no SPL iterators).
 *
 * @param string   $dir        Absolute directory path.
 * @param string[] $extensions Lowercase extensions without dot (e.g. ['js','css']).
 *
 * @return string[] Absolute paths.
 */
function starter_flexible_find_files_recursive( string $dir, array $extensions ): array {
	if ( ! is_dir( $dir ) ) {
		return array();
	}

	$extensions = array_values(
		array_filter(
			array_map( 'strtolower', $extensions ),
			static function ( $ext ) {
				return is_string( $ext ) && '' !== $ext;
			}
		)
	);

	$result = array();
	$items  = scandir( $dir );

	if ( false === $items ) {
		return array();
	}

	foreach ( $items as $item ) {
		if ( '.' === $item || '..' === $item ) {
			continue;
		}

		$path = $dir . '/' . $item;

		if ( is_dir( $path ) ) {
			$result = array_merge( $result, starter_flexible_find_files_recursive( $path, $extensions ) );
			continue;
		}

		if ( ! is_file( $path ) ) {
			continue;
		}

		$ext = strtolower( pathinfo( $path, PATHINFO_EXTENSION ) );
		if ( in_array( $ext, $extensions, true ) ) {
			$result[] = $path;
		}
	}

	return $result;
}
