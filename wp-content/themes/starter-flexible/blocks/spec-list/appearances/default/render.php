<?php
/**
 * Spec List — default appearance.
 *
 * @var object $data
 * @var bool   $is_preview
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( empty( $data->should_render ) ) {
	if ( $is_preview ) {
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Nhập tiêu đề và các dòng thông số ở thanh bên.', 'starter-flexible' ) );
	}
	return;
}

?>
<section class="<?php echo esc_attr( $data->module_class ); ?>" data-reveal<?php if ( $data->anchor ) : ?> id="<?php echo esc_attr( $data->anchor ); ?>"<?php endif; ?>>
	<div class="sl">
		<div class="sl__intro">
			<<?php echo $data->heading_tag; // phpcs:ignore -- h1 or h2. ?> class="h3"><?php echo esc_html( $data->heading ); ?></<?php echo $data->heading_tag; // phpcs:ignore ?>>
			<?php if ( $data->has_note ) : ?>
				<p class="sl__note"><?php echo esc_html( $data->note ); ?></p>
			<?php endif; ?>
		</div>
		<div data-reveal-stagger>
			<?php foreach ( $data->rows as $row ) : ?>
				<div class="spec">
					<span class="spec__label"><?php echo esc_html( $row['label'] ); ?></span>
					<span class="spec__leader"></span>
					<?php
					// A phone number or an email is a link: tap to call or write.
					$sl_v    = trim( (string) $row['value'] );
					$sl_href = is_email( $sl_v ) ? 'mailto:' . $sl_v : ( preg_match( '/^\+?[\d\s.]{8,}$/', $sl_v ) ? 'tel:' . preg_replace( '/[^\d+]/', '', $sl_v ) : '' );
					?>
					<?php if ( '' !== $sl_href ) : ?>
						<a class="spec__value" href="<?php echo esc_url( $sl_href ); ?>"><?php echo esc_html( $sl_v ); ?></a>
					<?php else : ?>
						<span class="spec__value"><?php echo esc_html( $row['value'] ); ?></span>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
