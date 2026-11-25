<?php
/**
 * Global site settings from the static export: the ACF options the header,
 * footer, nav overlay, schema and design-brief letterhead read (see
 * wp-content/themes/starter-flexible/inc/site-settings.php), the site name,
 * the site icon and the Yoast defaults that show in every <head>.
 *
 * Everything is parsed from the static home page (header, nav overlay, footer,
 * head), so re-running it after a new export picks the changes up. Safe to run
 * again: values are overwritten, media is imported once.
 *
 *   docker exec -u www-data -e WP_HOME=http://192.168.1.199:49731 lasan_wp \
 *     php /var/www/html/tools/static-import/site-settings.php [--dry-run]
 *
 * The English side needs nothing here: the theme overrides the CTA, address
 * and legal name for EN in starter_flexible_setting(), and the rest is shared.
 *
 * @package Starter_Flexible
 */

declare(strict_types=1);

if ( 'cli' !== PHP_SAPI ) {
	exit( 1 );
}

$root = getenv( 'WP_PATH' ) ?: dirname( __DIR__, 2 );
$home = getenv( 'WP_HOME' ) ?: 'http://localhost';
$_SERVER['HTTP_HOST']   = $_SERVER['HTTP_HOST'] ?? ( parse_url( $home, PHP_URL_HOST ) . ( parse_url( $home, PHP_URL_PORT ) ? ':' . parse_url( $home, PHP_URL_PORT ) : '' ) );
$_SERVER['REQUEST_URI'] = $_SERVER['REQUEST_URI'] ?? '/';
error_reporting( E_ALL & ~E_DEPRECATED & ~E_NOTICE & ~E_WARNING );
require_once $root . '/wp-load.php';
error_reporting( E_ALL & ~E_DEPRECATED & ~E_NOTICE & ~E_WARNING );
require_once $root . '/tools/lib/content.php';
require_once __DIR__ . '/lib.php';
require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/class-wp-site-icon.php';

$dry = in_array( '--dry-run', $argv, true );

if ( ! function_exists( 'update_field' ) ) {
	fwrite( STDERR, "ACF chưa bật\n" );
	exit( 1 );
}

lasan_content_lang( 'vi' );
$doc = ls_load( ls_docs() . '/index.html' );

/* -------------------------------------------------------------------------
 * Helpers.
 * ---------------------------------------------------------------------- */

/** ACF link value ({title, url, target}) from an <a>; pages resolve to their permalink. */
function ss_link( ?DOMElement $a ): array {
	if ( ! $a ) {
		return array();
	}
	$l   = ls_link( $a );
	$url = '';
	if ( isset( $l['page'] ) ) {
		$id  = lasan_content_find_page( (string) $l['page'] );
		$url = $id ? (string) get_permalink( $id ) : '';
		if ( ! $id ) {
			fwrite( STDERR, "  ! không tìm thấy trang {$l['page']}\n" );
		}
		// The page map drops the fragment ("/#" is the home page plus "#").
		if ( $url && preg_match( '/#.*$/', (string) ls_site_path( $a->getAttribute( 'href' ) ), $frag ) ) {
			$url .= $frag[0];
		}
	} elseif ( isset( $l['url'] ) ) {
		$url = (string) $l['url'];
		// Site-relative (e.g. "/#"): store absolute, as the admin would.
		if ( str_starts_with( $url, '/' ) && ! str_starts_with( $url, '//' ) ) {
			$url = untrailingslashit( (string) get_option( 'home' ) ) . $url;
		}
	}
	return array(
		'title'  => (string) $l['label'],
		'url'    => $url,
		'target' => (string) ( $l['target'] ?? '' ),
	);
}

/** The value of the footer spec row with this label, inside $ctx. */
function ss_spec( DOMNode $ctx, string $label ): string {
	foreach ( ls_all( $ctx, '.spec' ) as $row ) {
		if ( ls_t( $row, '.spec__label' ) === $label ) {
			$value = ls_one( $row, '.spec__value' );
			if ( ! $value ) {
				return '';
			}
			// The copy button's label sits inside the value; leave it out.
			$text = '';
			foreach ( $value->childNodes as $c ) {
				if ( $c instanceof DOMText ) {
					$text .= $c->textContent;
				}
			}
			return trim( (string) preg_replace( '/\s+/u', ' ', $text ) );
		}
	}
	return '';
}

/** Attachment id for an uploaded image URL in the export (imported on first use), or 0. */
function ss_media( string $url ): int {
	$ref = ls_image( $url );
	if ( ! is_array( $ref ) ) {
		return 0;
	}
	return ls_media_id_fresh( $ref['media'] );
}

$set = static function ( string $name, $value ) use ( $dry ): void {
	printf( "  %-18s %s\n", $name, wp_json_encode( $value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) );
	if ( ! $dry ) {
		update_field( $name, $value, 'option' );
	}
};

/* -------------------------------------------------------------------------
 * ACF options (Site Settings).
 * ---------------------------------------------------------------------- */

echo "Site Settings (ACF options)\n";

