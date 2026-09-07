<?php
/**
 * The blog listing — the posts index and every post archive (category, tag,
 * author, date, search).
 *
 * It opens on the same navy header every inner page uses, so an archive is not
 * a different-looking corner of the site, then lists the posts on the page's
 * own grid.
 *
 * @package Starter_Flexible
 * @since 1.0.0
 */

$eyebrow     = '';
$title       = __( 'Bài viết', 'starter-flexible' );
$description = __( 'Tin tức, cập nhật công trình và các góc nhìn kỹ thuật từ đội ngũ LASAN MARINE.', 'starter-flexible' );

if ( is_category() ) {
	$eyebrow = __( 'Danh mục', 'starter-flexible' );
	$title   = single_cat_title( '', false );
} elseif ( is_tag() ) {
	$eyebrow = __( 'Thẻ', 'starter-flexible' );
	$title   = single_tag_title( '', false );
} elseif ( is_author() ) {
	$eyebrow = __( 'Tác giả', 'starter-flexible' );
	$title   = get_the_author();
} elseif ( is_search() ) {
	$eyebrow = __( 'Tìm kiếm', 'starter-flexible' );
	$title   = get_search_query();
} elseif ( is_archive() ) {
	// Dates and anything else: the stock title, minus the markup it carries.
	$eyebrow = __( 'Lưu trữ', 'starter-flexible' );
	$title   = wp_strip_all_tags( get_the_archive_title() );
} elseif ( is_home() && ! is_front_page() ) {
	$posts_page = (int) get_option( 'page_for_posts' );
	if ( $posts_page ) {
		$title = get_the_title( $posts_page );
	}
}

// An archive's own description wins over the standing blurb.
$archive_description = trim( wp_strip_all_tags( (string) get_the_archive_description() ) );
if ( '' !== $archive_description ) {
	$description = $archive_description;
}

if ( is_search() ) {
	$found       = (int) $GLOBALS['wp_query']->found_posts;
	$description = sprintf(
		/* translators: %d: number of results. */
		_n( '%d bài viết khớp với từ khóa.', '%d bài viết khớp với từ khóa.', $found, 'starter-flexible' ),
		$found
	);
}
?>

<?php
// Trang chủ / Tin tức / <danh mục> — the same three-level trail the project
// taxonomies use.
$crumbs    = array( array( 'label' => __( 'Trang chủ', 'starter-flexible' ), 'url' => home_url( '/' ) ) );
$news_url  = starter_flexible_content_page_url( 'insights', 'tin-tuc' );
$news_name = __( 'Tin tức', 'starter-flexible' );
if ( '' !== $news_url && ! ( is_home() && ! is_front_page() ) ) {
	$crumbs[] = array( 'label' => $news_name, 'url' => $news_url );
}
$crumbs[] = array( 'label' => '' !== $title ? $title : $news_name, 'url' => '' );

ob_start();
?>
<form class="blog__search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
	<label class="screen-reader-text" for="blog-search"><?php esc_html_e( 'Tìm bài viết', 'starter-flexible' ); ?></label>
	<input
		class="blog__search-input"
		id="blog-search"
		type="search"
		name="s"
		value="<?php echo esc_attr( get_search_query() ); ?>"
		placeholder="<?php esc_attr_e( 'Tìm bài viết…', 'starter-flexible' ); ?>"
	/>
	<button class="blog__search-btn" type="submit" aria-label="<?php esc_attr_e( 'Tìm', 'starter-flexible' ); ?>">
		<?php echo starter_flexible_icon( 'search', 18 ); // phpcs:ignore ?>
	</button>
</form>
<?php
$search_form = (string) ob_get_clean();

get_template_part(
	'template-parts/components/page-head',
	null,
	array(
		'crumbs'  => $crumbs,
		'eyebrow' => $eyebrow,
		'title'   => '' !== $title ? $title : __( 'Bài viết', 'starter-flexible' ),
		'lead'    => $description,
		'aside'   => $search_form,
	)
);
?>

<section class="blog">
	<div class="container blog__body">
		<?php if ( have_posts() ) : ?>
			<div class="blog__grid" data-reveal-stagger>
				<?php
				while ( have_posts() ) :
					the_post();
					$categories = array_values(
						array_filter(
							(array) get_the_category(),
							static fn( WP_Term $term ): bool => 'bai-viet' !== $term->slug
						)
					);
					?>
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?>>
						<a class="post-card__link" href="<?php the_permalink(); ?>">
							<span class="post-card__media">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php the_post_thumbnail( 'large', array( 'class' => 'post-card__image', 'loading' => 'lazy' ) ); ?>
								<?php else : ?>
									<span class="post-card__placeholder" aria-hidden="true"></span>
								<?php endif; ?>
							</span>

							<span class="post-card__body">
								<span class="post-card__meta">
									<?php if ( $categories ) : ?>
										<span class="post-card__cat"><?php echo esc_html( $categories[0]->name ); ?></span>
									<?php endif; ?>
									<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date( 'd.m.Y' ) ); ?></time>
								</span>
								<span class="post-card__title"><?php the_title(); ?></span>
								<span class="post-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 24, '…' ) ); ?></span>
							</span>
						</a>
					</article>
					<?php
				endwhile;
				?>
			</div>

			<div class="blog__pagination">
				<?php
				the_posts_pagination(
					array(
						'mid_size'  => 1,
						'prev_text' => starter_flexible_icon( 'arrowLeft', 18 ),
						'next_text' => starter_flexible_icon( 'arrow', 18 ),
					)
				);
				?>
			</div>
		<?php else : ?>
			<p class="blog__empty"><?php esc_html_e( 'Chưa có bài viết nào trong mục này.', 'starter-flexible' ); ?></p>
		<?php endif; ?>
	</div>
</section>
