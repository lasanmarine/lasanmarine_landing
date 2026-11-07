<?php
/**
 * Shaft Diameter — default appearance.
 *
 * A shell for the Svelte island in assets/island.svelte, which shares the
 * Power Converter's `pc__*` shell so the calculators read as one tool.
 *
 * @var object $data
 * @var bool   $is_preview
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( empty( $data->should_render ) ) {
	if ( $is_preview ) {
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Thêm ít nhất một vật liệu ở thanh bên.', 'starter-flexible' ) );
	}
	return;
}

starter_flexible_island( 'shaft-diameter', $data->props, array( 'placeholder' => starter_flexible_island_noscript() ) );
