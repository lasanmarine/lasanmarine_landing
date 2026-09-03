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
	<?php get_template_part( 'template-parts/components/block-head', null, array( 'label' => $data->label ) ); ?>
	<div class="tool">
		<div class="tool__intro">
			<h2 class="h4"><?php echo esc_html( $data->heading ); ?></h2>
			<?php if ( $data->has_lead ) : ?>
				<p class="copy tool__lead"><?php echo esc_html( $data->lead ); ?></p>
			<?php endif; ?>
			<?php if ( $data->has_note ) : ?>
				<p class="tool__note"><?php echo esc_html( $data->note ); ?></p>
			<?php endif; ?>
		</div>
		<div class="tool__body">
			<InnerBlocks allowedBlocks="<?php echo esc_attr( $allowed ); ?>" template="<?php echo esc_attr( $template ); ?>" />
		</div>
	</div>
</section>
