<?php
/**
 * Template part for displaying single posts.
 *
 * @package Starter_Flexible
 * @since 1.0.0
 */

$post_categories = array_values( array_filter( get_the_category(), static fn( WP_Term $term ): bool => 'bai-viet' !== $term->slug ) );
$post_tags       = get_the_tags();
$plain_content   = trim( wp_strip_all_tags( (string) get_post_field( 'post_content', get_the_ID() ) ) );
$words           = '' === $plain_content ? array() : preg_split( '/\s+/u', $plain_content );
$word_count      = is_array( $words ) ? count( $words ) : 0;
$reading_time    = max( 1, (int) ceil( $word_count / 180 ) );
$placeholder     = (string) get_post_meta( get_the_ID(), '_lasan_image_placeholder', true );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-single' ); ?>>

	<header class="post-single__header">
		<div class="post-single__intro">
			<span class="post-single__eyebrow"><?php esc_html_e( 'GHI CHÚ KỸ THUẬT', 'starter-flexible' ); ?></span>
			<?php if ( ! empty( $post_categories ) ) : ?>
				<div class="post-single__cats">
					<?php foreach ( $post_categories as $category ) : ?>
						<a class="post-single__cat-link" href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>"><?php echo esc_html( $category->name ); ?></a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
			<h1 class="post-single__title"><?php the_title(); ?></h1>
			<?php if ( has_excerpt() ) : ?>
				<p class="post-single__lead"><?php echo esc_html( get_the_excerpt() ); ?></p>
			<?php endif; ?>
		</div>

		<div class="post-single__meta">
			<span><?php echo esc_html( get_the_date() ); ?></span>
			<span class="post-single__sep">/</span>
			<span><?php printf( esc_html__( '%d phút đọc', 'starter-flexible' ), $reading_time ); ?></span>
			<span class="post-single__sep">/</span>
			<span><?php echo esc_html( get_the_author() ); ?></span>
		</div>
	</header>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="post-single__thumb">
			<?php the_post_thumbnail( 'full', array( 'class' => 'post-single__image' ) ); ?>
		</div>
	<?php else : ?>
		<div class="post-single__thumb post-single__thumb--placeholder" role="img" aria-label="<?php echo esc_attr( $placeholder ?: get_the_title() ); ?>">
			<?php echo esc_html( $placeholder ?: get_the_title() ); ?>
		</div>
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
	<section class="post-related" aria-labelledby="post-related-title">
		<h2 class="post-related__head" id="post-related-title"><?php esc_html_e( 'BÀI VIẾT LIÊN QUAN', 'starter-flexible' ); ?></h2>
		<div class="post-related__grid">
			<?php foreach ( $related as $related_post ) : ?>
				<a class="post-related__item" href="<?php echo esc_url( get_permalink( $related_post ) ); ?>">
					<span class="post-related__date"><?php echo esc_html( get_the_date( 'd.m.Y', $related_post ) ); ?></span>
					<span class="post-related__title"><?php echo esc_html( get_the_title( $related_post ) ); ?></span>
					<span class="post-related__arrow" aria-hidden="true"><?php echo starter_flexible_icon( 'arrow', 18 ); // phpcs:ignore ?></span>
				</a>
			<?php endforeach; ?>
		</div>
	</section>
<?php endif; ?>

<nav class="post-nav">
	<?php
	the_post_navigation(
		array(
			'prev_text'    => '<span class="post-nav__label">' . __( '← Bài trước', 'starter-flexible' ) . '</span><span class="post-nav__title">%title</span>',
			'next_text'    => '<span class="post-nav__label">' . __( 'Bài tiếp →', 'starter-flexible' ) . '</span><span class="post-nav__title">%title</span>',
			'in_same_term' => true,
			'taxonomy'     => 'category',
		)
	);
	?>
</nav>

<section class="post-single__cta">
	<h2><?php esc_html_e( 'Cần trao đổi về một bài toán kỹ thuật cụ thể?', 'starter-flexible' ); ?></h2>
	<a class="btn" href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>">
		<?php esc_html_e( 'Liên hệ kỹ sư Lasan Marine', 'starter-flexible' ); ?>
		<?php echo starter_flexible_icon( 'arrowUpRight', 18 ); // phpcs:ignore ?>
	</a>
</section>

<?php
if ( comments_open() || get_comments_number() ) {
	comments_template();
}
