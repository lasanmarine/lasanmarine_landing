<?php
/**
 * Search engines and AI answer engines.
 *
 *   robots.txt  The site's own rules (served by WordPress/Yoast): every
 *               crawler may read the site, AI search and assistant crawlers
 *               are named explicitly, and the sitemap and llms.txt are
 *               listed. (A robots.txt that Cloudflare manages replaces
 *               these rules; it has to be switched off in Cloudflare.)
 *   /llms.txt   A plain-text map of the site for language models
 *               (llmstxt.org): who the company is, what it does, and the
 *               key pages in Vietnamese and English with one line each —
 *               taken from each page's own title and meta description, so
 *               it never drifts from the site.
 *   Project     Each project page describes the design as a CreativeWork
 *               made by the company.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* --- robots.txt -------------------------------------------------------- */
add_filter(
	'robots_txt',
	static function ( $output, $public ) {
		if ( ! $public ) {
			return $output;
		}
		$ai = array(
			// Search and answer engines that cite and link their sources.
			'OAI-SearchBot', 'ChatGPT-User', 'GPTBot',
			'Claude-SearchBot', 'Claude-User', 'ClaudeBot',
			'PerplexityBot', 'Perplexity-User',
			'Google-Extended', 'Applebot', 'Applebot-Extended',
			'Bingbot', 'DuckAssistBot', 'CCBot',
		);
		$lines   = array( '', '# AI search and assistant crawlers are welcome to read and cite this site.' );
		foreach ( $ai as $agent ) {
			$lines[] = 'User-agent: ' . $agent;
		}
		$lines[] = 'Allow: /';
		$lines[] = 'Disallow: /wp-admin/';
		$lines[] = '';
		$lines[] = '# Site summary for language models: ' . home_url( '/llms.txt' );
		if ( false === strpos( (string) $output, 'Sitemap:' ) ) {
			$lines[] = 'Sitemap: ' . home_url( '/sitemap_index.xml' );
		}
		return rtrim( (string) $output ) . "\n" . implode( "\n", $lines ) . "\n";
	},
	20,
	2
);

/* --- /llms.txt ----------------------------------------------------------- */

/** A page by its content key (tools/content), in its own language. */
function starter_flexible_ai_page( string $key ): ?WP_Post {
	$found = get_posts(
		array(
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'meta_key'       => '_lasan_content_key', // phpcs:ignore WordPress.DB.SlowDBQuery
			'meta_value'     => $key, // phpcs:ignore WordPress.DB.SlowDBQuery
			'lang'           => '',
		)
	);
	return $found ? $found[0] : null;
}

/** "- [Title](url): description" for each key that exists. */
function starter_flexible_ai_list( array $keys ): string {
	$out = '';
	foreach ( $keys as $key ) {
		$page = starter_flexible_ai_page( $key );
		if ( ! $page ) {
			continue;
		}
		$title = (string) get_post_meta( $page->ID, '_yoast_wpseo_title', true );
		$title = '' !== $title && function_exists( 'wpseo_replace_vars' ) ? wpseo_replace_vars( $title, $page ) : get_the_title( $page );
		$title = trim( (string) preg_replace( '/\s*\|\s*(Công ty TNHH Lasan Marine|Lasan Marine Co\., Ltd\.)\s*$/u', '', wp_strip_all_tags( $title ) ) );
		$desc  = trim( wp_strip_all_tags( (string) get_post_meta( $page->ID, '_yoast_wpseo_metadesc', true ) ) );
		$out  .= '- [' . $title . '](' . get_permalink( $page ) . ')' . ( '' !== $desc ? ': ' . $desc : '' ) . "\n";
	}
	return $out;
}

