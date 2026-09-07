<?php
/**
 * Hero — the cinematic hero. Full-bleed navy, content anchored to the bottom,
 * closed off by the wave.
 *
 * A hero is a list of slides: each one carries its own photograph, headline
 * and lead, while the buttons below belong to the block. One slide renders
 * exactly as it always did; two or more turn the same markup into a
 * cross-fading set with dots underneath.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Starter_Flexible_Block_Hero extends Starter_Flexible_Abstract_Block {
	protected function defaults(): array {
		return array(
			'items'           => array(),
			'image'           => 0,
			'headline'        => '',
			'headline_accent' => '',
			'headline_tail'   => '',
			'lead'            => '',
			'primary'         => array(),
			'secondary'       => array(),
			'autoplay'        => 4,
			'heading_level'   => 'h1',
			'custom_class'    => '',
		);
	}

	protected function base_class(): string {
		return 'hero band--navy';
	}

	protected function prepare( array $data ): array {

		$rows = is_array( $data['items'] ) ? $data['items'] : array();

		// Heroes written before the repeater existed keep their single set of
		// fields; it reads as slide one and nothing has to be migrated.
		if ( ! $rows ) {
			$rows = array(
				array(
					'image'           => $data['image'],
					'headline'        => $data['headline'],
					'headline_accent' => $data['headline_accent'],
					'headline_tail'   => $data['headline_tail'],
					'lead'            => $data['lead'],
				),
			);
		}

		$slides = array();
		foreach ( $rows as $row ) {
			$slide = starter_flexible_hero_slide( (array) $row, count( $slides ) === 0 );
			if ( $slide['is_empty'] ) {
				continue;
			}
			$slides[] = $slide;
		}

		$data['slides']    = $slides;
		$data['primary']   = starter_flexible_hero_link( $data['primary'] );
		$data['secondary'] = starter_flexible_hero_link( $data['secondary'] );

		$data['heading_level'] = in_array( $data['heading_level'], array( 'h1', 'h2' ), true ) ? $data['heading_level'] : 'h1';
		$data['has_actions']   = ! empty( $data['primary'] ) || ! empty( $data['secondary'] );
		$data['is_slider']     = count( $slides ) > 1;
		$data['has_lead']      = (bool) array_filter( array_column( $slides, 'has_lead' ) );
		$data['has_media']     = (bool) array_filter( array_column( $slides, 'image_html' ) );

		// Milliseconds, and only worth carrying when there is something to turn.
		$seconds           = max( 0.0, (float) $data['autoplay'] );
		$data['autoplay']  = $data['is_slider'] && $seconds > 0 ? (int) round( $seconds * 1000 ) : 0;

		$data['should_render'] = ! empty( $slides ) || $data['has_actions'];

		return $data;
	}
}

function starter_flexible_block_data_hero( array $block ) {
	return ( new Starter_Flexible_Block_Hero( $block ) )->data();
}

/**
 * One slide, prepared for the template.
 *
 * @param array<string, mixed> $row   Raw repeater row.
 * @param bool                 $first Whether this is the slide shown on load.
 * @return array<string, mixed>
 */
function starter_flexible_hero_slide( array $row, bool $first ): array {
	$image_id = (int) ( $row['image'] ?? 0 );
	$headline = trim( (string) ( $row['headline'] ?? '' ) );
	$accent   = trim( (string) ( $row['headline_accent'] ?? '' ) );
	$tail     = trim( (string) ( $row['headline_tail'] ?? '' ) );
	$lead     = trim( (string) ( $row['lead'] ?? '' ) );

	// The hero is the largest thing on the page and the LCP element, so the
	// original is served through the responsive sizes WordPress already has —
	// but only the first slide is worth the browser's early attention.
	$image_html = $image_id
		? (string) wp_get_attachment_image(
			$image_id,
			'full',
			false,
			array(
				'alt'           => '',
				'sizes'         => '100vw',
				'fetchpriority' => $first ? 'high' : 'low',
				'loading'       => $first ? 'eager' : 'lazy',
				'decoding'      => 'async',
			)
		)
		: '';

	return array(
		'image_html'      => $image_html,
		'headline'        => $headline,
		'headline_accent' => $accent,
		'headline_tail'   => $tail,
		'lead'            => $lead,
		'has_headline'    => '' !== $headline || '' !== $accent || '' !== $tail,
		'has_lead'        => '' !== $lead,
		'is_empty'        => '' === $headline && '' === $accent && '' === $tail && '' === $lead && '' === $image_html,
	);
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
