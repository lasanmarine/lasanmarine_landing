<?php
/**
 * Where static apps live and how they get there.
 *
 * An app is a built front end (an index.html plus its assets) served as plain
 * files from uploads/static-apps/<slug>/<version>/. Each upload is a new
 * version directory, so a version's URLs never change content (long caches
 * are safe) and an earlier version can be made current again.
 *
 * The registry is one option:
 *   [ slug => [ title, active, versions => [ version => [ added, files, bytes, source ] ] ] ]
 *
 * @package Lasan_Static_Apps
 */

namespace Lasan\StaticApps;

use WP_Error;
use ZipArchive;

defined( 'ABSPATH' ) || exit;

final class Store {

	const OPTION = 'lasan_static_apps';
	const DIR    = 'static-apps';

	/** File types an app may contain: what a browser loads, nothing a server runs. */
	const ALLOWED_EXT = array(
		'html', 'htm', 'js', 'mjs', 'css', 'map', 'json', 'webmanifest', 'txt', 'xml', 'csv', 'md',
		'svg', 'png', 'jpg', 'jpeg', 'gif', 'webp', 'avif', 'ico', 'bmp',
		'woff', 'woff2', 'ttf', 'otf', 'eot',
		'wasm', 'glb', 'gltf', 'bin', 'obj', 'stl', 'hdr', 'ktx2', 'basis',
		'pdf', 'mp4', 'webm', 'mp3', 'wav', 'ogg',
	);

	/** Text files whose build paths are rewritten when the app moves. */
	const TEXT_EXT = array( 'html', 'htm', 'js', 'mjs', 'css', 'json', 'webmanifest', 'map', 'svg', 'xml', 'txt' );

	const MAX_FILES = 5000;
	const MAX_BYTES = 314572800; // 300 MB uncompressed: refuses zip bombs, fits real apps.

	/* ---------------------------------------------------------------------
	 * Registry
	 * ------------------------------------------------------------------ */

	/** @return array<string, array<string, mixed>> */
	public static function all(): array {
		$apps = get_option( self::OPTION, array() );
		return is_array( $apps ) ? $apps : array();
	}

	/** @return array<string, mixed>|null */
	public static function get( string $slug ): ?array {
		$apps = self::all();
		return $apps[ $slug ] ?? null;
	}

	private static function save( array $apps ): void {
		ksort( $apps );
		update_option( self::OPTION, $apps, false );
	}

	/* ---------------------------------------------------------------------
	 * Paths and URLs
	 * ------------------------------------------------------------------ */

	public static function base_dir(): string {
		return trailingslashit( wp_upload_dir( null, false )['basedir'] ) . self::DIR;
	}

	public static function base_url(): string {
		return trailingslashit( wp_upload_dir( null, false )['baseurl'] ) . self::DIR;
	}

	public static function version_dir( string $slug, string $version ): string {
		return self::base_dir() . '/' . $slug . '/' . $version;
	}

	/** Site-relative URL path of a version's folder, with a trailing slash. */
	public static function version_path( string $slug, string $version ): string {
		$path = (string) wp_parse_url( self::base_url(), PHP_URL_PATH );
		return trailingslashit( $path ) . $slug . '/' . $version . '/';
	}

	/** URL of the current version's index.html, or '' when the app is unknown. */
	public static function url( string $slug ): string {
		$app = self::get( $slug );
		if ( ! $app || empty( $app['active'] ) ) {
			return '';
		}
		$index = self::version_dir( $slug, (string) $app['active'] ) . '/index.html';
		return is_file( $index ) ? trailingslashit( self::base_url() ) . $slug . '/' . $app['active'] . '/index.html' : '';
	}

	/* ---------------------------------------------------------------------
	 * Install
	 * ------------------------------------------------------------------ */

	public static function sanitize_slug( string $slug ): string {
		return trim( (string) preg_replace( '/[^a-z0-9-]+/', '-', strtolower( remove_accents( $slug ) ) ), '-' );
	}

