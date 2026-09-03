<?php
/**
 * Register widget areas.
 *
 * @package Starter_Flexible
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function starter_flexible_widgets_init(): void {
	register_sidebar(
		array(
			'name'          => __( 'Sidebar', 'starter-flexible' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Add widgets here.', 'starter-flexible' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'starter_flexible_widgets_init' );
