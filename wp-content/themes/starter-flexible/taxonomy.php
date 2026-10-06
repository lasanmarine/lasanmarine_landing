<?php
/**
 * Project taxonomy archives — every vessel filed under one material or use.
 *
 * @package Starter_Flexible
 */

get_header();

$term     = get_queried_object();
$taxonomy = $term instanceof WP_Term ? get_taxonomy( $term->taxonomy ) : null;
$count    = $term instanceof WP_Term ? (int) $term->count : 0;

// Trang chủ / Dự án / Vật liệu / Composite — a term is three levels down, and
// the header says so rather than dropping the reader in cold.
$crumbs = array( array( 'label' => __( 'Trang chủ', 'starter-flexible' ), 'url' => home_url( '/' ) ) );

$projects_url = starter_flexible_content_page_url( 'projects', 'du-an' );
if ( '' !== $projects_url ) {
	$crumbs[] = array( 'label' => __( 'Dự án', 'starter-flexible' ), 'url' => $projects_url );
}
if ( $taxonomy ) {
	// The taxonomy itself has no archive of its own, so the catalogue's own
	// filter list is the nearest thing to a parent index.
	$crumbs[] = array(
		'label' => (string) $taxonomy->labels->singular_name,
		'url'   => '' !== $projects_url ? $projects_url . '#danh-muc' : '',
	);
}
$crumbs[] = array( 'label' => single_term_title( '', false ), 'url' => '' );

// Every material and every use, as chips: a visitor on one term can step
// sideways to the next without going back to the catalogue.
ob_start();
?>
<div class="tax-filter">
	<?php foreach ( array( 'project_material', 'project_use' ) as $filter_tax ) : ?>
		<?php
		$filter_terms = get_terms( array( 'taxonomy' => $filter_tax, 'hide_empty' => true ) );
		$filter_obj   = get_taxonomy( $filter_tax );
		if ( is_wp_error( $filter_terms ) || ! $filter_terms || ! $filter_obj ) {
			continue;
		}
		?>
		<div class="tax-filter__row">
			<span class="tax-filter__label"><?php echo esc_html( (string) $filter_obj->labels->singular_name ); ?></span>
			<div class="tax-filter__chips">
				<?php foreach ( $filter_terms as $filter_term ) : ?>
					<?php $is_current = $term instanceof WP_Term && $term->term_id === $filter_term->term_id; ?>
					<a
						class="tax-filter__chip"
						href="<?php echo esc_url( (string) get_term_link( $filter_term ) ); ?>"
						<?php echo $is_current ? 'aria-current="page"' : ''; ?>
					>
						<?php echo esc_html( $filter_term->name ); ?>
						<span><?php echo esc_html( (string) $filter_term->count ); ?></span>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endforeach; ?>
	<?php if ( '' !== $projects_url ) : ?>
		<a class="link tax-filter__all" href="<?php echo esc_url( $projects_url ); ?>">
			<?php esc_html_e( 'Tất cả dự án', 'starter-flexible' ); ?>
			<?php echo starter_flexible_icon_swap( 'arrow', 18 ); // phpcs:ignore ?>
		</a>
	<?php endif; ?>
</div>
<?php
$tax_filter = (string) ob_get_clean();

get_template_part(
	'template-parts/components/page-head',
	null,
	array(
		'crumbs'  => $crumbs,
		'eyebrow' => $taxonomy ? (string) $taxonomy->labels->singular_name : '',
		'title'   => single_term_title( '', false ),
		'lead'    => trim( wp_strip_all_tags( (string) term_description() ) ),
		'note'    => sprintf(
			/* translators: %d: number of projects. */
			_n( '%d dự án', '%d dự án', $count, 'starter-flexible' ),
			$count
		),
		'after'   => $tax_filter,
	)
);
?>

<div class="site-main site-main--blog">
	<div class="container blog__body">
		<?php if ( have_posts() ) : ?>
			<div class="pi__grid" data-reveal-stagger>
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/components/project-card', null, array( 'item' => starter_flexible_project_card( get_post() ) ) );
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
			<div class="srch__empty">
				<p class="srch__empty-title"><?php esc_html_e( 'Chưa có dự án nào trong nhóm này.', 'starter-flexible' ); ?></p>
				<p class="srch__empty-note"><?php esc_html_e( 'Chọn một nhóm khác ở trên, hoặc xem toàn bộ danh mục dự án.', 'starter-flexible' ); ?></p>
			</div>
		<?php endif; ?>
	</div>
</div>

<?php
get_footer();
