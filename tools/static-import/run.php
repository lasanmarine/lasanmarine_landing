<?php
/**
 * Rebuild content JSON from the static export, and prove it: every block is
 * rendered from the parsed fields and compared with the static HTML.
 *
 *   php run.php build [key…]                 JSON bundle on stdout
 *   php run.php verify [key…] [--block=slug] [--diff]
 *   php run.php static <key> <n>             canonical static HTML of block n
 *   php run.php render <key> <n>             canonical rendered HTML of block n
 *   php run.php fields <key> <n>             parsed fields of block n
 *
 * Runs inside the WordPress container (see tools/static-import/sync).
 *
 * @package Starter_Flexible
 */

declare(strict_types=1);

if ( 'cli' !== PHP_SAPI ) {
	exit( 1 );
}

$root = dirname( __DIR__, 2 );
$_SERVER['HTTP_HOST']   = $_SERVER['HTTP_HOST'] ?? ( parse_url( getenv( 'WP_HOME' ) ?: 'http://localhost', PHP_URL_HOST ) . ( parse_url( getenv( 'WP_HOME' ) ?: '', PHP_URL_PORT ) ? ':' . parse_url( getenv( 'WP_HOME' ), PHP_URL_PORT ) : '' ) );
$_SERVER['REQUEST_URI'] = $_SERVER['REQUEST_URI'] ?? '/';
error_reporting( E_ALL & ~E_DEPRECATED & ~E_NOTICE & ~E_WARNING );
require_once $root . '/wp-load.php';
error_reporting( E_ALL & ~E_DEPRECATED & ~E_NOTICE & ~E_WARNING );
require_once $root . '/tools/lib/content.php';
require_once __DIR__ . '/lib.php';

$args  = array_slice( $argv, 1 );
$cmd   = (string) array_shift( $args );
$flags = array();
$pos   = array();
foreach ( $args as $a ) {
	if ( str_starts_with( $a, '--' ) ) {
		$kv                            = explode( '=', substr( $a, 2 ), 2 );
		$flags[ $kv[0] ]               = $kv[1] ?? true;
	} else {
		$pos[] = $a;
	}
}

/** Existing authored docs in tools/content, by key. */
function ls_existing_docs(): array {
	static $docs = null;
	if ( null === $docs ) {
		$docs = array();
		foreach ( (array) glob( dirname( __DIR__ ) . '/content/*.json' ) as $f ) {
			$d = json_decode( (string) file_get_contents( (string) $f ), true );
			if ( is_array( $d ) && isset( $d['key'] ) ) {
				$docs[ (string) $d['key'] ] = $d;
			}
		}
	}
	return $docs;
}

/** The static file for a page. */
function ls_page_file( array $page ): string {
	return ls_docs() . $page['path'] . 'index.html';
}

/** Top-level block elements of <main>, as [slug, element]. @return array<int, array{0:string,1:DOMElement}> */
function ls_main_blocks( DOMDocument $doc ): array {
	$main = ls_one( $doc, 'main' );
	$out  = array();
	if ( ! $main ) {
		return $out;
	}
	$kids = array();
	foreach ( ls_children( $main ) as $el ) {
		// page.php wraps the blocks in <div class="block-stream">.
		if ( ls_has_class( $el, 'block-stream' ) ) {
			array_push( $kids, ...ls_children( $el ) );
		} else {
			$kids[] = $el;
		}
	}
	foreach ( $kids as $el ) {
		$slug = '';
		foreach ( ls_classes( $el ) as $c ) {
			if ( preg_match( '/^lasanmarine-([a-z0-9-]+)$/', $c, $m ) ) {
				$slug = $m[1];
			}
		}
		$out[] = array( $slug, $el );
	}
	return $out;
}

/** Load a parser for a block slug, or null. */
function ls_parser( string $slug ): ?callable {
	static $cache = array();
	if ( ! array_key_exists( $slug, $cache ) ) {
		$f              = __DIR__ . '/parsers/' . $slug . '.php';
		$cache[ $slug ] = is_file( $f ) ? require $f : null;
	}
	return $cache[ $slug ];
}

/**
 * Parse one static page into a content doc. Fields a parser does not return
 * (hidden in the markup) are kept from the existing doc's block of the same
 * type and ordinal.
 */
