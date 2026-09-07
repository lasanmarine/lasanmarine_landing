<?php
/**
 * One-off: put the hand-edited Vietnamese pages back.
 *
 * A full `lasan apply` overwrote edits made in wp-admin. WordPress keeps a
 * revision for every save, so the last revision before that apply is the
 * edited version. This restores it, then re-attaches only the image ids the
 * apply had added — nothing else from the apply is kept.
 *
 * Run: docker exec lasan_wp php /var/www/html/tools/restore-vi-content.php [--dry-run]
 */

require_once __DIR__ . '/../wp-load.php';

if ( 'cli' !== PHP_SAPI ) {
	exit( "CLI only\n" );
}

$dry = in_array( '--dry-run', $argv, true );

// page id => revision to restore (the newest save before the 09:39 apply).
$restore = array(
	12  => 824, // home
	13  => 876, // about
	17  => 870, // service_03
	18  => 833, // projects
	22  => 869, // tools
	493 => 867, // service_rnd
	769 => 838, // design_brief
);

// The images the apply had assigned, by page and block type. Slide images on
// the hero are keyed by row index.
$images = array(
	12  => array( 'hero' => array( 0 => 585, 1 => 527, 2 => 818 ), 'service-spotlight' => 531 ),
	13  => array( 'page-hero' => 592, 'image-text' => 576, 'team' => 587 ),
	17  => array( 'page-hero' => 818, 'image-text' => 576 ),
	18  => array( 'page-hero' => 230, 'image-text' => 535 ),
	493 => array( 'page-hero' => 527, 'image-text' => 526 ),
);

/** Add an image id to one block's data without touching anything else. */
function lasan_attach_images( string $content, array $plan ): string {
	return (string) preg_replace_callback(
		'#<!-- wp:acf/([a-z0-9-]+) (\{.*?\}) (/?)-->#s',
		static function ( array $m ) use ( $plan ): string {
			$type = $m[1];
			if ( ! isset( $plan[ $type ] ) ) {
				return $m[0];
			}
			$block = json_decode( $m[2], true );
			if ( ! is_array( $block ) || ! isset( $block['data'] ) ) {
				return $m[0];
			}
			$want = $plan[ $type ];
			if ( is_array( $want ) ) {
				foreach ( $want as $row => $id ) {
					if ( empty( $block['data'][ "items_{$row}_image" ] ) ) {
						$block['data'][ "items_{$row}_image" ]  = $id;
						$block['data'][ "_items_{$row}_image" ] = 'field_hero_item_image';
					}
				}
			} elseif ( empty( $block['data']['image'] ) ) {
				$block['data']['image']  = $want;
				$block['data']['_image'] = 'field_' . str_replace( '-', '_', $type ) . '_image';
			}
			return sprintf( '<!-- wp:acf/%s %s %s-->', $type, wp_json_encode( $block, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ), $m[3] );
		},
		$content
	);
}

kses_remove_filters();
$admin = get_users( array( 'role' => 'administrator', 'number' => 1, 'fields' => 'ID' ) );
if ( $admin ) {
	wp_set_current_user( (int) $admin[0] );
}

foreach ( $restore as $page_id => $rev_id ) {
	$rev  = get_post( $rev_id );
	$page = get_post( $page_id );
	if ( ! $rev || ! $page || (int) $rev->post_parent !== $page_id ) {
		echo "#$page_id: revision #$rev_id không hợp lệ — bỏ qua\n";
		continue;
	}

	$content = $rev->post_content;
	$added   = 0;
	if ( isset( $images[ $page_id ] ) ) {
		$before  = $content;
		$content = lasan_attach_images( $content, $images[ $page_id ] );
		$added   = $before === $content ? 0 : 1;
	}

	printf(
		"#%-4d %-14s ← revision #%d (%s)  %d → %d ký tự%s\n",
		$page_id,
		$page->post_name,
		$rev_id,
		$rev->post_date,
		strlen( $page->post_content ),
		strlen( $content ),
		$added ? '  + gắn lại ảnh' : ''
	);

	if ( $dry ) {
		continue;
	}
	wp_update_post( array( 'ID' => $page_id, 'post_content' => wp_slash( $content ) ) );
}

echo $dry ? "\nChạy thử, chưa ghi gì.\n" : "\nXong. Bản của tool vẫn còn trong revision nếu cần quay lại.\n";
