<?php
/**
 * Project card — one vessel in a listing.
 *
 * @var array $args item (from starter_flexible_project_card), filter_key
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
?>
<a
	class="pj-card"
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
				'ratio'       => 'ratio-4-3',
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
		<span class="pj-card__more">
			<?php esc_html_e( 'Xem hồ sơ', 'starter-flexible' ); ?>
			<?php echo starter_flexible_icon_swap( 'arrow', 16 ); // phpcs:ignore ?>
		</span>
	</span>
</a>
