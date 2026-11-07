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

/**
 * The ACF block slugs the current page actually renders.
 *
 * Read from the queried post's content (nested and reusable blocks included),
 * plus the listings that draw a block's components straight from a template:
 * the project cards and grid come from the Project Index block's stylesheet.
 *
 * @return array<int, string>
 */
function starter_flexible_page_block_slugs(): array {
	static $slugs = null;
	if ( null !== $slugs ) {
		return $slugs;
	}

	$found   = array();
	$collect = static function ( array $blocks ) use ( &$collect, &$found ): void {
		foreach ( $blocks as $block ) {
			$name = (string) ( $block['blockName'] ?? '' );
			if ( str_starts_with( $name, 'acf/' ) ) {
				$found[ substr( $name, 4 ) ] = true;
			}
			if ( 'core/block' === $name && ! empty( $block['attrs']['ref'] ) ) {
				$collect( parse_blocks( (string) get_post_field( 'post_content', (int) $block['attrs']['ref'] ) ) );
			}
			if ( ! empty( $block['innerBlocks'] ) ) {
				$collect( $block['innerBlocks'] );
			}
		}
	};

	if ( is_singular() ) {
		$collect( parse_blocks( (string) get_post_field( 'post_content', get_queried_object_id() ) ) );
	}

	if ( is_singular( 'project' ) || is_tax( array( 'project_material', 'project_use' ) ) || is_search() || is_404() ) {
		$found['project-index'] = true;
	}

	// What the page itself renders, before stylesheet dependencies are added:
	// this is the list whose islands get preloaded.
	$GLOBALS['starter_flexible_rendered_block_slugs'] = array_keys( $found );

	// The tools share one form vocabulary (`pc__*`, `field__*`) whose rules live
	// in the Power Converter and Engine Lookup stylesheets.
	$tools = array( 'power-converter', 'engine-lookup', 'shaft-diameter', 'design-brief', 'tool-shell' );
	if ( array_intersect( $tools, array_keys( $found ) ) ) {
		$found['power-converter'] = true;
		$found['engine-lookup']   = true;
	}

	/**
	 * Filters the block slugs whose assets load on this page.
	 *
	 * @param array<int, string> $slugs Block slugs, without the `acf/` prefix.
	 */
	$slugs = (array) apply_filters( 'starter_flexible_page_block_slugs', array_keys( $found ) );

	return $slugs;
}

