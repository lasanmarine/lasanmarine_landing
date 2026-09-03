<?php
/**
 * Standards — default appearance.
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
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Nhập tiêu đề và các chứng nhận ở thanh bên.', 'starter-flexible' ) );
	}
	return;
}

$anchor = ! empty( $block['anchor'] ) ? ' id="' . esc_attr( (string) $block['anchor'] ) . '"' : '';
?>
<section class="<?php echo esc_attr( $data->module_class ); ?>" data-reveal<?php echo $anchor; // phpcs:ignore ?>>
	<div class="container">
		<?php get_template_part( 'template-parts/components/block-head', null, array( 'label' => $data->label ) ); ?>
	</div>
	<div class="band band--pale band--pad">
		<div class="container">
			<h2 class="h3 st__heading"><?php echo esc_html( $data->heading ); ?></h2>
			<div class="mesh st" data-reveal-stagger>
				<?php foreach ( $data->items as $item ) : ?>
					<article class="st__cell">
						<?php echo starter_flexible_icon( 'award', 30 ); // phpcs:ignore ?>
						<h3 class="st__name"><?php echo esc_html( $item['name'] ); ?></h3>
						<p class="st__issuer"><?php echo esc_html( $item['issuer'] ); ?></p>
						<div class="st__foot">
							<span><?php echo esc_html( $item['year'] ); ?></span>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
			<?php if ( $data->has_note ) : ?>
				<p class="st__note"><?php echo esc_html( $data->note ); ?></p>
			<?php endif; ?>
		</div>
	</div>
</section>
