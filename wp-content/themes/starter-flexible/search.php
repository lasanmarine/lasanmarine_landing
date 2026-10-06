<?php
/**
 * Search results.
 *
 * A search on this site can land on three different kinds of thing — a
 * vessel, an article or a page — and each reads best in its own shape, so the
 * results are grouped rather than poured into one grid. Tabs narrow it to one
 * kind (WordPress's own `post_type` query var), which then paginates.
 *
 * @package Starter_Flexible
 * @since 1.0.0
 */

get_header();

$query_text = get_search_query();
$types      = array(
	'project' => __( 'Dự án', 'starter-flexible' ),
	'post'    => __( 'Bài viết', 'starter-flexible' ),
	'page'    => __( 'Trang', 'starter-flexible' ),
);

// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- read-only filter.
$active = isset( $_GET['post_type'] ) ? sanitize_key( wp_unslash( $_GET['post_type'] ) ) : '';
if ( ! isset( $types[ $active ] ) ) {
	$active = '';
}

// One small query per kind: the count for its tab, and the first few results
// for the grouped view.
$groups = array();
$total  = 0;
foreach ( $types as $type => $label ) {
	$found = '' === $query_text ? null : new WP_Query(
		array(
			's'              => $query_text,
			'post_type'      => $type,
			'post_status'    => 'publish',
			'posts_per_page' => 'page' === $type ? 5 : 6,
			'no_found_rows'  => false,
		)
	);

	$groups[ $type ] = array(
		'label' => $label,
		'query' => $found,
		'count' => $found ? (int) $found->found_posts : 0,
	);
	$total          += $groups[ $type ]['count'];
}

$tab_url = static function ( string $type ) use ( $query_text ): string {
	$args = array( 's' => $query_text );
	if ( '' !== $type ) {
		$args['post_type'] = $type;
	}
	return add_query_arg( array_map( 'rawurlencode', $args ), home_url( '/' ) );
};

/**
 * Draw one result in the shape its kind reads best in.
 */
$render = static function ( WP_Post $item ): void {
	if ( 'project' === $item->post_type ) {
		get_template_part( 'template-parts/components/project-card', null, array( 'item' => starter_flexible_project_card( $item ) ) );
		return;
	}
	if ( 'post' === $item->post_type ) {
		get_template_part( 'template-parts/components/post-card', null, array( 'post' => $item ) );
		return;
	}
	$trail = array_reverse( array_map( 'get_the_title', get_post_ancestors( $item ) ) );
	?>
	<a class="srch-row" href="<?php echo esc_url( get_permalink( $item ) ); ?>">
		<span class="srch-row__body">
			<?php if ( $trail ) : ?>
				<span class="srch-row__trail"><?php echo esc_html( implode( ' / ', $trail ) ); ?></span>
			<?php endif; ?>
			<span class="srch-row__title"><?php echo esc_html( get_the_title( $item ) ); ?></span>
			<?php $excerpt = wp_trim_words( get_the_excerpt( $item ), 26, '…' ); ?>
			<?php if ( '' !== trim( $excerpt ) ) : ?>
				<span class="srch-row__excerpt"><?php echo esc_html( $excerpt ); ?></span>
			<?php endif; ?>
		</span>
		<span class="srch-row__go" aria-hidden="true"><?php echo starter_flexible_icon_swap( 'arrow', 22 ); // phpcs:ignore ?></span>
	</a>
	<?php
};

$grid_class = array(
	'project' => 'pi__grid srch__grid',
	'post'    => 'blog__grid srch__grid',
	'page'    => 'srch__rows',
);

ob_start();
?>
<form class="srch__form" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
	<label class="screen-reader-text" for="site-search"><?php esc_html_e( 'Tìm kiếm', 'starter-flexible' ); ?></label>
	<?php echo starter_flexible_icon( 'search', 22, 'srch__form-icon' ); // phpcs:ignore ?>
	<input
		class="srch__input"
		id="site-search"
		type="search"
		name="s"
		value="<?php echo esc_attr( $query_text ); ?>"
		placeholder="<?php esc_attr_e( 'Tên tàu, số hiệu, chủ đề kỹ thuật…', 'starter-flexible' ); ?>"
		autocomplete="off"
	/>
	<?php if ( '' !== $active ) : ?>
		<input type="hidden" name="post_type" value="<?php echo esc_attr( $active ); ?>" />
	<?php endif; ?>
	<button class="btn srch__submit" type="submit"><?php esc_html_e( 'Tìm', 'starter-flexible' ); ?></button>
</form>

