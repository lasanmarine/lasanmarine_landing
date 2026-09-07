<?php
/**
 * Input / Output — default appearance.
 *
 * @var object $data
 * @var bool   $is_preview
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( empty( $data->should_render ) ) {
	if ( $is_preview ) {
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Thêm mục cho ít nhất một cột đầu vào / xử lý / đầu ra.', 'starter-flexible' ) );
	}
	return;
}

$last_index = count( $data->columns ) - 1;
?>
<section class="<?php echo esc_attr( $data->module_class ); ?>" data-reveal<?php if ( $data->anchor ) : ?> id="<?php echo esc_attr( $data->anchor ); ?>"<?php endif; ?>>
	<?php if ( $data->has_label ) : ?>
		<?php get_template_part( 'template-parts/components/block-head', null, array( 'label' => $data->label ) ); ?>
	<?php endif; ?>
	<?php if ( $data->has_heading || $data->has_intro ) : ?>
		<div class="io__intro">
			<?php if ( $data->has_heading ) : ?>
				<h2 class="h4"><?php echo esc_html( $data->heading ); ?></h2>
			<?php endif; ?>
			<?php if ( $data->has_intro ) : ?>
				<p class="copy"><?php echo esc_html( $data->intro ); ?></p>
			<?php endif; ?>
		</div>
	<?php endif; ?>
	<div class="io" data-reveal-stagger>
		<?php foreach ( $data->columns as $index => $column ) : ?>
			<div class="io__col io__col--<?php echo esc_attr( $column['kind'] ); ?>">
				<div class="io__head">
					<span class="io__step"><?php echo esc_html( str_pad( (string) ( $index + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
					<h3 class="io__title"><?php echo esc_html( $column['title'] ); ?></h3>
				</div>
				<ul class="io__items">
					<?php foreach ( $column['items'] as $item ) : ?>
						<li><?php echo esc_html( $item ); ?></li>
					<?php endforeach; ?>
				</ul>
				<?php if ( $index < $last_index ) : ?>
					<span class="io__arrow" aria-hidden="true"><?php echo starter_flexible_icon( 'arrow', 22 ); // phpcs:ignore ?></span>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	</div>
</section>
