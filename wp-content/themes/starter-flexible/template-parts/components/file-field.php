<?php
/**
 * FileField — the native file input is visually hidden inside its own label,
 * so the whole dashed plate is the click target and keyboard focus still
 * lands correctly.
 *
 * @var array $args label, action, name, hint, multiple, accept, id, attrs
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$label    = isset( $args['label'] ) ? (string) $args['label'] : '';
$action   = isset( $args['action'] ) ? (string) $args['action'] : '';
$name     = isset( $args['name'] ) ? (string) $args['name'] : '';
$hint     = isset( $args['hint'] ) ? (string) $args['hint'] : '';
$multiple = array_key_exists( 'multiple', $args ) ? (bool) $args['multiple'] : true;
$accept   = isset( $args['accept'] ) ? (string) $args['accept'] : '';
$id       = isset( $args['id'] ) ? (string) $args['id'] : ( '' !== $name ? $name : wp_unique_id( 'f-' ) );
$attrs    = isset( $args['attrs'] ) && is_array( $args['attrs'] ) ? $args['attrs'] : array();

$attr_html = '';
foreach ( $attrs as $key => $value ) {
	if ( true === $value ) {
		$attr_html .= ' ' . esc_attr( $key );
		continue;
	}
	if ( null === $value || false === $value ) {
		continue;
	}
	$attr_html .= sprintf( ' %s="%s"', esc_attr( $key ), esc_attr( (string) $value ) );
}
?>
<div class="field">
	<span class="field__label"><?php echo esc_html( $label ); ?></span>
	<label class="field__file" for="<?php echo esc_attr( $id ); ?>">
		<input
			id="<?php echo esc_attr( $id ); ?>"
			<?php echo '' !== $name ? 'name="' . esc_attr( $name ) . '"' : ''; ?>
			type="file"
			<?php echo $multiple ? 'multiple' : ''; ?>
			<?php echo '' !== $accept ? 'accept="' . esc_attr( $accept ) . '"' : ''; ?>
			<?php echo $attr_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		/>
		<span class="field__file-action">
			<?php echo esc_html( $action ); ?>
			<?php echo starter_flexible_icon( 'download', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</span>
		<?php if ( '' !== $hint ) : ?>
			<span class="field__hint"><?php echo esc_html( $hint ); ?></span>
		<?php endif; ?>
	</label>
</div>
