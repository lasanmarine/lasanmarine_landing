<?php
/**
 * Vite integration (dev server + production dist).
 *
 * @package Starter_Flexible
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Vite dev server URL.
const STARTER_FLEXIBLE_VITE_DEV_SERVER = 'http://localhost:5173';

// Vite entry path (relative to Vite root).
const STARTER_FLEXIBLE_VITE_ENTRY = '/main.js';

// Build output directory (relative to theme root).
const STARTER_FLEXIBLE_VITE_DIST_DIR = '/fe/dist';

// Dev flag files (relative to theme root).
// Prefer `fe/.vite-dev` (written by Vite config); keep `/.vite-dev` for backward compatibility.
const STARTER_FLEXIBLE_VITE_DEV_FLAG_FE = '/fe/.vite-dev';
const STARTER_FLEXIBLE_VITE_DEV_FLAG_THEME = '/.vite-dev';

/**
 * Determine whether to use the Vite dev server.
 *
 * Priority:
 * - If a dev-flag file exists (preferred `fe/.vite-dev`): use dev only when the dev server responds.
 * - Otherwise: don't probe (use production assets from `fe/dist`).
 */
function starter_flexible_vite_is_dev_mode(): bool {
	$theme_dir = defined( 'STARTER_FLEXIBLE_THEME_DIR' ) ? STARTER_FLEXIBLE_THEME_DIR : get_stylesheet_directory();

	$has_flag = is_file( $theme_dir . STARTER_FLEXIBLE_VITE_DEV_FLAG_FE ) || is_file( $theme_dir . STARTER_FLEXIBLE_VITE_DEV_FLAG_THEME );
	if ( ! $has_flag ) {
		return false;
	}

	$dev_server_url = STARTER_FLEXIBLE_VITE_DEV_SERVER . '/@vite/client';

	$context = stream_context_create(
		array(
			'http' => array(
				'method'  => 'GET',
				'timeout' => 0.2,
			),
		)
	);

	$handle = @fopen( $dev_server_url, 'r', false, $context );
	if ( false === $handle ) {
		return false;
	}

	fclose( $handle );
	return true;
}

/**
 * Enqueue Vite assets (dev or prod).
 */
function starter_flexible_vite_enqueue_assets(): void {
	if ( starter_flexible_vite_is_dev_mode() ) {
		starter_flexible_vite_enqueue_dev_assets();
		return;
	}

	$theme_dir = defined( 'STARTER_FLEXIBLE_THEME_DIR' ) ? STARTER_FLEXIBLE_THEME_DIR : get_stylesheet_directory();
	$dist_dir  = $theme_dir . STARTER_FLEXIBLE_VITE_DIST_DIR;

	if ( is_dir( $dist_dir ) ) {
		starter_flexible_vite_enqueue_prod_assets_from_dist( $dist_dir );
		return;
	}

	// Fallback to dev when dist isn't available (useful on fresh setups).
	starter_flexible_vite_enqueue_dev_assets();
}

function starter_flexible_vite_enqueue_dev_assets(): void {
	$vite_base = STARTER_FLEXIBLE_VITE_DEV_SERVER;
	$entry     = STARTER_FLEXIBLE_VITE_ENTRY;

	if ( function_exists( 'wp_enqueue_script_module' ) ) {
		wp_enqueue_script_module( 'starter-flexible-vite-client', $vite_base . '/@vite/client', array(), null );
		wp_enqueue_script_module(
			'starter-flexible-theme-main',
			$vite_base . $entry,
			array( 'starter-flexible-vite-client' ),
			null
		);
		return;
	}

	wp_enqueue_script( 'starter-flexible-vite-client', $vite_base . '/@vite/client', array(), null, false );
	wp_enqueue_script(
		'starter-flexible-theme-main',
		$vite_base . $entry,
		array( 'starter-flexible-vite-client' ),
		null,
		false
	);

	add_filter(
		'script_loader_tag',
		static function ( $tag, $handle ) {
			if ( in_array( $handle, array( 'starter-flexible-vite-client', 'starter-flexible-theme-main' ), true ) ) {
				$tag = starter_flexible_vite_script_tag_as_module( (string) $tag );
			}
			return $tag;
		},
		10,
		2
	);
}

/**
 * Force a script tag to be a module, even if WordPress outputs `type="text/javascript"`.
 *
 * Older WP versions may include `type="text/javascript"` by default; Vite build output
 * requires `type="module"` so `import` statements work in production.
 */
