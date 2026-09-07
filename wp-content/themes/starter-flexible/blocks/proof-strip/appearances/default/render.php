<?php
/**
 * Proof Strip — default appearance.
 *
 * @var object $data
 * @var bool   $is_preview
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( empty( $data->should_render ) ) {
	if ( $is_preview ) {
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Thêm ba đến bốn bằng chứng ngắn ở thanh bên.', 'starter-flexible' ) );
	}
	return;
}

?>
<section class="<?php echo esc_attr( $data->module_class ); ?>" data-reveal<?php if ( $data->anchor ) : ?> id="<?php echo esc_attr( $data->anchor ); ?>"<?php endif; ?>>
	<div class="band band--pale ps">
		<div class="container ps__row" data-reveal-stagger>
			<?php
			foreach ( $data->items as $item ) :
				$tag   = $item['has_link'] ? 'a' : 'div';
				$attrs = '';
				if ( $item['has_link'] ) {
					$attrs = ' href="' . esc_url( $item['link_url'] ) . '"';
					if ( '_blank' === $item['link_target'] ) {
						$attrs .= ' target="_blank" rel="noopener"';
					}
				}
				?>
				<<?php echo esc_html( $tag ); ?> class="ps__item<?php echo $item['has_link'] ? ' ps__item--link' : ''; ?>"<?php echo $attrs; // phpcs:ignore ?>>
					<span class="ps__value"><?php echo esc_html( $item['value'] ); ?></span>
					<span class="ps__label"><?php echo esc_html( $item['label'] ); ?></span>
					<?php if ( $item['has_note'] ) : ?>
						<span class="ps__note"><?php echo esc_html( $item['note'] ); ?></span>
					<?php endif; ?>
				</<?php echo esc_html( $tag ); ?>>
			<?php endforeach; ?>
		</div>
	</div>
</section>
