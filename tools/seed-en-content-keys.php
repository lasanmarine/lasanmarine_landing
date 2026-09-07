<?php
/**
 * One-off: give the English pages the content keys the CLI updates them by.
 *
 * Without a key the CLI falls back to matching on slug; the English pages are
 * about to change slug, so it would create duplicates instead of updating.
 *
 * Run: docker exec lasan_wp php /var/www/html/tools/seed-en-content-keys.php
 */

require_once __DIR__ . '/../wp-load.php';

if ( 'cli' !== PHP_SAPI ) {
	exit( "CLI only\n" );
}

$map = array(
	'about-us'                        => 'about_en',
	'capabilities'                    => 'capabilities_en',
	'ship-design'                     => 'service_01_en',
	'information-technology-services' => 'service_03_en',
	'marine-rd'                       => 'service_rnd_en',
	'projects'                        => 'projects_en',
	'tools'                           => 'tools_en',
);

foreach ( $map as $slug => $key ) {
	$found = get_posts(
		array(
			'post_type'      => 'page',
			'post_status'    => 'any',
			'name'           => $slug,
			'posts_per_page' => -1,
			'lang'           => 'en',
		)
	);
	$page = null;
	foreach ( $found as $candidate ) {
		if ( ! function_exists( 'pll_get_post_language' ) || 'en' === pll_get_post_language( $candidate->ID ) ) {
			$page = $candidate;
			break;
		}
	}
	if ( ! $page ) {
		echo "bỏ qua $slug — không thấy trang EN\n";
		continue;
	}
	$current = get_post_meta( $page->ID, '_lasan_content_key', true );
	update_post_meta( $page->ID, '_lasan_content_key', $key );
	printf( "#%d  %-34s → %s%s\n", $page->ID, $slug, $key, $current ? " (thay '$current')" : '' );
}
