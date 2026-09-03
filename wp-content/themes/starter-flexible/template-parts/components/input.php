<?php
/**
 * Input — a labelled text control. `attrs` is forwarded to the <input> so
 * callers can still attach data-* hooks, min/max, autocomplete and so on.
 *
 * @var array $args label, name, type, required, hint, id, attrs
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$label    = isset( $args['label'] ) ? (string) $args['label'] : '';
$name     = isset( $args['name'] ) ? (string) $args['name'] : '';
$type     = isset( $args['type'] ) ? (string) $args['type'] : 'text';
$required = ! empty( $args['required'] );
$hint     = isset( $args['hint'] ) ? (string) $args['hint'] : '';
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
	<label class="field__label" for="<?php echo esc_attr( $id ); ?>">
		<?php echo esc_html( $label ); ?>
		<?php if ( $required ) : ?>
			<span class="field__req" aria-hidden="true">*</span>
		<?php endif; ?>
	</label>
	<input
		class="field__control"
		id="<?php echo esc_attr( $id ); ?>"
		<?php echo '' !== $name ? 'name="' . esc_attr( $name ) . '"' : ''; ?>
		type="<?php echo esc_attr( $type ); ?>"
		<?php echo $required ? 'required' : ''; ?>
		<?php echo '' !== $hint ? 'aria-describedby="' . esc_attr( $id ) . '-hint"' : ''; ?>
		<?php echo $attr_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	/>
	<?php if ( '' !== $hint ) : ?>
		<span class="field__hint" id="<?php echo esc_attr( $id ); ?>-hint"><?php echo esc_html( $hint ); ?></span>
	<?php endif; ?>
</div>
