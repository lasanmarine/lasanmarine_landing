<?php
/**
 * A single project: the headline figures, the photograph, the overview, the
 * full spec sheet, any drawings, and the other vessels of the same material.
 *
 * @package Starter_Flexible
 */

get_header();

while ( have_posts() ) :
	the_post();

	$project     = starter_flexible_project_card( get_post() );
	$specs       = starter_flexible_project_specs( get_the_ID() );
	$gallery     = function_exists( 'get_field' ) ? (array) get_field( 'gallery' ) : array();
	$materials   = wp_get_post_terms( get_the_ID(), 'project_material' );
	$uses        = wp_get_post_terms( get_the_ID(), 'project_use' );
	$terms       = array_merge( is_array( $uses ) ? $uses : array(), is_array( $materials ) ? $materials : array() );
	$body        = trim( (string) get_the_content() );
	$case_field  = static fn( string $name ): string => trim( (string) ( function_exists( 'get_field' ) ? get_field( $name ) : get_post_meta( get_the_ID(), $name, true ) ) );
	$requirement = $case_field( 'requirement' );
	$scope       = starter_flexible_project_lines( $case_field( 'scope' ) );
	$highlight   = $case_field( 'highlight' );
	$result      = $case_field( 'result' );
	$works       = wp_get_post_terms( get_the_ID(), 'project_work' );
	$terms_year  = $case_field( 'year' );
	$projects_id = 0;

	$index = get_posts(
		array(
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'meta_key'       => '_lasan_content_key',
			'meta_value'     => 'projects',
		)
	);
	if ( $index ) {
		$projects_id = (int) $index[0]->ID;
	}

	// Siblings sharing a material read as "more of this kind"; newest first.
	$related = array();
	if ( is_array( $materials ) && $materials ) {
		$related = get_posts(
			array(
				'post_type'      => 'project',
				'post_status'    => 'publish',
				'posts_per_page' => 3,
				'post__not_in'   => array( get_the_ID() ),
				'tax_query'      => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
					array(
						'taxonomy' => 'project_material',
						'field'    => 'term_id',
						'terms'    => wp_list_pluck( $materials, 'term_id' ),
					),
				),
			)
		);
	}
	?>
	<?php
	get_template_part(
		'template-parts/components/reading-bar',
		null,
		array(
			'title'  => get_the_title(),
			'byline' => trim( implode( ' · ', array_filter( array( $project['tag'], $project['location'] ) ) ) ),
		)
	);
	?>

	<?php
	// The four figures a naval architect reads first, pulled out of the sheet.
	$key_labels = array(
		__( 'Lmax', 'starter-flexible' )                => __( 'Chiều dài', 'starter-flexible' ),
		__( 'Bmax', 'starter-flexible' )                => __( 'Chiều rộng', 'starter-flexible' ),
		__( 'Trọng tải', 'starter-flexible' )           => __( 'Trọng tải', 'starter-flexible' ),
		__( 'Công suất máy chính', 'starter-flexible' ) => __( 'Công suất', 'starter-flexible' ),
	);
	$key_specs  = array();
	foreach ( $specs as $row ) {
		if ( isset( $key_labels[ $row['label'] ] ) ) {
			$key_specs[] = array( 'label' => $key_labels[ $row['label'] ], 'value' => $row['value'] );
		}
	}

	$crumbs = array( array( 'label' => __( 'Trang chủ', 'starter-flexible' ), 'url' => home_url( '/' ) ) );
	if ( $projects_id ) {
		$crumbs[] = array( 'label' => get_the_title( $projects_id ), 'url' => get_permalink( $projects_id ) );
	}
	$crumbs[] = array( 'label' => get_the_title(), 'url' => '' );

	$cta = starter_flexible_link( starter_flexible_setting( 'header_cta', array() ) );
	?>

	<article <?php post_class( 'project-single' ); ?>>

		<?php /* The vessel's name over the drawing office, its four headline figures
		         read across the band beneath it. */ ?>
		<header class="phead project-single__hero<?php echo '' !== $project['image_url'] ? ' project-single__hero--media' : ''; ?>">
			<div class="container project-single__intro">
				<nav class="phead__crumbs" aria-label="<?php esc_attr_e( 'Đường dẫn', 'starter-flexible' ); ?>">
					<?php foreach ( $crumbs as $i => $crumb ) : ?>
						<?php if ( $i > 0 ) : ?>
							<span class="phead__sep" aria-hidden="true">/</span>
						<?php endif; ?>
						<?php if ( '' !== $crumb['url'] ) : ?>
							<a href="<?php echo esc_url( (string) $crumb['url'] ); ?>"><?php echo esc_html( (string) $crumb['label'] ); ?></a>
						<?php else : ?>
							<span aria-current="page"><?php echo esc_html( (string) $crumb['label'] ); ?></span>
						<?php endif; ?>
					<?php endforeach; ?>
				</nav>

				<?php if ( $terms || $works || '' !== $terms_year ) : ?>
					<div class="project-single__terms">
						<?php foreach ( $terms as $term ) : ?>
							<a href="<?php echo esc_url( (string) get_term_link( $term ) ); ?>"><?php echo esc_html( $term->name ); ?></a>
						<?php endforeach; ?>
						<?php foreach ( is_array( $works ) ? $works : array() as $work ) : ?>
							<span><?php echo esc_html( $work->name ); ?></span>
						<?php endforeach; ?>
						<?php if ( '' !== $terms_year ) : ?>
							<span><?php echo esc_html( $terms_year ); ?></span>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<h1 class="project-single__title"><?php the_title(); ?></h1>

				<?php if ( has_excerpt() ) : ?>
					<p class="project-single__lead"><?php echo esc_html( get_the_excerpt() ); ?></p>
				<?php endif; ?>

				<?php $service_page = (string) get_post_meta( get_the_ID(), 'lm_service_page', true ); $is_english = function_exists( 'pll_current_language' ) && 'en' === pll_current_language( 'slug' ); ?>
				<?php if ( '' !== $service_page && ! $is_english ) : ?>
					<a class="link link--fixed project-single__service" href="<?php echo esc_url( $service_page ); ?>">
						<?php esc_html_e( 'Xem dịch vụ thiết kế loại tàu này', 'starter-flexible' ); ?>
						<?php echo starter_flexible_icon_swap( 'arrow', 18 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</a>
				<?php endif; ?>

				<?php if ( $key_specs ) : ?>
					<dl class="project-single__kpis">
						<?php foreach ( $key_specs as $kpi ) : ?>
							<div>
								<dt><?php echo esc_html( $kpi['label'] ); ?></dt>
								<dd><?php echo esc_html( $kpi['value'] ); ?></dd>
							</div>
						<?php endforeach; ?>
					</dl>
				<?php endif; ?>
			</div>
		</header>

		<?php if ( '' !== $project['image_url'] ) : ?>
			<?php /* The photograph rises into the navy band, so the page opens on the vessel. */ ?>
			<div class="container">
				<figure class="project-single__cover">
					<?php
					// The page's largest paint: responsive sizes, fetched first.
					echo wp_get_attachment_image( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						(int) get_post_thumbnail_id(),
						'full',
						false,
						starter_flexible_image_priority_attrs(
							array(
								'alt'   => $project['title'],
								'sizes' => '(min-width: 1280px) 1200px, calc(100vw - 32px)',
							)
						)
					);
					?>
				</figure>
			</div>
		<?php endif; ?>

		<?php /* The overview and the call to action hold the left rail; the spec
		         sheet fills the column beside them. */ ?>
		<div class="container project-single__overview">
			<div class="project-single__rail">
				<div class="project-single__body">
					<h2 class="project-single__h"><?php esc_html_e( 'Tổng quan dự án', 'starter-flexible' ); ?></h2>
					<?php if ( '' !== $body ) : ?>
						<div class="prose"><?php the_content(); ?></div>
					<?php elseif ( has_excerpt() ) : ?>
						<p class="copy"><?php echo esc_html( get_the_excerpt() ); ?></p>
					<?php endif; ?>
				</div>

				<?php /* The case study: brief → what LASAN MARINE did → the engineering point → result. Each part only when it is filled in. */ ?>
				<?php if ( '' !== $requirement || $scope || '' !== $highlight || '' !== $result ) : ?>
					<div class="project-single__case">
						<?php if ( '' !== $requirement ) : ?>
							<div class="project-single__case-part">
								<h3 class="project-single__case-h"><?php esc_html_e( 'Yêu cầu dự án', 'starter-flexible' ); ?></h3>
								<p class="copy"><?php echo esc_html( $requirement ); ?></p>
							</div>
						<?php endif; ?>
						<?php if ( $scope ) : ?>
							<div class="project-single__case-part">
								<h3 class="project-single__case-h"><?php esc_html_e( 'Phạm vi LASAN MARINE thực hiện', 'starter-flexible' ); ?></h3>
								<ul class="project-single__scope">
									<?php foreach ( $scope as $line ) : ?>
										<li><?php echo esc_html( $line ); ?></li>
									<?php endforeach; ?>
								</ul>
							</div>
						<?php endif; ?>
						<?php if ( '' !== $highlight ) : ?>
							<div class="project-single__case-part project-single__case-part--note">
								<h3 class="project-single__case-h"><?php esc_html_e( 'Điểm kỹ thuật đáng chú ý', 'starter-flexible' ); ?></h3>
								<p class="copy"><?php echo esc_html( $highlight ); ?></p>
							</div>
						<?php endif; ?>
						<?php if ( '' !== $result ) : ?>
							<div class="project-single__case-part">
								<h3 class="project-single__case-h"><?php esc_html_e( 'Kết quả', 'starter-flexible' ); ?></h3>
								<p class="copy"><?php echo esc_html( $result ); ?></p>
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<?php if ( '' !== $cta['url'] ) : ?>
					<aside class="project-single__cta">
						<span class="project-single__cta-icon" aria-hidden="true"><?php echo starter_flexible_icon( 'ship', 26 ); // phpcs:ignore ?></span>
						<p class="project-single__cta-title"><?php esc_html_e( 'Cần thiết kế một phương tiện tương tự?', 'starter-flexible' ); ?></p>
						<p class="project-single__cta-note"><?php esc_html_e( 'Gửi yêu cầu, đội ngũ kỹ thuật sẽ phản hồi với phương án và báo giá sơ bộ.', 'starter-flexible' ); ?></p>
						<a class="btn project-single__cta-btn" href="<?php echo esc_url( $cta['url'] ); ?>">
							<?php echo esc_html( $cta['label'] ); ?>
							<?php echo starter_flexible_icon_swap( 'arrowUpRight', 18 ); // phpcs:ignore ?>
						</a>
					</aside>
				<?php endif; ?>
			</div>

			<?php if ( $specs ) : ?>
				<section class="project-single__specs" aria-labelledby="project-specs-title">
					<h2 class="project-single__h" id="project-specs-title"><?php esc_html_e( 'Thông số kỹ thuật', 'starter-flexible' ); ?></h2>
					<dl class="mesh project-single__spec-grid">
						<?php foreach ( $specs as $row ) : ?>
							<div>
								<dt><?php echo esc_html( $row['label'] ); ?></dt>
								<dd><?php echo esc_html( $row['value'] ); ?></dd>
							</div>
						<?php endforeach; ?>
					</dl>
				</section>
			<?php endif; ?>
		</div>

		<?php if ( $gallery ) : ?>
			<section class="container project-single__gallery-wrap">
				<h2 class="project-single__h"><?php esc_html_e( 'Hình ảnh & bản vẽ', 'starter-flexible' ); ?></h2>
				<div class="project-single__gallery">
					<?php foreach ( $gallery as $row ) : ?>
						<?php
						$image_id = isset( $row['image'] ) ? (int) $row['image'] : 0;
						if ( ! $image_id ) {
							continue;
						}
						?>
						<figure>
							<?php echo wp_get_attachment_image( $image_id, 'large' ); ?>
							<?php if ( ! empty( $row['caption'] ) ) : ?>
								<figcaption><?php echo esc_html( (string) $row['caption'] ); ?></figcaption>
							<?php endif; ?>
						</figure>
					<?php endforeach; ?>
				</div>
			</section>
		<?php endif; ?>

		<?php if ( $related ) : ?>
			<section class="block container project-single__related">
				<header class="srch__group-head">
					<h2 class="srch__group-title"><?php esc_html_e( 'Dự án cùng nhóm', 'starter-flexible' ); ?></h2>
					<?php if ( $projects_id ) : ?>
						<a class="link srch__group-more" href="<?php echo esc_url( get_permalink( $projects_id ) ); ?>">
							<?php esc_html_e( 'Tất cả dự án', 'starter-flexible' ); ?>
							<?php echo starter_flexible_icon_swap( 'arrow', 18 ); // phpcs:ignore ?>
						</a>
					<?php endif; ?>
				</header>
				<div class="pi__grid">
					<?php foreach ( $related as $sibling ) : ?>
						<?php get_template_part( 'template-parts/components/project-card', null, array( 'item' => starter_flexible_project_card( $sibling ) ) ); ?>
					<?php endforeach; ?>
				</div>
			</section>
		<?php endif; ?>
	</article>
	<?php
endwhile;

get_footer();