function ls_build_doc( array $page, array &$problems ): array {
	$doc      = ls_load( ls_page_file( $page ) );
	$existing = ls_existing_docs()[ $page['key'] ] ?? array();
	lasan_content_lang( $page['lang'] );

	$title = html_entity_decode( ls_t( $doc, 'title' ), ENT_QUOTES | ENT_HTML5, 'UTF-8' );
	$desc  = '';
	foreach ( ls_all( $doc, 'meta[name=description]' ) as $m ) {
		$desc = $m->getAttribute( 'content' );
	}
	$name = (string) ( $existing['title'] ?? preg_replace( '/\s*[|–-]\s*LASAN MARINE\s*$/u', '', $title ) );

	$parts = array_values( array_filter( explode( '/', trim( preg_replace( '#^/en/#', '/', $page['path'] ), '/' ) ) ) );
	$slug  = $page['slug'] ?? ( $parts ? end( $parts ) : 'home' );
	$out   = array(
		'key'   => $page['key'],
		'title' => $name,
		'slug'  => $slug,
		'lang'  => $page['lang'],
	);
	if ( ! empty( $page['translation_of'] ) ) {
		$out['translation_of'] = $page['translation_of'];
	}
	if ( count( $parts ) > 1 ) {
		$parent_path = ( 'en' === $page['lang'] ? '/en/' : '/' ) . implode( '/', array_slice( $parts, 0, -1 ) ) . '/';
		$parent      = ls_page_key_for_path( $parent_path );
		if ( '' === $parent ) {
			$problems[] = "{$page['key']}: không có trang cha {$parent_path}";
		} else {
			$out['parent'] = $parent;
		}
	}
	if ( ! empty( $page['front_page'] ) ) {
		$out['front_page'] = true;
	}
	if ( ! empty( $page['template'] ) ) {
		$out['template'] = $page['template'];
	}
	$out['seo'] = array( 'title' => $title, 'description' => html_entity_decode( $desc, ENT_QUOTES | ENT_HTML5, 'UTF-8' ) );
	// A social title set apart from the page title (Yoast "Social" tab).
	foreach ( ls_all( $doc, 'meta[property=og:title]' ) as $m ) {
		$og = html_entity_decode( $m->getAttribute( 'content' ), ENT_QUOTES | ENT_HTML5, 'UTF-8' );
		if ( $og !== $title ) {
			$out['seo']['og_title'] = $og;
		}
	}

	// Existing blocks by type, in order, to keep hidden fields.
	$old = array();
	foreach ( (array) ( $existing['blocks'] ?? array() ) as $b ) {
		$old[ (string) ( $b['type'] ?? '' ) ][] = $b;
	}
	$seen   = array();
	$blocks = array();
	if ( ! empty( $page['template'] ) ) {
		$blocks[] = ls_app_page_block( $doc, $page, $problems );
	} else {
		foreach ( ls_main_blocks( $doc ) as $i => list( $type, $el ) ) {
			if ( '' === $type ) {
				$blocks[] = array( 'type' => 'core', 'html' => ls_core_markup( $el ) );
				continue;
			}
			$n            = $seen[ $type ] = ( $seen[ $type ] ?? -1 ) + 1;
			$base         = $old[ $type ][ $n ]['fields'] ?? array();
			$parser       = ls_parser( $type );
			$fields       = $base;
			if ( $parser ) {
				$parsed = (array) $parser( $el, $page );
				$fields = array_replace( $base, $parsed );
			} else {
				$problems[] = "{$page['key']}#{$i}: chưa có parser cho {$type}";
			}
			$entry = array( 'type' => $type, 'fields' => $fields );
			// Blocks holding inner blocks (tool-shell → calculator) supply them
			// through a `ls_<slug>_inner()` helper defined in their parser file.
			$inner_fn = 'ls_' . str_replace( '-', '_', $type ) . '_inner';
			if ( function_exists( $inner_fn ) ) {
				$entry['inner'] = $inner_fn( $el );
			}
			// Setting the anchor is harmless where the block derives the same id
			// itself, and required where the editor set it.
			if ( $el->hasAttribute( 'id' ) ) {
				$entry['anchor'] = $el->getAttribute( 'id' );
			}
			$blocks[] = $entry;
		}
	}
	$out['blocks'] = $blocks;
	return $out;
}

/**
 * News posts (post type `post`) from /tin-tuc/<slug>/: title, date, author,
 * categories (with their parents, from the category archive paths), cover
 * image, SEO, the body as core block markup, and the manual excerpt when the
 * cards show one that is not simply the start of the body.
 */
