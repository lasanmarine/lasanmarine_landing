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
	<?php if ( $data->has_heading ) : ?>
		<header class="tool__head">
			<h1 class="tool__title"><?php echo esc_html( $data->heading ); ?></h1>
			<?php if ( $data->has_lead ) : ?>
				<p class="tool__lead"><?php echo esc_html( $data->lead ); ?></p>
			<?php endif; ?>
		</header>
	<?php endif; ?>
	<div class="tool">
		<InnerBlocks allowedBlocks="<?php echo esc_attr( $data->allowed ); ?>" template="<?php echo esc_attr( $data->template ); ?>" />
	</div>
</section>
