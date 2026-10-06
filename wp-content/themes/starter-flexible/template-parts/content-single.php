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

// Give every h2 an anchor and collect them for the table of contents.
$toc     = array();
$content = (string) apply_filters( 'the_content', get_the_content() ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- core hook.
$content = (string) preg_replace_callback(
	'/<h2([^>]*)>(.*?)<\/h2>/is',
	static function ( array $m ) use ( &$toc ): string {
		$text = trim( wp_strip_all_tags( $m[2] ) );
		if ( '' === $text ) {
			return $m[0];
		}
		if ( preg_match( '/\sid="([^"]+)"/', $m[1], $id ) ) {
			$anchor = $id[1];
			$attrs  = $m[1];
		} else {
			$anchor = 'muc-' . ( count( $toc ) + 1 ) . '-' . sanitize_title( $text );
			$attrs  = $m[1] . ' id="' . esc_attr( $anchor ) . '"';
		}
		$toc[] = array( 'id' => $anchor, 'text' => $text );
		return '<h2' . $attrs . '>' . $m[2] . '</h2>';
	},
	$content
);

$share_url   = rawurlencode( (string) get_permalink() );
$share_title = rawurlencode( get_the_title() );
$news_url    = starter_flexible_content_page_url( 'insights', 'tin-tuc' );
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
				<?php the_post_thumbnail( 'full', starter_flexible_image_priority_attrs( array( 'sizes' => '100vw' ) ) ); ?>
			</div>
			<span class="post-hero__scrim" aria-hidden="true"></span>
		<?php endif; ?>

		<div class="container post-hero__inner">
			<nav class="phead__crumbs" aria-label="<?php esc_attr_e( 'Đường dẫn', 'starter-flexible' ); ?>">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Trang chủ', 'starter-flexible' ); ?></a>
				<?php if ( '' !== $news_url ) : ?>
					<span class="phead__sep" aria-hidden="true">/</span>
					<a href="<?php echo esc_url( $news_url ); ?>"><?php esc_html_e( 'Tin tức', 'starter-flexible' ); ?></a>
				<?php endif; ?>
			</nav>
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

	<div class="container post-single__layout">
		<aside class="post-single__aside">
			<?php if ( count( $toc ) > 1 ) : ?>
				<details class="post-toc" open>
					<summary class="post-toc__head">
						<?php esc_html_e( 'Nội dung bài viết', 'starter-flexible' ); ?>
						<?php echo starter_flexible_icon( 'chevronDown', 18, 'post-toc__chev' ); // phpcs:ignore ?>
					</summary>
					<ol class="post-toc__list" data-toc>
						<?php foreach ( $toc as $entry ) : ?>
							<li><a href="#<?php echo esc_attr( $entry['id'] ); ?>"><?php echo esc_html( $entry['text'] ); ?></a></li>
						<?php endforeach; ?>
					</ol>
				</details>
			<?php endif; ?>

			<div class="post-share">
				<span class="post-share__label"><?php esc_html_e( 'Chia sẻ', 'starter-flexible' ); ?></span>
				<div class="post-share__row">
					<a class="post-share__btn" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_attr( $share_url ); ?>" target="_blank" rel="noopener">Facebook</a>
					<a class="post-share__btn" href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo esc_attr( $share_url ); ?>" target="_blank" rel="noopener">LinkedIn</a>
					<button
						type="button"
						class="post-share__btn"
						data-copy="<?php echo esc_attr( (string) get_permalink() ); ?>"
						data-copied="<?php esc_attr_e( 'Đã chép', 'starter-flexible' ); ?>"
					><span data-copy-label><?php esc_html_e( 'Chép link', 'starter-flexible' ); ?></span></button>
				</div>
			</div>
		</aside>

		<div class="post-single__main">
			<?php if ( has_excerpt() ) : ?>
				<p class="post-single__lead"><?php echo esc_html( get_the_excerpt() ); ?></p>
			<?php endif; ?>

			<div class="post-single__body">
				<?php
				echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- filtered post content.
				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . __( 'Trang:', 'starter-flexible' ),
						'after'  => '</div>',
					)
				);
				?>
			</div>

			<?php if ( ! empty( $post_tags ) ) : ?>
				<footer class="post-single__footer">
					<span class="post-single__tags-label"><?php esc_html_e( 'Thẻ', 'starter-flexible' ); ?></span>
					<div class="post-single__tags">
						<?php foreach ( $post_tags as $tag ) : ?>
							<a class="post-single__tag" href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>">
								<?php echo esc_html( $tag->name ); ?>
							</a>
						<?php endforeach; ?>
					</div>
				</footer>
			<?php endif; ?>

			<div class="post-author">
				<span class="post-author__avatar" aria-hidden="true"><?php echo esc_html( $author_initial ); ?></span>
				<span class="post-author__body">
					<span class="post-author__label"><?php esc_html_e( 'Tác giả', 'starter-flexible' ); ?></span>
					<span class="post-author__name"><?php echo esc_html( $author_name ); ?></span>
					<?php $bio = trim( (string) get_the_author_meta( 'description' ) ); ?>
					<span class="post-author__bio"><?php echo esc_html( '' !== $bio ? $bio : __( 'Đội ngũ kỹ thuật LASAN MARINE — thiết kế tàu, hồ sơ đăng kiểm và nghiên cứu thủy động lực.', 'starter-flexible' ) ); ?></span>
				</span>
			</div>
		</div>
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
			<header class="srch__group-head">
				<h2 class="srch__group-title" id="post-related-title"><?php esc_html_e( 'Bài viết liên quan', 'starter-flexible' ); ?></h2>
				<?php if ( '' !== $news_url ) : ?>
					<a class="link srch__group-more" href="<?php echo esc_url( $news_url ); ?>">
						<?php esc_html_e( 'Xem tất cả', 'starter-flexible' ); ?>
						<?php echo starter_flexible_icon_swap( 'arrow', 18 ); // phpcs:ignore ?>
					</a>
				<?php endif; ?>
			</header>
			<div class="blog__grid">
				<?php foreach ( $related as $related_post ) : ?>
					<?php get_template_part( 'template-parts/components/post-card', null, array( 'post' => $related_post ) ); ?>
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
