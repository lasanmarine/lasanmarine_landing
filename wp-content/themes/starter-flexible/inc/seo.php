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
	// The name Google shows above the link in results is the WebSite name.
	// It comes from Yoast's "Website name" (Settings → Site basics), falling
	// back to the site title; Yoast's "Alternate website name" and the site
	// title go in alternateName. The registered name goes in legalName.
	// (The Site Settings names are display text for the header and footer, in
	// capitals, so they are not used here.)
	$brand      = (string) get_bloginfo( 'name' );
	$titles     = (array) get_option( 'wpseo_titles', array() );
	$name       = trim( (string) ( $titles['website_name'] ?? '' ) ) ?: $brand;
	$legal_name = 'Công ty TNHH Lasan Marine';
	// Every way people type the name, so a search for any of them — "Lasan
	// Marine" as two words, the capitalised logo form, the domain's one word,
	// the English company name — resolves to this organisation.
	$alt_names  = array_values(
		array_unique(
			array_filter(
				array( trim( (string) ( $titles['alternate_website_name'] ?? '' ) ), 'Lasan Marine', 'LASAN MARINE', 'lasanmarine', 'Lasan Marine Co., Ltd.', $brand, $legal_name ),
				static fn( $n ) => '' !== $n && $n !== $name
			)
		)
	);
	$phone      = (string) starter_flexible_setting( 'phone', '' );
	$email      = (string) starter_flexible_setting( 'email', '' );
	$address    = (string) starter_flexible_setting( 'address', '' );
	$tax_code   = (string) starter_flexible_setting( 'tax_code', '' );
	$logo_id    = (int) starter_flexible_setting( 'header_logo', 0 );
	$logo_url   = $logo_id ? (string) wp_get_attachment_image_url( $logo_id, 'full' ) : get_template_directory_uri() . '/assets/images/logo-lasan.svg';

	$same_as = array();
	foreach ( (array) starter_flexible_setting( 'social', array() ) as $row ) {
		$link = starter_flexible_link( $row['link'] ?? array() );
		// Only real profiles elsewhere: a link back to this site is not one.
		$host = (string) wp_parse_url( (string) $link['url'], PHP_URL_HOST );
		if ( '' !== $host && $host !== (string) wp_parse_url( home_url(), PHP_URL_HOST ) ) {
			$same_as[] = $link['url'];
		}
	}

	$org = array(
		'@type'       => array( 'Organization', 'ProfessionalService' ),
		'@id'         => $org_id,
		'name'          => $name,
		'alternateName' => $alt_names,
		'url'         => home_url( '/' ),
		'logo'        => array(
			'@type' => 'ImageObject',
			'@id'   => home_url( '/#logo' ),
			'url'   => $logo_url,
		),
		'image'       => array( '@id' => home_url( '/#logo' ) ),
		'description' => $is_english
			? 'Lasan Marine Co., Ltd. is a naval architecture and marine software firm in Nha Trang, Vietnam: fishing vessel, support vessel and passenger boat design, conversions, stability and structural calculations, approval documents, and marine engineering software development.'
			: 'Công ty TNHH Lasan Marine là công ty thiết kế tàu và phần mềm hàng hải tại Nha Trang, Khánh Hòa: thiết kế tàu cá, tàu hậu cần thủy sản, cano chở khách; hoán cải, tính toán ổn định, kết cấu, hồ sơ thiết kế, đăng kiểm và phát triển phần mềm chuyên ngành hàng hải.',
		'areaServed'  => array( '@type' => 'Country', 'name' => 'Vietnam' ),
		'knowsAbout'  => $is_english
			? array( 'Ship design', 'Naval architecture', 'Fishing vessel design', 'Vessel conversion', 'Stability calculation', 'Hull structure', 'Marine R&D', 'CFD simulation', 'Marine engineering software development', 'Software outsourcing' )
			: array( 'Thiết kế tàu', 'Thiết kế tàu cá', 'Thiết kế tàu vỏ thép', 'Thiết kế tàu composite', 'Hoán cải tàu cá', 'Hồ sơ đăng kiểm tàu cá', 'Tính toán ổn định tàu', 'Mô phỏng CFD', 'Phần mềm chuyên ngành hàng hải', 'Gia công phần mềm' ),
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
			$graph[ $i ]['name']          = $name;
			$graph[ $i ]['alternateName'] = $alt_names;
			$graph[ $i ]['publisher']     = array( '@id' => $org_id );
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

/**
 * og:site_name: Yoast prints the WordPress site title here, not its "Website
 * name". Google reads both when choosing the name it shows above a result,
 * so give them the same value as the WebSite schema above.
 */
add_filter(
	'wpseo_opengraph_site_name',
	static function ( $site_name ) {
		$titles = (array) get_option( 'wpseo_titles', array() );
		$name   = trim( (string) ( $titles['website_name'] ?? '' ) );
		return '' !== $name ? $name : $site_name;
	}
);

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
	$suffix = ( '' !== $material && false === mb_stripos( $card['title'], $material ) ) ? ' vỏ ' . $material : '';
	// "<content> | Company": the site's title pattern (see tools/content/*.json).
	$title  = $is_english
		? sprintf( '%s Design | Lasan Marine Co., Ltd.', $card['title'] )
		: sprintf( 'Thiết kế %s%s | Công ty TNHH Lasan Marine', mb_strtolower( mb_substr( $card['title'], 0, 1 ) ) . mb_substr( $card['title'], 1 ), $suffix );

	$facts = implode( ', ', array_filter( array( $card['tag'], $card['meta'], $card['location'] ) ) );
	$tail  = $is_english
		? 'Design, conversion and approval drawings by Lasan Marine.'
		: 'Thiết kế, hoán cải và hồ sơ đăng kiểm: Lasan Marine.';
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

/**
 * Pages served as static apps beside WordPress (not WordPress pages), so Yoast
 * cannot list them itself: added to the page sitemap by path.
 *
 * @return string[] Site-relative paths.
 */
function starter_flexible_static_app_paths(): array {
	// The simulators are WordPress pages now (app embedded via acf/app-embed),
	// so Yoast lists them itself; nothing to add by hand.
	return array();
}

add_filter(
	'wpseo_sitemap_page_content',
	static function ( string $content ): string {
		foreach ( starter_flexible_static_app_paths() as $path ) {
			$content .= "\t<url>\n\t\t<loc>" . esc_url( home_url( $path ) ) . "</loc>\n\t</url>\n";
		}
		return $content;
	}
);

/* -------------------------------------------------------------------------
 * v2 SEO additions.
 * ---------------------------------------------------------------------- */

/**
 * og:title falls back to the SEO title (not the bare page name, e.g. "Trang chủ")
 * when no social title was written by hand.
 */
add_filter(
	'wpseo_opengraph_title',
	static function ( $title ) {
		if ( ! is_singular() || starter_flexible_has_yoast_meta( 'opengraph-title' ) ) {
			return $title;
		}
		$seo_title = (string) get_post_meta( get_queried_object_id(), '_yoast_wpseo_title', true );
		if ( '' === $seo_title || ! function_exists( 'wpseo_replace_vars' ) ) {
			return $title;
		}
		return wpseo_replace_vars( $seo_title, get_queried_object() );
	},
	20
);

/**
 * hreflang x-default → the Vietnamese version (the site's default language).
 */
add_filter(
	'pll_rel_hreflang_attributes',
	static function ( $hreflangs ) {
		if ( is_array( $hreflangs ) && isset( $hreflangs['vi'] ) && ! isset( $hreflangs['x-default'] ) ) {
			$hreflangs['x-default'] = $hreflangs['vi'];
		}
		return $hreflangs;
	}
);

/**
 * The ACF blocks of the current page, parsed once.
 *
 * @return array<int, array<string, mixed>>
 */
function starter_flexible_seo_page_blocks(): array {
	static $blocks = null;
	if ( null === $blocks ) {
		$post   = is_singular() ? get_post( get_queried_object_id() ) : null;
		$blocks = $post ? parse_blocks( (string) $post->post_content ) : array();
	}
	return $blocks;
}

/**
 * FAQPage from the page's accordion blocks, and Service for capability pages.
 *
 * @param array<int, array<string, mixed>> $graph Schema graph pieces.
 * @return array<int, array<string, mixed>>
 */
function starter_flexible_schema_page_extras( $graph ) {
	if ( ! is_array( $graph ) || ! is_singular( 'page' ) ) {
		return $graph;
	}
	$url = get_permalink( get_queried_object_id() );

	// FAQ: every accordion item with a question and an answer.
	$faq = array();
	foreach ( starter_flexible_seo_page_blocks() as $block ) {
		if ( 'acf/accordion' !== ( $block['blockName'] ?? '' ) ) {
			continue;
		}
		$data  = (array) ( $block['attrs']['data'] ?? array() );
		$count = (int) ( $data['items'] ?? 0 );
		for ( $i = 0; $i < $count; $i++ ) {
			$q = trim( wp_strip_all_tags( (string) ( $data[ "items_{$i}_title" ] ?? '' ) ) );
			$a = trim( wp_strip_all_tags( (string) ( $data[ "items_{$i}_content" ] ?? '' ) ) );
			if ( '' !== $q && '' !== $a ) {
				$faq[] = array(
					'@type'          => 'Question',
					'name'           => $q,
					'acceptedAnswer' => array( '@type' => 'Answer', 'text' => $a ),
				);
			}
		}
	}
	if ( $faq ) {
		$graph[] = array(
			'@type'      => 'FAQPage',
			'@id'        => $url . '#faq',
			'mainEntity' => $faq,
		);
	}

	// Service: pages under the capabilities section.
	$path = (string) wp_parse_url( (string) $url, PHP_URL_PATH );
	if ( preg_match( '#/(nang-luc|capabilities)/.+#', $path ) ) {
		$desc    = (string) get_post_meta( get_queried_object_id(), '_yoast_wpseo_metadesc', true );
		$graph[] = array(
			'@type'       => 'Service',
			'@id'         => $url . '#service',
			'name'        => wp_strip_all_tags( get_the_title( get_queried_object_id() ) ),
			'description' => $desc,
			'url'         => $url,
			'provider'    => array( '@id' => home_url( '/#organization' ) ),
			'areaServed'  => array( '@type' => 'Country', 'name' => 'Vietnam' ),
		);
	}

	// WebApplication: a tool page that opens the tool full screen.
	if ( 'page-app.php' === get_page_template_slug( get_queried_object_id() ) ) {
		$desc    = (string) get_post_meta( get_queried_object_id(), '_yoast_wpseo_metadesc', true );
		$graph[] = array(
			'@type'               => 'WebApplication',
			'@id'                 => $url . '#app',
			'name'                => wp_strip_all_tags( get_the_title( get_queried_object_id() ) ),
			'description'         => $desc,
			'url'                 => $url,
			'applicationCategory' => 'DesignApplication',
			'operatingSystem'     => 'Any (web browser)',
			'browserRequirements' => 'Requires JavaScript',
			'inLanguage'          => starter_flexible_seo_is_english() ? 'en' : 'vi',
			'isAccessibleForFree' => true,
			'offers'              => array(
				'@type'         => 'Offer',
				'price'         => '0',
				'priceCurrency' => 'VND',
			),
			'publisher'           => array( '@id' => home_url( '/#organization' ) ),
			'mainEntityOfPage'    => array( '@id' => $url ),
		);
	}

	return $graph;
}
add_filter( 'wpseo_schema_graph', 'starter_flexible_schema_page_extras', 30 );
