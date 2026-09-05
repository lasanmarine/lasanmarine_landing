<?php
/**
 * BlockHead — the ruled label that opens a content block.
 *
 * @var array $args label, aside (optional pre-rendered HTML)
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$label = isset( $args['label'] ) ? (string) $args['label'] : '';
$aside = isset( $args['aside'] ) ? (string) $args['aside'] : '';
?>
<div class="block-head">
	<h2 class="h3 block-head__label"><?php echo esc_html( $label ); ?></h2>
	<?php if ( '' !== $aside ) : ?>
		<?php /* wp_kses_post() strips <svg>, so the icon set is allowed alongside it. */ ?>
		<span class="block-head__aside"><?php echo wp_kses( $aside, array_merge( wp_kses_allowed_html( 'post' ), starter_flexible_icon_kses() ) ); ?></span>
	<?php endif; ?>
</div>
