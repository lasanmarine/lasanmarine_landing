<?php
/**
 * Accordion — default appearance.
 *
 * @var object $data
 * @var bool   $is_preview
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( empty( $data->should_render ) ) {
	if ( $is_preview ) {
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Thêm ít nhất một mục cho accordion ở thanh bên.', 'starter-flexible' ) );
	}
	return;
}

?>
<section class="<?php echo esc_attr( $data->module_class ); ?>" data-reveal<?php if ( $data->anchor ) : ?> id="<?php echo esc_attr( $data->anchor ); ?>"<?php endif; ?>>
	<?php if ( $data->has_label ) : ?>
		<?php get_template_part( 'template-parts/components/block-head', null, array( 'label' => $data->label ) ); ?>
	<?php endif; ?>
	<div class="ac">
		<?php if ( $data->has_heading || $data->has_intro ) : ?>
			<div class="ac__intro">
				<?php if ( $data->has_heading ) : ?>
					<h2 class="h4"><?php echo esc_html( $data->heading ); ?></h2>
				<?php endif; ?>
				<?php if ( $data->has_intro ) : ?>
					<p class="copy"><?php echo esc_html( $data->intro ); ?></p>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<div class="ac__list" data-accordion data-reveal-stagger>
			<?php foreach ( $data->items as $item ) : ?>
				<div class="ac__item">
					<h3 class="ac__row">
						<button
							type="button"
							class="ac__trigger"
							id="<?php echo esc_attr( $item['button_id'] ); ?>"
							aria-expanded="<?php echo $item['is_open'] ? 'true' : 'false'; ?>"
							aria-controls="<?php echo esc_attr( $item['panel_id'] ); ?>"
						>
							<span class="ac__title"><?php echo esc_html( $item['title'] ); ?></span>
							<span class="ac__sign" aria-hidden="true"></span>
						</button>
					</h3>
					<div
						class="ac__panel"
						id="<?php echo esc_attr( $item['panel_id'] ); ?>"
						role="region"
						aria-labelledby="<?php echo esc_attr( $item['button_id'] ); ?>"
						<?php echo $item['is_open'] ? '' : 'hidden'; ?>
					>
						<?php if ( $item['has_body'] ) : ?>
							<div class="prose ac__body"><?php echo wp_kses_post( $item['content'] ); ?></div>
						<?php endif; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
