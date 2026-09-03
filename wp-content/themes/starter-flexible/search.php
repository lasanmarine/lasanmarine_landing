<?php
/**
 * The template for displaying search results
 *
 * @package Starter_Flexible
 * @since 1.0.0
 */

get_header();
?>

<div class="site-main">
	<div class="container">
		<div class="row">
			<header class="search-header">
				<h1 class="search-title">
					<?php
					printf(
						esc_html__('Search Results for: %s', 'starter-flexible'),
						'<span>' . get_search_query() . '</span>'
					);
					?>
				</h1>
			</header>

			<?php
			if (have_posts()) {
				while (have_posts()) {
					the_post();
					get_template_part('template-parts/content', 'search');
				}

				the_posts_pagination(array(
					'prev_text' => __('Previous', 'starter-flexible'),
					'next_text' => __('Next', 'starter-flexible'),
				));
			} else {
				get_template_part('template-parts/content', 'none');
			}
			?>
		</div>
	</div>
</div>

<?php
get_footer();
