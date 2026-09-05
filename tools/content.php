<?php
/**
 * LASAN content CLI — nạp nội dung trang từ file JSON, hoặc xuất ngược ra JSON.
 *
 *   php tools/content.php apply                  # nạp mọi file trong tools/content/
 *   php tools/content.php apply home.vi          # nạp một file
 *   php tools/content.php apply --dry-run        # xem sẽ làm gì, không ghi
 *   php tools/content.php dump home > x.json     # xuất trang đang có ra JSON
 *   php tools/content.php pages                  # liệt kê trang trong site
 *   php tools/content.php blocks [slug]          # liệt kê khối và trường của khối
 *
 * @package Starter_Flexible
 */

declare(strict_types=1);

if ( 'cli' !== PHP_SAPI ) {
	exit( 1 );
}

// Warnings must never land in stdout: `dump` writes JSON there.
ini_set( 'display_errors', 'stderr' );
// Polylang reads these on load and notices when a CLI leaves them unset.
$_SERVER['HTTP_HOST']   = $_SERVER['HTTP_HOST'] ?? ( parse_url( getenv( 'WP_HOME' ) ?: 'http://localhost', PHP_URL_HOST ) ?: 'localhost' );
$_SERVER['REQUEST_URI'] = $_SERVER['REQUEST_URI'] ?? '/';

$root = dirname( __DIR__ );
require_once $root . '/wp-load.php';
require_once __DIR__ . '/lib/content.php';

// Without a logged-in user WordPress runs post_content through KSES, which
// re-encodes the `&` inside block-attribute JSON on every run — an ampersand
// in the copy would drift to &amp;amp; over repeated applies.
kses_remove_filters();
$lasan_admin = get_users( array( 'role' => 'administrator', 'number' => 1, 'fields' => 'ID' ) );
if ( $lasan_admin ) {
	wp_set_current_user( (int) $lasan_admin[0] );
}

const LASAN_CONTENT_DIR = __DIR__ . '/content';

