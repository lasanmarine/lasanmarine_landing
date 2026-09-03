<?php
/**
 * Hero — default appearance.
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
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Nhập headline cho Hero ở thanh bên.', 'starter-flexible' ) );
	}
	return;
}

$heading = $data->heading_level;
$anchor  = ! empty( $block['anchor'] ) ? ' id="' . esc_attr( (string) $block['anchor'] ) . '"' : '';

/**
 * Renders one hero button through the shared component.
 *
 * @param array  $link    Normalised link.
 * @param string $variant Button variant.
 * @param string $icon    Icon name.
 */
$render_button = static function ( array $link, string $variant, string $icon ): void {
	if ( empty( $link ) ) {
		return;
	}

	get_template_part(
		'template-parts/components/button',
		null,
		array(
			'href'    => $link['url'],
			'label'   => $link['label'],
			'size'    => 'lg',
			'variant' => $variant,
			'icon'    => $icon,
			'attrs'   => '_blank' === $link['target'] ? array( 'target' => '_blank', 'rel' => 'noopener' ) : array(),
		)
	);
};
?>
<section class="<?php echo esc_attr( $data->module_class ); ?>"<?php echo $anchor; // phpcs:ignore ?>>
	<?php if ( '' !== $data->image_html ) : ?>
		<div class="hero__media">
			<?php echo $data->image_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
	<?php endif; ?>
	<span class="hero__scrim"></span>

	<div class="container hero__body">
		<div data-enter style="--enter-i:0">
			<<?php echo esc_attr( $heading ); ?> class="hero__headline"><?php
				echo esc_html( $data->headline ) . ' ';
				?><span><?php echo esc_html( $data->headline_accent ); ?></span><?php
				echo ' ' . esc_html( $data->headline_tail );
			?></<?php echo esc_attr( $heading ); ?>>
		</div>
		<div class="hero__foot">
			<?php if ( $data->has_lead ) : ?>
				<p class="copy" data-enter style="--enter-i:1"><?php echo esc_html( $data->lead ); ?></p>
			<?php endif; ?>
			<?php if ( $data->has_actions ) : ?>
				<div class="hero__actions" data-enter style="--enter-i:2">
					<?php
					$render_button( $data->primary, 'primary', 'arrow' );
					$render_button( $data->secondary, 'secondary', 'arrowUpRight' );
					?>
				</div>
			<?php endif; ?>
		</div>
	</div>

	<?php get_template_part( 'template-parts/components/wave' ); ?>
</section>
