<?php
/**
 * Project taxonomy archives — every vessel filed under one material or use.
 *
 * @package Starter_Flexible
 */

get_header();

$term = get_queried_object();
?>
<div class="site-main">
	<section class="block container">
		<header class="tax-head">
			<span class="meta"><?php echo esc_html( (string) ( get_taxonomy( $term->taxonomy )->labels->singular_name ?? '' ) ); ?></span>
			<h1 class="tax-head__title"><?php echo esc_html( single_term_title( '', false ) ); ?></h1>
			<?php if ( term_description() ) : ?>
				<div class="copy"><?php echo wp_kses_post( term_description() ); ?></div>
			<?php endif; ?>
			<p class="meta"><?php echo esc_html( sprintf( /* translators: %d: number of projects. */ _n( '%d dự án', '%d dự án', (int) $term->count, 'starter-flexible' ), (int) $term->count ) ); ?></p>
		</header>

		<?php if ( have_posts() ) : ?>
			<div class="pi__grid" data-reveal-stagger>
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/components/project-card', null, array( 'item' => starter_flexible_project_card( get_post() ) ) );
				endwhile;
				?>
			</div>
			<?php
			the_posts_pagination(
				array(
					'mid_size'  => 1,
					'prev_text' => esc_html__( 'Trước', 'starter-flexible' ),
					'next_text' => esc_html__( 'Sau', 'starter-flexible' ),
				)
			);
			?>
		<?php else : ?>
			<p class="copy"><?php esc_html_e( 'Chưa có dự án nào trong nhóm này.', 'starter-flexible' ); ?></p>
		<?php endif; ?>
	</section>
</div>
<?php
get_footer();