function ls_build_news( array &$problems ): array {
	$posts = array();
	$cats  = ls_news_categories();
	foreach ( (array) glob( ls_docs() . '/tin-tuc/*/index.html' ) as $file ) {
		$doc  = ls_load( (string) $file );
		$body = ls_one( $doc, 'body' );
		if ( ! $body || ! ls_has_class( $body, 'single-post' ) ) {
			continue;
		}
		$slug    = basename( dirname( (string) $file ) );
		$article = ls_one( $doc, 'article.post-single' );
		$terms   = array();
		foreach ( ls_classes( $article ) as $c ) {
			if ( preg_match( '/^category-(.+)$/', $c, $m ) && isset( $cats[ $m[1] ] ) ) {
				$terms[] = $cats[ $m[1] ];
			}
		}
		usort( $terms, static fn( $a, $b ) => (int) isset( $a['parent'] ) <=> (int) isset( $b['parent'] ) );
		$content = array();
		foreach ( ls_children( ls_one( $doc, '.post-single__body' ) ) as $el ) {
			$content[] = ls_core_markup( $el );
		}
		$date = '';
		$desc = '';
		foreach ( ls_all( $doc, 'meta' ) as $m ) {
			if ( 'article:published_time' === $m->getAttribute( 'property' ) ) {
				$date = $m->getAttribute( 'content' );
			}
			if ( 'description' === $m->getAttribute( 'name' ) ) {
				$desc = $m->getAttribute( 'content' );
			}
		}
		$cover = ls_one( $doc, '.post-cover img' );
		$entry = array(
			'slug'    => $slug,
			'title'   => ls_t( $doc, '.post-hero__title' ),
			'date'    => $date,
			'author'  => ls_t( $doc, '.reading-bar__byline' ) ?: 'lasan',
			'excerpt' => ls_news_excerpt( $slug, ls_text( ls_one( $doc, '.post-single__body' ) ) ),
			'image'   => $cover ? ls_image( $cover ) : '',
			'terms'   => array( 'category' => $terms ),
			'seo'     => array(
				'title'       => html_entity_decode( ls_t( $doc, 'title' ), ENT_QUOTES | ENT_HTML5, 'UTF-8' ),
				'description' => html_entity_decode( $desc, ENT_QUOTES | ENT_HTML5, 'UTF-8' ),
			),
			'content' => implode( "\n\n", $content ),
		);
		if ( '' === $entry['excerpt'] ) {
			unset( $entry['excerpt'] );
		}
		if ( '' === $entry['image'] ) {
			unset( $entry['image'] );
			$problems[] = "{$slug}: không có ảnh bìa";
		}
		$posts[] = $entry;
	}
	usort( $posts, static fn( $a, $b ) => strcmp( $a['date'], $b['date'] ) );
	// Every category in the export, including ones with no posts yet.
	$all = array_values( $cats );
	usort( $all, static fn( $a, $b ) => (int) isset( $a['parent'] ) <=> (int) isset( $b['parent'] ) );
	return array( 'post_type' => 'post', 'lang' => 'vi', 'terms' => array( 'category' => $all ), 'posts' => $posts );
}

/** Category slug => term spec, from the archive pages under /tin-tuc/category/. */
function ls_news_categories(): array {
	$out  = array();
	$base = ls_docs() . '/tin-tuc/category';
	$iter = new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $base, FilesystemIterator::SKIP_DOTS ) );
	foreach ( $iter as $f ) {
		if ( 'index.html' !== $f->getFilename() ) {
			continue;
		}
		if ( str_contains( (string) file_get_contents( (string) $f, false, null, 0, 2000 ), 'http-equiv="refresh"' ) ) {
			continue; // an old slug redirecting elsewhere, not a category
		}
		$rel   = trim( substr( dirname( (string) $f ), strlen( $base ) ), '/' );
		$parts = explode( '/', $rel );
		$slug  = (string) end( $parts );
		$spec  = array( 'name' => ls_t( ls_load( (string) $f ), '.phead__title' ), 'slug' => $slug );
		if ( count( $parts ) > 1 ) {
			$spec['parent'] = $parts[ count( $parts ) - 2 ];
		}
		$out[ $slug ] = $spec;
	}
	return $out;
}

/**
 * The manual excerpt of a post, if it has one. Cards show it cut to 22 words;
 * the longest version anywhere in the export is taken. An excerpt that is just
 * the start of the body is WordPress's automatic one and is not stored.
 */
function ls_news_excerpt( string $slug, string $body_text ): string {
	static $cards = null;
	static $texts = null;
	if ( null === $cards ) {
		$cards = array();
		$texts = array();
		foreach ( (array) glob( ls_docs() . '/{tin-tuc,tin-tuc/*,tin-tuc/category/*,tin-tuc/category/*/*}/index.html', GLOB_BRACE ) as $f ) {
			$d = ls_load( (string) $f );
			foreach ( ls_all( $d, 'article.post-card' ) as $card ) {
				$a = ls_one( $card, 'a' );
				if ( $a && preg_match( '#/tin-tuc/([^/]+)/#', $a->getAttribute( 'href' ), $m ) ) {
					$cards[ $m[1] ] = ls_t( $card, '.post-card__excerpt' );
				}
			}
			foreach ( ls_all( $d, 'p, span, div' ) as $el ) {
				if ( 1 === $el->childNodes->length ) {
					$texts[] = ls_text( $el );
				}
			}
		}
		$texts = array_unique( $texts );
	}
	$card = (string) ( $cards[ $slug ] ?? '' );
	if ( '' === $card ) {
		return '';
	}
	$prefix = rtrim( $card, '…' );
	if ( str_starts_with( $body_text, $prefix ) ) {
		return ''; // automatic excerpt
	}
	$best = $prefix;
	foreach ( $texts as $t ) {
		if ( str_starts_with( $t, $prefix ) && mb_strlen( $t ) > mb_strlen( $best ) && ! str_ends_with( $t, '…' ) ) {
			$best = $t;
		}
	}
	return $best;
}

