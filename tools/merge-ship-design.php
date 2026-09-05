<?php
/** Run inside the WordPress container: php tools/merge-ship-design.php */
if ( PHP_SAPI !== 'cli' ) { exit; }
$_SERVER['HTTP_HOST'] = 'localhost:49731';
$_SERVER['REQUEST_URI'] = '/';
require dirname( __DIR__ ) . '/wp-load.php';
if ( get_option( 'lasan_ship_design_merged' ) ) { echo "Already merged.\n"; exit; }

$pairs = array(
	array( 15, 16, 'Thiết kế tàu', 'thiet-ke-tau', 'vi' ),
	array( 246, 247, 'Ship Design', 'ship-design', 'en' ),
);
$redirects = array( 'paths' => array(), 'ids' => array() );
$replacements = array();
foreach ( $pairs as [ $target, $source, $title, $slug, $lang ] ) {
	foreach ( array( $target, $source ) as $id ) {
		$old = get_permalink( $id );
		$redirects['paths'][ untrailingslashit( wp_parse_url( $old, PHP_URL_PATH ) ) ] = $target;
		$replacements[ $old ] = $target;
	}
	$redirects['ids'][ $source ] = $target;
	$keep = array_values( array_filter( parse_blocks( get_post( $target )->post_content ), fn( $b ) => ! empty( $b['blockName'] ) ) );
	$incoming = array_values( array_filter( parse_blocks( get_post( $source )->post_content ), fn( $b ) => ! empty( $b['blockName'] ) ) );
	$blocks = $supplements = array();
	$contact = $standards = null;
	foreach ( $keep as $b ) {
		if ( 'acf/contact-statement' === $b['blockName'] ) { $contact = $b; continue; }
		if ( 'acf/standards' === $b['blockName'] ) { $standards = $b; continue; }
		if ( 'core/group' === $b['blockName'] ) { $supplements[] = $b; continue; }
		if ( 'acf/page-hero' === $b['blockName'] ) {
			$b['attrs']['data']['headline'] = $title;
			$b['attrs']['data']['lead'] = 'vi' === $lang
				? 'Thiết kế tàu từ nhu cầu khai thác đến hồ sơ kỹ thuật: tàu cá, tàu hàng, tàu khách và sà lan. Lasan Marine tư vấn đóng mới, hoán cải và lập hồ sơ phù hợp với từng phương tiện.'
				: 'Ship design from operating requirements to technical documentation, covering fishing vessels, cargo ships, passenger craft and barges. Lasan Marine supports newbuilds, conversions and vessel documentation.';
		}
		if ( 'acf/service-spotlight' === $b['blockName'] ) {
			$b['attrs']['data']['caption'] = 'vi' === $lang ? 'THIẾT KẾ TÀU CÁ' : 'FISHING VESSEL DESIGN';
		}
		if ( 'acf/spec-list' === $b['blockName'] ) {
			$b['attrs']['data']['heading'] = 'vi' === $lang ? 'Phạm vi thiết kế tàu cá' : 'Fishing vessel design scope';
		}
		$blocks[] = $b;
	}
	foreach ( $incoming as $b ) {
		if ( in_array( $b['blockName'], array( 'acf/page-hero', 'acf/contact-statement' ), true ) ) { continue; }
		if ( 'core/group' === $b['blockName'] ) { $supplements[] = $b; continue; }
		if ( 'acf/value-grid' === $b['blockName'] ) {
			$b['attrs']['data']['label'] = 'vi' === $lang ? 'PHƯƠNG TIỆN THỦY NỘI ĐỊA' : 'INLAND WATERWAY VESSELS';
		}
		if ( 'acf/spec-list' === $b['blockName'] ) {
			$b['attrs']['data']['heading'] = 'vi' === $lang ? 'Phạm vi phương tiện thủy nội địa' : 'Inland vessel design scope';
		}
		$blocks[] = $b;
	}
	if ( $standards ) { $blocks[] = $standards; }
	$blocks = array_merge( $blocks, $supplements );
	if ( $contact ) { $blocks[] = $contact; }
	$result = wp_update_post( wp_slash( array( 'ID' => $target, 'post_title' => $title, 'post_name' => $slug, 'post_content' => serialize_blocks( $blocks ) ) ), true );
	if ( is_wp_error( $result ) ) { throw new RuntimeException( $result->get_error_message() ); }
	$description = 'vi' === $lang
		? 'Thiết kế tàu, đóng mới và hoán cải cùng Lasan Marine. Tìm hiểu dịch vụ cho tàu cá, tàu hàng, tàu khách, sà lan và hồ sơ kỹ thuật theo nhu cầu khai thác.'
		: 'Ship design, newbuild and conversion support from Lasan Marine. Explore services for fishing vessels, cargo ships, passenger craft and barges.';
	foreach ( array( 'focuskw' => $title, 'title' => $title . ( 'vi' === $lang ? ' và hồ sơ kỹ thuật | Lasan Marine' : ' and Technical Documentation | Lasan Marine' ), 'metadesc' => $description ) as $key => $value ) {
		update_post_meta( $target, '_yoast_wpseo_' . $key, $value );
	}
	update_post_meta( $target, '_lasan_meta_title', $title . ' | Lasan Marine' );
	update_post_meta( $target, '_lasan_meta_description', $description );
	wp_update_post( array( 'ID' => $source, 'post_status' => 'draft' ) );
}
update_option( 'lasan_service_redirects', $redirects, false );

