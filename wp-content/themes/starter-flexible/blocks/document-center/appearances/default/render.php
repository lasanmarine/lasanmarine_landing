<?php
/**
 * Document Center — default appearance.
 *
 * @var object $data
 * @var bool   $is_preview
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( empty( $data->should_render ) ) {
	if ( $is_preview ) {
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Thêm nhóm và tài liệu ở thanh bên.', 'starter-flexible' ) );
	}
	return;
}

?>
<section class="<?php echo esc_attr( $data->module_class ); ?>" data-reveal<?php if ( $data->anchor ) : ?> id="<?php echo esc_attr( $data->anchor ); ?>"<?php endif; ?>>
	<?php if ( '' !== $data->heading || '' !== $data->view_all_url ) : ?>
		<div class="dc__head">
			<?php if ( '' !== $data->heading ) : ?>
				<h2 class="h3 dc__heading"><?php echo esc_html( $data->heading ); ?></h2>
			<?php endif; ?>
			<?php if ( '' !== $data->view_all_url ) : ?>
				<a class="link link--fixed link--lg" href="<?php echo esc_url( $data->view_all_url ); ?>">
					<?php echo esc_html( $data->view_all_text ); ?>
					<?php echo starter_flexible_icon( 'arrow' ); // phpcs:ignore ?>
				</a>
			<?php endif; ?>
		</div>
	<?php endif; ?>
	<div class="dc__filters" role="tablist" data-doc-filters>
		<button type="button" class="dc__filter" data-doc-filter="all" data-active="true">
			<?php echo esc_html( $data->all_label ); ?>
		</button>
		<?php foreach ( $data->filters as $i => $filter ) : ?>
			<button type="button" class="dc__filter" data-doc-filter="<?php echo esc_attr( (string) $i ); ?>" data-active="false">
				<?php echo esc_html( $filter ); ?>
			</button>
		<?php endforeach; ?>
	</div>
	<div class="dc__grid" data-doc-list data-reveal-stagger="[data-doc-group]">
		<?php foreach ( $data->items as $item ) : ?>
			<article class="dc__card" data-doc-group="<?php echo esc_attr( (string) $item['group'] ); ?>">
				<div class="dc__meta">
					<span class="dc__icon"><?php echo starter_flexible_icon( 'file', 22 ); // phpcs:ignore ?></span>
					<?php if ( '' !== $item['year'] ) : ?>
						<span class="dc__year"><?php echo esc_html( $item['year'] ); ?></span>
					<?php endif; ?>
					<?php if ( '' !== $item['source'] ) : ?>
						<span class="dc__source"><?php echo esc_html( $item['source'] ); ?></span>
					<?php endif; ?>
				</div>
				<h3 class="dc__title"><?php echo esc_html( $item['title'] ); ?></h3>
				<div class="dc__foot">
					<span class="dc__tag"><?php echo esc_html( $data->filters[ $item['group'] ] ?? '' ); ?></span>
					<?php if ( '' !== $item['size'] ) : ?>
						<span class="dc__size"><?php echo esc_html( $item['size'] ); ?></span>
					<?php endif; ?>
					<span class="dc__actions">
						<?php if ( $item['is_pdf'] ) : ?>
							<a class="btn btn--sm btn--secondary dc__view" href="<?php echo esc_url( $item['file'] ); ?>" target="_blank" rel="noopener">
								<?php esc_html_e( 'Xem PDF', 'starter-flexible' ); ?>
							</a>
						<?php endif; ?>
						<?php if ( '' !== $item['file'] ) : ?>
							<a class="btn btn--sm dc__dl" href="<?php echo esc_url( $item['file'] ); ?>" download>
								<?php esc_html_e( 'Tải xuống', 'starter-flexible' ); ?>
								<?php echo starter_flexible_icon_swap( 'download', 18 ); // phpcs:ignore ?>
							</a>
						<?php else : ?>
							<a class="link dc__ask" href="<?php echo esc_url( $data->contact_url ); ?>">
								<?php esc_html_e( 'Liên hệ để nhận tài liệu', 'starter-flexible' ); ?>
								<?php echo starter_flexible_icon_swap( 'arrow', 16 ); // phpcs:ignore ?>
							</a>
						<?php endif; ?>
					</span>
				</div>
			</article>
		<?php endforeach; ?>
		<p class="dc__empty" data-doc-empty hidden><?php echo esc_html( $data->empty_text ); ?></p>
	</div>
</section>
