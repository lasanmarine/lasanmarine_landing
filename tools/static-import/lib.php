<?php
/**
 * Helpers for reading the static export (lasanmarine.github.io/docs) back into
 * content JSON. Parsers in parsers/<block>.php receive the block's <section>
 * element and return the block's `fields` in the shape `tools/lasan apply`
 * accepts (repeaters as arrays, links as {label, page|url}, images as {media}).
 *
 * @package Starter_Flexible
 */

declare(strict_types=1);

const LS_HOSTS = array(
	'https://lasanmarine.com',
	'http://lasanmarine.com',
	'https://dev.lasanmarine.com',
	'http://dev.lasanmarine.com',
	'http://localhost:49731',
	'http://192.168.1.199:49731',
);

/** Root of the static export inside the container. */
function ls_docs(): string {
	return rtrim( (string) ( getenv( 'LS_DOCS' ) ?: '/srv/static-docs' ), '/' );
}

/** Load an HTML file into a DOMDocument (UTF-8 safe, HTML5 tags tolerated). */
function ls_load( string $file ): DOMDocument {
	$html = (string) file_get_contents( $file );
	return ls_load_html( $html );
}

function ls_load_html( string $html ): DOMDocument {
	$doc = new DOMDocument();
	libxml_use_internal_errors( true );
	$doc->loadHTML( '<?xml encoding="utf-8"?>' . $html, LIBXML_NOBLANKS | LIBXML_COMPACT | LIBXML_HTML_NODEFDTD );
	libxml_clear_errors();
	return $doc;
}

/**
 * Translate a small CSS selector into XPath. Supports: tag, .class, #id,
 * [attr], [attr=value], [attr^=value], [attr*=value], descendant (space),
 * child (>), and :scope-relative use (the result is relative: `.//…`).
 * Several selectors may be joined with a comma.
 */
function ls_css2xpath( string $css, bool $relative = true ): string {
	$out = array();
	foreach ( array_map( 'trim', explode( ',', $css ) ) as $sel ) {
		$sel   = preg_replace( '/\s*>\s*/', ' > ', $sel );
		$parts = preg_split( '/\s+/', trim( (string) $sel ) );
		$xp    = $relative ? '.' : '';
		$axis  = '//';
		foreach ( $parts as $part ) {
			if ( '>' === $part ) {
				$axis = '/';
				continue;
			}
			if ( ! preg_match( '/^([a-zA-Z0-9*-]*)(.*)$/', $part, $m ) ) {
				continue;
			}
			$tag   = '' === $m[1] ? '*' : $m[1];
			$preds = '';
			if ( preg_match_all( '/\.([\w-]+)|#([\w-]+)|\[([\w-]+)(?:([\^*$]?=)"?([^"\]]*)"?)?\]/', $m[2], $mm, PREG_SET_ORDER ) ) {
				foreach ( $mm as $p ) {
					if ( '' !== ( $p[1] ?? '' ) ) {
						$preds .= "[contains(concat(' ',normalize-space(@class),' '),' {$p[1]} ')]";
					} elseif ( '' !== ( $p[2] ?? '' ) ) {
						$preds .= "[@id='{$p[2]}']";
					} elseif ( '' !== ( $p[3] ?? '' ) ) {
						$op  = $p[4] ?? '';
						$val = $p[5] ?? '';
						if ( '' === $op ) {
							$preds .= "[@{$p[3]}]";
						} elseif ( '=' === $op ) {
							$preds .= "[@{$p[3]}='{$val}']";
						} elseif ( '^=' === $op ) {
							$preds .= "[starts-with(@{$p[3]},'{$val}')]";
						} else {
							$preds .= "[contains(@{$p[3]},'{$val}')]";
						}
					}
				}
			}
			$xp  .= $axis . $tag . $preds;
			$axis = '//';
		}
		$out[] = $xp;
	}
	return implode( ' | ', $out );
}

