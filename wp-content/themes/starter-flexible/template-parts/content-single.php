<?php
/**
 * Template part for displaying single posts.
 *
 * @package Starter_Flexible
 * @since 1.0.0
 */

$post_categories = array_values( array_filter( get_the_category(), static fn( WP_Term $term ): bool => 'bai-viet' !== $term->slug ) );
$post_tags        = get_the_tags();
$plain_content    = trim( wp_strip_all_tags( (string) get_post_field( 'post_content', get_the_ID() ) ) );
$words            = '' === $plain_content ? array() : preg_split( '/\s+/u', $plain_content );
$word_count       = is_array( $words ) ? count( $words ) : 0;
$reading_time     = max( 1, (int) ceil( $word_count / 180 ) );
$placeholder      = (string) get_post_meta( get_the_ID(), '_lasan_image_placeholder', true );
$author_name      = get_the_author();
$author_initial   = mb_strtoupper( mb_substr( $author_name, 0, 1 ) );
?>

<?php
get_template_part(
	'template-parts/components/reading-bar',
	null,
	array( 'title' => get_the_title(), 'byline' => $author_name )
);
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-single' ); ?>>

	<?php /* The photograph carries the title and the byline, so the article
	         opens on the subject rather than on a stack of labels. */ ?>
	<header class="post-hero<?php echo has_post_thumbnail() ? '' : ' post-hero--flat'; ?>">
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="post-hero__media">
				<?php the_post_thumbnail( 'full' ); ?>
			</div>
			<span class="post-hero__scrim" aria-hidden="true"></span>
		<?php endif; ?>

		<div class="container post-hero__inner">
			<div class="post-hero__badges">
				<?php foreach ( $post_categories as $category ) : ?>
					<a class="post-hero__cat" href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>"><?php echo esc_html( $category->name ); ?></a>
				<?php endforeach; ?>
			</div>

			<h1 class="post-hero__title"><?php the_title(); ?></h1>

			<ul class="post-hero__meta">
				<li>
					<span class="post-hero__avatar" aria-hidden="true"><?php echo esc_html( $author_initial ); ?></span>
					<?php echo esc_html( $author_name ); ?>
				</li>
				<li><time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date( 'd/m/Y' ) ); ?></time></li>
				<li><?php printf( esc_html__( '%d phút đọc', 'starter-flexible' ), $reading_time ); ?></li>
			</ul>
		</div>
	</header>

	<div class="container post-single__wrap">
		<?php if ( has_excerpt() ) : ?>
			<p class="post-single__lead"><?php echo esc_html( get_the_excerpt() ); ?></p>
		<?php endif; ?>

	<div class="post-single__body">
		<?php
		the_content();
		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'starter-flexible' ),
				'after'  => '</div>',
			)
		);
		?>
	</div>

	<?php if ( ! empty( $post_tags ) ) : ?>
		<footer class="post-single__footer">
			<span class="post-single__tags-label"><?php esc_html_e( 'Tags', 'starter-flexible' ); ?></span>
			<div class="post-single__tags">
				<?php foreach ( $post_tags as $tag ) : ?>
					<a class="post-single__tag" href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>">
						<?php echo esc_html( $tag->name ); ?>
					</a>
				<?php endforeach; ?>
			</div>
		</footer>
	<?php endif; ?>
	</div>

</article>

<?php
$related = get_posts(
	array(
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'posts_per_page' => 3,
		'post__not_in'   => array( get_the_ID() ),
		'category__in'   => wp_get_post_categories( get_the_ID() ),
	)
);
if ( $related ) :
	?>
	<?php /* The article is set to a reading measure; what follows it is not —
	         the related posts take the page's own width. */ ?>
	<section class="post-related" aria-labelledby="post-related-title">
		<div class="container">
			<h2 class="post-related__head" id="post-related-title"><?php esc_html_e( 'Bài viết liên quan', 'starter-flexible' ); ?></h2>
			<div class="post-related__grid" data-reveal-stagger>
				<?php foreach ( $related as $related_post ) : ?>
					<a class="post-related__item" href="<?php echo esc_url( get_permalink( $related_post ) ); ?>">
						<span class="post-related__figure">
							<?php if ( has_post_thumbnail( $related_post ) ) : ?>
								<?php echo get_the_post_thumbnail( $related_post, 'medium_large', array( 'class' => 'post-related__image', 'loading' => 'lazy' ) ); ?>
							<?php else : ?>
								<span class="post-related__placeholder"></span>
							<?php endif; ?>
						</span>
						<span class="post-related__body">
							<span class="post-related__date"><?php echo esc_html( get_the_date( 'd.m.Y', $related_post ) ); ?></span>
							<span class="post-related__title"><?php echo esc_html( get_the_title( $related_post ) ); ?></span>
						</span>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
<?php endif; ?>

<nav class="post-nav">
	<div class="container">
	<?php
	the_post_navigation(
		array(
			'prev_text'    => '<span class="post-nav__icon">' . starter_flexible_icon( 'arrowLeft', 18 ) . '</span><span class="post-nav__copy"><span class="post-nav__label">' . __( 'Bài trước', 'starter-flexible' ) . '</span><span class="post-nav__title">%title</span></span>',
			'next_text'    => '<span class="post-nav__copy post-nav__copy--right"><span class="post-nav__label">' . __( 'Bài tiếp', 'starter-flexible' ) . '</span><span class="post-nav__title">%title</span></span><span class="post-nav__icon">' . starter_flexible_icon( 'arrow', 18 ) . '</span>',
			'in_same_term' => true,
			'taxonomy'     => 'category',
		)
	);
	?>
	</div>
</nav>

<?php
if ( comments_open() || get_comments_number() ) {
	comments_template();
}
