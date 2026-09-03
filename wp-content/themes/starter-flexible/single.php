<?php
/**
 * The template for displaying single posts
 *
 * @package Starter_Flexible
 * @since 1.0.0
 */

get_header();
?>

<div class="site-main site-main--single">
	<div class="container">
		<?php
		while ( have_posts() ) {
			the_post();
			get_template_part( 'template-parts/content', 'single' );
		}
		?>
	</div>
</div>

<?php
get_footer();