foreach ( $replacements as $old => $target ) {
	$replacements[ $old ] = get_permalink( $target );
	$replacements[ wp_parse_url( $old, PHP_URL_PATH ) ] = wp_parse_url( get_permalink( $target ), PHP_URL_PATH );
}
$replacements['/?page_id=16'] = get_permalink( 15 );
$replacements['/?page_id=247'] = get_permalink( 246 );
$replacements['/?page_id=15'] = get_permalink( 15 );
$replacements['/?page_id=246'] = get_permalink( 246 );

function lasan_merge_block_links( $value, array $map ) {
	if ( is_array( $value ) ) {
		foreach ( $value as &$item ) { $item = lasan_merge_block_links( $item, $map ); }
		return $value;
	}
	return is_string( $value ) ? strtr( $value, $map ) : $value;
}

global $wpdb;
foreach ( $wpdb->get_results( "SELECT ID,post_content FROM {$wpdb->posts} WHERE post_status='publish' AND post_type IN ('page','post')" ) as $post ) {
	$blocks = parse_blocks( $post->post_content );
	$lang = pll_get_post_language( $post->ID );
	$title = 'en' === $lang ? 'Ship Design' : 'Thiết kế tàu';
	foreach ( $blocks as &$b ) {
		if ( ! in_array( $b['blockName'], array( 'acf/service-architecture', 'acf/capability-matrix' ), true ) ) { continue; }
		$d = &$b['attrs']['data'];
		if ( 3 !== (int) ( $d['items'] ?? 0 ) || ! isset( $d['items_2_name'] ) ) { continue; }
		$d['items_0_name'] = $title;
		$d['items_0_desc'] = 'en' === $lang ? 'Design, conversion and technical documentation for fishing vessels, cargo ships, passenger craft and barges.' : 'Thiết kế đóng mới, hoán cải và hồ sơ kỹ thuật cho tàu cá, tàu hàng, tàu khách và sà lan.';
		$d['items_0_link']['title'] = $title;
		$last = array();
		foreach ( $d as $key => $value ) {
			if ( preg_match( '/^(_?)items_2_/', $key ) ) { $last[ preg_replace( '/^(_?)items_2_/', '${1}items_1_', $key ) ] = $value; }
			if ( preg_match( '/^_?items_[12]_/', $key ) ) { unset( $d[ $key ] ); }
		}
		$d = array_merge( $d, $last );
		$d['items'] = 2;
		$d['items_1_index'] = '02';
		unset( $d );
	}
	unset( $b );
	$blocks = lasan_merge_block_links( $blocks, $replacements );
	$content = serialize_blocks( $blocks );
	if ( $content !== $post->post_content ) { wp_update_post( wp_slash( array( 'ID' => $post->ID, 'post_content' => $content ) ) ); }
}
foreach ( wp_get_nav_menus() as $menu ) {
	foreach ( wp_get_nav_menu_items( $menu->term_id ) ?: array() as $item ) {
		if ( in_array( (int) $item->object_id, array( 16, 247 ), true ) ) {
			wp_update_post( array( 'ID' => $item->ID, 'post_status' => 'draft' ) );
		} elseif ( in_array( (int) $item->object_id, array( 15, 246 ), true ) ) {
			wp_update_post( array( 'ID' => $item->ID, 'post_title' => 15 === (int) $item->object_id ? 'Thiết kế tàu' : 'Ship Design' ) );
		}
	}
}
foreach ( array( 15, 16, 246, 247 ) as $id ) {
	YoastSEO()->classes->get( \Yoast\WP\SEO\Builders\Indexable_Builder::class )->build_for_id_and_type( $id, 'post' );
}
update_option( 'lasan_ship_design_merged', true, false );
echo "Merged Vietnamese and English services; menus, links, SEO and 301 redirects updated.\n";
