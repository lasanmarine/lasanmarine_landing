<?php
/**
 * Page Hero — default appearance.
 *
 * @var object $data
 * @var bool   $is_preview
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( empty( $data->should_render ) ) {
	if ( $is_preview ) {
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Nhập tiêu đề cho Page Hero ở thanh bên.', 'starter-flexible' ) );
	}
	return;
}

?>
<section class="<?php echo esc_attr( $data->module_class ); ?>" style="--phero-h:<?php echo esc_attr( (string) $data->height ); ?>px"<?php if ( $data->anchor ) : ?> id="<?php echo esc_attr( $data->anchor ); ?>"<?php endif; ?>>
	<div class="container phero__body">
		<div>
			<<?php echo esc_attr( $data->heading_level ); ?> class="phero__headline"><?php echo esc_html( $data->headline ); ?></<?php echo esc_attr( $data->heading_level ); ?>>
		</div>
		<?php if ( $data->has_lead ) : ?>
			<p class="copy phero__lead"><?php echo esc_html( $data->lead ); ?></p>
		<?php endif; ?>
		<?php if ( $data->actions ) : ?>
			<div class="phero__actions">
				<?php foreach ( $data->actions as $action ) : ?>
					<a
						class="btn<?php echo $action['primary'] ? '' : ' btn--secondary'; ?> phero__action"
						href="<?php echo esc_url( $action['url'] ); ?>"
						<?php echo '_blank' === $action['target'] ? 'target="_blank" rel="noopener"' : ''; ?>
						data-cta="hero"
						<?php echo empty( $action['fullscreen'] ) ? '' : 'data-app-fullscreen'; ?>
					>
						<?php echo esc_html( $action['label'] ); ?>
						<?php echo ! empty( $action['fullscreen'] ) ? starter_flexible_icon( 'expand', 18 ) : ( 0 === strpos( $action['url'], '#' ) ? starter_flexible_icon_swap( 'arrowDown', 18, 'down' ) : starter_flexible_icon_swap( 'arrow', 18 ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
		<?php /* Tags are kept in the editor but no longer shown: the quick links above do that job. */ ?>
	</div>
</section>
