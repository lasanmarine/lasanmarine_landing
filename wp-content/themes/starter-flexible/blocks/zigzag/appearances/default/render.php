<?php
/**
 * Zigzag — default appearance.
 *
 * @var object $data
 * @var bool   $is_preview
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( empty( $data->should_render ) ) {
	if ( $is_preview ) {
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Thêm ít nhất một mục ở thanh bên.', 'starter-flexible' ) );
	}
	return;
}

?>
<section class="<?php echo esc_attr( $data->module_class ); ?>" data-reveal<?php if ( $data->anchor ) : ?> id="<?php echo esc_attr( $data->anchor ); ?>"<?php endif; ?>>
	<?php if ( '' !== trim( (string) $data->heading ) || $data->has_intro ) : ?>
		<header class="zz__head">
			<?php if ( '' !== trim( (string) $data->heading ) ) : ?>
				<<?php echo $data->heading_tag; // phpcs:ignore -- h1 or h2. ?> class="h3 zz__heading"><?php echo esc_html( $data->heading ); ?></<?php echo $data->heading_tag; // phpcs:ignore ?>>
			<?php endif; ?>
			<?php if ( $data->has_intro ) : ?>
				<p class="copy zz__intro"><?php echo esc_html( $data->intro ); ?></p>
			<?php endif; ?>
		</header>
	<?php endif; ?>
	<ol class="zz">
		<?php foreach ( $data->items as $i => $item ) : ?>
			<li class="zz__item" style="--zz-row:<?php echo (int) $i + 1; ?>">
				<span class="zz__node" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
				<div class="zz__card">
					<?php if ( '' !== $item['title'] ) : ?>
						<h3 class="zz__title"><?php echo esc_html( $item['title'] ); ?></h3>
					<?php endif; ?>
					<?php if ( '' !== $item['text'] ) : ?>
						<p class="zz__text"><?php echo esc_html( $item['text'] ); ?></p>
					<?php endif; ?>
				</div>
			</li>
		<?php endforeach; ?>
	</ol>
</section>
