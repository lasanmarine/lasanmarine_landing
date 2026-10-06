<?php
/**
 * Frame — a square image frame. With no `src` it draws the wave signature as
 * a placeholder. `caption` and `caption_position` are still accepted from older
 * callers but no longer drawn over the image.
 *
 * When the image is in the media library (passed as `id`, or found from its
 * URL) it is served with srcset/sizes so a phone never downloads the desktop
 * file. The first image on the page is fetched eagerly; the rest lazily.
 *
 * @var array $args src, id, alt, placeholder, ratio (ratio-16-9 …), class,
 *                  sizes (defaults to half the viewport, full on a phone)
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$src         = isset( $args['src'] ) ? (string) $args['src'] : '';
$image_id    = isset( $args['id'] ) ? (int) $args['id'] : 0;
$alt         = isset( $args['alt'] ) ? (string) $args['alt'] : '';
$placeholder = isset( $args['placeholder'] ) ? (string) $args['placeholder'] : '';
$ratio       = isset( $args['ratio'] ) ? (string) $args['ratio'] : 'ratio-16-9';
$extra       = isset( $args['class'] ) ? (string) $args['class'] : '';
$sizes       = isset( $args['sizes'] ) ? (string) $args['sizes'] : '(max-width: 760px) 100vw, 50vw';

if ( ! $image_id && '' !== $src ) {
	$image_id = starter_flexible_attachment_id_from_url( $src );
}

$image_html = $image_id
	? (string) wp_get_attachment_image( $image_id, 'large', false, starter_flexible_image_priority_attrs( array( 'alt' => $alt, 'sizes' => $sizes ) ) )
	: '';

$classes = implode( ' ', array_filter( array( 'frame', $ratio, $extra ) ) );
?>
<div class="<?php echo esc_attr( $classes ); ?>">
	<?php if ( '' !== $image_html ) : ?>
		<?php echo $image_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- wp_get_attachment_image(). ?>
	<?php elseif ( '' !== $src ) : ?>
		<?php $attrs = starter_flexible_image_priority_attrs(); ?>
		<img src="<?php echo esc_url( $src ); ?>" alt="<?php echo esc_attr( $alt ); ?>" loading="<?php echo esc_attr( $attrs['loading'] ); ?>" fetchpriority="<?php echo esc_attr( $attrs['fetchpriority'] ); ?>" decoding="async" />
	<?php else : ?>
		<span class="frame__placeholder"><?php echo esc_html( $placeholder ); ?></span>
	<?php endif; ?>
</div>
