<?php
/**
 * Blog posts index template.
 *
 * @package Starter_Flexible
 * @since 1.0.0
 */

get_header();
?>

<div class="site-main site-main--blog">
	<?php get_template_part( 'template-parts/content', 'blog-list' ); ?>
</div>

<?php
get_footer();
