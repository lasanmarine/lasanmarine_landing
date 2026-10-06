<?php
/**
 * Post card — one article in a listing: the photograph, its section and date,
 * the headline and a short excerpt. The blog index, the search results and
 * the related posts under an article all draw the same card.
 *
 * @var array $args post (WP_Post, defaults to the loop's post), excerpt (bool)
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$card = isset( $args['post'] ) && $args['post'] instanceof WP_Post ? $args['post'] : get_post();
if ( ! $card ) {
	return;
}

$show_excerpt = ! isset( $args['excerpt'] ) || (bool) $args['excerpt'];
$categories   = array_values(
	array_filter(
		(array) get_the_category( $card->ID ),
		static fn( WP_Term $term ): bool => 'bai-viet' !== $term->slug
	)
);
?>
<article <?php post_class( 'post-card', $card ); ?>>
	<a class="post-card__link" href="<?php echo esc_url( get_permalink( $card ) ); ?>">
		<span class="post-card__media">
			<?php if ( has_post_thumbnail( $card ) ) : ?>
				<?php echo get_the_post_thumbnail( $card, 'large', array( 'class' => 'post-card__image', 'loading' => 'lazy' ) ); ?>
			<?php else : ?>
				<span class="post-card__placeholder" aria-hidden="true">
					<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo-lasan.svg' ); ?>" alt="" loading="lazy" />
				</span>
			<?php endif; ?>
		</span>

		<span class="post-card__body">
			<span class="post-card__meta">
				<?php if ( $categories ) : ?>
					<span class="post-card__cat"><?php echo esc_html( $categories[0]->name ); ?></span>
				<?php endif; ?>
				<time datetime="<?php echo esc_attr( get_the_date( 'c', $card ) ); ?>"><?php echo esc_html( get_the_date( 'd.m.Y', $card ) ); ?></time>
			</span>
			<span class="post-card__title"><?php echo esc_html( get_the_title( $card ) ); ?></span>
			<?php if ( $show_excerpt ) : ?>
				<span class="post-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt( $card ), 22, '…' ) ); ?></span>
			<?php endif; ?>
			<span class="post-card__more">
				<?php esc_html_e( 'Đọc bài', 'starter-flexible' ); ?>
				<?php echo starter_flexible_icon_swap( 'arrow', 16 ); // phpcs:ignore ?>
			</span>
		</span>
	</a>
</article>