	/**
	 * Install a version from a zip file.
	 *
	 * @return string|WP_Error The new version id.
	 */
	public static function install_zip( string $zip_file, string $slug, string $title = '' ) {
		if ( ! class_exists( ZipArchive::class ) ) {
			return new WP_Error( 'no_zip', __( 'Máy chủ thiếu tiện ích ZipArchive của PHP.', 'lasan-static-apps' ) );
		}
		$slug = self::sanitize_slug( $slug );
		if ( '' === $slug ) {
			return new WP_Error( 'bad_slug', __( 'Chưa có đường dẫn (slug) cho app.', 'lasan-static-apps' ) );
		}

		$zip = new ZipArchive();
		if ( true !== $zip->open( $zip_file ) ) {
			return new WP_Error( 'bad_zip', __( 'Không mở được file zip.', 'lasan-static-apps' ) );
		}

		// Read the list first: refuse the whole archive on any bad entry.
		$entries = array();
		$bytes   = 0;
		for ( $i = 0; $i < $zip->numFiles; $i++ ) {
			$stat = $zip->statIndex( $i );
			$name = (string) $stat['name'];
			if ( str_ends_with( $name, '/' ) || str_starts_with( $name, '__MACOSX/' ) || str_contains( $name, '/.DS_Store' ) || '.DS_Store' === basename( $name ) ) {
				continue;
			}
			$check = self::check_entry( $name, $zip, $i );
			if ( is_wp_error( $check ) ) {
				$zip->close();
				return $check;
			}
			$bytes += (int) $stat['size'];
			$entries[ $i ] = $name;
		}
		if ( count( $entries ) > self::MAX_FILES || $bytes > self::MAX_BYTES ) {
			$zip->close();
			return new WP_Error( 'too_big', __( 'File zip quá lớn hoặc quá nhiều file.', 'lasan-static-apps' ) );
		}

		// The app's root: where index.html is, allowing one wrapping folder (dist/, build/…).
		$root = self::find_root( $entries );
		if ( null === $root ) {
			$zip->close();
			return new WP_Error( 'no_index', __( 'Không thấy index.html ở gốc file zip (hoặc trong một thư mục duy nhất như dist/).', 'lasan-static-apps' ) );
		}

		$version = gmdate( 'Ymd-His' );
		$dir     = self::version_dir( $slug, $version );
		if ( ! wp_mkdir_p( $dir ) ) {
			$zip->close();
			return new WP_Error( 'mkdir', __( 'Không tạo được thư mục trong uploads.', 'lasan-static-apps' ) );
		}

		foreach ( $entries as $i => $name ) {
			if ( '' !== $root && ! str_starts_with( $name, $root ) ) {
				continue; // outside the app's folder
			}
			$rel    = substr( $name, strlen( $root ) );
			$target = $dir . '/' . $rel;
			wp_mkdir_p( dirname( $target ) );
			$stream = $zip->getStream( $name );
			if ( ! $stream ) {
				continue;
			}
			$out = fopen( $target, 'wb' ); // phpcs:ignore WordPress.WP.AlternativeFunctions
			stream_copy_to_stream( $stream, $out );
			fclose( $out ); // phpcs:ignore WordPress.WP.AlternativeFunctions
			fclose( $stream ); // phpcs:ignore WordPress.WP.AlternativeFunctions
		}
		$zip->close();

		return self::register_version( $slug, $version, $title, 'zip' );
	}

	/**
	 * Install a version from a folder already on the server (the apps that
	 * used to ship inside the theme).
	 *
	 * @return string|WP_Error
	 */
	public static function install_dir( string $source, string $slug, string $title = '' ) {
		$slug = self::sanitize_slug( $slug );
		if ( '' === $slug || ! is_file( trailingslashit( $source ) . 'index.html' ) ) {
			return new WP_Error( 'no_index', __( 'Thư mục không có index.html.', 'lasan-static-apps' ) );
		}
		$version = gmdate( 'Ymd-His' );
		$dir     = self::version_dir( $slug, $version );
		$it      = new \RecursiveIteratorIterator( new \RecursiveDirectoryIterator( $source, \FilesystemIterator::SKIP_DOTS ) );
		foreach ( $it as $file ) {
			$rel = ltrim( substr( (string) $file->getPathname(), strlen( untrailingslashit( $source ) ) ), '/' );
			if ( ! in_array( strtolower( pathinfo( $rel, PATHINFO_EXTENSION ) ), self::ALLOWED_EXT, true ) ) {
				continue;
			}
			wp_mkdir_p( dirname( $dir . '/' . $rel ) );
			copy( (string) $file->getPathname(), $dir . '/' . $rel );
		}
		return self::register_version( $slug, $version, $title, 'thư mục ' . basename( $source ) );
	}

	/** Rewrite build paths, add the guard files, and record the version as current. */
	private static function register_version( string $slug, string $version, string $title, string $source ) {
		$dir = self::version_dir( $slug, $version );
		if ( ! is_file( $dir . '/index.html' ) ) {
			self::rmdir( $dir );
			return new WP_Error( 'no_index', __( 'Bản cài không có index.html.', 'lasan-static-apps' ) );
		}
		self::rebase( $dir, self::version_path( $slug, $version ) );
		self::harden();

		$files = 0;
		$bytes = 0;
		foreach ( new \RecursiveIteratorIterator( new \RecursiveDirectoryIterator( $dir, \FilesystemIterator::SKIP_DOTS ) ) as $f ) {
			++$files;
			$bytes += (int) $f->getSize();
		}

		$apps          = self::all();
		$app           = $apps[ $slug ] ?? array( 'title' => '', 'versions' => array() );
		$app['title']  = '' !== trim( $title ) ? sanitize_text_field( $title ) : ( $app['title'] ?: $slug );
		$app['versions'][ $version ] = array(
			'added'  => time(),
			'files'  => $files,
			'bytes'  => $bytes,
			'source' => $source,
		);
		$app['active']  = $version;
		$apps[ $slug ]  = $app;
		self::save( $apps );
		self::changed();

		return $version;
	}

