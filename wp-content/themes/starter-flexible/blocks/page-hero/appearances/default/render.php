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
		<?php if ( $data->tags ) : ?>
			<ul class="phero__tags">
				<?php foreach ( $data->tags as $tag ) : ?>
					<li><?php echo esc_html( $tag ); ?></li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
</section>
