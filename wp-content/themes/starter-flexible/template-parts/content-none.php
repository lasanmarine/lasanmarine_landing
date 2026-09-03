<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @package Starter_Flexible
 * @since 1.0.0
 */
?>

<section class="no-results not-found">
	<header class="page-header">
		<h1 class="page-title"><?php _e('Nothing Found', 'starter-flexible'); ?></h1>
	</header>

	<div class="page-content">
		<?php if (is_home() && current_user_can('publish_posts')) : ?>
			<p>
				<?php
				printf(
					wp_kses(
						__('Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'starter-flexible'),
						array(
							'a' => array(
								'href' => array(),
							),
						)
					),
					esc_url(admin_url('post-new.php'))
				);
				?>
			</p>
		<?php elseif (is_search()) : ?>
			<p><?php _e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'starter-flexible'); ?></p>
			<?php get_search_form(); ?>
		<?php else : ?>
			<p><?php _e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'starter-flexible'); ?></p>
			<?php get_search_form(); ?>
		<?php endif; ?>
	</div>
</section>

