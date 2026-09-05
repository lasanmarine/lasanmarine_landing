<?php
/** Render current editor blocks for Yoast without saving or changing scores. */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'rest_api_init', function () {
	register_rest_route( 'lasan/v1', '/seo-content/(?P<id>\d+)', array(
		'methods'             => 'POST',
		'permission_callback' => function ( WP_REST_Request $request ) {
			return current_user_can( 'edit_post', (int) $request['id'] );
		},
		'args'                => array(
			'content' => array( 'type' => 'string', 'required' => true ),
		),
		'callback'            => 'starter_flexible_seo_analysis_content',
	) );
} );

function starter_flexible_seo_analysis_content( WP_REST_Request $request ) {
	$post = get_post( (int) $request['id'] );
	if ( ! $post || ! in_array( $post->post_type, array( 'page', 'post' ), true ) ) {
		return new WP_Error( 'invalid_post', 'Invalid post.', array( 'status' => 404 ) );
	}
	$previous_post = $GLOBALS['post'] ?? null;
	$GLOBALS['post'] = $post;
	setup_postdata( $post );
	try {
		// Dynamic ACF blocks receive current unsaved attributes and post context.
		$html = do_blocks( $request->get_param( 'content' ) );
		$html = preg_replace( '#<(script|style)\b[^>]*>.*?</\1>#is', '', $html );
		return rest_ensure_response( array( 'html' => $html ) );
	} finally {
		$GLOBALS['post'] = $previous_post;
		if ( $previous_post instanceof WP_Post ) {
			setup_postdata( $previous_post );
		} else {
			wp_reset_postdata();
		}
	}
}

add_action( 'enqueue_block_editor_assets', function () {
	if ( ! defined( 'WPSEO_VERSION' ) ) {
		return;
	}
	$path = '/assets/js/seo-analysis.js';
	wp_enqueue_script(
		'lasan-seo-analysis',
		get_stylesheet_directory_uri() . $path,
		array( 'wp-data', 'wp-api-fetch', 'jquery' ),
		(string) filemtime( get_stylesheet_directory() . $path ),
		true
	);
} );
