<?php
/**
 * Template part for displaying posts
 *
 * @package Starter_Flexible
 * @since 1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
	<?php if (!is_singular()) : ?>
	<header class="entry-header">
		<?php the_title('<h2 class="post-title"><a href="' . esc_url(get_permalink()) . '">', '</a></h2>'); ?>

		<div class="post-meta">
			<span><?php echo get_the_date(); ?></span>
			<?php
			if (has_category()) {
				echo ' | <span>' . get_the_category_list(', ') . '</span>';
			}
			if (has_tag()) {
				echo ' | <span>' . get_the_tag_list('', ', ') . '</span>';
			}
			?>
		</div>
	</header>
	<?php endif; ?>

	<?php if (has_post_thumbnail()) : ?>
		<div class="post-thumbnail">
			<?php
			if (is_singular()) {
				the_post_thumbnail('large');
			} else {
				?>
				<a href="<?php the_permalink(); ?>">
					<?php the_post_thumbnail('large'); ?>
				</a>
				<?php
			}
			?>
		</div>
	<?php endif; ?>

	<div class="post-content">
		<?php
		if (is_singular()) {
			the_content();
			wp_link_pages(array(
				'before' => '<div class="page-links">' . __('Pages:', 'starter-flexible'),
				'after' => '</div>',
			));
		} else {
			the_excerpt();
			?>
			<a href="<?php the_permalink(); ?>" class="read-more"><?php _e('Read More', 'starter-flexible'); ?></a>
			<?php
		}
		?>
	</div>
</article>

