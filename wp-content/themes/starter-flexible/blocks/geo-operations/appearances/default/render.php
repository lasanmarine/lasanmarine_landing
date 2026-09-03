<?php
/**
 * Geo Operations — default appearance.
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
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Nhập tiêu đề và các địa bàn ở thanh bên.', 'starter-flexible' ) );
	}
	return;
}

$anchor = ! empty( $block['anchor'] ) ? ' id="' . esc_attr( (string) $block['anchor'] ) . '"' : '';
$width  = $data->map_width;
$height = $data->map_height;
?>
<section class="<?php echo esc_attr( $data->module_class ); ?>" data-reveal<?php echo $anchor; // phpcs:ignore ?>>
	<div class="band band--navy band--pad">
		<div class="container geo">
			<div class="geo__side">
				<h2 class="h4 geo__heading"><?php echo esc_html( $data->heading ); ?></h2>
				<?php if ( $data->has_note ) : ?>
					<p class="copy geo__note"><?php echo esc_html( $data->note ); ?></p>
				<?php endif; ?>

				<ul class="geo__list">
					<?php foreach ( $data->provinces as $i => $province ) : ?>
						<li>
							<button type="button" data-geo-row data-i="<?php echo esc_attr( (string) $i ); ?>" data-active="<?php echo 0 === $i ? 'true' : 'false'; ?>">
								<?php echo esc_html( $province['name'] ); ?>
							</button>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>

			<div class="geo__plate">
				<svg viewBox="0 0 <?php echo esc_attr( (string) $width ); ?> <?php echo esc_attr( (string) $height ); ?>" role="img" aria-label="<?php echo esc_attr( $data->heading ); ?>">
					<g class="geo__grid" aria-hidden="true">
						<?php for ( $i = 0; $i < 7; $i++ ) : ?>
							<?php $y = ( ( $i + 1 ) * $height ) / 8; ?>
							<line x1="0" x2="<?php echo esc_attr( (string) $width ); ?>" y1="<?php echo esc_attr( (string) $y ); ?>" y2="<?php echo esc_attr( (string) $y ); ?>" />
						<?php endfor; ?>
						<?php for ( $i = 0; $i < 7; $i++ ) : ?>
							<?php $x = ( ( $i + 1 ) * $width ) / 8; ?>
							<line y1="0" y2="<?php echo esc_attr( (string) $height ); ?>" x1="<?php echo esc_attr( (string) $x ); ?>" x2="<?php echo esc_attr( (string) $x ); ?>" />
						<?php endfor; ?>
					</g>

					<path class="geo__land" d="<?php echo esc_attr( $data->map_outline ); ?>"></path>

					<?php /* Both archipelagos, boxed and labelled. */ ?>
					<?php foreach ( $data->islands as $island ) : ?>
						<g class="geo__island">
							<rect x="<?php echo esc_attr( (string) ( $island['x'] - 22 ) ); ?>" y="<?php echo esc_attr( (string) ( $island['y'] - 16 ) ); ?>" width="44" height="32" rx="3" />
							<circle cx="<?php echo esc_attr( (string) $island['x'] ); ?>" cy="<?php echo esc_attr( (string) $island['y'] ); ?>" r="2.8" />
							<text x="<?php echo esc_attr( (string) $island['x'] ); ?>" y="<?php echo esc_attr( (string) ( $island['y'] + 34 ) ); ?>"><?php echo esc_html( $island['name'] ); ?></text>
						</g>
					<?php endforeach; ?>

					<?php foreach ( $data->provinces as $i => $province ) : ?>
						<g class="geo__pin" data-geo-pin data-i="<?php echo esc_attr( (string) $i ); ?>" data-active="<?php echo 0 === $i ? 'true' : 'false'; ?>">
							<circle class="geo__pin-halo" cx="<?php echo esc_attr( (string) $province['x'] ); ?>" cy="<?php echo esc_attr( (string) $province['y'] ); ?>" r="14" />
							<circle class="geo__pin-dot" cx="<?php echo esc_attr( (string) $province['x'] ); ?>" cy="<?php echo esc_attr( (string) $province['y'] ); ?>" r="5" />
						</g>
					<?php endforeach; ?>
				</svg>
			</div>
		</div>
	</div>
</section>
