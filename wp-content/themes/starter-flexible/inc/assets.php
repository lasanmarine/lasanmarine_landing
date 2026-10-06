<?php
/**
 * Frontend assets (CSS/JS).
 *
 * @package Starter_Flexible
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function starter_flexible_enqueue_theme_style(): void {
	$style_path = ( defined( 'STARTER_FLEXIBLE_THEME_DIR' ) ? STARTER_FLEXIBLE_THEME_DIR : get_stylesheet_directory() ) . '/style.css';

	wp_enqueue_style(
		'starter-flexible-theme-style',
		get_stylesheet_uri(),
		array(),
		starter_flexible_file_version( $style_path )
	);
}

function starter_flexible_enqueue_frontend_assets(): void {
	// Manrope and Be Vietnam Pro are bundled by Vite (see fe/src/styles/_base.scss),
	// so there is no webfont host to call out to.
	starter_flexible_vite_enqueue_assets();
	starter_flexible_enqueue_theme_style();

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'starter_flexible_enqueue_frontend_assets' );

function starter_flexible_enqueue_editor_assets(): void {
	if ( ! is_admin() || ! function_exists( 'get_current_screen' ) ) {
		return;
	}

	$screen = get_current_screen();
	if ( ! $screen || ! method_exists( $screen, 'is_block_editor' ) || ! $screen->is_block_editor() ) {
		return;
	}

	starter_flexible_vite_enqueue_editor_styles();
	starter_flexible_enqueue_targeted_admin_editor_overrides( $screen );
	starter_flexible_enqueue_targeted_admin_editor_scripts( $screen );
}
add_action( 'enqueue_block_assets', 'starter_flexible_enqueue_editor_assets' );

/**
 * Apply targeted admin editor overrides for a specific post edit screen.
 */
function starter_flexible_enqueue_targeted_admin_editor_overrides( WP_Screen $screen ): void {
	if ( 'post' !== $screen->base ) {
		return;
	}

	$css = <<<'CSS'
.wp-block-post-title {
	font-size: 50px !important;
	font-weight: 700 !important;
	line-height: 1.15 !important;
}

.editor-styles-wrapper {
	--wp--style--global--content-size: 1560px;
	--wp--style--global--wide-size: 1560px;
	--starter-flexible-editor-width: 1560px;
	box-sizing: border-box;
	padding-inline: 24px;
}

.editor-styles-wrapper .is-root-container,
.block-editor-block-list__layout.is-root-container,
.editor-visual-editor__post-title-wrapper {
	box-sizing: border-box;
	width: 100% !important;
	max-width: var(--starter-flexible-editor-width) !important;
	margin-left: auto !important;
	margin-right: auto !important;
}

.editor-styles-wrapper .is-root-container > .wp-block,
.block-editor-block-list__layout.is-root-container > .wp-block {
	width: 100% !important;
	max-width: none !important;
	margin-left: 0 !important;
	margin-right: 0 !important;
}

.interface-interface-skeleton__content,
.editor-visual-editor,
.block-editor-block-canvas,
.edit-post-visual-editor__content-area {
	width: 100% !important;
	max-width: none !important;
}
CSS;

	wp_add_inline_style( 'wp-edit-blocks', $css );
}

/**
 * Enqueue built frontend scripts on the targeted editor screen.
 */
function starter_flexible_enqueue_targeted_admin_editor_scripts( WP_Screen $screen ): void {
	if ( 'post' !== $screen->base ) {
		return;
	}

	$theme_dir = defined( 'STARTER_FLEXIBLE_THEME_DIR' ) ? STARTER_FLEXIBLE_THEME_DIR : get_stylesheet_directory();
	$theme_uri = defined( 'STARTER_FLEXIBLE_THEME_URI' ) ? STARTER_FLEXIBLE_THEME_URI : get_stylesheet_directory_uri();
	$dist_dir  = $theme_dir . STARTER_FLEXIBLE_VITE_DIST_DIR;

	$scripts = array(
		'starter-flexible-admin-vendor' => $dist_dir . '/vendor.js',
		'starter-flexible-admin-app'    => $dist_dir . '/app.js',
	);

	$enqueued_handles = array();

	foreach ( $scripts as $handle => $absolute_path ) {
		if ( ! is_file( $absolute_path ) ) {
			continue;
		}

		$relative_path = str_replace( $theme_dir, '', $absolute_path );
		wp_enqueue_script(
			$handle,
			$theme_uri . $relative_path,
			array(),
			starter_flexible_file_version( $absolute_path ),
			true
		);

		$enqueued_handles[] = $handle;
	}

	if ( ! $enqueued_handles ) {
		return;
	}

	add_filter(
		'script_loader_tag',
		static function ( $tag, $handle ) use ( $enqueued_handles ) {
			if ( in_array( $handle, $enqueued_handles, true ) ) {
				return starter_flexible_vite_script_tag_as_module( (string) $tag );
			}
			return $tag;
		},
		10,
		2
	);
}

/**
 * Whether the current page renders a Contact Form 7 form: the enquiry and
 * design-brief blocks embed one, and an editor may drop a shortcode or the
 * form's own block into any page.
 */
function starter_flexible_page_has_form(): bool {
	if ( array_intersect( array( 'enquiry-form', 'design-brief' ), starter_flexible_page_block_slugs() ) ) {
		return true;
	}

	if ( is_singular() ) {
		$content = (string) get_post_field( 'post_content', get_queried_object_id() );
		return str_contains( $content, '[contact-form-7' ) || str_contains( $content, 'wp:contact-form-7' );
	}

	return false;
}

/**
 * Contact Form 7 and its conditional-fields add-on load their CSS, their JS
 * and jQuery on every page. Only a page with a form needs any of it; elsewhere
 * those files are render-blocking weight for nothing.
 */
function starter_flexible_dequeue_unused_form_assets(): void {
	if ( is_admin() || starter_flexible_page_has_form() ) {
		return;
	}

	foreach ( array( 'contact-form-7', 'swv', 'wpcf7cf-scripts', 'wpcf7-recaptcha', 'google-recaptcha' ) as $handle ) {
		wp_dequeue_script( $handle );
	}
	foreach ( array( 'contact-form-7', 'cf7cf-style' ) as $handle ) {
		wp_dequeue_style( $handle );
	}
}
add_action( 'wp_enqueue_scripts', 'starter_flexible_dequeue_unused_form_assets', 100 );
