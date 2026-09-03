<?php
/**
 * Team — default appearance.
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
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Nhập tiêu đề và nhân sự ở thanh bên.', 'starter-flexible' ) );
	}
	return;
}

$anchor = ! empty( $block['anchor'] ) ? ' id="' . esc_attr( (string) $block['anchor'] ) . '"' : '';
?>
<section class="<?php echo esc_attr( $data->module_class ); ?>" data-reveal<?php echo $anchor; // phpcs:ignore ?>>
	<?php get_template_part( 'template-parts/components/block-head', null, array( 'label' => $data->label ) ); ?>
	<div class="tm">
		<?php
		get_template_part(
			'template-parts/components/frame',
			null,
			array(
				'ratio'       => 'ratio-4-5',
				'class'       => 'frame--zoom',
				'src'         => $data->image_url,
				'alt'         => $data->heading,
				'placeholder' => $data->placeholder,
			)
		);
		?>
		<div>
			<h2 class="h4 tm__heading"><?php echo esc_html( $data->heading ); ?></h2>
			<div class="tm__list" data-reveal-stagger>
				<?php foreach ( $data->people as $person ) : ?>
					<div class="tm__row">
						<span class="tm__name"><?php echo esc_html( $person['name'] ); ?></span>
						<span class="tm__role"><?php echo esc_html( $person['role'] ); ?></span>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