$brand = ls_one( $doc, 'header .hdr__brand' );
$footer = ls_one( $doc, 'footer.ftr' );
$details = ls_one( $footer, '.ftr__details' );
$bank_el = ls_one( $footer, '.ftr__bank' );

// General.
$set( 'site_name', $brand ? $brand->getAttribute( 'aria-label' ) : '' );
$set( 'legal_name', ss_spec( $details, 'Tên công ty' ) );
$set( 'tax_code', ss_spec( $details, 'MST' ) );
$set( 'address', ss_spec( $details, 'Địa chỉ' ) );
$set( 'phone', ss_spec( $details, 'Điện thoại' ) );
$set( 'email', ss_spec( $details, 'Email' ) );
$iframe = ls_one( $footer, '.ftr__map iframe' );
$maps   = $iframe && preg_match( '/[?&]key=([^&]+)/', html_entity_decode( $iframe->getAttribute( 'src' ) ), $m ) ? rawurldecode( $m[1] ) : '';
$set( 'maps_api_key', $maps );

// Header. The logo is the theme's own SVG unless the export shows an upload.
$logo = $brand ? ls_one( $brand, 'img' ) : null;
$logo_id = $logo && str_contains( $logo->getAttribute( 'src' ), '/wp-content/uploads/' ) ? ss_media( $logo->getAttribute( 'src' ) ) : 0;
$set( 'header_logo', $logo_id ?: '' );
$set( 'footer_logo', '' ); // footer.php draws the header logo.
$strip = ls_one( $doc, 'header .hdr__strip' );
$set( 'announcement_text', $strip ? ls_t( $strip, 'span' ) : '' );
$set( 'announcement_cta', $strip ? ss_link( ls_one( $strip, 'a' ) ) : array() );
$set( 'header_cta', ss_link( ls_one( $doc, 'header .hdr__cta' ) ) );

// Footer.
$set( 'wordmark', implode( '|', array_filter( explode( "\n", ls_text_br( ls_one( $footer, '.ftr__wordmark' ) ) ) ) ) );
$set( 'footer_cta', ss_link( ls_one( $footer, '.ftr__statement a' ) ) );

$bank = array();
if ( $bank_el ) {
	$number = ss_spec( $bank_el, 'Số tài khoản' ); // "310781 (VND)"
	$bank   = array(
		'holder'   => ss_spec( $bank_el, 'Chủ tài khoản' ),
		'number'   => trim( (string) preg_replace( '/\s*\([^)]*\)\s*$/', '', $number ) ),
		'currency' => preg_match( '/\(([^)]*)\)\s*$/', $number, $m ) ? $m[1] : '',
		'name'     => ss_spec( $bank_el, 'Ngân hàng' ),
		'swift'    => ss_spec( $bank_el, 'Swift code' ),
	);
}
$set( 'bank', $bank );

// Social links show in the nav overlay's footer (and the schema's sameAs).
$social = array();
foreach ( ls_all( $doc, '.navx__social a' ) as $a ) {
	$social[] = array( 'link' => ss_link( $a ) );
}
$set( 'social', $social );

$legal = array();
foreach ( ls_all( $footer, 'li.ftr__menu-legal a' ) as $a ) {
	$legal[] = array( 'link' => ss_link( $a ) );
}
$set( 'legal_links', $legal );

/* -------------------------------------------------------------------------
 * WordPress: site name, tagline, site icon.
 * ---------------------------------------------------------------------- */

echo "\nWordPress\n";

$og_site = ls_one( $doc, 'head meta[property=og:site_name]' );
$blogname = $og_site ? $og_site->getAttribute( 'content' ) : '';
printf( "  %-18s %s\n", 'blogname', $blogname );
// The export's WebSite schema carries the theme's fallback description, which
// the theme only uses when the tagline is empty: the tagline is empty.
printf( "  %-18s %s\n", 'blogdescription', '(trống)' );
if ( ! $dry ) {
	if ( '' !== $blogname ) {
		update_option( 'blogname', $blogname );
	}
	update_option( 'blogdescription', '' );
}

// Polylang translates the site title per language (Languages → Translations):
// each language's title is the og:site_name of its own home page.
if ( function_exists( 'PLL' ) && class_exists( 'PLL_MO' ) && '' !== $blogname ) {
	foreach ( PLL()->model->get_languages_list() as $language ) {
		$home_key = 'vi' === $language->slug ? 'home' : 'home_' . $language->slug;
		$page     = ls_page_by_key( $home_key );
		if ( ! $page || ! is_file( ls_docs() . $page['path'] . 'index.html' ) ) {
			continue;
		}
		$el    = ls_one( ls_load( ls_docs() . $page['path'] . 'index.html' ), 'head meta[property=og:site_name]' );
		$title = $el ? $el->getAttribute( 'content' ) : '';
		if ( '' === $title ) {
			continue;
		}
		printf( "  %-18s %s\n", 'blogname@' . $language->slug, $title );
		if ( ! $dry ) {
			$mo = new PLL_MO();
			$mo->import_from_db( $language );
			$mo->add_entry( $mo->make_entry( $blogname, $title ) );
			$mo->export_to_db( $language );
		}
	}
}