/**
 * Projects (post type `project`) from /du-an/<slug>/: title, lead (excerpt),
 * cover, terms (use + material links, work-type spans), the spec sheet back
 * into ACF fields, the case-study parts, the gallery, the service-page link
 * (meta lm_service_page, as a page key) and the body when it is not just the
 * excerpt. Listing order: menu_order from the /du-an/ index; dates from the
 * project sitemap, ties broken the way the export shows them (lower old id
 * first). Fields the page cannot show are kept from the existing file.
 */
function ls_build_projects( array &$problems ): array {
	$old = json_decode( (string) @file_get_contents( dirname( __DIR__ ) . '/content/05-projects-cpt.json' ), true );
	$old = array_column( (array) ( $old['posts'] ?? array() ), null, 'slug' );

	// Spec-sheet label => field (see starter_flexible_project_specs()).
	$spec_fields = array(
		'Tên tàu'                => 'vessel_name',
		'Số hiệu tàu'            => 'vessel_no',
		'Số ĐKHC / Số đăng kiểm' => 'registry',
		'Loại thiết kế'          => 'design_type',
		'Lmax'                   => 'lmax',
		'Bmax'                   => 'bmax',
		'Chiều cao mạn D'        => 'depth',
		'Trọng tải'              => 'tonnage',
		'Công suất máy chính'    => 'power_kw',
		'Vùng hoạt động'         => 'region',
		'Địa phương'             => 'location',
		'Năm thực hiện'          => 'year',
		'Trạng thái'             => 'status',
	);
	$numeric   = array( 'lmax' => 2, 'bmax' => 2, 'depth' => 2, 'tonnage' => 2, 'power_kw' => 0 );
	$case_h    = array(
		'Yêu cầu dự án'                  => 'requirement',
		'Phạm vi LASAN MARINE thực hiện' => 'scope',
		'Điểm kỹ thuật đáng chú ý'       => 'highlight',
		'Kết quả'                        => 'result',
	);
	$tax_paths = array( 'vat-lieu' => 'project_material', 'cong-dung' => 'project_use' );

	// Order on the catalogue page = menu_order.
	$index = array();
	foreach ( ls_all( ls_load( ls_docs() . '/du-an/index.html' ), '[data-pi-item]' ) as $card ) {
		if ( preg_match( '#/du-an/([^/]+)/#', $card->getAttribute( 'href' ), $m ) ) {
			$index[] = $m[1];
		}
	}
	// Publish dates: the sitemap's lastmod.
	$lastmod = array();
	$sm      = (string) @file_get_contents( ls_docs() . '/project-sitemap.xml' );
	if ( preg_match_all( '#<loc>[^<]*/du-an/([^/<]+)/</loc>\s*<lastmod>([^<]+)</lastmod>#', $sm, $mm, PREG_SET_ORDER ) ) {
		foreach ( $mm as $m ) {
			$lastmod[ $m[1] ] = strtotime( $m[2] );
		}
	}

	$posts   = array();
	$old_ids = array();
	foreach ( (array) glob( ls_docs() . '/du-an/*/index.html' ) as $file ) {
		$doc     = ls_load( (string) $file );
		$article = ls_one( $doc, 'article.project-single' );
		if ( ! $article ) {
			continue; // redirect stub
		}
		$slug  = basename( dirname( (string) $file ) );
		$prev  = $old[ $slug ] ?? array();
		$entry = array(
			'slug'  => $slug,
			'title' => ls_t( $doc, '.project-single__title' ),
		);
		foreach ( ls_classes( $article ) as $c ) {
			if ( preg_match( '/^post-(\d+)$/', $c, $m ) ) {
				$old_ids[ $slug ] = (int) $m[1];
			}
		}
		$lead = ls_t( $doc, '.project-single__lead' );
		if ( '' !== $lead ) {
			$entry['excerpt'] = $lead;
		}
		$cover = ls_one( $doc, '.project-single__cover img' );
		if ( $cover ) {
			$entry['image'] = ls_image( $cover );
		}
		if ( empty( $entry['image'] ) ) {
			unset( $entry['image'] );
			$problems[] = "{$slug}: không có ảnh dự án";
		}

		// Terms: linked chips are use/material (archive path gives the slug),
		// plain spans are work types, then the year (a field, not a term).
		$terms = array();
		$year  = '';
		$spans = array();
		foreach ( ls_children( ls_one( $doc, '.project-single__terms' ) ?? $doc->createElement( 'div' ) ) as $el ) {
			if ( 'a' === $el->tagName && preg_match( '#/(vat-lieu|cong-dung)/([^/]+)/#', $el->getAttribute( 'href' ), $m ) ) {
				$terms[ $tax_paths[ $m[1] ] ][] = array( 'name' => ls_text( $el ), 'slug' => $m[2] );
			} elseif ( 'span' === $el->tagName ) {
				$spans[] = ls_text( $el );
			}
		}

		$fields = array();
		foreach ( ls_all( $doc, '.project-single__spec-grid > div' ) as $row ) {
			$label = ls_t( $row, 'dt' );
			$value = ls_t( $row, 'dd' );
			if ( ! isset( $spec_fields[ $label ] ) ) {
				continue; // Vật liệu / Công dụng come from the terms
			}
			$name = $spec_fields[ $label ];
			if ( isset( $numeric[ $name ] ) ) {
				$num = (float) str_replace( array( '.', ',' ), array( '', '.' ), (string) preg_replace( '/\s*[^\d.,]+$/u', '', $value ) );
				// Keep the stored value when it shows the same: it may carry more precision.
				$was    = $prev['fields'][ $name ] ?? null;
				$fields[ $name ] = ( null !== $was && number_format( (float) $was, $numeric[ $name ], ',', '.' ) === number_format( $num, $numeric[ $name ], ',', '.' ) ) ? $was : $num;
			} else {
				$fields[ $name ] = $value;
			}
		}
		$year = (string) ( $fields['year'] ?? '' );
		if ( '' !== $year && end( $spans ) === $year ) {
			array_pop( $spans );
		}
		foreach ( $spans as $work ) {
			$known            = array( 'Thiết kế đóng mới' => 'dong-moi', 'Thiết kế cải hoán' => 'cai-hoan', 'Tính toán & hồ sơ' => 'tinh-toan-ho-so' );
			$terms['project_work'][] = array( 'name' => $work, 'slug' => $known[ $work ] ?? sanitize_title( $work ) );
		}
		if ( $terms ) {
			$entry['terms'] = $terms;
		}

		foreach ( ls_all( $doc, '.project-single__case-part' ) as $part ) {
			$name = $case_h[ ls_t( $part, '.project-single__case-h' ) ] ?? '';
			if ( 'scope' === $name ) {
				$fields['scope'] = implode( "\n", array_map( 'ls_text', ls_all( $part, 'li' ) ) );
			} elseif ( '' !== $name ) {
				$fields[ $name ] = ls_t( $part, 'p' );
			}
		}
		$gallery = array();
		foreach ( ls_all( $doc, '.project-single__gallery figure' ) as $fig ) {
			$img = ls_one( $fig, 'img' );
			$row = array( 'image' => $img ? ls_image( $img ) : '' );
			if ( '' !== ls_t( $fig, 'figcaption' ) ) {
				$row['caption'] = ls_t( $fig, 'figcaption' );
			}
			$gallery[] = $row;
		}
		if ( $gallery ) {
			$fields['gallery'] = $gallery;
		}
		// Fields the page would show if set but does not are empty; anything
		// else the old file had (nothing the template hides today) is kept.
		$visible = array_merge( array_values( $spec_fields ), array_values( $case_h ), array( 'gallery' ) );
		foreach ( (array) ( $prev['fields'] ?? array() ) as $name => $value ) {
			if ( ! array_key_exists( $name, $fields ) && ! in_array( $name, $visible, true ) ) {
				$fields[ $name ] = $value;
			}
		}
		foreach ( $visible as $name ) {
			if ( ! array_key_exists( $name, $fields ) && array_key_exists( $name, (array) ( $prev['fields'] ?? array() ) ) ) {
				$fields[ $name ] = '';
			}
		}
		$entry['fields'] = $fields;

		$service = ls_one( $doc, '.project-single__service' );
		$key     = $service ? ls_page_key_for_path( (string) ls_site_path( $service->getAttribute( 'href' ) ) ) : '';
		if ( $service && '' === $key ) {
			$problems[] = "{$slug}: trang dịch vụ không có trong bản đồ trang: " . $service->getAttribute( 'href' );
		}
		$entry['meta'] = array( 'lm_service_page' => '' !== $key ? array( 'page' => $key ) : '' );

		// A body of its own renders as .prose; otherwise the overview repeats the excerpt.
		$prose = ls_one( $doc, '.project-single__body .prose' );
		if ( $prose ) {
			$content = array();
			foreach ( ls_children( $prose ) as $el ) {
				$content[] = ls_core_markup( $el );
			}
			$entry['content'] = implode( "\n\n", $content );
		}

		$pos            = array_search( $slug, $index, true );
		$entry['order'] = false === $pos ? count( $index ) : (int) $pos;
		$posts[]        = $entry;
	}

	// Distinct dates in the order the export lists by date: newer second
	// first, and within one second the lower old id first.
	usort(
		$posts,
		static fn( $a, $b ) => ( $lastmod[ $b['slug'] ] ?? 0 ) <=> ( $lastmod[ $a['slug'] ] ?? 0 ) ?: ( $old_ids[ $a['slug'] ] ?? 0 ) <=> ( $old_ids[ $b['slug'] ] ?? 0 )
	);
	$t = PHP_INT_MAX;
	foreach ( $posts as &$p ) {
		$t         = min( $t - 1, ( $lastmod[ $p['slug'] ] ?? time() ) );
		$p['date'] = gmdate( 'Y-m-d\TH:i:s\Z', $t );
	}
	unset( $p );
	usort( $posts, static fn( $a, $b ) => $a['order'] <=> $b['order'] );

	// Every term shown on the archive filter chips, with its slug.
	$all = array();
	foreach ( (array) glob( ls_docs() . '/{vat-lieu,cong-dung}/*/index.html', GLOB_BRACE ) as $f ) {
		$parts = explode( '/', trim( substr( dirname( (string) $f ), strlen( ls_docs() ) ), '/' ) );
		$all[ $tax_paths[ $parts[0] ] ][] = array( 'name' => ls_t( ls_load( (string) $f ), '.phead__title' ), 'slug' => $parts[1] );
	}
	return array( 'post_type' => 'project', 'lang' => 'vi', 'terms' => $all, 'posts' => $posts );
}