function starter_flexible_vite_enqueue_prod_assets_from_dist( string $dist_dir ): void {
	$theme_dir = defined( 'STARTER_FLEXIBLE_THEME_DIR' ) ? STARTER_FLEXIBLE_THEME_DIR : get_stylesheet_directory();
	$theme_uri = defined( 'STARTER_FLEXIBLE_THEME_URI' ) ? STARTER_FLEXIBLE_THEME_URI : get_stylesheet_directory_uri();
	$used      = array_flip( starter_flexible_page_block_slugs() );

	// A block's own files live under dist/blocks/{slug}/…; they load only on a
	// page that renders that block. Everything else is site-wide.
	$block_of = static function ( string $absolute_path ) use ( $dist_dir ): string {
		$relative = ltrim( str_replace( DIRECTORY_SEPARATOR, '/', substr( $absolute_path, strlen( $dist_dir ) ) ), '/' );
		return preg_match( '#^blocks/([^/]+)/#', $relative, $m ) ? $m[1] : '';
	};

	$css_files = starter_flexible_find_files_recursive( $dist_dir, array( 'css' ) );
	sort( $css_files );

	// Site-wide CSS as ordinary stylesheets; the used blocks' CSS is small, so
	// it is inlined after them instead of costing one blocking request each.
	$main_handle = '';
	$inline_css  = '';
	foreach ( $css_files as $absolute_path ) {
		$block = $block_of( $absolute_path );
		if ( '' !== $block ) {
			if ( isset( $used[ $block ] ) ) {
				$inline_css .= (string) file_get_contents( $absolute_path ) . "\n"; // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- local build file.
			}
			continue;
		}

		$handle = 'starter-flexible-' . sanitize_key( basename( $absolute_path, '.css' ) ) . '-css';
		wp_enqueue_style(
			$handle,
			$theme_uri . str_replace( $theme_dir, '', $absolute_path ),
			array(),
			starter_flexible_file_version( $absolute_path )
		);
		if ( 'app' === basename( $absolute_path, '.css' ) || '' === $main_handle ) {
			$main_handle = $handle;
		}
	}
	if ( '' !== $inline_css && '' !== $main_handle ) {
		wp_add_inline_style( $main_handle, $inline_css );
	}

	// JS: one module entry. Behaviours ship inside app.js; each tool block's
	// Svelte island is a lazy chunk app.js imports when the page has its shell.
	// Those chunks (and the shared runtime) are preloaded for the blocks this
	// page renders, so the lazy import costs no extra round-trip.
	$app = $dist_dir . '/app.js';
	if ( ! is_file( $app ) ) {
		return;
	}

	wp_enqueue_script(
		'starter-flexible-theme-main',
		$theme_uri . str_replace( $theme_dir, '', $app ),
		array(),
		starter_flexible_file_version( $app ),
		true
	);

	add_filter(
		'script_loader_tag',
		static function ( $tag, $handle ) {
			return 'starter-flexible-theme-main' === $handle ? starter_flexible_vite_script_tag_as_module( (string) $tag ) : $tag;
		},
		10,
		2
	);

	$preload = starter_flexible_vite_island_preloads( $dist_dir, (array) ( $GLOBALS['starter_flexible_rendered_block_slugs'] ?? array_keys( $used ) ) );
	if ( $preload ) {
		add_action(
			'wp_head',
			static function () use ( $preload, $theme_uri, $theme_dir ) {
				foreach ( $preload as $file ) {
					printf(
						"<link rel=\"modulepreload\" href=\"%s\" />
",
						esc_url( add_query_arg( 'ver', starter_flexible_file_version( $file ), $theme_uri . str_replace( $theme_dir, '', $file ) ) )
					);
				}
			},
			5
		);
	}
}

/**
 * The JS files a page's islands will import: vendor.js, then for every used
 * block with an island its chunk and that chunk's own imports, read from
 * Vite's manifest.
 *
 * @param array<int, string> $slugs Block slugs on the page.
 * @return array<int, string> Absolute paths.
 */
function starter_flexible_vite_island_preloads( string $dist_dir, array $slugs ): array {
	$manifest_file = $dist_dir . '/.vite/manifest.json';
	if ( ! is_file( $manifest_file ) ) {
		return array();
	}
	$manifest = json_decode( (string) file_get_contents( $manifest_file ), true ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- local build file.
	if ( ! is_array( $manifest ) ) {
		return array();
	}

	$files = array();
	$walk  = static function ( string $key ) use ( &$walk, &$files, $manifest, $dist_dir ): void {
		if ( empty( $manifest[ $key ]['file'] ) ) {
			return;
		}
		// app.js is already the page's script.
		if ( ! empty( $manifest[ $key ]['isEntry'] ) && 'app.js' === $manifest[ $key ]['file'] ) {
			return;
		}
		$path = $dist_dir . '/' . $manifest[ $key ]['file'];
		if ( isset( $files[ $path ] ) ) {
			return;
		}
		$files[ $path ] = true;
		foreach ( (array) ( $manifest[ $key ]['imports'] ?? array() ) as $import ) {
			$walk( (string) $import );
		}
	};

	foreach ( $slugs as $slug ) {
		$walk( '../../blocks/' . $slug . '/assets/island.svelte' );
	}
	if ( ! $files ) {
		return array();
	}
	if ( is_file( $dist_dir . '/vendor.js' ) ) {
		$files = array( $dist_dir . '/vendor.js' => true ) + $files;
	}

	return array_keys( $files );
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
