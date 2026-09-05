<?php
/**
 * Contact Statement — the closing statement on a navy field of stacked waves.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function starter_flexible_block_data_contact_statement( array $block ) {
	$data = array_merge(
		array(
			'label'        => '',
			'heading'      => '',
			'description'  => '',
			'phone'        => '',
			'email'        => '',
			'cta'          => array(),
			'mascot'       => 0,
			'custom_class' => '',
		),
		starter_flexible_get_block_fields( $block )
	);

	// Ten strokes drawn from the same curve, each one shifted up and fading.
	$waves = array();
	for ( $i = 0; $i < 10; $i++ ) {
		$waves[] = array(
			'd' => sprintf(
				'M-70 %1$d C200 %2$d 380 %3$d 600 %4$d C820 %5$d 1010 %6$d 1270 %7$d',
				346 - $i * 24,
				268 - $i * 24,
				372 - $i * 24,
				316 - $i * 24,
				260 - $i * 24,
				214 - $i * 24,
				228 - $i * 24
			),
			'w' => max( 2.4 - $i * 0.15, 1 ),
			'o' => number_format( 0.5 * pow( 0.78, $i ), 3, '.', '' ),
		);
	}

	$mascot_id = (int) $data['mascot'];

	$cta     = is_array( $data['cta'] ) ? $data['cta'] : array();
	$cta_url = isset( $cta['url'] ) ? (string) $cta['url'] : '';

	$data['waves']      = $waves;
	// No stand-in image: an unset mascot simply leaves the band to the copy.
	$data['mascot_url'] = $mascot_id ? (string) wp_get_attachment_image_url( $mascot_id, 'full' ) : '';
	$data['has_mascot'] = '' !== $data['mascot_url'];
	$data['cta']        = array(
		'url'    => $cta_url,
		'label'  => isset( $cta['title'] ) ? (string) $cta['title'] : '',
		'target' => ! empty( $cta['target'] ) ? (string) $cta['target'] : '_self',
	);
	$data['has_cta']       = '' !== $cta_url && '' !== $data['cta']['label'];
	$data['has_description'] = '' !== trim( wp_strip_all_tags( (string) $data['description'] ) );
	$data['has_label']     = '' !== trim( (string) $data['label'] );
	$data['has_phone']     = '' !== trim( (string) $data['phone'] );
	$data['has_email']     = '' !== trim( (string) $data['email'] );
	$data['phone_href']    = 'tel:' . preg_replace( '/\s/', '', (string) $data['phone'] );
	$data['module_class']  = starter_flexible_build_module_class( 'block', (string) $data['custom_class'] );
	$data['should_render'] = '' !== trim( wp_strip_all_tags( (string) $data['heading'] ) ) || $data['has_phone'] || $data['has_email'];

	return (object) $data;
}
