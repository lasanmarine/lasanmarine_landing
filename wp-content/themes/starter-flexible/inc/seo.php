<?php
/**
 * SEO additions on top of Yoast: the business itself in the schema graph, and
 * written titles and descriptions for projects nobody has filled in by hand.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Whether the current request is the English side of the site.
 */
function starter_flexible_seo_is_english(): bool {
	return function_exists( 'pll_current_language' ) && 'en' === pll_current_language( 'slug' );
}

/* -------------------------------------------------------------------------
 * Schema: the company as an Organization / ProfessionalService node.
 * ---------------------------------------------------------------------- */

/**
 * Add the company node to Yoast's graph and make it the site's publisher.
 *
 * Yoast's own Organization settings are empty on this site; everything here
 * comes from the theme's Site Settings, so the footer and the schema can never
 * disagree about the address or the phone number.
 *
 * @param array<int, array<string, mixed>> $graph Schema graph pieces.
 * @return array<int, array<string, mixed>>
 */
function starter_flexible_schema_organization( $graph ) {
	if ( ! is_array( $graph ) ) {
		return $graph;
	}

	$org_id     = home_url( '/#organization' );
	$is_english = starter_flexible_seo_is_english();
	$name       = (string) starter_flexible_setting( 'site_name', get_bloginfo( 'name' ) );
	$legal_name = (string) starter_flexible_setting( 'legal_name', '' );
	$phone      = (string) starter_flexible_setting( 'phone', '' );
	$email      = (string) starter_flexible_setting( 'email', '' );
	$address    = (string) starter_flexible_setting( 'address', '' );
	$tax_code   = (string) starter_flexible_setting( 'tax_code', '' );
	$logo_id    = (int) starter_flexible_setting( 'header_logo', 0 );
	$logo_url   = $logo_id ? (string) wp_get_attachment_image_url( $logo_id, 'full' ) : get_template_directory_uri() . '/assets/images/logo-lasan.svg';

	$same_as = array();
	foreach ( (array) starter_flexible_setting( 'social', array() ) as $row ) {
		$link = starter_flexible_link( $row['link'] ?? array() );
		if ( '' !== $link['url'] ) {
			$same_as[] = $link['url'];
		}
	}

	$org = array(
		'@type'       => array( 'Organization', 'ProfessionalService' ),
		'@id'         => $org_id,
		'name'        => $name,
		'url'         => home_url( '/' ),
		'logo'        => array(
			'@type' => 'ImageObject',
			'@id'   => home_url( '/#logo' ),
			'url'   => $logo_url,
		),
		'image'       => array( '@id' => home_url( '/#logo' ) ),
		'description' => $is_english
			? 'Naval architecture firm in Nha Trang, Vietnam: fishing vessel, support vessel and passenger boat design, conversions, stability and structural calculations, and class/registry approval documents.'
			: 'Công ty thiết kế tàu tại Nha Trang, Khánh Hòa: thiết kế tàu cá, tàu hậu cần thủy sản, cano chở khách; hoán cải, tính toán ổn định, kết cấu và hoàn thiện hồ sơ thiết kế, đăng kiểm.',
		'areaServed'  => array( '@type' => 'Country', 'name' => 'Vietnam' ),
		'knowsAbout'  => $is_english
			? array( 'Ship design', 'Fishing vessel design', 'Vessel conversion', 'Stability calculation', 'Hull structure', 'Marine R&D', 'CFD simulation' )
			: array( 'Thiết kế tàu', 'Thiết kế tàu cá', 'Thiết kế tàu vỏ thép', 'Thiết kế tàu composite', 'Hoán cải tàu cá', 'Hồ sơ đăng kiểm tàu cá', 'Tính toán ổn định tàu', 'Mô phỏng CFD' ),
	);

	if ( '' !== $legal_name ) {
		$org['legalName'] = $legal_name;
	}
	if ( '' !== $phone ) {
		$org['telephone'] = $phone;
	}
	if ( '' !== $email ) {
		$org['email'] = $email;
	}
	if ( '' !== $tax_code ) {
		$org['taxID'] = $tax_code;
	}
	if ( '' !== $address ) {
		$org['address'] = array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => $address,
			'addressLocality' => 'Nha Trang',
			'addressRegion'   => 'Khánh Hòa',
			'addressCountry'  => 'VN',
		);
	}
	if ( $same_as ) {
		$org['sameAs'] = $same_as;
	}

	$has_org = false;
	foreach ( $graph as $i => $piece ) {
		$types = (array) ( $piece['@type'] ?? array() );
		if ( in_array( 'Organization', $types, true ) ) {
			$graph[ $i ] = array_merge( $piece, $org );
			$has_org     = true;
		}
		if ( in_array( 'WebSite', $types, true ) ) {
			$graph[ $i ]['publisher'] = array( '@id' => $org_id );
			if ( empty( $piece['description'] ) ) {
				$graph[ $i ]['description'] = $org['description'];
			}
		}
	}
	if ( ! $has_org ) {
		$graph[] = $org;
	}

	return $graph;
}
add_filter( 'wpseo_schema_graph', 'starter_flexible_schema_organization', 20 );