/** The single App Embed block of a full-screen app page. */
function ls_app_page_block( DOMDocument $doc, array $page, array &$problems ): array {
	$iframe = ls_one( $doc, 'iframe' );
	$src    = $iframe ? $iframe->getAttribute( 'src' ) : '';
	$app    = preg_match( '#/apps/([a-z0-9-]+)/#', $src, $m ) ? $m[1] : '';
	if ( '' === $app ) {
		$problems[] = "{$page['key']}: không thấy iframe app";
	}
	$fields = array( 'app' => $app );
	$title  = $iframe ? $iframe->getAttribute( 'title' ) : '';
	if ( '' !== $title ) {
		$fields['title'] = $title;
	}
	return array( 'type' => 'app-embed', 'fields' => $fields );
}

/**
 * Put WordPress in the state of viewing a page, for offline rendering. With
 * $doc, the page's content is replaced in the object cache only (no DB write)
 * so blocks that read the page's other blocks see the parsed version.
 */
function ls_enter_page( array $page, ?array $doc = null ): int {
	lasan_content_lang( $page['lang'] );
	$id = lasan_content_find_page( $page['key'] );
	if ( $id && $doc ) {
		$probs  = array();
		$blocks = array();
		foreach ( (array) $doc['blocks'] as $entry ) {
			if ( 'core' === ( $entry['type'] ?? '' ) ) {
				array_push( $blocks, ...lasan_content_core_blocks( (string) $entry['html'] ) );
			} else {
				$blocks[] = lasan_content_block( $entry, $probs );
			}
		}
		$post               = get_post( $id );
		$post->post_content = implode( "\n\n", array_map( 'serialize_block', $blocks ) );
		wp_cache_set( $id, $post, 'posts' );
	}
	if ( function_exists( 'PLL' ) && PLL() && isset( PLL()->model ) ) {
		$lang = PLL()->model->get_language( $page['lang'] );
		if ( $lang ) {
			PLL()->curlang = $lang;
		}
	}
	if ( $id ) {
		$GLOBALS['wp_query']     = new WP_Query( array( 'page_id' => $id, 'post_type' => 'page', 'lang' => '' ) );
		$GLOBALS['wp_the_query'] = $GLOBALS['wp_query'];
		$GLOBALS['post']         = get_post( $id );
		setup_postdata( $GLOBALS['post'] );
		$GLOBALS['wp_query']->is_page     = true;
		$GLOBALS['wp_query']->is_singular = true;
		$GLOBALS['wp_query']->queried_object    = $GLOBALS['post'];
		$GLOBALS['wp_query']->queried_object_id = $id;
	}
	return (int) $id;
}

