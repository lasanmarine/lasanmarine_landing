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
		<span class="block-head__aside"><?php echo wp_kses_post( $aside ); ?></span>
	<?php endif; ?>
</div>