/** All elements under $ctx matching a CSS selector. @return array<int, DOMElement> */
function ls_all( DOMNode $ctx, string $css ): array {
	$doc = $ctx instanceof DOMDocument ? $ctx : $ctx->ownerDocument;
	$xp  = new DOMXPath( $doc );
	$res = $xp->query( ls_css2xpath( $css ), $ctx );
	$out = array();
	foreach ( $res ?: array() as $n ) {
		if ( $n instanceof DOMElement ) {
			$out[] = $n;
		}
	}
	return $out;
}

/** First element under $ctx matching a CSS selector. */
function ls_one( DOMNode $ctx, string $css ): ?DOMElement {
	$all = ls_all( $ctx, $css );
	return $all[0] ?? null;
}

/** Direct element children of $el, optionally only those with a class. @return array<int, DOMElement> */
function ls_children( DOMElement $el, string $class = '' ): array {
	$out = array();
	foreach ( $el->childNodes as $c ) {
		if ( $c instanceof DOMElement && ( '' === $class || ls_has_class( $c, $class ) ) ) {
			$out[] = $c;
		}
	}
	return $out;
}

function ls_has_class( DOMElement $el, string $class ): bool {
	return in_array( $class, preg_split( '/\s+/', trim( $el->getAttribute( 'class' ) ) ) ?: array(), true );
}

/** Collapsed text content ('' for null). */
function ls_text( ?DOMNode $n ): string {
	if ( ! $n ) {
		return '';
	}
	return trim( (string) preg_replace( '/\s+/u', ' ', $n->textContent ) );
}

/** Text of the first match of $css under $ctx. */
function ls_t( DOMNode $ctx, string $css ): string {
	return ls_text( ls_one( $ctx, $css ) );
}

/**
 * Text with <br> kept as newlines (for textarea fields with new_lines=br or
 * text that the template runs through nl2br).
 */
function ls_text_br( ?DOMNode $n ): string {
	if ( ! $n ) {
		return '';
	}
	$html = ls_inner_html( $n );
	$html = preg_replace( '#<br\s*/?>\s*#i', "\n", $html );
	$text = html_entity_decode( wp_strip_all_tags( (string) $html, false ), ENT_QUOTES | ENT_HTML5, 'UTF-8' );
	$lines = array_map( static fn( $l ) => trim( (string) preg_replace( '/[ \t\r\f\v]+/u', ' ', $l ) ), explode( "\n", $text ) );
	return trim( implode( "\n", $lines ) );
}

/** Inner HTML of a node, with site hosts stripped from URLs. */
function ls_inner_html( ?DOMNode $n ): string {
	if ( ! $n ) {
		return '';
	}
	$html = '';
	foreach ( $n->childNodes as $c ) {
		$html .= $n->ownerDocument->saveHTML( $c );
	}
	return trim( ls_strip_hosts( $html ) );
}

function ls_outer_html( ?DOMNode $n ): string {
	return $n ? ls_strip_hosts( (string) $n->ownerDocument->saveHTML( $n ) ) : '';
}

function ls_strip_hosts( string $s ): string {
	$s = str_replace( LS_HOSTS, '', $s );
	return str_replace( array_map( 'rawurlencode', LS_HOSTS ), '', $s );
}

/** Path part of a site URL ('' when external). Keeps #fragment and ?query. */
function ls_site_path( string $href ): ?string {
	$href = trim( html_entity_decode( $href ) );
	foreach ( LS_HOSTS as $h ) {
		if ( str_starts_with( $href, $h ) ) {
			$href = substr( $href, strlen( $h ) );
			return '' === $href ? '/' : $href;
		}
	}
	if ( str_starts_with( $href, '/' ) || str_starts_with( $href, '#' ) ) {
		return $href;
	}
	return null; // external, mailto:, tel:, …
}

/**
 * A link field value from an <a>. Known pages become {label, page: key} so the
 * JSON is host-free and survives renumbering; everything else keeps its URL.
 *
 * @param string|null $label Override the label (default: the anchor's text).
 * @return array<string, string>
 */
