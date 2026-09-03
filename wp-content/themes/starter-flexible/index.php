<?php
/**
 * The main template file
 *
 * @package Starter_Flexible
 * @since 1.0.0
 */

get_header();
?>

<div class="site-main">
	<div class="container">
		<div class="row">
			<?php get_template_part('template-parts/content', 'blog-list'); ?>
		</div>
	</div>
</div>

<?php
get_footer();
