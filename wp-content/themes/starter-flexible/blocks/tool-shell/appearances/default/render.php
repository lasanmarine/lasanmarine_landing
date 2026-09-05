<?php
/**
 * Tool Shell — default appearance. The calculator itself is an inner block.
 *
 * @var object $data
 * @var array  $block
 * @var bool   $is_preview
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$anchor    = ! empty( $block['anchor'] ) ? ' id="' . esc_attr( (string) $block['anchor'] ) . '"' : '';
$allowed   = wp_json_encode( array( 'acf/engine-lookup', 'acf/power-converter', 'acf/shaft-diameter' ) );
$template  = wp_json_encode( array() );
?>
<section class="<?php echo esc_attr( $data->module_class ); ?>" data-reveal<?php echo $anchor; // phpcs:ignore ?>>
	<div class="tool">
		<InnerBlocks allowedBlocks="<?php echo esc_attr( $allowed ); ?>" template="<?php echo esc_attr( $template ); ?>" />
	</div>
</section>
