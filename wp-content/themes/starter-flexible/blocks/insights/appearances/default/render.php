<?php
/**
 * Insights — default appearance.
 *
 * @var object $data
 * @var bool   $is_preview
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( empty( $data->should_render ) ) {
	if ( $is_preview ) {
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Chưa có bài viết đã xuất bản.', 'starter-flexible' ) );
	}
	return;
}


?>
<section class="<?php echo esc_attr( $data->module_class ); ?>" data-reveal<?php if ( $data->anchor ) : ?> id="<?php echo esc_attr( $data->anchor ); ?>"<?php endif; ?>>
	<?php if ( '' !== trim( (string) $data->aside ) ) : ?>
		<?php /* The "view all" link that used to ride on the block head. */ ?>
		<div class="in__more"><?php echo wp_kses( $data->aside, array_merge( wp_kses_allowed_html( 'post' ), starter_flexible_icon_kses() ) ); ?></div>
	<?php endif; ?>

	<?php if ( $data->has_heading ) : ?>
		<h2 class="h3 in__heading"><?php echo esc_html( $data->heading ); ?></h2>
	<?php endif; ?>

	<?php if ( $data->has_featured ) : ?>
		<div class="in__featured">
			<?php
			get_template_part(
				'template-parts/components/frame',
				null,
				array(
					'ratio'       => 'ratio-16-10',
					'class'       => 'frame--zoom',
					'src'         => $data->featured['image_url'],
					'alt'         => $data->featured['title'],
					'placeholder' => $data->featured['placeholder'],
				)
			);
			?>
			<div>
				<div class="in__kicker">
					<span class="in__badge"><?php echo esc_html( $data->featured['kind'] ); ?></span>
					<span class="in__badge"><?php echo starter_flexible_icon( 'calendar', 15 ); // phpcs:ignore ?><?php echo esc_html( $data->featured['date'] ); ?></span>
				</div>
				<?php $in_tag = $data->has_heading ? 'h3' : 'h2'; ?>
				<<?php echo $in_tag; // phpcs:ignore ?> class="h4 in__title"><?php echo esc_html( $data->featured['title'] ); ?></<?php echo $in_tag; // phpcs:ignore ?>>
				<p class="copy in__excerpt"><?php echo esc_html( $data->featured['excerpt'] ); ?></p>
				<?php if ( $data->has_read_more ) : ?>
					<a href="<?php echo esc_url( $data->featured['url'] ); ?>" class="link link--fixed link--lg in__cta">
						<?php echo esc_html( $data->read_more ); ?>
						<?php echo starter_flexible_icon_swap( 'arrow', 18 ); // phpcs:ignore ?>
					</a>
				<?php endif; ?>
			</div>
		</div>
	<?php endif; ?>

	<div class="in__row" data-reveal-stagger>
		<?php foreach ( $data->articles as $article ) : ?>
			<a href="<?php echo esc_url( $article['url'] ); ?>" class="in__card">
				<span class="in__card-media">
					<?php
					get_template_part(
						'template-parts/components/frame',
						null,
						array(
							'ratio'       => 'ratio-4-3',
							'class'       => 'frame--zoom',
							'src'         => $article['image_url'],
							'alt'         => $article['title'],
							'placeholder' => $article['title'],
						)
					);
					?>
					<?php if ( '' !== $article['kind'] ) : ?>
						<span class="in__card-chip"><?php echo esc_html( $article['kind'] ); ?></span>
					<?php endif; ?>
				</span>
				<span class="in__card-body">
					<span class="in__card-title"><?php echo esc_html( $article['title'] ); ?></span>
					<span class="in__card-meta">
						<span><?php echo esc_html( $article['date'] ); ?></span>
						<span><?php printf( esc_html__( '%d phút đọc', 'starter-flexible' ), (int) $article['minutes'] ); ?></span>
					</span>
					<span class="in__card-more">
						<?php echo esc_html( $data->read_more ); ?>
						<?php echo starter_flexible_icon_swap( 'arrow', 16 ); // phpcs:ignore ?>
					</span>
				</span>
			</a>
		<?php endforeach; ?>
	</div>
</section>
