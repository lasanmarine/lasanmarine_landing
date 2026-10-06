<?php
/**
 * A single project: the photograph, the spec sheet, any notes, and the other
 * vessels of the same material.
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
	$terms       = array_merge( is_array( $materials ) ? $materials : array(), is_array( $uses ) ? $uses : array() );
	$body        = trim( (string) get_the_content() );
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

		<header class="phead project-single__hero">
			<span class="phead__scrim" aria-hidden="true"></span>
			<div class="container phead__inner project-single__intro">
				<div class="phead__copy">
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

					<?php if ( $terms ) : ?>
						<div class="project-single__terms">
							<?php foreach ( $terms as $term ) : ?>
								<a href="<?php echo esc_url( (string) get_term_link( $term ) ); ?>"><?php echo esc_html( $term->name ); ?></a>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>

					<h1 class="phead__title project-single__title"><?php the_title(); ?></h1>

					<?php if ( has_excerpt() ) : ?>
						<p class="phead__lead"><?php echo esc_html( get_the_excerpt() ); ?></p>
					<?php endif; ?>
				</div>

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

		<?php /* The drawing rises into the navy band, so the page opens on the vessel. */ ?>
		<div class="container project-single__media-wrap">
			<div class="project-single__media">
				<?php
				get_template_part(
					'template-parts/components/frame',
					null,
					array(
						'ratio'       => 'ratio-16-9',
						'src'         => $project['image_url'],
						'alt'         => $project['title'],
						'placeholder' => $project['placeholder'],
					)
				);
				?>
			</div>
		</div>

		<div class="container project-single__grid">
			<div class="project-single__body">
				<h2 class="project-single__h"><?php esc_html_e( 'Tổng quan dự án', 'starter-flexible' ); ?></h2>
				<?php if ( '' !== $body ) : ?>
					<div class="prose"><?php the_content(); ?></div>
				<?php else : ?>
					<p class="copy"><?php esc_html_e( 'Hồ sơ kỹ thuật của phương tiện này được lập theo quy chuẩn Đăng kiểm, gồm bố trí chung, kết cấu thân vỏ, hệ động lực và các bài toán tính năng đi kèm.', 'starter-flexible' ); ?></p>
				<?php endif; ?>

				<?php if ( $gallery ) : ?>
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
				<?php endif; ?>
			</div>

			<aside class="project-single__aside">
			<div class="project-single__specs">
				<h2 class="project-single__specs-title"><?php esc_html_e( 'Thông số kỹ thuật', 'starter-flexible' ); ?></h2>
				<dl class="project-single__spec-list">
					<?php foreach ( $specs as $row ) : ?>
						<div>
							<dt><?php echo esc_html( $row['label'] ); ?></dt>
							<dd><?php echo esc_html( $row['value'] ); ?></dd>
						</div>
					<?php endforeach; ?>
				</dl>
			</div>

			<?php if ( '' !== $cta['url'] ) : ?>
				<div class="project-single__cta">
					<p class="project-single__cta-title"><?php esc_html_e( 'Cần thiết kế một phương tiện tương tự?', 'starter-flexible' ); ?></p>
					<p class="project-single__cta-note"><?php esc_html_e( 'Gửi yêu cầu, đội ngũ kỹ thuật sẽ phản hồi với phương án và báo giá sơ bộ.', 'starter-flexible' ); ?></p>
					<a class="btn project-single__cta-btn" href="<?php echo esc_url( $cta['url'] ); ?>">
						<?php echo esc_html( $cta['label'] ); ?>
						<?php echo starter_flexible_icon_swap( 'arrowUpRight', 18 ); // phpcs:ignore ?>
					</a>
				</div>
			<?php endif; ?>
			</aside>
		</div>

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