function starter_flexible_llms_txt(): string {
	$phone   = (string) starter_flexible_setting( 'phone', '' );
	$email   = (string) starter_flexible_setting( 'email', '' );
	$address = (string) starter_flexible_setting( 'address', '' );
	$tax     = (string) starter_flexible_setting( 'tax_code', '' );

	$t  = "# Công ty TNHH Lasan Marine (Lasan Marine Co., Ltd.)\n\n";
	$t .= "> Công ty thiết kế tàu và phần mềm hàng hải tại Nha Trang, Khánh Hòa, Việt Nam: thiết kế tàu cá vỏ thép và composite, tàu khách và cano, hoán cải và chuyển đổi nghề, tính toán ổn định, kết cấu, sức cản và lập hồ sơ thiết kế, thẩm định, đăng kiểm; phát triển phần mềm chuyên ngành hàng hải. Naval architecture and marine software firm in Nha Trang, Vietnam.\n\n";
	$t .= "Thông tin doanh nghiệp / Company facts:\n";
	$t .= "- Tên pháp lý: Công ty TNHH Lasan Marine; tên tiếng Anh: Lasan Marine Co., Ltd.\n";
	if ( '' !== $tax ) {
		$t .= '- Mã số thuế: ' . $tax . "\n";
	}
	if ( '' !== $address ) {
		$t .= '- Địa chỉ: ' . wp_strip_all_tags( $address ) . "\n";
	}
	if ( '' !== $phone ) {
		$t .= '- Điện thoại / Zalo: ' . $phone . "\n";
	}
	if ( '' !== $email ) {
		$t .= '- Email: ' . $email . "\n";
	}
	$t .= '- Website: ' . home_url( '/' ) . "\n\n";

	$t .= "## Dịch vụ (Tiếng Việt)\n\n" . starter_flexible_ai_list( array( 'service_01', 'design_steel', 'design_composite', 'design_conversion', 'design_passenger', 'approval_docs', 'service_rnd', 'service_03', 'capabilities' ) ) . "\n";
	$t .= "## Công ty, dự án, liên hệ\n\n" . starter_flexible_ai_list( array( 'about', 'projects', 'publications', 'insights', 'contact', 'design_brief' ) ) . "\n";
	$t .= "## Công cụ tính toán miễn phí\n\n" . starter_flexible_ai_list( array( 'tools', 'app_stability', 'app_resistance', 'app_structure', 'tool_power', 'tool_shaft', 'tool_engine' ) ) . "\n";

	$posts = get_posts( array( 'post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => 20, 'lang' => '' ) );
	if ( $posts ) {
		$t .= "## Bài viết kỹ thuật\n\n";
		foreach ( $posts as $post ) {
			$desc = trim( wp_strip_all_tags( (string) ( get_post_meta( $post->ID, '_yoast_wpseo_metadesc', true ) ?: $post->post_excerpt ) ) );
			$t   .= '- [' . wp_strip_all_tags( get_the_title( $post ) ) . '](' . get_permalink( $post ) . ')' . ( '' !== $desc ? ': ' . $desc : '' ) . "\n";
		}
		$t .= "\n";
	}

	$t .= "## English\n\n" . starter_flexible_ai_list( array( 'home_en', 'about_en', 'service_01_en', 'design_steel_en', 'design_composite_en', 'design_conversion_en', 'design_passenger_en', 'approval_docs_en', 'service_03_en', 'service_rnd_en', 'projects_en', 'tools_en', 'contact_en' ) ) . "\n";
	$t .= "## Optional\n\n" . starter_flexible_ai_list( array( 'accessibility', 'accessibility_en' ) );
	$t .= '- [Sitemap](' . home_url( '/sitemap_index.xml' ) . ")\n";
	return $t;
}

// Served before WordPress looks for a page: /llms.txt is plain text.
add_action(
	'parse_request',
	static function () {
		$path = trim( (string) wp_parse_url( (string) ( $_SERVER['REQUEST_URI'] ?? '' ), PHP_URL_PATH ), '/' ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
		if ( 'llms.txt' !== $path ) {
			return;
		}
		$cached = get_transient( 'starter_flexible_llms_txt' );
		if ( false === $cached ) {
			$cached = starter_flexible_llms_txt();
			set_transient( 'starter_flexible_llms_txt', $cached, DAY_IN_SECONDS );
		}
		status_header( 200 );
		header( 'Content-Type: text/plain; charset=utf-8' );
		header( 'X-Robots-Tag: noindex' );
		echo $cached; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- plain text.
		exit;
	},
	0
);
/*
 * Real files in the web root. The host's nginx answers any .txt path that is
 * not a file with 404 before WordPress is asked (it then falls back to PHP
 * but keeps the 404 status), so robots.txt and llms.txt are written out as
 * files, refreshed whenever content changes and on theme switch (and by
 * `php -r` after a deploy: starter_flexible_write_ai_files()).
 */
function starter_flexible_robots_body(): string {
	$out = "User-agent: *\nDisallow: /wp-admin/\nAllow: /wp-admin/admin-ajax.php\n";
	return (string) apply_filters( 'robots_txt', $out, (string) get_option( 'blog_public' ) ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- core hook.
}
function starter_flexible_write_ai_files(): bool {
	delete_transient( 'starter_flexible_llms_txt' );
	foreach ( array( 'llms.txt', 'robots.txt' ) as $file ) {
		$path = ABSPATH . $file;
		if ( file_exists( $path ) ? ! wp_is_writable( $path ) : ! wp_is_writable( ABSPATH ) ) {
			return false; // A read-only web root: /llms.txt is still served by parse_request.
		}
	}
	$ok  = false !== file_put_contents( ABSPATH . 'llms.txt', starter_flexible_llms_txt() ); // phpcs:ignore WordPress.WP.AlternativeFunctions
	$ok  = $ok && false !== file_put_contents( ABSPATH . 'robots.txt', starter_flexible_robots_body() ); // phpcs:ignore WordPress.WP.AlternativeFunctions
	return $ok;
}
// Any content change refreshes them (once, at the end of the request).
add_action(
	'save_post',
	static function () {
		delete_transient( 'starter_flexible_llms_txt' );
		if ( ! has_action( 'shutdown', 'starter_flexible_write_ai_files' ) ) {
			add_action( 'shutdown', 'starter_flexible_write_ai_files' );
		}
	}
);
add_action( 'after_switch_theme', 'starter_flexible_write_ai_files' );

/* --- Project: CreativeWork ------------------------------------------------ */
add_filter(
	'wpseo_schema_graph',
	static function ( $graph ) {
		if ( ! is_array( $graph ) || ! is_singular( 'project' ) ) {
			return $graph;
		}
		$id    = get_queried_object_id();
		$url   = (string) get_permalink( $id );
		$desc  = trim( wp_strip_all_tags( (string) ( get_post_meta( $id, '_yoast_wpseo_metadesc', true ) ?: get_the_excerpt( $id ) ) ) );
		$image = (string) get_the_post_thumbnail_url( $id, 'large' );
		$work  = array(
			'@type'            => 'CreativeWork',
			'@id'              => $url . '#design',
			'name'             => wp_strip_all_tags( get_the_title( $id ) ),
			'url'              => $url,
			'genre'            => starter_flexible_seo_is_english() ? 'Ship design' : 'Thiết kế tàu',
			'creator'          => array( '@id' => home_url( '/#organization' ) ),
			'mainEntityOfPage' => array( '@id' => $url ),
			'inLanguage'       => starter_flexible_seo_is_english() ? 'en' : 'vi',
		);
		if ( '' !== $desc ) {
			$work['description'] = $desc;
		}
		if ( '' !== $image ) {
			$work['image'] = $image;
		}
		$terms = array();
		foreach ( array( 'project_use', 'project_material' ) as $tax ) {
			foreach ( (array) get_the_terms( $id, $tax ) as $term ) {
				if ( $term instanceof WP_Term ) {
					$terms[] = $term->name;
				}
			}
		}
		if ( $terms ) {
			$work['keywords'] = implode( ', ', $terms );
		}
		$graph[] = $work;
		return $graph;
	},
	30
);
