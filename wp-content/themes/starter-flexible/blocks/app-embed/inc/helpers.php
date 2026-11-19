<?php
/**
 * App Embed — a prebuilt single-page app (theme/apps/<slug>/) shown in a frame.
 *
 * The apps are full-viewport React builds with their own global CSS, so they
 * run in an iframe: neither their styles nor the theme's can leak across.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Starter_Flexible_Block_App_Embed extends Starter_Flexible_Abstract_Block {
	protected function defaults(): array {
		return array(
			'app'          => '',
			'title'        => '',
			'custom_class' => '',
		);
	}

	protected function base_class(): string {
		return 'block container';
	}

	protected function prepare( array $data ): array {
		// The plugin's current version of the app, else the theme's copy (inc/static-apps.php).
		$data['src']           = starter_flexible_app_src( (string) $data['app'] );
		$data['frame_title']   = '' !== trim( (string) $data['title'] ) ? (string) $data['title'] : __( 'Công cụ mô phỏng', 'starter-flexible' );
		$data['should_render'] = '' !== $data['src'];

		return $data;
	}
}

function starter_flexible_block_data_app_embed( array $block ) {
	return ( new Starter_Flexible_Block_App_Embed( $block ) )->data();
}