/** Render a doc block entry to HTML in the current page context. */
function ls_render_entry( array $entry, array &$problems ): string {
	if ( 'core' === ( $entry['type'] ?? '' ) ) {
		return implode( '', array_map( 'render_block', lasan_content_core_blocks( (string) $entry['html'] ) ) );
	}
	$block = lasan_content_block( $entry, $problems );
	return (string) render_block( $block );
}

/**
 * Canonical, line-per-node form of an HTML fragment for diffing: hosts and
 * upload paths normalised, volatile attributes dropped, whitespace collapsed.
 */
function ls_canon( string $html ): string {
	$doc   = ls_load_html( '<html><body><div id="__ls">' . $html . '</div></body></html>' );
	$root  = ls_one( $doc, '#__ls' );
	$lines = array();
	$walk  = static function ( DOMNode $n, int $depth ) use ( &$walk, &$lines ): void {
		$pad = str_repeat( '  ', $depth );
		if ( $n instanceof DOMText ) {
			$t = trim( (string) preg_replace( '/\s+/u', ' ', $n->textContent ) );
			if ( '' !== $t ) {
				$lines[] = $pad . $t;
			}
			return;
		}
		if ( ! $n instanceof DOMElement ) {
			return;
		}
		$tag = strtolower( $n->tagName );
		if ( in_array( $tag, array( 'script', 'style', 'noscript' ), true ) ) {
			$lines[] = $pad . "<{$tag}>…";
			return;
		}
		$attrs = array();
		foreach ( $n->attributes as $a ) {
			$name = strtolower( $a->name );
			if ( in_array( $name, array( 'srcset', 'sizes', 'decoding', 'loading', 'fetchpriority' ), true ) ) {
				continue;
			}
			$v = ls_canon_value( $a->value );
			// Nav menu item ids (header panels) are database ids.
			if ( in_array( $name, array( 'data-panel', 'data-panel-open' ), true ) && ctype_digit( $v ) ) {
				$v = 'N';
			}
			if ( 'class' === $name ) {
				$parts = preg_split( '/\s+/', trim( $v ) ) ?: array();
				sort( $parts );
				$v = implode( ' ', $parts );
			}
			$attrs[ $name ] = $v;
		}
		ksort( $attrs );
		$s = '';
		foreach ( $attrs as $k => $v ) {
			$s .= ' ' . $k . ( '' === $v ? '' : '="' . $v . '"' );
		}
		if ( 'svg' === $tag ) {
			// Icons come from the theme; compare their identity, not their paths.
			$lines[] = $pad . "<svg{$s}>…";
			return;
		}
		$lines[] = $pad . "<{$tag}{$s}>";
		foreach ( $n->childNodes as $c ) {
			$walk( $c, $depth + 1 );
		}
	};
	if ( $root ) {
		foreach ( $root->childNodes as $c ) {
			$walk( $c, 0 );
		}
	}
	return implode( "\n", $lines ) . "\n";
}

