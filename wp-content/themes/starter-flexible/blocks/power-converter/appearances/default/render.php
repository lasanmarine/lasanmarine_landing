<?php
/**
 * Power Converter — default appearance.
 *
 * A shell for the Svelte island in assets/island.svelte; the form itself is
 * rendered there from the props built in inc/helpers.php.
 *
 * @var object $data
 * @var bool   $is_preview
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( empty( $data->should_render ) ) {
	if ( $is_preview ) {
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Thêm các đơn vị quy đổi ở thanh bên.', 'starter-flexible' ) );
	}
	return;
}

starter_flexible_island( 'power-converter', $data->props, array( 'placeholder' => starter_flexible_island_noscript() ) );
