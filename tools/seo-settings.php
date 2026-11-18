<?php
/**
 * SEO settings that are not page content (re-runnable, local or server).
 *
 *   php tools/seo-settings.php [--dry-run]
 *   WP_PATH=/home/lasanmarinecom/lasanmarine.com WP_HOME=https://lasanmarine.com php ~/lasan-tools/seo-settings.php
 *
 * - The company name Google shows and reads: "Công ty TNHH Lasan Marine",
 *   alternate "Lasan Marine" (WebSite/Organization schema, og:site_name).
 * - Title templates in the site's pattern "<content> | Công ty TNHH Lasan
 *   Marine" for what Yoast titles itself (posts without their own SEO title,
 *   categories, project taxonomies, archives, search, 404).
 * - No author or date archives: one author, so they repeat the blog; they were
 *   a thin page in the sitemap.
 *
 * @package Starter_Flexible
 */

if ( 'cli' !== PHP_SAPI ) {
	exit( 1 );
}

$home = (string) ( getenv( 'WP_HOME' ) ?: 'http://localhost' );
$_SERVER['HTTP_HOST']   = $_SERVER['HTTP_HOST'] ?? ( parse_url( $home, PHP_URL_HOST ) . ( parse_url( $home, PHP_URL_PORT ) ? ':' . parse_url( $home, PHP_URL_PORT ) : '' ) );
$_SERVER['REQUEST_URI'] = '/';
if ( str_starts_with( $home, 'https://' ) ) {
	$_SERVER['HTTPS'] = 'on';
}
error_reporting( E_ALL & ~E_DEPRECATED & ~E_NOTICE & ~E_WARNING );
require ( getenv( 'WP_PATH' ) ?: dirname( __DIR__ ) ) . '/wp-load.php';

$dry     = in_array( '--dry-run', $argv, true );
$company = 'Công ty TNHH Lasan Marine';
$suffix  = ' %%sep%% ' . $company;

$titles = array(
	'website_name'                  => $company,
	'alternate_website_name'        => 'Lasan Marine',
	'company_name'                  => $company,
	'company_alternate_name'        => 'Lasan Marine',
	'company_or_person'             => 'company',
	'separator'                     => 'sc-pipe',
	'title-post'                    => '%%title%%' . $suffix,
	'title-page'                    => '%%title%%' . $suffix,
	'title-project'                 => '%%title%%' . $suffix,
	'title-tax-category'            => '%%term_title%%' . $suffix,
	'title-tax-project_material'    => 'Dự án tàu vỏ %%term_title%%' . $suffix,
	'title-tax-project_use'         => 'Dự án tàu %%term_title%%' . $suffix,
	'title-tax-project_work'        => '%%term_title%%' . $suffix,
	'title-search-wpseo'            => 'Tìm kiếm: %%searchphrase%%' . $suffix,
	'title-404-wpseo'               => 'Không tìm thấy trang' . $suffix,
	'title-home-wpseo'              => $company,
	'disable-author'                => true,
	'noindex-author-wpseo'          => true,
	'noindex-author-noposts-wpseo'  => true,
	'disable-date'                  => true,
	'noindex-archive-wpseo'         => true,
);

$current = (array) get_option( 'wpseo_titles', array() );
foreach ( $titles as $k => $v ) {
	$before = $current[ $k ] ?? null;
	printf( "  %-30s %s%s\n", $k, is_bool( $v ) ? ( $v ? 'true' : 'false' ) : $v, $before === $v ? '' : '   (đổi)' );
}

if ( ! $dry ) {
	update_option( 'wpseo_titles', array_merge( $current, $titles ) );
	update_option( 'blogname', 'Lasan Marine' );
	// Yoast keeps sitemaps in a cache; a settings change must show at once.
	if ( class_exists( 'WPSEO_Sitemaps_Cache' ) ) {
		WPSEO_Sitemaps_Cache::clear();
	}
	delete_transient( 'wpseo_sitemap_cache_validator_global' );
	do_action( 'cache_enabler_clear_complete_cache' ); // page cache (production)
	echo "Xong.\n";
}