function ls_canon_value( string $v ): string {
	$v = ls_strip_hosts( html_entity_decode( $v, ENT_QUOTES | ENT_HTML5, 'UTF-8' ) );
	$v = ls_resolve_old_id( $v );
	// /wp-content/uploads/2026/09/name-1024x683.webp → uploads:name
	$v = (string) preg_replace_callback(
		'#/wp-content/uploads/(?:\d{4}/\d{2}/)?([^"\s,)?]+?)(?:-\d+x\d+|-scaled)?\.(webp|jpe?g|png|gif|svg|pdf|avif)#i',
		static fn( $m ) => 'uploads:' . sanitize_title( preg_replace( '/-scaled$/', '', $m[1] ) ) . '.' . strtolower( $m[2] ),
		$v
	);
	$v = (string) preg_replace( '/\bwp-image-\d+\b/', 'wp-image-N', $v );
	// Ids from per-process counters (wp_unique_id) depend on render order.
	$v = (string) preg_replace( '/\bac-\d+-/', 'ac-N-', $v );
	$v = (string) preg_replace( '/\bwpcf7-f\d+(-p\d+)?-o\d+\b/', 'wpcf7-fN', $v );
	$v = (string) preg_replace( '/\b(post|postid|page-id)-\d+\b/', '$1-N', $v );
	$v = (string) preg_replace( '/\b(menu-item|page-item|hdr-panel|navx-sub)-\d+\b/', '$1-N', $v );
	$v = (string) preg_replace( '/\bblock_[0-9a-f]{6,}\b/', 'block_X', $v );
	$v = (string) preg_replace( '/\?ver=[^"\s&]+/', '', $v );
	return trim( (string) preg_replace( '/\s+/u', ' ', $v ) );
}

/** The root element(s) of a rendered block matching its lasanmarine class. */
function ls_rendered_root( string $html, string $slug ): string {
	$doc = ls_load_html( '<html><body><div id="__r">' . $html . '</div></body></html>' );
	$el  = ls_one( $doc, '.lasanmarine-' . $slug );
	return $el ? (string) $doc->saveHTML( $el ) : $html;
}

function ls_diff( string $a, string $b ): string {
	$fa = tempnam( sys_get_temp_dir(), 'lsa' );
	$fb = tempnam( sys_get_temp_dir(), 'lsb' );
	file_put_contents( $fa, $a );
	file_put_contents( $fb, $b );
	$d = (string) shell_exec( 'diff -U2 --label static --label rendered ' . escapeshellarg( $fa ) . ' ' . escapeshellarg( $fb ) );
	unlink( $fa );
	unlink( $fb );
	return $d;
}

function ls_selected_pages( array $keys ): array {
	$pages = ls_pages();
	if ( ! $keys ) {
		return $pages;
	}
	return array_values( array_filter( $pages, static fn( $p ) => in_array( $p['key'], $keys, true ) ) );
}


