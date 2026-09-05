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

	<article <?php post_class( 'project-single' ); ?>>

		<header class="project-single__hero">
			<div class="container project-single__intro">
				<?php if ( $projects_id ) : ?>
					<a class="link project-single__back" href="<?php echo esc_url( get_permalink( $projects_id ) ); ?>">
						<?php echo starter_flexible_icon( 'arrowLeft', 16 ); // phpcs:ignore ?>
						<?php esc_html_e( 'Tất cả dự án', 'starter-flexible' ); ?>
					</a>
				<?php endif; ?>

				<h1 class="project-single__title"><?php the_title(); ?></h1>

				<?php if ( $terms ) : ?>
					<div class="project-single__terms">
						<?php foreach ( $terms as $term ) : ?>
							<a href="<?php echo esc_url( (string) get_term_link( $term ) ); ?>"><?php echo esc_html( $term->name ); ?></a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<?php if ( has_excerpt() ) : ?>
					<p class="copy project-single__lead"><?php echo esc_html( get_the_excerpt() ); ?></p>
				<?php endif; ?>
			</div>

			<div class="container">
				<div class="project-single__media">
					<?php
					get_template_part(
						'template-parts/components/frame',
						null,
						array(
							'ratio'       => 'ratio-16-10',
							'src'         => $project['image_url'],
							'alt'         => $project['title'],
							'placeholder' => $project['placeholder'],
						)
					);
					?>
				</div>
			</div>
		</header>

		<div class="container project-single__grid">
			<div class="project-single__body">
				<?php if ( '' !== $body ) : ?>
					<div class="prose"><?php the_content(); ?></div>
				<?php else : ?>
					<p class="copy"><?php esc_html_e( 'Hồ sơ kỹ thuật của phương tiện này được lập theo quy chuẩn Đăng kiểm, gồm bố trí chung, kết cấu thân vỏ, hệ động lực và các bài toán tính năng đi kèm.', 'starter-flexible' ); ?></p>
				<?php endif; ?>

				<?php if ( $gallery ) : ?>
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

			<aside class="project-single__specs">
				<h2 class="h4"><?php esc_html_e( 'Thông số cơ bản', 'starter-flexible' ); ?></h2>
				<dl class="project-single__spec-list">
					<?php foreach ( $specs as $row ) : ?>
						<div>
							<dt><?php echo esc_html( $row['label'] ); ?></dt>
							<dd><?php echo esc_html( $row['value'] ); ?></dd>
						</div>
					<?php endforeach; ?>
				</dl>
			</aside>
		</div>

		<?php if ( $related ) : ?>
			<section class="block container project-single__related">
				<?php get_template_part( 'template-parts/components/block-head', null, array( 'label' => __( 'DỰ ÁN CÙNG NHÓM', 'starter-flexible' ) ) ); ?>
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
