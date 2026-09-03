<?php
/**
 * Textarea — a labelled multi-line control.
 *
 * @var array $args label, name, required, hint, rows, id, attrs
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$label    = isset( $args['label'] ) ? (string) $args['label'] : '';
$name     = isset( $args['name'] ) ? (string) $args['name'] : '';
$required = ! empty( $args['required'] );
$hint     = isset( $args['hint'] ) ? (string) $args['hint'] : '';
$rows     = isset( $args['rows'] ) ? (int) $args['rows'] : 5;
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
	<textarea
		class="field__control"
		id="<?php echo esc_attr( $id ); ?>"
		<?php echo '' !== $name ? 'name="' . esc_attr( $name ) . '"' : ''; ?>
		rows="<?php echo esc_attr( (string) $rows ); ?>"
		<?php echo $required ? 'required' : ''; ?>
		<?php echo '' !== $hint ? 'aria-describedby="' . esc_attr( $id ) . '-hint"' : ''; ?>
		<?php echo $attr_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	></textarea>
	<?php if ( '' !== $hint ) : ?>
		<span class="field__hint" id="<?php echo esc_attr( $id ); ?>-hint"><?php echo esc_html( $hint ); ?></span>
	<?php endif; ?>
</div>