	/* ---------------------------------------------------------------------
	 * Manage
	 * ------------------------------------------------------------------ */

	public static function activate( string $slug, string $version ): bool {
		$apps = self::all();
		if ( empty( $apps[ $slug ]['versions'][ $version ] ) || ! is_file( self::version_dir( $slug, $version ) . '/index.html' ) ) {
			return false;
		}
		$apps[ $slug ]['active'] = $version;
		self::save( $apps );
		self::changed();
		return true;
	}

	public static function rename( string $slug, string $title ): void {
		$apps = self::all();
		if ( isset( $apps[ $slug ] ) && '' !== trim( $title ) ) {
			$apps[ $slug ]['title'] = sanitize_text_field( $title );
			self::save( $apps );
		}
	}

	/** Delete one version; the current one can only go with the whole app. */
	public static function delete_version( string $slug, string $version ): bool {
		$apps = self::all();
		if ( empty( $apps[ $slug ]['versions'][ $version ] ) || ( $apps[ $slug ]['active'] ?? '' ) === $version ) {
			return false;
		}
		self::rmdir( self::version_dir( $slug, $version ) );
		unset( $apps[ $slug ]['versions'][ $version ] );
		self::save( $apps );
		return true;
	}

	public static function delete_app( string $slug ): bool {
		$apps = self::all();
		if ( ! isset( $apps[ $slug ] ) ) {
			return false;
		}
		self::rmdir( self::base_dir() . '/' . $slug );
		unset( $apps[ $slug ] );
		self::save( $apps );
		self::changed();
		return true;
	}

	/* ---------------------------------------------------------------------
	 * Internals
	 * ------------------------------------------------------------------ */

	/** Reject paths that escape the folder, links, and file types a server could run. */
	private static function check_entry( string $name, ZipArchive $zip, int $index ) {
		if ( str_contains( $name, "\0" ) || str_contains( $name, '\\' ) || str_starts_with( $name, '/' ) || preg_match( '#(^|/)\.\.(/|$)#', $name ) ) {
			/* translators: %s: file name in the zip */
			return new WP_Error( 'bad_path', sprintf( __( 'Đường dẫn không hợp lệ trong zip: %s', 'lasan-static-apps' ), $name ) );
		}
		// Symbolic links (Unix mode in the high bits of the external attributes).
		if ( $zip->getExternalAttributesIndex( $index, $opsys, $attr ) && ZipArchive::OPSYS_UNIX === $opsys && 0120000 === ( ( $attr >> 16 ) & 0170000 ) ) {
			/* translators: %s: file name in the zip */
			return new WP_Error( 'symlink', sprintf( __( 'Zip có liên kết tượng trưng (symlink): %s', 'lasan-static-apps' ), $name ) );
		}
		$base = basename( $name );
		$ext  = strtolower( pathinfo( $base, PATHINFO_EXTENSION ) );
		if ( str_starts_with( $base, '.' ) || ! in_array( $ext, self::ALLOWED_EXT, true ) ) {
			/* translators: %s: file name in the zip */
			return new WP_Error( 'bad_type', sprintf( __( 'Loại file không được phép: %s (chỉ nhận file tĩnh: HTML, JS, CSS, ảnh, font, dữ liệu…)', 'lasan-static-apps' ), $name ) );
		}
		return true;
	}

	/** Prefix inside the zip that holds index.html: '' or one folder like "dist/". */
	private static function find_root( array $entries ): ?string {
		if ( in_array( 'index.html', $entries, true ) ) {
			return '';
		}
		$tops = array();
		foreach ( $entries as $name ) {
			$tops[ explode( '/', $name, 2 )[0] ] = true;
		}
		if ( 1 === count( $tops ) ) {
			$top = (string) array_key_first( $tops ) . '/';
			if ( in_array( $top . 'index.html', $entries, true ) ) {
				return $top;
			}
		}
		return null;
	}

