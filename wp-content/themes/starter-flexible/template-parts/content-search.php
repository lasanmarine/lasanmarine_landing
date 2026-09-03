<?php
/**
 * Template part for displaying search results.
 *
 * @package Starter_Flexible
 * @since 1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post search-result'); ?>>
	<?php if (has_post_thumbnail()) : ?>
		<div class="post-thumbnail">
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail('medium'); ?>
			</a>
		</div>
	<?php endif; ?>

	<div class="search-result__body">
		<header class="entry-header">
			<?php the_title('<h2 class="post-title"><a href="' . esc_url(get_permalink()) . '">', '</a></h2>'); ?>

			<div class="post-meta">
				<span><?php echo get_the_date(); ?></span>
				<?php
				if (has_category()) {
					echo ' | <span>' . get_the_category_list(', ') . '</span>';
				}
				?>
			</div>
		</header>

		<div class="post-content">
			<?php the_excerpt(); ?>
			<a href="<?php the_permalink(); ?>" class="read-more"><?php _e('Read More', 'starter-flexible'); ?></a>
		</div>
	</div>
</article>

