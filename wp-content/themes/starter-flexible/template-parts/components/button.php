<?php
/**
 * Button — renders an <a> when `href` is set, a <button> otherwise.
 *
 * @var array $args href, label, variant (primary|secondary|ghost), size (sm|md|lg),
 *                  icon (icon name, '' to omit), class, attrs (array of extra attributes)
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$href    = isset( $args['href'] ) ? (string) $args['href'] : '';
$label   = isset( $args['label'] ) ? (string) $args['label'] : '';
$variant = isset( $args['variant'] ) ? (string) $args['variant'] : 'primary';
$size    = isset( $args['size'] ) ? (string) $args['size'] : 'md';
$icon    = array_key_exists( 'icon', $args ) ? (string) $args['icon'] : 'arrow';
$extra   = isset( $args['class'] ) ? (string) $args['class'] : '';
$attrs   = isset( $args['attrs'] ) && is_array( $args['attrs'] ) ? $args['attrs'] : array();

$classes = array_filter(
	array(
		'btn',
		'secondary' === $variant ? 'btn--secondary' : '',
		'ghost' === $variant ? 'btn--ghost' : '',
		'lg' === $size ? 'btn--lg' : '',
		'sm' === $size ? 'btn--sm' : '',
		$extra,
	)
);

$attr_html = '';
foreach ( $attrs as $key => $value ) {
	if ( true === $value ) {
		$attr_html .= ' ' . esc_attr( $key );
		continue;
	}
	if ( null === $value || false === $value ) {
		continue;
	}
	$attr_html .= sprintf( ' %s="%s"', esc_attr( $key ), esc_attr( (string) $value ) );
}

$class_attr = esc_attr( implode( ' ', $classes ) );
$icon_html  = '' !== $icon ? starter_flexible_icon( $icon ) : '';
?>
<?php if ( '' !== $href ) : ?>
	<a class="<?php echo $class_attr; // phpcs:ignore ?>" href="<?php echo esc_url( $href ); ?>"<?php echo $attr_html; // phpcs:ignore ?>><?php echo esc_html( $label ); ?><?php echo $icon_html; // phpcs:ignore ?></a>
<?php else : ?>
	<button type="button" class="<?php echo $class_attr; // phpcs:ignore ?>"<?php echo $attr_html; // phpcs:ignore ?>><?php echo esc_html( $label ); ?><?php echo $icon_html; // phpcs:ignore ?></button>
<?php endif; ?>