function ls_link( ?DOMElement $a, ?string $label = null ): array {
	if ( ! $a ) {
		return array();
	}
	$href  = $a->getAttribute( 'href' );
	$label = $label ?? ls_text( $a );
	$out   = array( 'label' => $label );
	$path  = ls_site_path( $href );
	if ( null !== $path ) {
		$path = ls_resolve_old_id( $path );
		$key  = ls_page_key_for_path( $path );
		if ( '' !== $key ) {
			$out['page'] = $key;
		} else {
			$out['url'] = $path;
		}
	} else {
		$out['url'] = $href;
	}
	if ( '_blank' === $a->getAttribute( 'target' ) ) {
		$out['target'] = '_blank';
	}
	return $out;
}

/**
 * Old WordPress ids seen in the export (body class page-id-N / postid-N) =>
 * the page key, or the post's path for posts. Content written in Gutenberg
 * links by `/?page_id=N`, which only the old database understood.
 *
 * @return array<int, string>
 */
function ls_old_ids(): array {
	static $map = null;
	if ( null !== $map ) {
		return $map;
	}
	$map  = array();
	$iter = new RecursiveIteratorIterator( new RecursiveDirectoryIterator( ls_docs(), FilesystemIterator::SKIP_DOTS ) );
	foreach ( $iter as $f ) {
		if ( 'index.html' !== $f->getFilename() ) {
			continue;
		}
		$head = (string) file_get_contents( (string) $f, false, null, 0, 200000 );
		if ( preg_match( '/<body[^>]*class="[^"]*\b(?:page-id|postid)-(\d+)\b/', $head, $m ) ) {
			$path = substr( dirname( (string) $f ), strlen( ls_docs() ) ) . '/';
			$map[ (int) $m[1] ] = $path;
		}
	}
	return $map;
}

/** `/?page_id=N` / `/?p=N` → the path that id had in the export. */
function ls_resolve_old_id( string $path ): string {
	if ( preg_match( '#^/?\?(?:page_id|p)=(\d+)(.*)$#', $path, $m ) ) {
		$ids = ls_old_ids();
		if ( isset( $ids[ (int) $m[1] ] ) ) {
			$rest = preg_replace( '/^&[^#]*/', '', $m[2] );
			return $ids[ (int) $m[1] ] . $rest;
		}
	}
	return $path;
}

/**
 * Serialize static core-block HTML back into block markup. Paragraphs,
 * headings, lists, groups, images, separators and buttons map to their core
 * blocks; anything else is kept as a Custom HTML block. Links to known pages
 * become `{{page:key}}` (resolved by `apply`).
 */
