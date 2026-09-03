<?php
/**
 * Icon — thin wrapper around starter_flexible_icon().
 *
 * @var array $args name, size, class, stroke
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$name   = isset( $args['name'] ) ? (string) $args['name'] : 'arrow';
$size   = isset( $args['size'] ) ? (int) $args['size'] : 19;
$class  = isset( $args['class'] ) ? (string) $args['class'] : '';
$stroke = isset( $args['stroke'] ) ? (float) $args['stroke'] : 1.5;

echo starter_flexible_icon( $name, $size, $class, $stroke ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
