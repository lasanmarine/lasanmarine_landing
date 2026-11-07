<?php
/**
 * Page Hero — the compact hero every inner page opens with.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Starter_Flexible_Block_Page_Hero extends Starter_Flexible_Abstract_Block {
	protected function defaults(): array {
		return array(
			'headline'      => '',
			'lead'          => '',
			'tags'          => '',
			'actions'       => array(),
			'image'         => 0,
			'placeholder'   => '',
			'heading_level' => 'h1',
			'height'        => 420,
			'custom_class'  => '',
		);
	}

	protected function base_class(): string {
		return 'phero band--navy';
	}

	protected function prepare( array $data ): array {

		$image_id = (int) $data['image'];

		$data['image_url']     = $image_id ? (string) wp_get_attachment_image_url( $image_id, 'full' ) : '';
		// The page's opening picture: responsive sizes, fetched first.
		$data['image_html']    = $image_id
			? (string) wp_get_attachment_image(
				$image_id,
				'full',
				false,
				starter_flexible_image_priority_attrs( array( 'alt' => '', 'sizes' => '100vw' ) )
			)
			: '';
		$data['heading_level'] = in_array( $data['heading_level'], array( 'h1', 'h2' ), true ) ? $data['heading_level'] : 'h1';
		$data['height']        = $data['height'] > 0 ? min( 800, max( 200, (int) $data['height'] ) ) : 420;
		$data['has_media']     = '' !== $data['image_url'] || '' !== trim( (string) $data['placeholder'] );
		$data['has_lead']      = '' !== trim( wp_strip_all_tags( (string) $data['lead'] ) );
		$data['tags']          = array_values( array_filter( array_map( 'trim', explode( '·', (string) $data['tags'] ) ) ) );
		$data['actions']       = $this->actions( (array) $data['actions'] );
		$data['should_render'] = '' !== trim( wp_strip_all_tags( (string) $data['headline'] ) ) || $data['has_lead'];

		return $data;
	}

	/**
	 * Up to three buttons under the lead: the editor's own, or — when none
	 * are set — a contact button and the page's two main sections, so every
	 * hero leads somewhere useful without per-page setup.
	 *
	 * @return array<int, array{url: string, label: string, target: string, primary: bool}>
	 */
	private function actions( array $rows ): array {
		$out = array();
		foreach ( $rows as $row ) {
			$link = (array) ( $row['link'] ?? array() );
			if ( empty( $link['url'] ) || '' === trim( (string) ( $link['title'] ?? '' ) ) ) {
				continue;
			}
			$out[] = array(
				'url'     => (string) $link['url'],
				'label'   => (string) $link['title'],
				'target'  => (string) ( $link['target'] ?? '' ),
				'primary' => ! $out,
			);
		}
		$out = $out ? array_slice( $out, 0, 3 ) : $this->auto_actions();

		// A page built around an embedded app (app-embed) leads with opening
		// that app full screen, in place, on this same URL.
		if ( has_block( 'acf/app-embed', (int) get_the_ID() ) ) {
			$en = function_exists( 'pll_current_language' ) && 'en' === pll_current_language( 'slug' );
			foreach ( $out as &$action ) {
				$action['primary'] = false;
			}
			unset( $action );
			// The introduction page of a tool whose own address is the
			// full-screen app (page-app.php) leads there instead.
			$parent = (int) wp_get_post_parent_id( (int) get_the_ID() );
			$to_app = $parent && 'page-app.php' === get_page_template_slug( $parent );
			array_unshift(
				$out,
				$to_app
					? array(
						'url'     => (string) get_permalink( $parent ),
						'label'   => $en ? 'Open the tool' : 'Mở công cụ',
						'target'  => '',
						'primary' => true,
					)
					: array(
						'url'        => '#app',
						'label'      => $en ? 'Open full screen' : 'Mở toàn màn hình',
						'target'     => '',
						'primary'    => true,
						'fullscreen' => true,
					)
			);
			$out = array_slice( $out, 0, 3 );
		}
		return $out;
	}

	/** @return array<int, array{url: string, label: string, target: string, primary: bool}> */
	private function auto_actions(): array {
		$post_id = (int) get_the_ID();
		if ( ! $post_id ) {
			return array();
		}
		// Sections worth a shortcut, most useful first. The label comes from
		// the block's own heading.
		$priority = array( 'vessel-finder', 'project-showcase', 'project-index', 'use-case', 'service-architecture', 'capability-matrix', 'tool-shell', 'document-center', 'insights', 'deliverables', 'input-output', 'process-timeline', 'service-spotlight', 'value-grid', 'geo-operations', 'image-text', 'spec-list', 'accordion' );
		$found    = array();
		foreach ( parse_blocks( (string) get_post_field( 'post_content', $post_id ) ) as $block ) {
			$slug = str_replace( 'acf/', '', (string) ( $block['blockName'] ?? '' ) );
			$data = (array) ( $block['attrs']['data'] ?? array() );
			$head = trim( wp_strip_all_tags( (string) ( $data['heading'] ?? '' ) ) );
			$id   = (string) ( $block['attrs']['anchor'] ?? '' );
			$rank = array_search( $slug, $priority, true );
			if ( false === $rank || '' === $head ) {
				continue;
			}
			$found[ $rank * 100 + count( $found ) ] = array(
				'url'     => '#' . ( '' !== $id ? $id : starter_flexible_page_hero_slug( $head ) ),
				'label'   => $head,
				'target'  => '',
				'primary' => false,
			);
		}
		ksort( $found );

		// The shortcuts name what the page holds; contact already sits in the
		// header and at the foot of the page.
		$actions = array_slice( array_values( $found ), 0, 3 );
		if ( $actions ) {
			$actions[0]['primary'] = true;
		}
		return $actions;
	}
}


/**
 * Slug a heading the way behaviours/onpage-nav.js does, so an anchor made
 * here matches the id the script gives the section.
 */
function starter_flexible_page_hero_slug( string $text ): string {
	$slug = strtolower( remove_accents( $text ) );
	$slug = (string) preg_replace( '/[^a-z0-9]+/', '-', $slug );
	return substr( trim( $slug, '-' ), 0, 40 );
}

function starter_flexible_block_data_page_hero( array $block ) {
	return ( new Starter_Flexible_Block_Page_Hero( $block ) )->data();
}
