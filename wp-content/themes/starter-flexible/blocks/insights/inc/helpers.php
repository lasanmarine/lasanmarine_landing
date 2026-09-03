<?php
/** Insights — native WordPress posts prepared for the render template. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

/** @return array<string, string> */
function starter_flexible_insights_post_data( WP_Post $post, bool $featured = false ): array {
	$categories = get_the_category( $post->ID );
	$category   = null;
	foreach ( $categories as $candidate ) {
		if ( 'bai-viet' !== $candidate->slug ) {
			$category = $candidate;
			break;
		}
	}
	$category = $category ?: ( $categories[0] ?? null );
	$kind     = $category instanceof WP_Term ? mb_strtoupper( (string) $category->name, 'UTF-8' ) : '';
	$image_id   = (int) get_post_thumbnail_id( $post->ID );
	$excerpt    = has_excerpt( $post ) ? $post->post_excerpt : wp_trim_words( wp_strip_all_tags( $post->post_content ), 34 );

	return array(
		'image_url'   => $image_id ? (string) wp_get_attachment_image_url( $image_id, $featured ? 'large' : 'medium_large' ) : '',
		'placeholder' => (string) ( get_post_meta( $post->ID, '_lasan_image_placeholder', true ) ?: get_the_title( $post ) ),
		'kind'        => $kind,
		'date'        => $featured ? get_the_date( 'd.m.Y', $post ) : trim( $kind . ( $kind ? ' · ' : '' ) . get_the_date( 'd.m.Y', $post ) ),
		'title'       => get_the_title( $post ),
		'excerpt'     => (string) $excerpt,
		'url'         => get_permalink( $post ),
	);
}

function starter_flexible_block_data_insights( array $block ) {
	$data = array_merge(
		array(
			'label'          => 'BÀI VIẾT',
			'view_all'       => 'Xem tất cả bài viết',
			'view_all_link'  => array(),
			'read_more'      => 'Đọc tiếp',
			'featured_post'  => 0,
			'category'       => 0,
			'posts_per_page' => 6,
			'custom_class'   => '',
		),
		starter_flexible_get_block_fields( $block )
	);

	$category_id = is_array( $data['category'] ) ? (int) reset( $data['category'] ) : (int) $data['category'];
	if ( ! $category_id ) {
		$default_category = get_term_by( 'slug', 'bai-viet', 'category' );
		$category_id = $default_category instanceof WP_Term ? (int) $default_category->term_id : 0;
	}
	$featured_id = is_object( $data['featured_post'] ) ? (int) $data['featured_post']->ID : (int) $data['featured_post'];
	if ( ! $featured_id ) {
		$featured_posts = get_posts( array( 'post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => 1, 'category' => $category_id, 'meta_key' => '_lasan_featured_insight', 'meta_value' => '1' ) );
		$featured_id = $featured_posts ? (int) $featured_posts[0]->ID : 0;
	}
	if ( ! $featured_id ) {
		$latest = get_posts( array( 'post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => 1, 'category' => $category_id ) );
		$featured_id = $latest ? (int) $latest[0]->ID : 0;
	}

	$query_args = array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => max( 1, min( 12, (int) $data['posts_per_page'] ) ),
		'post__not_in'        => $featured_id ? array( $featured_id ) : array(),
		'ignore_sticky_posts' => true,
	);
	if ( $category_id ) { $query_args['cat'] = $category_id; }

	$featured_post = $featured_id ? get_post( $featured_id ) : null;
	$posts         = get_posts( $query_args );
	$view_all_link = is_array( $data['view_all_link'] ) ? $data['view_all_link'] : array();
	$data['featured']      = $featured_post instanceof WP_Post ? starter_flexible_insights_post_data( $featured_post, true ) : array( 'image_url' => '', 'placeholder' => '', 'kind' => '', 'date' => '', 'title' => '', 'excerpt' => '', 'url' => '' );
	$data['articles']      = array_map( static fn( WP_Post $post ): array => starter_flexible_insights_post_data( $post ), $posts );
	$data['view_all_url']  = ! empty( $view_all_link['url'] ) ? (string) $view_all_link['url'] : home_url( '/tin-tuc/' );
	$data['has_view_all']  = '' !== trim( (string) $data['view_all'] );
	$data['has_read_more'] = '' !== trim( (string) $data['read_more'] ) && '' !== $data['featured']['url'];
	$data['has_featured']  = '' !== $data['featured']['title'];
	$data['module_class']  = starter_flexible_build_module_class( 'block container', (string) $data['custom_class'] );
	$data['should_render'] = $data['has_featured'] || ! empty( $data['articles'] );
	return (object) $data;
}
