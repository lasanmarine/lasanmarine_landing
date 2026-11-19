<?php
/**
 * Where static apps live and how they get there.
 *
 * An app is a built front end (an index.html plus its assets) served as plain
 * files from uploads/static-apps/<slug>/<version>/. Versions are semantic
 * version numbers (1.0.0, 1.1.0, 2.0.0-beta.1). A version, once installed,
 * never changes: its URLs can be cached for long, and any earlier version can
 * be made current again. A new build is always a new number.
 *
 * Where a version comes from:
 *   - a .zip uploaded in the admin;
 *   - the plugin's own apps/<slug>/ folder (an app.json manifest beside the
 *     build), installed when the plugin is deployed with a version the site
 *     has not seen yet.
 *
 * An app's slug can be changed; the old slug stays as an alias, so content
 * (or a bundled app) that still names it keeps working.
 *
 * The registry is one option:
 *   [ slug => [ title, active, versions => [ version => [ added, files, bytes, source, notes ] ] ] ]
 *
 * @package Lasan_Static_Apps
 */

namespace Lasan\StaticApps;

use WP_Error;
use ZipArchive;

defined( 'ABSPATH' ) || exit;

final class Store {

	const OPTION     = 'lasan_static_apps';
	const SCHEMA_OPT = 'lasan_static_apps_schema';
	const SEEN_OPT   = 'lasan_static_apps_bundled';
	const ALIAS_OPT  = 'lasan_static_apps_aliases';
	const SCHEMA     = 2;
	const DIR        = 'static-apps';

	/** MAJOR.MINOR.PATCH with an optional pre-release tag: 1.2.0, 2.0.0-beta.1. Also a safe folder name. */
	const VERSION_RE = '/^(0|[1-9]\d{0,3})\.(0|[1-9]\d{0,3})\.(0|[1-9]\d{0,3})(-[0-9a-z]+(\.[0-9a-z]+)*)?$/';

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

	/** The slug an old slug was renamed to (following renames), or the slug itself. */
	public static function resolve( string $slug ): string {
		$aliases = (array) get_option( self::ALIAS_OPT, array() );
		for ( $hops = 0; isset( $aliases[ $slug ] ) && $hops < 10; $hops++ ) {
			$slug = (string) $aliases[ $slug ];
		}
		return $slug;
	}

	private static function save( array $apps ): void {
		ksort( $apps );
		update_option( self::OPTION, $apps, false );
	}

	/**
	 * An app's versions, newest first.
	 *
	 * @return array<string, array<string, mixed>>
	 */
	public static function versions( string $slug ): array {
		$versions = (array) ( self::get( $slug )['versions'] ?? array() );
		uksort( $versions, static fn( $a, $b ) => version_compare( (string) $b, (string) $a ) );
		return $versions;
	}

	/** Highest version installed, '' when none. */
	public static function latest( string $slug ): string {
		return (string) array_key_first( self::versions( $slug ) );
	}

	/** Current version, '' when none. */
	public static function active( string $slug ): string {
		return (string) ( self::get( $slug )['active'] ?? '' );
	}

	public static function valid_version( string $version ): bool {
		return 1 === preg_match( self::VERSION_RE, $version );
	}

