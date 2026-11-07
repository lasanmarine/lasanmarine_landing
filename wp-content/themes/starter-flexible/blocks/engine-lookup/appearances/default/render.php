<?php
/**
 * Engine Lookup — default appearance.
 *
 * A shell for the Svelte island in assets/island.svelte, built on the Power
 * Converter's `pc__*` shell so the tools read as one family.
 *
 * @var object $data
 * @var bool   $is_preview
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( empty( $data->should_render ) ) {
	if ( $is_preview ) {
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Không đọc được dữ liệu động cơ.', 'starter-flexible' ) );
	}
	return;
}

starter_flexible_island( 'engine-lookup', $data->props, array( 'placeholder' => starter_flexible_island_noscript() ) );
