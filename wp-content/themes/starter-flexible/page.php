<?php
/**
 * The template for displaying all pages.
 *
 * Pages are built from the LASAN blocks, and several of them are full-bleed
 * bands that supply their own `.container`. So the content is printed bare:
 * header.php has already opened <main>, and any wrapper here would both nest a
 * second <main> and pin the navy bands to the content column.
 *
 * @package Starter_Flexible
 * @since 1.0.0
 */

get_header();

echo '<div class="block-stream">';

while ( have_posts() ) {
	the_post();
	the_content();
	wp_link_pages(
		array(
			'before' => '<div class="container page-links">' . esc_html__( 'Trang:', 'starter-flexible' ),
			'after'  => '</div>',
		)
	);
}

echo '</div>';

get_footer();
