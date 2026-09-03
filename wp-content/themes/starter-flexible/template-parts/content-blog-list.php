<?php
/**
 * Template part for displaying the blog listing (index/archive).
 *
 * @package Starter_Flexible
 * @since 1.0.0
 */

$blog_title = __( 'Bài viết', 'starter-flexible' );
$blog_description = __( 'Tin tức, cập nhật công trình, giải pháp vật liệu AAC và các góc nhìn kỹ thuật được tổng hợp rõ ràng, dễ đọc.', 'starter-flexible' );

if ( is_home() && ! is_front_page() ) {
	$posts_page_id = (int) get_option( 'page_for_posts' );
	$page_title    = $posts_page_id ? get_the_title( $posts_page_id ) : '';
	if ( $page_title ) {
		$blog_title = $page_title;
	}
}

if ( is_archive() && ! is_home() ) {
	$blog_title = get_the_archive_title();
	$description = trim( wp_strip_all_tags( get_the_archive_description() ) );
	if ( '' !== $description ) {
		$blog_description = $description;
	}
}

$search_query = isset( $_GET['blog_search'] ) ? sanitize_text_field( wp_unslash( $_GET['blog_search'] ) ) : '';
?>

<section class="blog-list">
	<header class="blog-list__header">
		<div class="blog-list__header-inner">
			<div class="blog-list__header-left">
				<h1 class="blog-list__title"><?php echo esc_html( $blog_title ); ?></h1>
				<p class="blog-list__description"><?php echo esc_html( $blog_description ); ?></p>
			</div>
			<form class="blog-list__search" method="get" action="<?php echo esc_url( get_permalink() ); ?>">
				<input
					class="blog-list__search-input"
					type="search"
					name="s"
					value="<?php echo esc_attr( get_search_query() ); ?>"
					placeholder="<?php esc_attr_e( 'Tìm bài viết…', 'starter-flexible' ); ?>"
				>
				<button class="blog-list__search-btn" type="submit">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
				</button>
			</form>
		</div>
	</header>

	<?php if ( have_posts() ) : ?>
		<div class="blog-list__grid">
			<?php
			while ( have_posts() ) {
				the_post();
				$post_categories = get_the_category();
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?>>
					<a class="post-card__thumb" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
						<?php if ( has_post_thumbnail() ) : ?>
							<?php the_post_thumbnail( 'large', array( 'class' => 'post-card__image' ) ); ?>
						<?php else : ?>
							<div class="post-card__placeholder"></div>
						<?php endif; ?>
					</a>

					<div class="post-card__body">
						<h2 class="post-card__title">
							<a class="post-card__title-link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h2>
						<p class="post-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 20, '' ) ); ?></p>
						<div class="post-card__meta">
							<?php if ( ! empty( $post_categories ) ) : ?>
								<?php echo esc_html( strtoupper( $post_categories[0]->name ) ); ?>&nbsp;|&nbsp;
							<?php endif; ?>
							<?php echo esc_html( get_the_date( 'Y' ) ); ?>
						</div>
					</div>
				</article>
				<?php
			}
			?>
		</div>

		<div class="blog-list__pagination">
			<?php
			the_posts_pagination(
				array(
					'prev_text' => '&larr;',
					'next_text' => '&rarr;',
				)
			);
			?>
		</div>
	<?php else : ?>
		<div class="blog-list__empty">
			<p><?php esc_html_e( 'Chưa có bài viết nào.', 'starter-flexible' ); ?></p>
		</div>
	<?php endif; ?>
</section>
