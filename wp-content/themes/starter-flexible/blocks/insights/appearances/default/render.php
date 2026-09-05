<?php
/**
 * Insights — default appearance.
 *
 * @var object $data
 * @var array  $block
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

$anchor   = ! empty( $block['anchor'] ) ? ' id="' . esc_attr( (string) $block['anchor'] ) . '"' : '';
$featured = $data->featured;

$aside = '';
if ( $data->has_view_all ) {
	$aside = sprintf(
		'<a href="%s" class="link link--lg">%s %s</a>',
		esc_url( $data->view_all_url ),
		esc_html( $data->view_all ),
		starter_flexible_icon_swap( 'arrow', 18 )
	);
}
?>
<section class="<?php echo esc_attr( $data->module_class ); ?>" data-reveal<?php echo $anchor; // phpcs:ignore ?>>
	<?php
	get_template_part(
		'template-parts/components/block-head',
		null,
		array( 'label' => $data->label, 'aside' => $aside )
	);
	?>

	<?php if ( '' !== trim( (string) $data->heading ) ) : ?>
		<h3 class="in__heading"><?php echo esc_html( $data->heading ); ?></h3>
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
					'src'         => $featured['image_url'],
					'alt'         => $featured['title'],
					'placeholder' => $featured['placeholder'],
				)
			);
			?>
			<div>
				<div class="in__kicker">
					<span class="in__badge"><?php echo esc_html( $featured['kind'] ); ?></span>
					<span class="in__badge"><?php echo starter_flexible_icon( 'calendar', 15 ); // phpcs:ignore ?><?php echo esc_html( $featured['date'] ); ?></span>
				</div>
				<h3 class="h4 in__title"><?php echo esc_html( $featured['title'] ); ?></h3>
				<p class="copy in__excerpt"><?php echo esc_html( $featured['excerpt'] ); ?></p>
				<?php if ( $data->has_read_more ) : ?>
					<a href="<?php echo esc_url( $featured['url'] ); ?>" class="link link--fixed link--lg in__cta">
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
