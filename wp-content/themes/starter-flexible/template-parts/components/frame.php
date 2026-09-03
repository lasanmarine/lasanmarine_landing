<?php
/**
 * Frame — a square image frame with an optional caption. With no `src` it
 * draws the wave signature as a placeholder.
 *
 * @var array $args src, alt, placeholder, caption, caption_position (bl|tr),
 *                  ratio (ratio-16-9 …), class
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$src         = isset( $args['src'] ) ? (string) $args['src'] : '';
$alt         = isset( $args['alt'] ) ? (string) $args['alt'] : '';
$placeholder = isset( $args['placeholder'] ) ? (string) $args['placeholder'] : '';
$caption     = isset( $args['caption'] ) ? (string) $args['caption'] : '';
$caption_pos = isset( $args['caption_position'] ) ? (string) $args['caption_position'] : 'bl';
$ratio       = isset( $args['ratio'] ) ? (string) $args['ratio'] : 'ratio-16-9';
$extra       = isset( $args['class'] ) ? (string) $args['class'] : '';

$classes         = implode( ' ', array_filter( array( 'frame', $ratio, $extra ) ) );
$caption_classes = implode( ' ', array_filter( array( 'frame__caption', 'tr' === $caption_pos ? 'frame__caption--tr' : '' ) ) );
?>
<div class="<?php echo esc_attr( $classes ); ?>">
	<?php if ( '' !== $src ) : ?>
		<img src="<?php echo esc_url( $src ); ?>" alt="<?php echo esc_attr( $alt ); ?>" loading="lazy" decoding="async" />
	<?php else : ?>
		<span class="frame__placeholder"><?php echo esc_html( $placeholder ); ?></span>
	<?php endif; ?>
	<?php if ( '' !== $caption ) : ?>
		<span class="<?php echo esc_attr( $caption_classes ); ?>"><?php echo esc_html( $caption ); ?></span>
	<?php endif; ?>
</div>