switch ( $cmd ) {
	case 'build':
		$problems = array();
		$docs     = array();
		$special = array_values( array_intersect( $pos, array( 'news', 'projects-cpt' ) ) );
		$pages   = array_values( array_diff( $pos, $special ) );
		foreach ( ( $special && ! $pages ? array() : ls_selected_pages( $pages ) ) as $pg ) {
			$docs[ $pg['key'] ] = ls_build_doc( $pg, $problems );
		}
		$files = array();
		if ( ! $pos || in_array( 'news', $pos, true ) ) {
			$files['06-news.vi.json'] = ls_build_news( $problems );
		}
		if ( ! $pos || in_array( 'projects-cpt', $pos, true ) ) {
			$files['05-projects-cpt.json'] = ls_build_projects( $problems );
		}
		foreach ( $problems as $p ) {
			fwrite( STDERR, "  ! {$p}\n" );
		}
		echo wp_json_encode( array( 'docs' => $docs, 'files' => $files, 'media' => ls_media_used() ), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT );
		break;

	case 'verify':
		$want_block = is_string( $flags['block'] ?? null ) ? (string) $flags['block'] : '';
		$total      = 0;
		$ok         = 0;
		foreach ( ls_selected_pages( $pos ) as $pg ) {
			$problems = array();
			$doc      = ls_build_doc( $pg, $problems );
			if ( ! empty( $pg['template'] ) ) {
				continue; // full-screen app pages are checked by HTTP
			}
			if ( ! ls_enter_page( $pg, $doc ) ) {
				echo "{$pg['key']}: trang chưa có trong WP — chạy sync apply trước\n";
				continue;
			}
			$static = ls_main_blocks( ls_load( ls_page_file( $pg ) ) );
			$bi     = 0;
			foreach ( $static as $i => list( $type, $el ) ) {
				$entry = $doc['blocks'][ $bi++ ] ?? null;
				if ( '' === $type ) {
					$type = 'core';
				}
				if ( '' !== $want_block && $type !== $want_block ) {
					continue;
				}
				++$total;
				$probs = array();
				$a     = ls_canon( (string) $el->ownerDocument->saveHTML( $el ) );
				$b     = $entry ? ls_canon( 'core' === $type ? ls_render_entry( $entry, $probs ) : ls_rendered_root( ls_render_entry( $entry, $probs ), $type ) ) : '';
				$same  = $a === $b;
				$ok   += $same ? 1 : 0;
				$parser = ( 'core' === $type || ls_parser( $type ) ) ? '' : ' (chưa có parser)';
				printf( "%-4s %-26s #%-2d %s%s\n", $same ? 'OK' : 'DIFF', $pg['key'], $i, $type, $parser );
				foreach ( $probs as $p ) {
					echo "       ! {$p}\n";
				}
				if ( ! $same && ! empty( $flags['diff'] ) ) {
					echo preg_replace( '/^/m', '       ', ls_diff( $a, $b ) );
				}
			}
		}
		echo "\n{$ok}/{$total} block khớp\n";
		break;

	case 'static':
	case 'render':
	case 'fields':
		$pg = ls_page_by_key( (string) ( $pos[0] ?? '' ) );
		$n    = (int) ( $pos[1] ?? 0 );
		if ( ! $pg ) {
			fwrite( STDERR, "không có trang {$pos[0]}\n" );
			exit( 1 );
		}
		$static = ls_main_blocks( ls_load( ls_page_file( $pg ) ) );
		list( $type, $el ) = $static[ $n ];
		if ( 'static' === $cmd ) {
			echo ls_canon( (string) $el->ownerDocument->saveHTML( $el ) );
			break;
		}
		$problems = array();
		$doc      = ls_build_doc( $pg, $problems );
		// Map static index to doc block index (skipping non-blocks).
		$entry = $doc['blocks'][ $n ];
		$type  = '' === $type ? 'core' : $type;
		if ( 'fields' === $cmd ) {
			echo wp_json_encode( $entry, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ), "\n";
			break;
		}
		ls_enter_page( $pg, $doc );
		$html = ls_render_entry( $entry, $problems );
		echo ls_canon( 'core' === $type ? $html : ls_rendered_root( $html, $type ) );
		break;

	case 'compare':
		// compare <path…> [--sel=css] [--diff]: live page over HTTP vs static.
		$sel = is_string( $flags['sel'] ?? null ) ? (string) $flags['sel'] : 'main';
		$ok  = 0;
		foreach ( $pos as $path ) {
			$res  = wp_remote_get( home_url( $path ), array( 'timeout' => 60, 'sslverify' => false ) );
			$live = is_wp_error( $res ) ? '' : (string) wp_remote_retrieve_body( $res );
			$code = is_wp_error( $res ) ? $res->get_error_message() : (string) wp_remote_retrieve_response_code( $res );
			$file = ls_docs() . rtrim( $path, '/' ) . '/index.html';
			$sd   = ls_load( $file );
			$ld   = ls_load_html( $live );
			$a    = '';
			$b    = '';
			foreach ( ls_all( $sd, $sel ) as $el ) {
				$a .= ls_canon( (string) $sd->saveHTML( $el ) );
			}
			foreach ( ls_all( $ld, $sel ) as $el ) {
				$b .= ls_canon( (string) $ld->saveHTML( $el ) );
			}
			$same = '' !== $a && $a === $b;
			$ok  += $same ? 1 : 0;
			printf( "%-4s %s %s\n", $same ? 'OK' : 'DIFF', $code, $path );
			if ( ! $same && ! empty( $flags['diff'] ) ) {
				echo preg_replace( '/^/m', '       ', ls_diff( $a, $b ) );
			}
		}
		echo "\n{$ok}/" . count( $pos ) . " trang khớp\n";
		break;

	default:
		fwrite( STDERR, "lệnh: build | verify | static | render | fields | compare\n" );
		exit( 1 );
}