function starter_flexible_vite_script_tag_as_module( string $tag ): string {
	if ( false !== strpos( $tag, 'type=' ) ) {
		$tag = (string) preg_replace( '/\stype=(["\']).*?\\1/', ' type="module"', $tag, 1 );
		return $tag;
	}

	return str_replace( '<script ', '<script type="module" ', $tag );
}

function starter_flexible_vite_enqueue_prod_assets_from_dist( string $dist_dir ): void {
	$theme_dir = defined( 'STARTER_FLEXIBLE_THEME_DIR' ) ? STARTER_FLEXIBLE_THEME_DIR : get_stylesheet_directory();
	$theme_uri = defined( 'STARTER_FLEXIBLE_THEME_URI' ) ? STARTER_FLEXIBLE_THEME_URI : get_stylesheet_directory_uri();

	$css_files = starter_flexible_find_files_recursive( $dist_dir, array( 'css' ) );
	$js_files  = starter_flexible_find_files_recursive( $dist_dir, array( 'js' ) );

	sort( $css_files );
	sort( $js_files );

	// Enqueue CSS (preload + noscript for the first file).
	foreach ( $css_files as $index => $absolute_path ) {
		$relative_path = str_replace( $theme_dir, '', $absolute_path );
		$handle        = 'starter-flexible-main-css' . ( $index ? '-' . $index : '' );

		if ( 0 === $index ) {
			add_action(
				'wp_head',
				static function () use ( $theme_uri, $relative_path ) {
					echo '<link rel="preload" href="' . esc_url( $theme_uri . $relative_path ) . '" as="style" onload="this.onload=null;this.rel=\'stylesheet\'">' . "\n";
					echo '<noscript><link rel="stylesheet" href="' . esc_url( $theme_uri . $relative_path ) . '"></noscript>' . "\n";
				},
				1
			);
		}

		wp_enqueue_style(
			$handle,
			$theme_uri . $relative_path,
			array(),
			starter_flexible_file_version( $absolute_path )
		);
	}

	// Enqueue JS (vendor-like files first if present).
	usort(
		$js_files,
		static function ( string $a, string $b ): int {
			$an = basename( $a );
			$bn = basename( $b );

			if ( false !== strpos( $an, 'vendor' ) && false === strpos( $bn, 'vendor' ) ) {
				return -1;
			}

			if ( false !== strpos( $bn, 'vendor' ) && false === strpos( $an, 'vendor' ) ) {
				return 1;
			}

			return strcmp( $an, $bn );
		}
	);

	$module_handles = array();

	foreach ( $js_files as $index => $absolute_path ) {
		$relative_path = str_replace( $theme_dir, '', $absolute_path );
		$handle        = 0 === $index ? 'starter-flexible-theme-main' : 'starter-flexible-theme-main-' . $index;

		wp_enqueue_script(
			$handle,
			$theme_uri . $relative_path,
			array(),
			starter_flexible_file_version( $absolute_path ),
			true
		);

		$module_handles[] = $handle;
	}

	if ( $module_handles ) {
		add_filter(
			'script_loader_tag',
			static function ( $tag, $handle ) use ( $module_handles ) {
				if ( in_array( $handle, $module_handles, true ) ) {
					return starter_flexible_vite_script_tag_as_module( (string) $tag );
				}
				return $tag;
			},
			10,
			2
		);
	}
}

function starter_flexible_vite_enqueue_editor_styles(): void {
	$theme_dir = defined( 'STARTER_FLEXIBLE_THEME_DIR' ) ? STARTER_FLEXIBLE_THEME_DIR : get_stylesheet_directory();
	$theme_uri = defined( 'STARTER_FLEXIBLE_THEME_URI' ) ? STARTER_FLEXIBLE_THEME_URI : get_stylesheet_directory_uri();
	$dist_dir  = $theme_dir . STARTER_FLEXIBLE_VITE_DIST_DIR;

	if ( ! is_dir( $dist_dir ) ) {
		return;
	}

	$css_files = starter_flexible_find_files_recursive( $dist_dir, array( 'css' ) );
	sort( $css_files );

	foreach ( $css_files as $index => $absolute_path ) {
		$relative_path = str_replace( $theme_dir, '', $absolute_path );
		$handle        = 'starter-flexible-editor-css' . ( $index ? '-' . $index : '' );

		wp_enqueue_style(
			$handle,
			$theme_uri . $relative_path,
			array(),
			starter_flexible_file_version( $absolute_path )
		);
	}
}
