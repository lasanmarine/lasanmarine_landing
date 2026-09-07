<?php
/**
 * Capability Matrix — default appearance.
 *
 * @var object $data
 * @var bool   $is_preview
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( empty( $data->should_render ) ) {
	if ( $is_preview ) {
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Thêm ít nhất một năng lực ở thanh bên.', 'starter-flexible' ) );
	}
	return;
}

?>
<section class="<?php echo esc_attr( $data->module_class ); ?>" data-reveal<?php if ( $data->anchor ) : ?> id="<?php echo esc_attr( $data->anchor ); ?>"<?php endif; ?>>
	<?php
	if ( $data->has_label ) {
		get_template_part( 'template-parts/components/block-head', null, array( 'label' => $data->label ) );
	}
	?>
	<?php if ( $data->has_heading ) : ?>
		<h2 class="h3 cm__heading"><?php echo esc_html( $data->heading ); ?></h2>
	<?php endif; ?>
	<div class="mesh cm" data-reveal-stagger>
		<?php foreach ( $data->items as $item ) : ?>
			<a
				class="cm__cell"
				<?php echo '' !== $item['index'] ? 'id="' . esc_attr( $item['index'] ) . '"' : ''; ?>
				href="<?php echo esc_url( $item['url'] ); ?>"
				<?php echo '_blank' === $item['target'] ? 'target="_blank" rel="noopener"' : ''; ?>
			>
				<div class="cm__top">
					<span class="cm__index"><?php echo esc_html( $item['index'] ); ?></span>
					<?php echo starter_flexible_icon( $item['icon'], 34 ); // phpcs:ignore ?>
				</div>
				<h3 class="cm__name"><?php echo esc_html( $item['name'] ); ?></h3>
				<p class="cm__desc"><?php echo esc_html( $item['desc'] ); ?></p>
				<?php if ( $item['has_cta'] ) : ?>
					<span class="cm__cta">
						<?php echo esc_html( $item['cta'] ); ?>
						<?php echo starter_flexible_icon_swap( 'arrow', 17 ); // phpcs:ignore ?>
					</span>
				<?php endif; ?>
				<?php if ( ! empty( $item['children'] ) ) : ?>
					<ul class="cm__children">
						<?php foreach ( $item['children'] as $child ) : ?>
							<li><?php echo esc_html( $child ); ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</a>
		<?php endforeach; ?>
	</div>
</section>
