<?php
/**
 * Hero — the cinematic hero. Full-bleed navy, content anchored to the bottom,
 * closed off by the wave.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function starter_flexible_block_data_hero( array $block ) {
	$data = array_merge(
		array(
			'image'           => 0,
			'headline'        => '',
			'headline_accent' => '',
			'headline_tail'   => '',
			'lead'            => '',
			'primary'         => array(),
			'secondary'       => array(),
			'heading_level'   => 'h1',
			'custom_class'    => '',
		),
		starter_flexible_get_block_fields( $block )
	);

	$image_id = (int) $data['image'];

	// The hero is the largest thing on the page and the LCP element, so the
	// original is served through the responsive sizes WordPress already has.
	$data['image_html'] = $image_id
		? (string) wp_get_attachment_image(
			$image_id,
			'full',
			false,
			array(
				'alt'           => '',
				'sizes'         => '100vw',
				'fetchpriority' => 'high',
				'decoding'      => 'async',
			)
		)
		: '';

	$data['primary']       = starter_flexible_hero_link( $data['primary'] );
	$data['secondary']     = starter_flexible_hero_link( $data['secondary'] );
	$data['heading_level'] = in_array( $data['heading_level'], array( 'h1', 'h2' ), true ) ? $data['heading_level'] : 'h1';
	$data['module_class']  = starter_flexible_build_module_class( 'hero band--navy', (string) $data['custom_class'] );
	$data['has_lead']      = '' !== trim( (string) $data['lead'] );
	$data['has_actions']   = ! empty( $data['primary'] ) || ! empty( $data['secondary'] );
	$data['should_render'] = '' !== trim( (string) $data['headline'] ) || $data['has_lead'] || $data['has_actions'];

	return (object) $data;
}

/**
 * Normalise one ACF link field into the shape the button part expects.
 *
 * @param mixed $link Raw link field value.
 * @return array<string, string>
 */
function starter_flexible_hero_link( $link ): array {
	$link  = is_array( $link ) ? $link : array();
	$url   = isset( $link['url'] ) ? (string) $link['url'] : '';
	$label = isset( $link['title'] ) ? (string) $link['title'] : '';

	if ( '' === $url || '' === $label ) {
		return array();
	}

	return array(
		'url'    => $url,
		'label'  => $label,
		'target' => ! empty( $link['target'] ) ? (string) $link['target'] : '_self',
	);
}
