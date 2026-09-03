<?php
/**
 * Wave — the mark that caps a navy field onto the paper below.
 *
 * @var array $args fill, class
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$fill  = isset( $args['fill'] ) ? (string) $args['fill'] : '#FFFFFF';
$class = isset( $args['class'] ) ? (string) $args['class'] : 'wave-cap';
?>
<svg viewBox="0 0 1440 120" preserveAspectRatio="none" class="<?php echo esc_attr( $class ); ?>" data-wave="0.45" aria-hidden="true">
	<path d="M-80 88 C260 22 470 104 800 66 C1080 36 1280 16 1520 36 L1520 130 L-80 130 Z" fill="<?php echo esc_attr( $fill ); ?>"></path>
	<path d="M-80 88 C260 22 470 104 800 66 C1080 36 1280 16 1520 36" fill="none" stroke="#0A72C8" stroke-width="2"></path>
</svg>