/* -------------------------------------------------------------------------
 * Projects: a title and description written from the vessel's own record.
 * ---------------------------------------------------------------------- */

/**
 * The generated title and description for the current project, or null when
 * this is not a project page. Hand-written Yoast values always win.
 *
 * @return array{title: string, description: string}|null
 */
function starter_flexible_project_seo(): ?array {
	static $cache = false;
	if ( false !== $cache ) {
		return $cache;
	}
	if ( ! is_singular( 'project' ) ) {
		return $cache = null; // phpcs:ignore Squiz.PHP.DisallowMultipleAssignments
	}

	$post = get_queried_object();
	if ( ! $post instanceof WP_Post ) {
		return $cache = null; // phpcs:ignore Squiz.PHP.DisallowMultipleAssignments
	}

	$card       = starter_flexible_project_card( $post );
	$is_english = starter_flexible_seo_is_english();
	$materials  = wp_get_post_terms( $post->ID, 'project_material', array( 'fields' => 'names' ) );
	$material   = is_array( $materials ) && $materials ? mb_strtolower( (string) $materials[0] ) : '';

	// The material joins the title only when the vessel's name does not already say it.
	$suffix = ( '' !== $material && false === mb_stripos( $card['title'], $material ) ) ? ' tàu vỏ ' . $material : '';
	$title  = $is_english
		? sprintf( '%s — Vessel Design Documents | LASAN MARINE', $card['title'] )
		: sprintf( '%s — Hồ sơ thiết kế%s | LASAN MARINE', $card['title'], $suffix );

	$facts = implode( ', ', array_filter( array( $card['tag'], $card['meta'], $card['location'] ) ) );
	$tail  = $is_english
		? 'Design, conversion and approval drawings by LASAN MARINE.'
		: 'Thiết kế, hoán cải và hồ sơ đăng kiểm: LASAN MARINE.';
	$head  = $card['title'] . ( '' !== $facts ? ': ' . $facts : '' ) . '.';

	// The facts give way before the closing line does: it carries the keywords.
	$room = 158 - mb_strlen( $tail ) - 1;
	if ( mb_strlen( $head ) > $room ) {
		$head = rtrim( mb_substr( $head, 0, $room - 1 ), ' ,.;:·' ) . '….';
	}
	$description = $head . ' ' . $tail;

	return $cache = array( 'title' => $title, 'description' => $description ); // phpcs:ignore Squiz.PHP.DisallowMultipleAssignments
}

/**
 * Whether the editor has written this Yoast field for the current post.
 */
function starter_flexible_has_yoast_meta( string $key ): bool {
	return '' !== trim( (string) get_post_meta( get_queried_object_id(), '_yoast_wpseo_' . $key, true ) );
}

add_filter(
	'wpseo_title',
	static function ( $title ) {
		$seo = starter_flexible_project_seo();
		return ( $seo && ! starter_flexible_has_yoast_meta( 'title' ) ) ? $seo['title'] : $title;
	}
);
add_filter(
	'wpseo_opengraph_title',
	static function ( $title ) {
		$seo = starter_flexible_project_seo();
		return ( $seo && ! starter_flexible_has_yoast_meta( 'opengraph-title' ) && ! starter_flexible_has_yoast_meta( 'title' ) ) ? $seo['title'] : $title;
	}
);
foreach ( array( 'wpseo_metadesc', 'wpseo_opengraph_desc', 'wpseo_twitter_description' ) as $starter_flexible_desc_filter ) {
	add_filter(
		$starter_flexible_desc_filter,
		static function ( $description ) {
			$seo = starter_flexible_project_seo();
			return ( $seo && ! starter_flexible_has_yoast_meta( 'metadesc' ) ) ? $seo['description'] : $description;
		}
	);
}
