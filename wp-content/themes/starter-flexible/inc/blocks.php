<?php
/**
 * ACF blocks: auto-register blocks + load field groups + render callback.
 *
 * @package Starter_Flexible
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/abstract-block.php';

function starter_flexible_register_block_category( array $categories, $editor_context ): array {
	if ( ! empty( $editor_context->post ) ) {
		array_unshift(
			$categories,
			array(
				'slug'  => 'flexible-blocks',
				'title' => __( 'Flexible Blocks', 'starter-flexible' ),
				'icon'  => null,
			)
		);
	}

	return $categories;
}
add_filter( 'block_categories_all', 'starter_flexible_register_block_category', 10, 2 );

function starter_flexible_register_blocks(): void {
	if ( ! function_exists( 'acf_register_block_type' ) ) {
		return;
	}

	$blocks_dir = ( defined( 'STARTER_FLEXIBLE_THEME_DIR' ) ? STARTER_FLEXIBLE_THEME_DIR : get_template_directory() ) . '/blocks';
	if ( ! is_dir( $blocks_dir ) ) {
		return;
	}

	$block_folders = glob( $blocks_dir . '/*', GLOB_ONLYDIR );
	if ( ! $block_folders ) {
		return;
	}

	foreach ( $block_folders as $block_folder ) {
		$block_json_path = $block_folder . '/block.json';
		if ( ! is_file( $block_json_path ) ) {
			continue;
		}

		$block_json = file_get_contents( $block_json_path );
		if ( false === $block_json ) {
			continue;
		}

		$block_config = json_decode( $block_json, true );
		if ( ! is_array( $block_config ) || empty( $block_config['name'] ) ) {
			continue;
		}

		$full_name = (string) $block_config['name']; // e.g. "acf/accordion".
		$slug      = str_replace( 'acf/', '', $full_name );

		$block_args = array(
			'name'            => $slug,
			'title'           => $block_config['title'] ?? '',
			'description'     => $block_config['description'] ?? '',
			'category'        => $block_config['category'] ?? 'common',
			'icon'            => $block_config['icon'] ?? '',
			'keywords'        => $block_config['keywords'] ?? array(),
			'align'           => $block_config['align'] ?? '',
			'mode'            => $block_config['acf']['mode'] ?? 'preview',
			'supports'        => $block_config['supports'] ?? array(),
			'render_callback' => 'starter_flexible_render_block',
			// ACF Blocks V3: opt in per block via block.json ("apiVersion" / "acf.blockVersion").
			'api_version'       => (int) ( $block_config['apiVersion'] ?? 2 ),
			'acf_block_version' => (int) ( $block_config['acf']['blockVersion'] ?? 2 ),
		);

		if ( ! empty( $block_config['example'] ) ) {
			$block_args['example'] = $block_config['example'];
		}

		if ( ! empty( $block_config['usesContext'] ) ) {
			$block_args['uses_context'] = $block_config['usesContext'];
		}

		$result = acf_register_block_type( $block_args );
		if ( ! $result && defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			error_log( 'Failed to register block: ' . $full_name );
		}
	}
}
add_action( 'acf/init', 'starter_flexible_register_blocks', 10 );

function starter_flexible_load_block_field_groups(): void {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	$blocks_dir = ( defined( 'STARTER_FLEXIBLE_THEME_DIR' ) ? STARTER_FLEXIBLE_THEME_DIR : get_template_directory() ) . '/blocks';
	if ( ! is_dir( $blocks_dir ) ) {
		return;
	}

	$block_folders = glob( $blocks_dir . '/*', GLOB_ONLYDIR );
	if ( ! $block_folders ) {
		return;
	}

	foreach ( $block_folders as $block_folder ) {
		$json_files = glob( $block_folder . '/*.json' );
		if ( ! $json_files ) {
			continue;
		}

		foreach ( $json_files as $json_file ) {
			if ( 'block.json' === basename( $json_file ) ) {
				continue;
			}

			$json = file_get_contents( $json_file );
			if ( false === $json ) {
				continue;
			}

			$field_group = json_decode( $json, true );
			if ( ! is_array( $field_group ) || empty( $field_group['key'] ) ) {
				continue;
			}

			if ( ! isset( $field_group['menu_order'] ) ) {
				$field_group['menu_order'] = 0;
			}
			if ( ! isset( $field_group['active'] ) ) {
				$field_group['active'] = true;
			}

			$field_group['fields'] = starter_flexible_append_spacing_fields(
				isset( $field_group['fields'] ) && is_array( $field_group['fields'] ) ? $field_group['fields'] : array(),
				(string) $field_group['key']
			);

			acf_add_local_field_group( $field_group );
		}
	}
}
add_action( 'acf/init', 'starter_flexible_load_block_field_groups', 5 );

/**
 * Render callback for ACF blocks.
 *
 * @param array  $block      Block settings and attributes.
 * @param string $content    Block inner HTML (ignored for ACF blocks).
 * @param bool   $is_preview Whether it's in preview mode.
 * @param int    $post_id    Current post ID.
 */
function starter_flexible_render_block( array $block, string $content = '', bool $is_preview = false, int $post_id = 0 ): void {
	$block_name = $block['name'] ?? '';
	$block_slug = str_replace( 'acf/', '', (string) $block_name );

	if ( '' === $block_slug ) {
		return;
	}

	$theme_dir     = defined( 'STARTER_FLEXIBLE_THEME_DIR' ) ? STARTER_FLEXIBLE_THEME_DIR : get_template_directory();
	$blocks_dir    = $theme_dir . '/blocks';
	$block_folder  = $blocks_dir . '/' . $block_slug;
	$helpers_file  = $block_folder . '/inc/helpers.php';
	$appearance    = 'default';
	$render_file   = $block_folder . '/appearances/' . $appearance . '/render.php';

	if ( ! is_dir( $block_folder ) || ! is_file( $render_file ) ) {
		return;
	}

	if ( is_file( $helpers_file ) ) {
		require_once $helpers_file;
	}

	$data = null;

	$fn_suffix = preg_replace( '/[^a-z0-9_]/', '_', strtolower( $block_slug ) );
	$fn_name   = 'starter_flexible_block_data_' . $fn_suffix;

	if ( is_string( $fn_name ) && function_exists( $fn_name ) ) {
		$data = $fn_name( $block );
	}

	if ( null === $data ) {
		return;
	}

	if ( is_array( $data ) ) {
		$data = (object) $data;
	}

	ob_start();
	include $render_file;
	$html = (string) ob_get_clean();

	echo starter_flexible_decorate_module_markup( $html, $block_slug, $data->spacing_style ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
