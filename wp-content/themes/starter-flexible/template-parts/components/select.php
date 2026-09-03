<?php
/**
 * Select — a labelled select. `options` takes plain strings or
 * array( 'value' => …, 'label' => … ) pairs.
 *
 * @var array $args label, options, name, required, hint, placeholder, id, attrs
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$label       = isset( $args['label'] ) ? (string) $args['label'] : '';
$options     = isset( $args['options'] ) && is_array( $args['options'] ) ? $args['options'] : array();
$name        = isset( $args['name'] ) ? (string) $args['name'] : '';
$required    = ! empty( $args['required'] );
$hint        = isset( $args['hint'] ) ? (string) $args['hint'] : '';
$placeholder = isset( $args['placeholder'] ) ? (string) $args['placeholder'] : '';
$id          = isset( $args['id'] ) ? (string) $args['id'] : ( '' !== $name ? $name : wp_unique_id( 'f-' ) );
$attrs       = isset( $args['attrs'] ) && is_array( $args['attrs'] ) ? $args['attrs'] : array();

$items = array();
foreach ( $options as $option ) {
	if ( is_array( $option ) ) {
		$items[] = array(
			'value' => (string) ( $option['value'] ?? '' ),
			'label' => (string) ( $option['label'] ?? '' ),
		);
		continue;
	}
	$items[] = array( 'value' => (string) $option, 'label' => (string) $option );
}

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
	<select
		class="field__control"
		id="<?php echo esc_attr( $id ); ?>"
		<?php echo '' !== $name ? 'name="' . esc_attr( $name ) . '"' : ''; ?>
		<?php echo $required ? 'required' : ''; ?>
		<?php echo '' !== $hint ? 'aria-describedby="' . esc_attr( $id ) . '-hint"' : ''; ?>
		<?php echo $attr_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	>
		<?php if ( '' !== $placeholder ) : ?>
			<option value=""><?php echo esc_html( $placeholder ); ?></option>
		<?php endif; ?>
		<?php foreach ( $items as $item ) : ?>
			<option value="<?php echo esc_attr( $item['value'] ); ?>"><?php echo esc_html( $item['label'] ); ?></option>
		<?php endforeach; ?>
	</select>
	<?php if ( '' !== $hint ) : ?>
		<span class="field__hint" id="<?php echo esc_attr( $id ); ?>-hint"><?php echo esc_html( $hint ); ?></span>
	<?php endif; ?>
</div>
