<?php
/**
 * Svelte islands — the PHP half.
 *
 * An island is a Svelte component that owns one piece of a block (the tools:
 * power converter, shaft diameter, engine lookup, design brief). PHP prints a
 * shell carrying the component's props as JSON; fe/src/runtime/islands.js
 * finds the shell and mounts `blocks/{name}/assets/island.svelte` into it.
 *
 * Everything the component shows that comes from WordPress — labels, units,
 * catalogue data, icons — travels in the props, so no copy is hard-coded in
 * JavaScript and translations stay in PHP.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Print an island shell.
 *
 * @param string               $name        Island name: the block slug, or a file in fe/src/islands.
 * @param array<string, mixed> $props       Props handed to the component.
 * @param array<string, mixed> $args        `class`, `attrs` (extra attributes), `placeholder` (HTML shown until it mounts).
 */
function starter_flexible_island( string $name, array $props, array $args = array() ): void {
	$json = wp_json_encode( $props, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE );

	$attrs = '';
	foreach ( (array) ( $args['attrs'] ?? array() ) as $key => $value ) {
		$attrs .= true === $value ? ' ' . esc_attr( (string) $key ) : sprintf( ' %s="%s"', esc_attr( (string) $key ), esc_attr( (string) $value ) );
	}

	printf(
		'<div class="%1$s" data-island="%2$s"%3$s><script type="application/json" data-props>%4$s</script>%5$s</div>',
		esc_attr( trim( 'island ' . (string) ( $args['class'] ?? '' ) ) ),
		esc_attr( $name ),
		$attrs, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped above.
		false === $json ? '{}' : $json, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- JSON with HTML-significant characters hex-escaped.
		(string) ( $args['placeholder'] ?? '' ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- caller-built markup.
	);
}

/**
 * A set of theme icons as SVG strings, for an island to print with {@html}.
 *
 * @param array<string, array{0: string, 1?: int, 2?: string}> $map key => [icon name, size, class].
 * @return array<string, string>
 */
function starter_flexible_island_icons( array $map ): array {
	$out = array();
	foreach ( $map as $key => $spec ) {
		$out[ $key ] = starter_flexible_icon( (string) $spec[0], (int) ( $spec[1] ?? 19 ), (string) ( $spec[2] ?? '' ) );
	}
	return $out;
}

/** The "requires JavaScript" note printed inside an island until it mounts. */
function starter_flexible_island_noscript(): string {
	return '<noscript><p class="island__noscript">' . esc_html__( 'Công cụ này cần bật JavaScript.', 'starter-flexible' ) . '</p></noscript>';
}
