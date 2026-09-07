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
			<p class="blog__empty"><?php esc_html_e( 'Chưa có dự án nào trong nhóm này.', 'starter-flexible' ); ?></p>
		<?php endif; ?>
	</div>
</div>

<?php
get_footer();
