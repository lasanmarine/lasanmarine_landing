<?php
/**
 * One-off: give the remaining top-level header items their own sub-menus.
 *
 * The header panel builds itself from the menu, so the four items that had no
 * children showed no panel. This adds them, and the anchors the About links
 * need, from the pages, tools and taxonomy terms that already exist.
 *
 * Run: docker exec lasan_wp php /var/www/html/tools/seed-header-submenus.php
 */

require_once __DIR__ . '/../wp-load.php';

if ( 'cli' !== PHP_SAPI ) {
	exit( "CLI only\n" );
}

$menu_id = 3; // LASAN Header (vi).

/** Add one item under $parent, reusing it when it is already there. */
function seed_item( int $menu_id, int $parent, array $args, int $order ): int {
	$existing = wp_get_nav_menu_items( $menu_id ) ?: array();

	foreach ( $existing as $item ) {
		if ( (int) $item->menu_item_parent === $parent && $item->title === $args['menu-item-title'] ) {
			echo "  = {$args['menu-item-title']} (đã có, #{$item->ID})\n";
			return (int) $item->ID;
		}
	}

	$id = wp_update_nav_menu_item(
		$menu_id,
		0,
		array_merge(
			array(
				'menu-item-parent-id' => $parent,
				'menu-item-position'  => $order,
				'menu-item-status'    => 'publish',
			),
			$args
		)
	);

	if ( is_wp_error( $id ) ) {
		echo "  ! {$args['menu-item-title']}: " . $id->get_error_message() . "\n";
		return 0;
	}

	echo "  + {$args['menu-item-title']} (#{$id})\n";
	return (int) $id;
}

function page_args( int $page_id, string $title ): array {
	return array(
		'menu-item-title'     => $title,
		'menu-item-object'    => 'page',
		'menu-item-object-id' => $page_id,
		'menu-item-type'      => 'post_type',
	);
}

function term_args( int $term_id, string $taxonomy, string $title ): array {
	return array(
		'menu-item-title'     => $title,
		'menu-item-object'    => $taxonomy,
		'menu-item-object-id' => $term_id,
		'menu-item-type'      => 'taxonomy',
	);
}

function custom_args( string $url, string $title, string $description = '' ): array {
	return array(
		'menu-item-title'       => $title,
		'menu-item-url'         => $url,
		'menu-item-type'        => 'custom',
		'menu-item-description' => $description,
	);
}

/* ---------------------------------------------------------------------------
 * 1. Anchors on the About page, so its sub-menu has somewhere to land.
 * ------------------------------------------------------------------------ */

$about_id = 13;
$about    = get_post( $about_id );

if ( $about ) {
	$content = $about->post_content;
	$anchors = array(
		'acf/manifesto' => 'cau-chuyen',
		'acf/team'      => 'doi-ngu',
		'acf/spec-list' => 'phap-nhan',
	);

	foreach ( $anchors as $block => $anchor ) {
		$needle = '<!-- wp:' . $block . ' {"name":"' . $block . '"';
		if ( str_contains( $content, '"anchor":"' . $anchor . '"' ) ) {
			echo "= anchor #{$anchor} (đã có)\n";
			continue;
		}
		if ( ! str_contains( $content, $needle ) ) {
			echo "! không tìm thấy block {$block}\n";
			continue;
		}
		$content = str_replace( $needle, $needle . ',"anchor":"' . $anchor . '"', $content );
		echo "+ anchor #{$anchor}\n";
	}

	if ( $content !== $about->post_content ) {
		wp_update_post( array( 'ID' => $about_id, 'post_content' => $content ) );
	}
}

$about_url = get_permalink( $about_id );

/* ---------------------------------------------------------------------------
 * 2. The four sub-menus.
 * ------------------------------------------------------------------------ */

echo "\nGiới thiệu (#706)\n";
$order = 100;
seed_item( $menu_id, 706, custom_args( $about_url . '#cau-chuyen', 'Câu chuyện & định hướng' ), $order++ );
seed_item( $menu_id, 706, custom_args( $about_url . '#doi-ngu', 'Đội ngũ kỹ thuật' ), $order++ );
seed_item( $menu_id, 706, custom_args( $about_url . '#phap-nhan', 'Tư cách pháp nhân' ), $order++ );
seed_item( $menu_id, 706, page_args( 21, 'Liên hệ' ), $order++ );

echo "\nDự án (#721)\n";
$by_use = seed_item(
	$menu_id,
	721,
	array_merge( custom_args( get_permalink( 18 ), 'Theo công dụng', 'Đội tàu đã bàn giao, nhóm theo mục đích khai thác.' ) ),
	$order++
);
seed_item( $menu_id, $by_use, term_args( 56, 'project_use', 'Đánh bắt thủy sản' ), $order++ );
seed_item( $menu_id, $by_use, term_args( 58, 'project_use', 'Hậu cần thủy sản' ), $order++ );
seed_item( $menu_id, $by_use, term_args( 60, 'project_use', 'Chở khách' ), $order++ );

$by_material = seed_item(
	$menu_id,
	721,
	custom_args( get_permalink( 18 ), 'Theo vật liệu vỏ', 'Cùng một hồ sơ kỹ thuật, ba nhóm vật liệu vỏ khác nhau.' ),
	$order++
);
seed_item( $menu_id, $by_material, term_args( 57, 'project_material', 'Thép' ), $order++ );
seed_item( $menu_id, $by_material, term_args( 59, 'project_material', 'Composite' ), $order++ );
seed_item( $menu_id, $by_material, term_args( 55, 'project_material', 'Gỗ' ), $order++ );

echo "\nCông cụ (#722)\n";
seed_item( $menu_id, 722, page_args( 23, 'Chuyển đổi công suất' ), $order++ );
seed_item( $menu_id, 722, page_args( 24, 'Đường kính trục chân vịt' ), $order++ );
seed_item( $menu_id, 722, page_args( 25, 'Tra cứu động cơ' ), $order++ );
seed_item( $menu_id, 722, page_args( 769, 'Nhiệm vụ thư' ), $order++ );

echo "\nTin tức (#723)\n";
$topics = array(
	6  => 'Tư vấn kỹ thuật tàu cá',
	7  => 'Thủy động lực học',
	11 => 'Kết cấu và động lực',
	9  => 'Tính toán ổn định',
	10 => 'Phân tích hoán cải',
	8  => 'Hồ sơ đăng kiểm',
	12 => 'Quy chuẩn đăng kiểm',
);
foreach ( $topics as $term_id => $label ) {
	seed_item( $menu_id, 723, term_args( $term_id, 'category', $label ), $order++ );
}

echo "\nXong.\n";