<?php if ( '' !== $query_text ) : ?>
	<nav class="srch__tabs" aria-label="<?php esc_attr_e( 'Loại kết quả', 'starter-flexible' ); ?>">
		<a href="<?php echo esc_url( $tab_url( '' ) ); ?>" <?php echo '' === $active ? 'aria-current="page"' : ''; ?>>
			<?php esc_html_e( 'Tất cả', 'starter-flexible' ); ?>
		</a>
		<?php foreach ( $groups as $type => $group ) : ?>
			<a href="<?php echo esc_url( $tab_url( $type ) ); ?>" <?php echo $type === $active ? 'aria-current="page"' : ''; ?>>
				<?php echo esc_html( $group['label'] ); ?>
			</a>
		<?php endforeach; ?>
	</nav>
<?php endif; ?>
<?php
$search_head = (string) ob_get_clean();

get_template_part(
	'template-parts/components/page-head',
	null,
	array(
		'crumbs'  => array(
			array( 'label' => __( 'Trang chủ', 'starter-flexible' ), 'url' => home_url( '/' ) ),
			array( 'label' => __( 'Tìm kiếm', 'starter-flexible' ), 'url' => '' ),
		),
		'eyebrow' => __( 'Tìm kiếm', 'starter-flexible' ),
		'title'   => '' !== $query_text
			/* translators: %s: search terms. */
			? sprintf( __( 'Kết quả cho “%s”', 'starter-flexible' ), $query_text )
			: __( 'Bạn đang tìm gì?', 'starter-flexible' ),
		'after'   => $search_head,
	)
);
?>

<div class="site-main site-main--blog">
	<div class="container blog__body srch">
		<?php if ( '' === $query_text || 0 === $total ) : ?>
			<div class="srch__empty">
				<p class="srch__empty-title">
					<?php
					echo esc_html(
						'' === $query_text
							? __( 'Nhập từ khóa để tìm dự án, bài viết và trang.', 'starter-flexible' )
							: __( 'Không tìm thấy kết quả phù hợp.', 'starter-flexible' )
					);
					?>
				</p>
				<p class="srch__empty-note"><?php esc_html_e( 'Thử một từ khóa ngắn hơn, tên tàu hoặc số hiệu (ví dụ “composite”, “QNa”), hoặc xem thẳng các mục dưới đây.', 'starter-flexible' ); ?></p>
				<div class="srch__empty-links">
					<?php
					$shortcuts = array(
						array( starter_flexible_content_page_url( 'projects', 'du-an' ), __( 'Tất cả dự án', 'starter-flexible' ) ),
						array( starter_flexible_content_page_url( 'insights', 'tin-tuc' ), __( 'Tin tức & kỹ thuật', 'starter-flexible' ) ),
					);
					foreach ( $shortcuts as $shortcut ) :
						if ( '' === $shortcut[0] ) {
							continue;
						}
						?>
						<a class="btn btn--secondary" href="<?php echo esc_url( $shortcut[0] ); ?>">
							<?php echo esc_html( $shortcut[1] ); ?>
							<?php echo starter_flexible_icon_swap( 'arrow', 18 ); // phpcs:ignore ?>
						</a>
					<?php endforeach; ?>
				</div>
			</div>

		<?php elseif ( '' !== $active ) : ?>
			<?php /* One kind: the main query, already narrowed by `post_type`, paginates. */ ?>
			<?php if ( have_posts() ) : ?>
				<div class="<?php echo esc_attr( $grid_class[ $active ] ); ?>">
					<?php
					while ( have_posts() ) :
						the_post();
						$render( get_post() );
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
			<?php endif; ?>

		<?php else : ?>
			<?php foreach ( $groups as $type => $group ) : ?>
				<?php
				if ( ! $group['count'] ) {
					continue;
				}
				?>
				<section class="srch__group" aria-labelledby="srch-<?php echo esc_attr( $type ); ?>">
					<header class="srch__group-head">
						<h2 class="srch__group-title" id="srch-<?php echo esc_attr( $type ); ?>">
							<?php echo esc_html( $group['label'] ); ?>
						</h2>
						<?php if ( $group['count'] > $group['query']->post_count ) : ?>
							<a class="link srch__group-more" href="<?php echo esc_url( $tab_url( $type ) ); ?>">
								<?php esc_html_e( 'Xem tất cả', 'starter-flexible' ); ?>
								<?php echo starter_flexible_icon_swap( 'arrow', 18 ); // phpcs:ignore ?>
							</a>
						<?php endif; ?>
					</header>

					<div class="<?php echo esc_attr( $grid_class[ $type ] ); ?>">
						<?php
						foreach ( $group['query']->posts as $item ) {
							$render( $item );
						}
						?>
					</div>
				</section>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
</div>

<?php
get_footer();
