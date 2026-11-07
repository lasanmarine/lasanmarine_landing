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
$is_gallery = isset( $args['variant'] ) && 'gallery' === $args['variant'];
// The gallery keeps each picture's own shape, so cards differ in height and
// the listing reads as a masonry wall rather than a uniform grid.
$ratio = $is_row ? 'ratio-3-2' : ( $is_gallery ? '' : 'ratio-4-3' );
?>
<a
	class="pj-card<?php echo $is_row ? ' pj-card--row' : ''; ?><?php echo $is_gallery ? ' pj-card--gallery' : ''; ?>"
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
				'ratio'       => $ratio,
				'class'       => 'frame--zoom' . ( $is_gallery ? ' frame--natural' : '' ),
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
		<?php if ( '' !== ( $item['work'] ?? '' ) ) : ?>
			<span class="pj-card__work"><?php echo esc_html( $item['work'] ); ?></span>
		<?php endif; ?>
		<?php if ( ! $is_gallery && '' !== ( $item['scope'] ?? '' ) ) : ?>
			<span class="pj-card__scope"><?php echo esc_html( $item['scope'] ); ?></span>
		<?php endif; ?>
		<?php if ( $is_gallery && '' !== $item['meta'] ) : ?>
			<span class="pj-card__specs">
				<?php foreach ( array_filter( array_map( 'trim', explode( '·', $item['meta'] ) ) ) as $spec ) : ?>
					<span><?php echo esc_html( $spec ); ?></span>
				<?php endforeach; ?>
				<?php if ( '' !== $item['year'] ) : ?>
					<span><?php echo esc_html( $item['year'] ); ?></span>
				<?php endif; ?>
			</span>
		<?php elseif ( '' !== $item['meta'] ) : ?>
			<span class="pj-card__meta"><?php echo esc_html( $item['meta'] ); ?><?php echo '' !== $item['year'] ? esc_html( ' · ' . $item['year'] ) : ''; ?></span>
		<?php endif; ?>

		<?php if ( ! $is_row ) : ?>
			<span class="pj-card__more">
				<?php esc_html_e( 'Xem dự án', 'starter-flexible' ); ?>
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
