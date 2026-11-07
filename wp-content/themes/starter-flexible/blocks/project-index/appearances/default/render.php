<?php
/**
 * Project Index — default appearance.
 *
 * @var object $data
 * @var bool   $is_preview
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( empty( $data->should_render ) ) {
	if ( $is_preview ) {
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Chưa có dự án nào trong post type Dự án.', 'starter-flexible' ) );
	}
	return;
}

?>
<section class="<?php echo esc_attr( $data->module_class ); ?>" data-reveal data-project-index<?php if ( $data->anchor ) : ?> id="<?php echo esc_attr( $data->anchor ); ?>"<?php endif; ?>>

	<?php /* The filters and the tally sit on one line: what is being shown, and
	         how much of it. The tally is rewritten by the script on every filter. */ ?>
	<?php $pi_en = function_exists( 'pll_current_language' ) && 'en' === pll_current_language( 'slug' ); ?>
	<label class="pi__search" data-merge-search>
		<span class="sr-only"><?php echo esc_html( $pi_en ? 'Search projects' : 'Tìm dự án' ); ?></span>
		<?php echo starter_flexible_icon( 'search', 22 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		<input type="search" data-pi-search placeholder="<?php echo esc_attr( $pi_en ? 'Search by name, vessel type, material, size…' : 'Tìm theo tên tàu, loại tàu, vật liệu, kích thước…' ); ?>" autocomplete="off" />
	</label>

	<div class="pi__bar">
		<?php if ( $data->filters ) : ?>
			<div class="pi__filters" role="group" aria-label="<?php esc_attr_e( 'Lọc dự án', 'starter-flexible' ); ?>">
				<button type="button" class="pi__filter" data-pi-filter="" aria-pressed="true"><?php echo esc_html( $data->all_label ); ?></button>
				<?php foreach ( $data->filters as $filter ) : ?>
					<button type="button" class="pi__filter" data-pi-filter="<?php echo esc_attr( $filter['slug'] ); ?>" aria-pressed="false">
						<?php echo esc_html( $filter['name'] ); ?>
					</button>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<p class="pi__count" data-pi-count data-label="<?php echo esc_attr( $data->count_label ); ?>" aria-live="polite">
			<?php echo esc_html( count( $data->items ) . ' ' . $data->count_label ); ?>
		</p>
	</div>

	<div class="pi__list pi__list--gallery">
		<?php foreach ( $data->items as $item ) : ?>
			<?php get_template_part( 'template-parts/components/project-card', null, array( 'item' => $item, 'filter_key' => $data->filter_key, 'variant' => 'gallery' ) ); ?>
		<?php endforeach; ?>
	</div>

	<p class="pi__empty" data-pi-empty hidden><?php echo esc_html( $data->empty_text ); ?></p>
</section>