function ls_core_markup( DOMElement $el ): string {
	$tag     = strtolower( $el->tagName );
	$classes = ls_classes( $el );
	$extra   = array_values( array_filter( $classes, static fn( $c ) => ! preg_match( '/^(wp-block-|is-layout-|has-|wp-elements-|aligncenter$|alignwide$|alignfull$|size-)/', $c ) ) );
	$attrs   = $extra ? array( 'className' => implode( ' ', $extra ) ) : array();
	$cls     = static fn( string $base ) => trim( $base . ( $extra ? ' ' . implode( ' ', $extra ) : '' ) );
	$comment = static fn( string $name, array $a ) => '<!-- wp:' . $name . ( $a ? ' ' . wp_json_encode( $a, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) : '' ) . ' -->';

	if ( 'p' === $tag ) {
		$inner = ls_core_inner( $el );
		return $comment( 'paragraph', $attrs ) . "\n<p" . ( $extra ? ' class="' . esc_attr( implode( ' ', $extra ) ) . '"' : '' ) . ">{$inner}</p>\n<!-- /wp:paragraph -->";
	}
	if ( preg_match( '/^h([1-6])$/', $tag, $m ) ) {
		$level = (int) $m[1];
		$a     = 2 === $level ? $attrs : array( 'level' => $level ) + $attrs;
		return $comment( 'heading', $a ) . "\n<h{$level} class=\"" . esc_attr( $cls( 'wp-block-heading' ) ) . '">' . ls_core_inner( $el ) . "</h{$level}>\n<!-- /wp:heading -->";
	}
	if ( ( 'ul' === $tag || 'ol' === $tag ) && in_array( 'wp-block-list', $classes, true ) ) {
		$a     = 'ol' === $tag ? array( 'ordered' => true ) + $attrs : $attrs;
		$items = '';
		foreach ( ls_children( $el ) as $li ) {
			$items .= "<!-- wp:list-item -->\n<li>" . ls_core_inner( $li ) . "</li>\n<!-- /wp:list-item -->\n";
		}
		return $comment( 'list', $a ) . "\n<{$tag} class=\"" . esc_attr( $cls( 'wp-block-list' ) ) . "\">{$items}</{$tag}>\n<!-- /wp:list -->";
	}
	if ( 'div' === $tag && in_array( 'wp-block-group', $classes, true ) ) {
		$box  = ls_one( $el, '.wp-block-group__inner-container' );
		$kids = ls_children( $box && $box->parentNode === $el ? $box : $el );
		$body = implode( "\n\n", array_map( 'ls_core_markup', $kids ) );
		return $comment( 'group', $attrs ) . "\n<div class=\"" . esc_attr( $cls( 'wp-block-group' ) ) . "\">{$body}</div>\n<!-- /wp:group -->";
	}
	if ( 'hr' === $tag && in_array( 'wp-block-separator', $classes, true ) ) {
		return $comment( 'separator', $attrs ) . "\n<hr class=\"" . esc_attr( $cls( 'wp-block-separator has-alpha-channel-opacity' ) ) . "\"/>\n<!-- /wp:separator -->";
	}
	return "<!-- wp:html -->\n" . ls_core_inner_outer( $el ) . "\n<!-- /wp:html -->";
}

/** Inner HTML with page links turned into {{page:key}} placeholders. */
function ls_core_inner( DOMElement $el ): string {
	return ls_core_links( ls_inner_html( $el ) );
}

function ls_core_inner_outer( DOMElement $el ): string {
	return ls_core_links( ls_outer_html( $el ) );
}

function ls_core_links( string $html ): string {
	return (string) preg_replace_callback(
		'/href="([^"]*)"/',
		static function ( $m ) {
			$href = html_entity_decode( $m[1] );
			$path = ls_site_path( $href );
			if ( null === $path ) {
				return $m[0];
			}
			$path = ls_resolve_old_id( $path );
			$key  = ls_page_key_for_path( $path );
			if ( '' !== $key ) {
				$frag = preg_match( '/#.*$/', $path, $f ) ? $f[0] : '';
				return 'href="{{page:' . $key . '}}' . esc_attr( $frag ) . '"';
			}
			return 'href="' . esc_attr( $path ) . '"';
		},
		$html
	);
}

/** Page key for a site path, via the page map ('' if not a mapped page). */
function ls_page_key_for_path( string $path ): string {
	$path = ls_resolve_old_id( $path );
	$p    = (string) preg_replace( '/[?#].*$/', '', $path );
	if ( '' === $p ) {
		return '';
	}
	if ( ! str_ends_with( $p, '/' ) ) {
		$p .= '/';
	}
	foreach ( ls_pages() as $page ) {
		if ( $page['path'] === $p ) {
			return $page['key'];
		}
	}
	$redirects = ls_redirects();
	if ( isset( $redirects[ $p ] ) && $redirects[ $p ] !== $p ) {
		return ls_page_key_for_path( $redirects[ $p ] );
	}
	return '';
}