	/** 1.4.2 → 1.4.3; 2.0.0-beta.1 → 2.0.0; '' → 1.0.0. */
	public static function next_version( string $after ): string {
		if ( ! preg_match( self::VERSION_RE, $after, $m ) ) {
			return '1.0.0';
		}
		return ! empty( $m[4] ) ? "$m[1].$m[2].$m[3]" : $m[1] . '.' . $m[2] . '.' . ( (int) $m[3] + 1 );
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

	/** URL of a version's index.html (the current one by default), '' when there is none. */
	public static function url( string $slug, string $version = '' ): string {
		$slug    = self::resolve( $slug );
		$version = '' !== $version ? $version : self::active( $slug );
		if ( '' === $version || ! is_file( self::version_dir( $slug, $version ) . '/index.html' ) ) {
			return '';
		}
		return trailingslashit( self::base_url() ) . $slug . '/' . $version . '/index.html';
	}

	/** The apps that ship inside the plugin: apps/<slug>/ with app.json and index.html. */
	public static function bundled_dir(): string {
		return dirname( __DIR__ ) . '/apps';
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
	 * The version number, release notes and app name may come from $args,
	 * else from an app.json (or package.json) at the build's root; with
	 * neither, the version is the next patch after the highest installed.
	 *
	 * @param array{version?:string,notes?:string,activate?:bool} $args
	 * @return string|WP_Error The new version.
	 */
	public static function install_zip( string $zip_file, string $slug, string $title = '', array $args = array() ) {
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

		$manifest = self::manifest_from( static fn( $file ) => in_array( $root . $file, $entries, true ) ? (string) $zip->getFromName( $root . $file, 65536 ) : '' );
		$meta     = self::resolve_meta( $slug, $title, $args, $manifest );
		if ( is_wp_error( $meta ) ) {
			$zip->close();
			return $meta;
		}

		$stage = self::stage_dir( $slug );
		foreach ( $entries as $name ) {
			if ( '' !== $root && ! str_starts_with( $name, $root ) ) {
				continue; // outside the app's folder
			}
			$target = $stage . '/' . substr( $name, strlen( $root ) );
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

		return self::register_version( $slug, $stage, $meta, 'zip' );
	}

	/**
	 * Install a version from a folder on the server (the plugin's bundled
	 * apps). Same rules for the version as install_zip().
	 *
	 * @param array{version?:string,notes?:string,activate?:bool} $args
	 * @return string|WP_Error
	 */
	public static function install_dir( string $source, string $slug, string $title = '', array $args = array(), string $label = '' ) {
		$source = untrailingslashit( $source );
		$slug   = self::sanitize_slug( $slug );
		if ( '' === $slug || ! is_file( $source . '/index.html' ) ) {
			return new WP_Error( 'no_index', __( 'Thư mục không có index.html.', 'lasan-static-apps' ) );
		}
		$manifest = self::manifest_from( static fn( $file ) => is_file( "$source/$file" ) ? (string) file_get_contents( "$source/$file", false, null, 0, 65536 ) : '' );
		$meta     = self::resolve_meta( $slug, $title, $args, $manifest );
		if ( is_wp_error( $meta ) ) {
			return $meta;
		}

		$stage = self::stage_dir( $slug );
		$it    = new \RecursiveIteratorIterator( new \RecursiveDirectoryIterator( $source, \FilesystemIterator::SKIP_DOTS ) );
		foreach ( $it as $file ) {
			$rel = ltrim( substr( (string) $file->getPathname(), strlen( $source ) ), '/' );
			if ( $file->isLink() || str_starts_with( basename( $rel ), '.' ) || ! in_array( strtolower( pathinfo( $rel, PATHINFO_EXTENSION ) ), self::ALLOWED_EXT, true ) ) {
				continue;
			}
			wp_mkdir_p( dirname( $stage . '/' . $rel ) );
			copy( (string) $file->getPathname(), $stage . '/' . $rel );
		}
		return self::register_version( $slug, $stage, $meta, '' !== $label ? $label : 'thư mục ' . basename( $source ) );
	}

	/**
	 * Install what the plugin ships in apps/ and the site has not seen yet.
	 * Each bundled version is offered once: deleting it (or the app) in the
	 * admin is respected, and a rollback is not undone. A bundled version
	 * newer than the current one becomes current.
	 *
	 * @return array<string, string|WP_Error> slug => installed version or error
	 */
	public static function sync_bundled(): array {
		$seen = get_option( self::SEEN_OPT, array() );
		$seen = is_array( $seen ) ? $seen : array();
		$done = array();
		foreach ( self::bundled() as $key => $b ) {
			if ( ( $seen[ $key ] ?? '' ) === $b['version'] ) {
				continue;
			}
			$seen[ $key ] = $b['version'];
			$slug         = self::resolve( $key ); // the app may have been renamed in the admin
			if ( isset( self::versions( $slug )[ $b['version'] ] ) ) {
				continue; // already installed (from a zip, or before this was tracked)
			}
			$active        = self::active( $slug );
			$done[ $slug ] = self::install_dir(
				$b['dir'],
				$slug,
				self::get( $slug ) ? '' : $b['name'],
				array( 'activate' => '' === $active || version_compare( $b['version'], $active, '>' ) ),
				__( 'gói trong plugin', 'lasan-static-apps' )
			);
		}
		update_option( self::SEEN_OPT, $seen, false );
		return $done;
	}

	/**
	 * Bundled apps with a valid manifest.
	 *
	 * @return array<string, array{name:string,version:string,notes:string,dir:string}>
	 */
	public static function bundled(): array {
		$out = array();
		foreach ( (array) glob( self::bundled_dir() . '/*/app.json' ) as $file ) {
			$dir  = dirname( (string) $file );
			$slug = self::sanitize_slug( basename( $dir ) );
			$m    = json_decode( (string) file_get_contents( (string) $file ), true );
			if ( ! is_array( $m ) || ! is_file( $dir . '/index.html' ) || ! self::valid_version( (string) ( $m['version'] ?? '' ) ) ) {
				continue;
			}
			$out[ $slug ] = array(
				'name'    => (string) ( $m['name'] ?? $slug ),
				'version' => (string) $m['version'],
				'notes'   => (string) ( $m['notes'] ?? '' ),
				'dir'     => $dir,
			);
		}
		ksort( $out );
		return $out;
	}

	/** Move a staged build into place, rewrite its paths, and record it. */
	private static function register_version( string $slug, string $stage, array $meta, string $source ) {
		$version = $meta['version'];
		$dir     = self::version_dir( $slug, $version );
		if ( ! is_file( $stage . '/index.html' ) ) {
			self::rmdir( $stage );
			return new WP_Error( 'no_index', __( 'Bản cài không có index.html.', 'lasan-static-apps' ) );
		}
		if ( file_exists( $dir ) || ! rename( $stage, $dir ) ) {
			self::rmdir( $stage );
			/* translators: %s: version */
			return new WP_Error( 'version_exists', sprintf( __( 'Phiên bản %s đã có.', 'lasan-static-apps' ), $version ) );
		}
		self::rebase( $dir, self::version_path( $slug, $version ) );
		self::harden();

		[ $files, $bytes ] = self::measure( $dir );

		$apps                        = self::all();
		$app                         = $apps[ $slug ] ?? array( 'title' => '', 'active' => '', 'versions' => array() );
		$app['title']                = '' !== $meta['title'] ? $meta['title'] : ( $app['title'] ?: $slug );
		$app['versions'][ $version ] = array(
			'added'  => time(),
			'files'  => $files,
			'bytes'  => $bytes,
			'source' => $source,
			'notes'  => $meta['notes'],
		);
		if ( $meta['activate'] || empty( $app['active'] ) ) {
			$app['active'] = $version;
		}
		$apps[ $slug ] = $app;
		self::save( $apps );
		self::changed();

		return $version;
	}

	/**
	 * Name, version and notes for a new version, from the form or the build's manifest.
	 *
	 * @return array{title:string,version:string,notes:string,activate:bool}|WP_Error
	 */
	private static function resolve_meta( string $slug, string $title, array $args, array $manifest ) {
		$version = strtolower( trim( (string) ( $args['version'] ?? '' ) ) );
		$version = '' !== $version ? ltrim( $version, 'v' ) : (string) ( $manifest['version'] ?? '' );
		if ( '' === $version ) {
			$version = self::next_version( self::latest( $slug ) );
		}
		if ( ! self::valid_version( $version ) ) {
			/* translators: %s: version */
			return new WP_Error( 'bad_version', sprintf( __( 'Số phiên bản "%s" không hợp lệ. Dùng dạng 1.2.0 (có thể thêm -beta.1).', 'lasan-static-apps' ), $version ) );
		}
		if ( isset( self::versions( $slug )[ $version ] ) || file_exists( self::version_dir( $slug, $version ) ) ) {
			return new WP_Error(
				'version_exists',
				/* translators: 1: version, 2: suggested version */
				sprintf( __( 'Phiên bản %1$s đã có; mỗi bản build phải có số mới (ví dụ %2$s).', 'lasan-static-apps' ), $version, self::next_version( self::latest( $slug ) ) )
			);
		}
		$notes = trim( (string) ( $args['notes'] ?? '' ) );
		if ( '' === trim( $title ) && ! self::get( $slug ) ) {
			$title = (string) ( $manifest['name'] ?? '' ); // a manifest names a new app, never renames one
		}
		return array(
			'title'    => sanitize_text_field( $title ),
			'version'  => $version,
			'notes'    => sanitize_textarea_field( '' !== $notes ? $notes : (string) ( $manifest['notes'] ?? '' ) ),
			'activate' => (bool) ( $args['activate'] ?? true ),
		);
	}

	/**
	 * Version, name and notes from app.json, else package.json, at a build's root.
	 *
	 * @param callable(string):string $read
	 * @return array{version?:string,name?:string,notes?:string}
	 */
	private static function manifest_from( callable $read ): array {
		$app = json_decode( $read( 'app.json' ), true );
		if ( is_array( $app ) ) {
			return array_filter(
				array(
					'version' => is_string( $app['version'] ?? null ) ? $app['version'] : '',
					'name'    => is_string( $app['name'] ?? null ) ? $app['name'] : '',
					'notes'   => is_string( $app['notes'] ?? null ) ? $app['notes'] : '',
				)
			);
		}
		$pkg = json_decode( $read( 'package.json' ), true );
		return is_array( $pkg ) && is_string( $pkg['version'] ?? null ) ? array( 'version' => $pkg['version'] ) : array();
	}

	/** A fresh folder to unpack into before the version is known to be good. */
	private static function stage_dir( string $slug ): string {
		$dir = self::base_dir() . '/' . $slug . '/_staging-' . wp_generate_password( 12, false );
		wp_mkdir_p( $dir );
		return $dir;
	}

	/* ---------------------------------------------------------------------
	 * Upgrade
	 * ------------------------------------------------------------------ */

	/** Bring the stored data up to this plugin's schema. Safe to call on every load. */
	public static function maybe_upgrade(): void {
		$from = (int) get_option( self::SCHEMA_OPT, 1 );
		if ( $from >= self::SCHEMA ) {
			return;
		}
		if ( $from < 2 ) {
			self::upgrade_to_2();
		}
		update_option( self::SCHEMA_OPT, self::SCHEMA, true );
	}

	/**
	 * 1.0 named versions by upload time (20261119-015604). Number them
	 * 1.0.0, 1.0.1… in upload order, move their folders, and fix the paths
	 * written into the builds.
	 */
	private static function upgrade_to_2(): void {
		$apps = self::all();
		foreach ( $apps as $slug => &$app ) {
			$old = (array) ( $app['versions'] ?? array() );
			uasort( $old, static fn( $a, $b ) => ( (int) ( $a['added'] ?? 0 ) ) <=> ( (int) ( $b['added'] ?? 0 ) ) );
			$new  = array();
			$next = '1.0.0';
			foreach ( $old as $id => $info ) {
				$id = (string) $id;
				if ( self::valid_version( $id ) ) {
					$new[ $id ] = $info;
					continue;
				}
				while ( isset( $old[ $next ] ) || isset( $new[ $next ] ) ) {
					$next = self::next_version( $next );
				}
				$from = self::version_dir( $slug, $id );
				$to   = self::version_dir( $slug, $next );
				if ( is_dir( $from ) && ! file_exists( $to ) && rename( $from, $to ) ) {
					self::rebase( $to, self::version_path( $slug, $next ) );
				}
				/* translators: %s: old version id (upload time) */
				$info['notes']     = (string) ( $info['notes'] ?? '' ) ?: sprintf( __( 'Cài trước khi có số phiên bản (mã cũ %s).', 'lasan-static-apps' ), $id );
				$info['legacy_id'] = $id;
				$new[ $next ]      = $info;
				if ( ( $app['active'] ?? '' ) === $id ) {
					$app['active'] = $next;
				}
				$next = self::next_version( $next );
			}
			$app['versions'] = $new;
		}
		unset( $app );
		self::save( $apps );
		self::changed();
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

	/**
	 * Change an app's slug: move its files, fix the paths written into every
	 * version, point the pages that embed it at the new slug, and keep the old
	 * slug as an alias.
	 *
	 * @return true|WP_Error
	 */
	public static function change_slug( string $old, string $new ) {
		$new  = self::sanitize_slug( $new );
		$apps = self::all();
		if ( ! isset( $apps[ $old ] ) ) {
			return new WP_Error( 'no_app', __( 'Không thấy app.', 'lasan-static-apps' ) );
		}
		if ( '' === $new || $new === $old ) {
			return new WP_Error( 'bad_slug', __( 'Mã mới không hợp lệ hoặc trùng mã cũ.', 'lasan-static-apps' ) );
		}
		if ( isset( $apps[ $new ] ) || file_exists( self::base_dir() . '/' . $new ) ) {
			/* translators: %s: slug */
			return new WP_Error( 'slug_taken', sprintf( __( 'Mã "%s" đã có app khác dùng.', 'lasan-static-apps' ), $new ) );
		}
		$aliases = (array) get_option( self::ALIAS_OPT, array() );
		if ( isset( $aliases[ $new ] ) && self::resolve( $new ) !== $old ) {
			/* translators: %s: slug */
			return new WP_Error( 'slug_taken', sprintf( __( 'Mã "%s" là mã cũ của một app khác.', 'lasan-static-apps' ), $new ) );
		}
		if ( is_dir( self::base_dir() . '/' . $old ) && ! rename( self::base_dir() . '/' . $old, self::base_dir() . '/' . $new ) ) {
			return new WP_Error( 'move', __( 'Không đổi được thư mục của app.', 'lasan-static-apps' ) );
		}
		foreach ( array_keys( (array) $apps[ $old ]['versions'] ) as $version ) {
			$dir = self::version_dir( $new, (string) $version );
			if ( is_file( $dir . '/index.html' ) ) {
				self::rebase( $dir, self::version_path( $new, (string) $version ) );
			}
		}

		$apps[ $new ] = $apps[ $old ];
		unset( $apps[ $old ] );
		self::save( $apps );

		unset( $aliases[ $new ] ); // renaming back to an old slug
		foreach ( $aliases as $from => $to ) {
			if ( $to === $old ) {
				$aliases[ $from ] = $new;
			}
		}
		$aliases[ $old ] = $new;
		update_option( self::ALIAS_OPT, $aliases, false );

		self::retarget_content( $old, $new );
		self::changed();
		return true;
	}

	/** Point App Embed blocks in posts and pages (not revisions) at the new slug. */
	private static function retarget_content( string $old, string $new ): void {
		global $wpdb;
		$from = '"app":"' . $old . '"';
		$to   = '"app":"' . $new . '"';
		$ids  = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM {$wpdb->posts} WHERE post_type NOT IN ('revision','attachment') AND post_content LIKE %s", '%' . $wpdb->esc_like( $from ) . '%' ) ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery
		foreach ( $ids as $id ) {
			$wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->posts} SET post_content = REPLACE(post_content, %s, %s) WHERE ID = %d", $from, $to, $id ) ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery
			clean_post_cache( (int) $id );
		}
	}

	/** Change a version's release notes (the build itself never changes). */
	public static function set_notes( string $slug, string $version, string $notes ): bool {
		$apps = self::all();
		if ( empty( $apps[ $slug ]['versions'][ $version ] ) ) {
			return false;
		}
		$apps[ $slug ]['versions'][ $version ]['notes'] = sanitize_textarea_field( $notes );
		self::save( $apps );
		return true;
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
		$aliases = array_filter( (array) get_option( self::ALIAS_OPT, array() ), static fn( $to ) => $to !== $slug );
		update_option( self::ALIAS_OPT, $aliases, false );
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

	/** @return array{0:int,1:int} files, bytes */
	private static function measure( string $dir ): array {
		$files = 0;
		$bytes = 0;
		foreach ( new \RecursiveIteratorIterator( new \RecursiveDirectoryIterator( $dir, \FilesystemIterator::SKIP_DOTS ) ) as $f ) {
			++$files;
			$bytes += (int) $f->getSize();
		}
		return array( $files, $bytes );
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
