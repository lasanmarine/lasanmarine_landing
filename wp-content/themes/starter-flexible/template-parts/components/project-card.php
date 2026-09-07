<?php
/**
 * Project card — one vessel in a listing.
 *
 * Two shapes for the same record: `card` stacks the photograph over the name
 * for a grid, `row` sets it beside the name for a catalogue read top to bottom.
 *
 * @var array $args item (from starter_flexible_project_card), filter_key, variant
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$item = isset( $args['item'] ) && is_array( $args['item'] ) ? $args['item'] : array();
if ( empty( $item['title'] ) ) {
	return;
}

$filter_key = isset( $args['filter_key'] ) ? (string) $args['filter_key'] : 'materials';
$terms      = isset( $item[ $filter_key ] ) && is_array( $item[ $filter_key ] ) ? $item[ $filter_key ] : array();
$is_row     = isset( $args['variant'] ) && 'row' === $args['variant'];
?>
<a
	class="pj-card<?php echo $is_row ? ' pj-card--row' : ''; ?>"
	href="<?php echo esc_url( $item['url'] ); ?>"
	data-pi-item
	data-terms="<?php echo esc_attr( implode( ' ', $terms ) ); ?>"
>
	<span class="pj-card__media">
		<?php
		get_template_part(
			'template-parts/components/frame',
			null,
			array(
				'ratio'       => $is_row ? 'ratio-3-2' : 'ratio-4-3',
				'class'       => 'frame--zoom',
				'src'         => $item['image_url'],
				'alt'         => $item['title'],
				'placeholder' => $item['placeholder'],
			)
		);
		?>
	</span>
	<span class="pj-card__body">
		<?php if ( '' !== $item['tag'] ) : ?>
			<span class="pj-card__tag"><?php echo esc_html( $item['tag'] ); ?></span>
		<?php endif; ?>
		<span class="pj-card__name"><?php echo esc_html( $item['title'] ); ?></span>
		<?php if ( '' !== $item['meta'] ) : ?>
			<span class="pj-card__meta"><?php echo esc_html( $item['meta'] ); ?></span>
		<?php endif; ?>

		<?php if ( ! $is_row ) : ?>
			<span class="pj-card__more">
				<?php esc_html_e( 'Xem hồ sơ', 'starter-flexible' ); ?>
				<?php echo starter_flexible_icon_swap( 'arrow', 16 ); // phpcs:ignore ?>
			</span>
		<?php endif; ?>
	</span>

	<?php if ( $is_row ) : ?>
		<?php /* The whole row is the link; this only shows where it leads. */ ?>
		<span class="pj-card__go" aria-hidden="true">
			<?php echo starter_flexible_icon_swap( 'arrow', 26 ); // phpcs:ignore ?>
		</span>
	<?php endif; ?>
</a>