/** Static redirects (old path => new path) from tools/static-export.json. */
function ls_redirects(): array {
	static $r = null;
	if ( null === $r ) {
		$cfg = json_decode( (string) file_get_contents( dirname( __DIR__ ) . '/static-export.json' ), true );
		$r   = (array) ( $cfg['redirects'] ?? array() );
	}
	return $r;
}

/**
 * Resolve an uploaded image used by the static site to a media key, importing
 * the best available original into the media library on first use.
 * Accepts an <img> (or <source>/<a>/any element with src/srcset/href) or a URL.
 *
 * @param DOMElement|string|null $img
 * @return array{media: string}|string '' when there is no image
 */
function ls_image( $img ) {
	$url = '';
	if ( $img instanceof DOMElement ) {
		$srcset = $img->getAttribute( 'srcset' );
		$url    = $img->getAttribute( 'src' ) ?: $img->getAttribute( 'data-src' ) ?: $img->getAttribute( 'href' );
		if ( '' === $url && '' !== $srcset ) {
			$url = trim( explode( ' ', trim( explode( ',', $srcset )[0] ) )[0] );
		}
	} elseif ( is_string( $img ) ) {
		$url = $img;
	}
	if ( '' === $url ) {
		return '';
	}
	$path = ls_site_path( $url ) ?? (string) wp_parse_url( $url, PHP_URL_PATH );
	if ( ! str_contains( $path, '/wp-content/uploads/' ) ) {
		return ''; // theme asset or external: not a media-library image
	}
	$file = ls_best_original( ls_docs() . $path );
	if ( '' === $file ) {
		fwrite( STDERR, "  ! ảnh không có trong bản tĩnh: {$path}\n" );
		return '';
	}
	// Key from the requested name minus size/-scaled suffixes, so it matches
	// the original even when only a resized copy survives in the export.
	$base = (string) preg_replace( '/(-\d+x\d+|-scaled)$/', '', pathinfo( $path, PATHINFO_FILENAME ) );
	$key  = sanitize_title( $base );
	// The same file name uploaded in two months is two attachments (each with
	// its own alt text): tell them apart by month.
	$months = array_unique( array_map( static fn( $f ) => basename( dirname( dirname( (string) $f ) ) ) . basename( dirname( (string) $f ) ), (array) glob( ls_docs() . '/wp-content/uploads/*/*/' . $base . '{.,-}*', GLOB_BRACE ) ) );
	if ( count( $months ) > 1 && preg_match( '#/uploads/(\d{4})/(\d{2})/#', $path, $ym ) ) {
		$key .= '-' . $ym[1] . $ym[2];
	}
	ls_media_used( $key, $file );
	// Parallel runs: check-then-import under a lock, or the same key is
	// imported twice.
	$lock = fopen( sys_get_temp_dir() . '/ls-media.lock', 'c' );
	flock( $lock, LOCK_EX );
	wp_cache_delete( 'last_changed', 'posts' );
	if ( ! ls_media_id_fresh( $key ) ) {
		$id = ls_import_media( $file, $key, $base . '.' . pathinfo( $file, PATHINFO_EXTENSION ), preg_match( '#/uploads/(\d{4}/\d{2})/#', $path, $t ) ? $t[1] : null );
		if ( ! $id ) {
			fwrite( STDERR, "  ! không nạp được ảnh {$file}\n" );
		}
	}
	// Alt text lives on the attachment: take it from the first use that has one.
	$alt = $img instanceof DOMElement ? trim( $img->getAttribute( 'alt' ) ) : '';
	$aid = ls_media_id_fresh( $key );
	if ( '' !== $alt && $aid && '' === (string) get_post_meta( $aid, '_wp_attachment_image_alt', true ) ) {
		update_post_meta( $aid, '_wp_attachment_image_alt', $alt );
	}
	flock( $lock, LOCK_UN );
	fclose( $lock );
	return array( 'media' => $key );
}

/** Attachment id for a media key, bypassing the per-process cache. */
function ls_media_id_fresh( string $key ): int {
	global $wpdb;
	return (int) $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_lasan_media_key' AND meta_value = %s ORDER BY post_id LIMIT 1", $key ) );
}