/*
 * Site icon. WordPress emits 32/180/192/270 renditions of a 512×512
 * "cropped-…" attachment; the export only kept the renditions. Import the
 * largest one as the attachment, bring it to 512 so WordPress names the
 * renditions as it did, then put the export's own rendition files in place.
 */
$icon_url  = '';
$icon_size = 0;
foreach ( ls_all( $doc, 'head link[rel=icon], head link[rel=apple-touch-icon], head meta[name=msapplication-TileImage]' ) as $el ) {
	$u = $el->getAttribute( 'href' ) ?: $el->getAttribute( 'content' );
	$w = preg_match( '/-(\d+)x\d+\.\w+$/', $u, $m ) ? (int) $m[1] : 0;
	if ( $w > $icon_size ) {
		$icon_size = $w;
		$icon_url  = $u;
	}
}
if ( '' !== $icon_url && ! $dry ) {
	$icon_id = ss_media( $icon_url );
	if ( $icon_id ) {
		$file = (string) get_attached_file( $icon_id );
		$meta = (array) wp_get_attachment_metadata( $icon_id );
		$full = 512;
		if ( (int) ( $meta['width'] ?? 0 ) < $full || empty( $meta['sizes']['site_icon-270'] ) ) {
			$src = 'image/webp' === wp_get_image_mime( $file ) ? imagecreatefromwebp( $file ) : imagecreatefromstring( (string) file_get_contents( $file ) );
			if ( $src ) {
				imagealphablending( $src, false );
				$big = imagescale( $src, $full, $full, IMG_BICUBIC );
				imagealphablending( $big, false );
				imagesavealpha( $big, true );
				imagewebp( $big, $file, 90 );
			}
			$site_icon = new WP_Site_Icon();
			add_filter( 'intermediate_image_sizes_advanced', array( $site_icon, 'additional_sizes' ) );
			update_post_meta( $icon_id, '_wp_attachment_context', 'site-icon' );
			wp_update_attachment_metadata( $icon_id, wp_generate_attachment_metadata( $icon_id, $file ) );
			remove_filter( 'intermediate_image_sizes_advanced', array( $site_icon, 'additional_sizes' ) );
		}
		// The export's renditions, byte for byte, over the generated ones.
		$path = (string) ls_site_path( $icon_url );
		$base = (string) preg_replace( '/-\d+x\d+$/', '', pathinfo( $path, PATHINFO_FILENAME ) );
		foreach ( (array) glob( dirname( ls_docs() . $path ) . '/' . $base . '-*x*.' . pathinfo( $path, PATHINFO_EXTENSION ) ) as $rendition ) {
			copy( (string) $rendition, dirname( $file ) . '/' . basename( (string) $rendition ) );
		}
		update_option( 'site_icon', $icon_id );
		printf( "  %-18s #%d %s\n", 'site_icon', $icon_id, wp_get_attachment_url( $icon_id ) );
	}
}

/* -------------------------------------------------------------------------
 * Yoast: the default social image every page falls back to.
 * ---------------------------------------------------------------------- */

echo "\nYoast\n";

$og_image = ls_one( $doc, 'head meta[property=og:image]' );
if ( $og_image && ! $dry ) {
	$card_id = ss_media( $og_image->getAttribute( 'content' ) );
	if ( $card_id ) {
		$social_opts                        = (array) get_option( 'wpseo_social', array() );
		$social_opts['og_default_image']    = (string) wp_get_attachment_url( $card_id );
		$social_opts['og_default_image_id'] = $card_id;
		$social_opts['opengraph']           = true;
		update_option( 'wpseo_social', $social_opts );
		printf( "  %-18s #%d %s\n", 'og_default_image', $card_id, $social_opts['og_default_image'] );
	}
}
$card = ls_one( $doc, 'head meta[name=twitter:card]' );
if ( $card && ! $dry ) {
	$social_opts                      = (array) get_option( 'wpseo_social', array() );
	$social_opts['twitter']           = true;
	$social_opts['twitter_card_type'] = $card->getAttribute( 'content' );
	update_option( 'wpseo_social', $social_opts );
}

/* -------------------------------------------------------------------------
 * Site name in Google results (not from the export: chosen 2026-11-18).
 * The name above the link is the WebSite schema name, which inc/seo.php takes
 * from Yoast's "Website name"; og:site_name follows it too. The brand stays
 * the WordPress site title and an alternate name.
 * ---------------------------------------------------------------------- */
$site_names = array(
	'website_name'           => 'Công ty TNHH Lasan Marine', // see also tools/seo-settings.php
	'alternate_website_name' => 'Lasan Marine',
	'company_name'           => 'Công ty TNHH Lasan Marine',
	'company_alternate_name' => 'Lasan Marine',
);
foreach ( $site_names as $k => $v ) {
	printf( "  %-22s %s\n", $k, $v );
}
if ( ! $dry ) {
	update_option( 'wpseo_titles', array_merge( (array) get_option( 'wpseo_titles', array() ), $site_names ) );
}

echo "\nXong.\n";
