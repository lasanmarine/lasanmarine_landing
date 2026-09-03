<?php
/**
 * Template part for displaying pages
 *
 * @package Starter_Flexible
 * @since 1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>

	<?php if (has_post_thumbnail()) : ?>
		<div class="post-thumbnail">
			<?php the_post_thumbnail('large'); ?>
		</div>
	<?php endif; ?>

	<div class="post-content">
		<?php
		the_content();
		wp_link_pages(array(
			'before' => '<div class="page-links">' . __('Pages:', 'starter-flexible'),
			'after' => '</div>',
		));
		?>
	</div>
</article>

<?php
if (comments_open() || get_comments_number()) {
	comments_template();
}
?>