/** Track media used in this run: key => source file. */
function ls_media_used( ?string $key = null, ?string $file = null ): array {
	static $used = array();
	if ( null !== $key ) {
		$used[ $key ] = $file;
	}
	return $used;
}

/**
 * Pick the largest/original file for an upload path: the bare name if present,
 * else `-scaled`, else the widest `-WxH` variant.
 */
function ls_best_original( string $file ): string {
	$dir  = dirname( $file );
	$ext  = pathinfo( $file, PATHINFO_EXTENSION );
	$base = (string) preg_replace( '/(-\d+x\d+|-scaled)$/', '', pathinfo( $file, PATHINFO_FILENAME ) );
	foreach ( array( "{$dir}/{$base}.{$ext}", "{$dir}/{$base}-scaled.{$ext}" ) as $cand ) {
		if ( is_file( $cand ) ) {
			return $cand;
		}
	}
	$best = '';
	$bw   = 0;
	foreach ( (array) glob( "{$dir}/{$base}-*x*.{$ext}" ) as $cand ) {
		if ( preg_match( '/-(\d+)x(\d+)\.' . preg_quote( $ext, '/' ) . '$/', (string) $cand, $m ) && (int) $m[1] > $bw ) {
			$bw   = (int) $m[1];
			$best = (string) $cand;
		}
	}
	if ( '' === $best && is_file( $file ) ) {
		$best = $file;
	}
	return $best;
}

/**
 * Import a file under an explicit media key, into the upload folder (yyyy/mm)
 * and under the file name it had on the old site, so the URLs keep their shape.
 */
function ls_import_media( string $file, string $key, ?string $name = null, ?string $month = null ): int {
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';
	$name = $name ?? $key . '.' . pathinfo( $file, PATHINFO_EXTENSION );
	$tmp  = wp_tempnam( $name );
	if ( ! $tmp || ! copy( $file, $tmp ) ) {
		return 0;
	}
	$arr = array( 'name' => $name, 'tmp_name' => $tmp );
	$up  = wp_handle_sideload( $arr, array( 'test_form' => false ), $month );
	if ( ! empty( $up['error'] ) ) {
		@unlink( $tmp ); // phpcs:ignore
		fwrite( STDERR, "  ! {$up['error']}\n" );
		return 0;
	}
	$id = wp_insert_attachment(
		array( 'post_mime_type' => $up['type'], 'post_title' => $key, 'post_status' => 'inherit' ),
		$up['file'],
		0,
		true
	);
	if ( is_wp_error( $id ) ) {
		return 0;
	}
	wp_update_attachment_metadata( (int) $id, wp_generate_attachment_metadata( (int) $id, $up['file'] ) );
	update_post_meta( (int) $id, '_lasan_media_key', $key );
	return (int) $id;
}

/** The value of a `--phero-h:420px`-style custom property in a style attribute. */
function ls_style_var( DOMElement $el, string $var ): string {
	if ( preg_match( '/' . preg_quote( $var, '/' ) . '\s*:\s*([^;]+)/', $el->getAttribute( 'style' ), $m ) ) {
		return trim( $m[1] );
	}
	return '';
}

/** Classes of an element as an array. @return array<int, string> */
function ls_classes( DOMElement $el ): array {
	return array_values( array_filter( preg_split( '/\s+/', trim( $el->getAttribute( 'class' ) ) ) ?: array() ) );
}

/** The page map. @return array<int, array<string, mixed>> */
function ls_pages(): array {
	static $pages = null;
	if ( null === $pages ) {
		$pages = require __DIR__ . '/pages.php';
	}
	return $pages;
}

function ls_page_by_key( string $key ): ?array {
	foreach ( ls_pages() as $p ) {
		if ( $p['key'] === $key ) {
			return $p;
		}
	}
	return null;
}