/** @param array<int, string> $argv */
function lasan_cli_usage(): void {
	echo <<<TXT
	LASAN content CLI

	  apply [tên|đường dẫn ...] [--dry-run]   Nạp nội dung từ JSON vào WordPress.
	                                          Không truyền tên thì nạp tất cả
	                                          tools/content/*.json theo thứ tự tên file.
	  dump <key|slug>                         In nội dung trang hiện có ra JSON.
	  pages                                   Liệt kê trang: id, ngôn ngữ, key, slug.
	  blocks [slug]                           Liệt kê khối, hoặc các trường của một khối.

	File JSON một trang:

	  {
	    "key": "home",              // định danh bền, lưu vào _lasan_content_key
	    "title": "Trang chủ",
	    "slug": "trang-chu",
	    "lang": "vi",               // Polylang, bỏ qua nếu không dùng
	    "translation_of": "home",   // key của bản gốc, cho trang dịch
	    "parent": "capabilities",   // key hoặc slug trang cha
	    "front_page": true,
	    "seo": { "title": "...", "description": "..." },
	    "blocks": [
	      { "type": "hero", "fields": { "headline": "...",
	          "primary": { "label": "Xem thêm", "page": "about" } } },
	      { "type": "tool-shell", "fields": {}, "inner": [ { "type": "power-converter", "fields": {} } ] }
	    ]
	  }

	Trường kiểu link nhận { "label", "page" } (key/slug trang), hoặc
	{ "label", "url" } (đường dẫn tương đối hoặc tuyệt đối).

	TXT;
}

$argv    = $_SERVER['argv'] ?? array();
$command = $argv[1] ?? '';
$args    = array_slice( $argv, 2 );
$dry_run = in_array( '--dry-run', $args, true );
$args    = array_values( array_filter( $args, static fn( string $a ): bool => ! str_starts_with( $a, '--' ) ) );

switch ( $command ) {

	case 'apply':
		$files = array();
		if ( $args ) {
			foreach ( $args as $name ) {
				$candidates = array( $name, LASAN_CONTENT_DIR . '/' . $name, LASAN_CONTENT_DIR . '/' . $name . '.json' );
				$found      = '';
				foreach ( $candidates as $candidate ) {
					if ( is_file( $candidate ) ) {
						$found = $candidate;
						break;
					}
				}
				if ( '' === $found ) {
					fwrite( STDERR, "Không tìm thấy file: {$name}\n" );
					exit( 1 );
				}
				$files[] = $found;
			}
		} else {
			$files = (array) glob( LASAN_CONTENT_DIR . '/*.json' );
			sort( $files );
		}

		if ( ! $files ) {
			fwrite( STDERR, "Không có file JSON nào trong tools/content/\n" );
			exit( 1 );
		}

		// Two passes: every page exists before links and parents are resolved,
		// so a page may point at one defined later in the run.
		$docs = array();
		foreach ( $files as $file ) {
			$doc = json_decode( (string) file_get_contents( (string) $file ), true );
			if ( ! is_array( $doc ) ) {
				fwrite( STDERR, 'JSON hỏng: ' . basename( (string) $file ) . "\n" );
				exit( 1 );
			}
			$docs[ (string) $file ] = $doc;
		}

		$problems = array();

		// A document either describes one page (`blocks`) or a batch of posts
		// for one post type (`posts`).
		$is_posts = static fn( array $doc ): bool => isset( $doc['posts'] );
		$is_menu  = static fn( array $doc ): bool => isset( $doc['menu'] );

		echo $dry_run ? "Chạy thử, không ghi gì:\n" : "Lượt 1 — tạo trang và bài:\n";
		foreach ( $docs as $file => $doc ) {
			if ( $is_posts( $doc ) ) {
				lasan_content_apply_posts( $doc, $problems, $dry_run );
				continue;
			}
			if ( $is_menu( $doc ) ) {
				if ( $dry_run ) {
					lasan_content_apply_menu( $doc, $problems, true );
				}
				continue; // Menus are built in pass two, once every page exists.
			}
			lasan_content_apply( $doc, $problems, $dry_run );
		}

		if ( ! $dry_run ) {
			echo "Lượt 2 — nối liên kết và bản dịch:\n";
			foreach ( $docs as $file => $doc ) {
				if ( $is_posts( $doc ) ) {
					continue;
				}
				if ( $is_menu( $doc ) ) {
					lasan_content_apply_menu( $doc, $problems, false );
					continue;
				}
				lasan_content_apply( $doc, $problems, false );
			}
		}

		if ( $problems ) {
			fwrite( STDERR, "\nCảnh báo:\n" );
			foreach ( array_unique( $problems ) as $problem ) {
				fwrite( STDERR, "  ! {$problem}\n" );
			}
			exit( 1 );
		}
		echo "Xong.\n";
		break;

	case 'media':
		$dir = $args[0] ?? ( __DIR__ . '/media' );
		if ( ! is_dir( $dir ) ) {
			fwrite( STDERR, "Không có thư mục: {$dir}\n" );
			exit( 1 );
		}
		$files = (array) glob( rtrim( $dir, '/' ) . '/*.{jpg,jpeg,png,webp,gif,svg,pdf}', GLOB_BRACE );
		sort( $files );
		if ( ! $files ) {
			fwrite( STDERR, "Không có file nào trong {$dir}\n" );
			exit( 1 );
		}
		foreach ( $files as $file ) {
			$id = lasan_content_import_media( (string) $file );
			printf( "  %s %-40s #%d\n", $id ? '✓' : '✗', basename( (string) $file ), $id );
		}
		echo "Xong. Dùng trong JSON: \"image\": { \"media\": \"<tên-file-không-đuôi>\" }\n";
		break;

	case 'dump':
		$ref = $args[0] ?? '';
		if ( '' === $ref ) {
			fwrite( STDERR, "Cần key hoặc slug trang.\n" );
			exit( 1 );
		}
		$doc = lasan_content_dump( $ref );
		if ( null === $doc ) {
			fwrite( STDERR, "Không tìm thấy trang: {$ref}\n" );
			exit( 1 );
		}
		echo json_encode( $doc, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ), "\n";
		break;

	case 'pages':
		$pages = get_posts( array( 'post_type' => 'page', 'post_status' => 'any', 'posts_per_page' => -1, 'orderby' => 'ID', 'order' => 'ASC', 'lang' => '' ) );
		$front = (int) get_option( 'page_on_front' );
		foreach ( $pages as $page ) {
			printf(
				"%5d  %-3s  %-18s %-34s %s\n",
				$page->ID,
				function_exists( 'pll_get_post_language' ) ? (string) pll_get_post_language( $page->ID ) : '',
				(string) get_post_meta( $page->ID, '_lasan_content_key', true ),
				$page->post_name,
				$front === $page->ID ? '← trang chủ' : ''
			);
		}
		break;

	case 'blocks':
		$slug = $args[0] ?? '';
		if ( '' === $slug ) {
			foreach ( lasan_content_block_slugs() as $name ) {
				printf( "  %-22s %d trường\n", $name, count( lasan_content_defs( $name ) ) );
			}
			break;
		}
		$walk = static function ( array $defs, int $depth ) use ( &$walk ): void {
			foreach ( $defs as $def ) {
				$type = (string) ( $def['type'] ?? '' );
				if ( 'tab' === $type || 'message' === $type ) {
					continue;
				}
				printf(
					"  %s%-24s %s%s\n",
					str_repeat( '  ', $depth ),
					(string) ( $def['name'] ?? '' ),
					$type,
					isset( $def['choices'] ) ? ' [' . implode( '|', array_keys( (array) $def['choices'] ) ) . ']' : ''
				);
				if ( ! empty( $def['sub_fields'] ) ) {
					$walk( (array) $def['sub_fields'], $depth + 1 );
				}
			}
		};
		$defs = lasan_content_defs( $slug );
		if ( ! $defs ) {
			fwrite( STDERR, "Khối không có trường hoặc không tồn tại: {$slug}\n" );
			exit( 1 );
		}
		echo "acf/{$slug}\n";
		$walk( $defs, 0 );
		break;

	default:
		lasan_cli_usage();
		exit( '' === $command ? 0 : 1 );
}
