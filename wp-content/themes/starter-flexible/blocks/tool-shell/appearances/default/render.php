<?php
/**
 * Tool Shell — default appearance. The calculator itself is an inner block.
 *
 * @var object $data
 * @var bool   $is_preview
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<section class="<?php echo esc_attr( $data->module_class ); ?>" data-reveal<?php if ( $data->anchor ) : ?> id="<?php echo esc_attr( $data->anchor ); ?>"<?php endif; ?>>
	<div class="tool">
		<InnerBlocks allowedBlocks="<?php echo esc_attr( $data->allowed ); ?>" template="<?php echo esc_attr( $data->template ); ?>" />
	</div>
</section>