	/**
	 * Make an app work from its new folder.
	 *
	 * A build made with a relative base (Vite `base: './'`) needs nothing. A
	 * build made for a fixed address writes that address into its HTML, CSS and
	 * JS ("/wp-content/themes/…/apps/x/assets/…", or with the full domain). The
	 * old base is read off index.html — the folder in front of its scripts and
	 * styles — and replaced by the new one in every text file.
	 */
	private static function rebase( string $dir, string $new_path ): void {
		$index = $dir . '/index.html';
		$html  = (string) file_get_contents( $index );
		$old   = self::detect_base( $html );

		$targets = array();
		foreach ( new \RecursiveIteratorIterator( new \RecursiveDirectoryIterator( $dir, \FilesystemIterator::SKIP_DOTS ) ) as $f ) {
			if ( in_array( strtolower( $f->getExtension() ), self::TEXT_EXT, true ) ) {
				$targets[] = (string) $f->getPathname();
			}
		}

		if ( null !== $old && $old !== $new_path ) {
			$replace = array();
			// The same path written with any origin in front of it, then bare.
			if ( preg_match_all( '#https?://[a-z0-9.\-:]+' . preg_quote( $old, '#' ) . '#i', $html . implode( '', array_map( 'file_get_contents', $targets ) ), $m ) ) {
				foreach ( array_unique( $m[0] ) as $full ) {
					$replace[ $full ] = $new_path;
				}
			}
			$replace[ $old ] = $new_path;
			foreach ( $targets as $file ) {
				$text = (string) file_get_contents( $file );
				$new  = strtr( $text, $replace );
				if ( $new !== $text ) {
					file_put_contents( $file, $new );
				}
			}
			$html = (string) file_get_contents( $index );
		}

		// The app's own page is not a page of the site: the site's tool page
		// that embeds it is. Keep search engines off the bare file.
		$html = (string) preg_replace( '#<meta\s+name=["\']robots["\'][^>]*>\s*#i', '', $html );
		$html = (string) preg_replace( '#<link\s+rel=["\'](canonical|alternate)["\'][^>]*>\s*#i', '', $html );
		$html = (string) preg_replace( '#<head([^>]*)>#i', '<head$1>' . "\n" . '<meta name="robots" content="noindex, follow">', $html, 1 );
		file_put_contents( $index, $html );
	}

	/** The folder an absolute-base build was made for, read off its index.html. */
	private static function detect_base( string $html ): ?string {
		if ( ! preg_match_all( '#<(?:script|link)\b[^>]*\b(?:src|href)=["\']([^"\']+)["\']#i', $html, $m ) ) {
			return null;
		}
		foreach ( $m[1] as $ref ) {
			$path = (string) wp_parse_url( $ref, PHP_URL_PATH );
			if ( ! str_starts_with( $path, '/' ) || ! preg_match( '#\.(m?js|css)$#', $path ) ) {
				continue; // relative build, or not an asset
			}
			// "/a/b/app/assets/index-x.js" → "/a/b/app/"; "/a/b/app/main.js" → "/a/b/app/".
			$pos = strpos( $path, '/assets/' );
			return false !== $pos ? substr( $path, 0, $pos + 1 ) : trailingslashit( dirname( $path ) );
		}
		return null;
	}

	/** Belt and braces for servers that would run scripts from uploads. */
	private static function harden(): void {
		$guard = "# Static app files only.\n<FilesMatch \"\\.(php|phtml|phar|pl|py|cgi|sh)$\">\n\tRequire all denied\n</FilesMatch>\nOptions -ExecCGI -Indexes\n";
		$base  = self::base_dir();
		if ( ! is_file( $base . '/.htaccess' ) ) {
			file_put_contents( $base . '/.htaccess', $guard );
		}
		if ( ! is_file( $base . '/index.php' ) ) {
			file_put_contents( $base . '/index.php', "<?php\n// Silence is golden.\n" );
		}
	}

	private static function rmdir( string $dir ): void {
		$dir = untrailingslashit( $dir );
		if ( '' === $dir || ! str_starts_with( wp_normalize_path( $dir ), wp_normalize_path( self::base_dir() ) . '/' ) || ! is_dir( $dir ) ) {
			return; // only ever inside uploads/static-apps
		}
		$it = new \RecursiveIteratorIterator( new \RecursiveDirectoryIterator( $dir, \FilesystemIterator::SKIP_DOTS ), \RecursiveIteratorIterator::CHILD_FIRST );
		foreach ( $it as $f ) {
			$f->isDir() && ! $f->isLink() ? rmdir( (string) $f->getPathname() ) : unlink( (string) $f->getPathname() );
		}
		rmdir( $dir );
	}

	/** Pages embedding an app must not keep serving its old URL from a page cache. */
	private static function changed(): void {
		do_action( 'cache_enabler_clear_complete_cache' );
		do_action( 'lasan_static_apps_changed' );
	}
}
