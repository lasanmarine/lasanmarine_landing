<?php
/**
 * Deliverables — default appearance.
 *
 * @var object $data
 * @var bool   $is_preview
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( empty( $data->should_render ) ) {
	if ( $is_preview ) {
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Thêm hạng mục bàn giao ở thanh bên.', 'starter-flexible' ) );
	}
	return;
}

?>
<section class="<?php echo esc_attr( $data->module_class ); ?>" data-reveal<?php if ( $data->anchor ) : ?> id="<?php echo esc_attr( $data->anchor ); ?>"<?php endif; ?>>
	<div class="dl">
		<div class="dl__lead">
			<div class="dl__lead-top">
				<?php if ( '' !== trim( (string) $data->heading ) ) : ?>
					<h2 class="h3 dl__heading"><?php echo esc_html( $data->heading ); ?></h2>
				<?php endif; ?>
				<?php if ( '' !== trim( (string) $data->intro ) ) : ?>
					<p class="dl__intro"><?php echo esc_html( $data->intro ); ?></p>
				<?php endif; ?>
			</div>
			<?php if ( $data->has_note ) : ?>
				<p class="dl__note">
					<?php if ( '' !== trim( (string) $data->note_label ) ) : ?>
						<span class="dl__note-label"><?php echo esc_html( $data->note_label ); ?></span>
					<?php endif; ?>
					<span><?php echo esc_html( $data->note ); ?></span>
				</p>
			<?php endif; ?>
		</div>
		<ol class="dl__list" data-reveal-stagger>
			<?php foreach ( $data->items as $item ) : ?>
				<li class="dl__item">
					<span class="dl__check" aria-hidden="true"><?php echo starter_flexible_icon( 'check', 18 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<span class="dl__text">
						<span class="dl__title"><?php echo esc_html( $item['title'] ); ?></span>
						<?php if ( '' !== $item['desc'] ) : ?>
							<span class="dl__desc"><?php echo esc_html( $item['desc'] ); ?></span>
						<?php endif; ?>
					</span>
					<?php if ( '' !== $item['format'] ) : ?>
						<span class="dl__format"><?php echo esc_html( $item['format'] ); ?></span>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>
