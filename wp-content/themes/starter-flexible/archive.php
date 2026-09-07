<?php
/**
 * The template for displaying archive pages
 *
 * @package Starter_Flexible
 * @since 1.0.0
 */

get_header();
?>

<?php if ( is_post_type_archive( 'post' ) || is_category() || is_tag() || is_author() || is_date() ) : ?>
	<?php /* The listing is full-bleed: its own navy header, its own container. */ ?>
	<div class="site-main site-main--blog">
		<?php get_template_part( 'template-parts/content', 'blog-list' ); ?>
	</div>
<?php else : ?>
<div class="site-main">
	<div class="container">
		<div class="row">
			<?php if ( true ) : ?>
				<header class="archive-header">
					<?php
					the_archive_title( '<h1 class="archive-title">', '</h1>' );
					the_archive_description( '<div class="archive-description">', '</div>' );
					?>
				</header>

				<?php
				if ( have_posts() ) {
					?>
					<div class="posts-grid">
						<?php
						while ( have_posts() ) {
							the_post();
							get_template_part( 'template-parts/content', get_post_type() );
						}
						?>
					</div>
					<?php
					the_posts_pagination(
						array(
							'prev_text' => __( 'Previous', 'starter-flexible' ),
							'next_text' => __( 'Next', 'starter-flexible' ),
						)
					);
				} else {
					get_template_part( 'template-parts/content', 'none' );
				}
				?>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php endif; ?>

<?php
get_footer();
