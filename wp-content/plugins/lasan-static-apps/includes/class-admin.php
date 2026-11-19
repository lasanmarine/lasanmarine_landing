<?php
/**
 * The "App tĩnh" screen: upload, switch and remove versions, import the apps
 * that used to ship inside the theme.
 *
 * @package Lasan_Static_Apps
 */

namespace Lasan\StaticApps;

defined( 'ABSPATH' ) || exit;

final class Admin {

	const SLUG = 'lasan-static-apps';
	const CAP  = 'manage_options';

	public static function init(): void {
		add_action( 'admin_menu', array( __CLASS__, 'menu' ) );
		foreach ( array( 'upload', 'activate', 'delete_version', 'delete_app', 'rename', 'import_theme' ) as $action ) {
			add_action( 'admin_post_lsa_' . $action, array( __CLASS__, 'handle_' . $action ) );
		}
	}

	public static function menu(): void {
		add_menu_page(
			__( 'App tĩnh', 'lasan-static-apps' ),
			__( 'App tĩnh', 'lasan-static-apps' ),
			self::CAP,
			self::SLUG,
			array( __CLASS__, 'render' ),
			'dashicons-screenoptions',
			58
		);
	}

	/* ---------------------------------------------------------------------
	 * Screen
	 * ------------------------------------------------------------------ */

	public static function render(): void {
		if ( ! current_user_can( self::CAP ) ) {
			return;
		}
		$apps    = Store::all();
		$pending = self::theme_apps_not_imported();
		$max     = size_format( wp_max_upload_size() );
		?>
		<div class="wrap lsa">
			<h1><?php esc_html_e( 'App tĩnh', 'lasan-static-apps' ); ?></h1>
			<p class="description" style="max-width:760px">
				<?php esc_html_e( 'Các công cụ chạy trong trình duyệt (mô phỏng, máy tính…) được build sẵn thành index.html + assets. Tải file .zip bản build lên đây, rồi chọn app trong khối “App Embed” của trang. Mỗi lần tải là một phiên bản mới; có thể quay lại phiên bản cũ bất cứ lúc nào.', 'lasan-static-apps' ); ?>
			</p>
			<?php self::notice(); ?>

			<h2><?php esc_html_e( 'Tải lên', 'lasan-static-apps' ); ?></h2>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" enctype="multipart/form-data" class="lsa-card">
				<input type="hidden" name="action" value="lsa_upload">
				<?php wp_nonce_field( 'lsa_upload' ); ?>
				<table class="form-table" role="presentation">
					<tr>
						<th scope="row"><label for="lsa-zip"><?php esc_html_e( 'File .zip', 'lasan-static-apps' ); ?></label></th>
						<td>
							<input type="file" id="lsa-zip" name="lsa_zip" accept=".zip,application/zip" required>
							<p class="description">
								<?php
								/* translators: %s: maximum upload size */
								printf( esc_html__( 'Thư mục build (ví dụ dist/) nén lại; có index.html ở gốc. Tối đa %s.', 'lasan-static-apps' ), esc_html( $max ) );
								?>
								<?php esc_html_e( 'Nên build với đường dẫn tương đối (Vite: base: \'./\'); bản build theo đường dẫn tuyệt đối cũng được, plugin sẽ tự sửa đường dẫn.', 'lasan-static-apps' ); ?>
							</p>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="lsa-target"><?php esc_html_e( 'Cho app', 'lasan-static-apps' ); ?></label></th>
						<td>
							<select id="lsa-target" name="lsa_target">
								<option value=""><?php esc_html_e( '— App mới —', 'lasan-static-apps' ); ?></option>
								<?php foreach ( $apps as $slug => $app ) : ?>
									<option value="<?php echo esc_attr( $slug ); ?>"><?php echo esc_html( $app['title'] . ' (' . $slug . ')' ); ?></option>
								<?php endforeach; ?>
							</select>
						</td>
					</tr>
					<tr class="lsa-new">
						<th scope="row"><label for="lsa-title"><?php esc_html_e( 'Tên app', 'lasan-static-apps' ); ?></label></th>
						<td><input type="text" id="lsa-title" name="lsa_title" class="regular-text" placeholder="<?php esc_attr_e( 'Mô phỏng ổn định tàu', 'lasan-static-apps' ); ?>"></td>
					</tr>
					<tr class="lsa-new">
						<th scope="row"><label for="lsa-slug"><?php esc_html_e( 'Mã (slug)', 'lasan-static-apps' ); ?></label></th>
						<td>
							<input type="text" id="lsa-slug" name="lsa_slug" class="regular-text code" pattern="[a-z0-9-]+" placeholder="mo-phong-on-dinh-tau">
							<p class="description"><?php esc_html_e( 'Chữ thường không dấu, số và gạch ngang. Dùng trong đường dẫn file, không đổi được sau này.', 'lasan-static-apps' ); ?></p>
						</td>
					</tr>
				</table>
				<?php submit_button( __( 'Tải lên và cài', 'lasan-static-apps' ), 'primary', 'submit', false ); ?>
			</form>

			<h2><?php esc_html_e( 'Các app', 'lasan-static-apps' ); ?></h2>
			<?php if ( ! $apps ) : ?>
				<p><?php esc_html_e( 'Chưa có app nào.', 'lasan-static-apps' ); ?></p>
			<?php endif; ?>
			<?php foreach ( $apps as $slug => $app ) : ?>
				<?php self::render_app( $slug, $app ); ?>
			<?php endforeach; ?>

			<?php if ( $pending ) : ?>
				<h2><?php esc_html_e( 'App có sẵn trong theme', 'lasan-static-apps' ); ?></h2>
				<p class="description"><?php esc_html_e( 'Các app này vẫn chạy từ thư mục theme. Nhập vào đây để quản lý, cập nhật phiên bản ngay trong trang quản trị (trang đang dùng app không phải sửa gì).', 'lasan-static-apps' ); ?></p>
				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
					<input type="hidden" name="action" value="lsa_import_theme">
					<?php wp_nonce_field( 'lsa_import_theme' ); ?>
					<ul class="ul-disc">
						<?php foreach ( $pending as $slug => $label ) : ?>
							<li><code><?php echo esc_html( $slug ); ?></code> — <?php echo esc_html( $label ); ?></li>
						<?php endforeach; ?>
					</ul>
					<?php submit_button( __( 'Nhập các app này', 'lasan-static-apps' ), 'secondary', 'submit', false ); ?>
				</form>
			<?php endif; ?>
		</div>
		<style>
			.lsa-card{background:#fff;border:1px solid #c3c4c7;border-radius:6px;padding:4px 20px 16px;max-width:900px}
			.lsa-app{background:#fff;border:1px solid #c3c4c7;border-radius:6px;padding:12px 20px 16px;margin:0 0 16px;max-width:900px}
			.lsa-app h3{margin:.4em 0;display:flex;gap:10px;align-items:baseline;flex-wrap:wrap}
			.lsa-app table{margin-top:8px}
			.lsa-app .lsa-current{font-weight:600}
			.lsa-inline{display:inline}
			.lsa-used{margin:.3em 0 .6em}
		</style>
		<script>
			( function () {
				var sel = document.getElementById( 'lsa-target' );
				var rows = document.querySelectorAll( '.lsa-new' );
				var sync = function () { rows.forEach( function ( r ) { r.style.display = sel.value ? 'none' : ''; } ); };
				sel.addEventListener( 'change', sync ); sync();
				var t = document.getElementById( 'lsa-title' ), s = document.getElementById( 'lsa-slug' ), touched = false;
				s.addEventListener( 'input', function () { touched = true; } );
				t.addEventListener( 'input', function () {
					if ( touched ) { return; }
					s.value = t.value.normalize( 'NFD' ).replace( /[̀-ͯ]/g, '' ).replace( /đ/g, 'd' ).replace( /Đ/g, 'd' ).toLowerCase().replace( /[^a-z0-9]+/g, '-' ).replace( /^-|-$/g, '' );
				} );
				document.querySelectorAll( '[data-lsa-confirm]' ).forEach( function ( f ) {
					f.addEventListener( 'submit', function ( e ) { if ( ! window.confirm( f.getAttribute( 'data-lsa-confirm' ) ) ) { e.preventDefault(); } } );
				} );
			} )();
		</script>
		<?php
	}

	private static function render_app( string $slug, array $app ): void {
		$url  = Store::url( $slug );
		$used = self::pages_using( $slug );
		krsort( $app['versions'] );
		?>
		<div class="lsa-app">
			<h3>
				<?php echo esc_html( $app['title'] ); ?>
				<code><?php echo esc_html( $slug ); ?></code>
				<?php if ( $url ) : ?>
					<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Mở bản đang dùng ↗', 'lasan-static-apps' ); ?></a>
				<?php endif; ?>
			</h3>
			<p class="lsa-used">
				<?php if ( $used ) : ?>
					<?php esc_html_e( 'Đang dùng ở:', 'lasan-static-apps' ); ?>
					<?php foreach ( $used as $i => $post ) : ?>
						<?php echo $i ? ', ' : ''; ?><a href="<?php echo esc_url( get_permalink( $post ) ); ?>" target="_blank" rel="noopener"><?php echo esc_html( get_the_title( $post ) ); ?></a>
					<?php endforeach; ?>
				<?php else : ?>
					<em><?php esc_html_e( 'Chưa trang nào dùng app này (thêm khối “App Embed” vào trang để hiển thị).', 'lasan-static-apps' ); ?></em>
				<?php endif; ?>
			</p>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="lsa-inline">
				<input type="hidden" name="action" value="lsa_rename">
				<input type="hidden" name="slug" value="<?php echo esc_attr( $slug ); ?>">
				<?php wp_nonce_field( 'lsa_rename_' . $slug ); ?>
				<label><?php esc_html_e( 'Tên', 'lasan-static-apps' ); ?> <input type="text" name="title" value="<?php echo esc_attr( $app['title'] ); ?>" class="regular-text"></label>
				<?php submit_button( __( 'Đổi tên', 'lasan-static-apps' ), 'small', 'submit', false ); ?>
			</form>
			<table class="widefat striped">
				<thead><tr>
					<th><?php esc_html_e( 'Phiên bản', 'lasan-static-apps' ); ?></th>
					<th><?php esc_html_e( 'Tải lên', 'lasan-static-apps' ); ?></th>
					<th><?php esc_html_e( 'Dung lượng', 'lasan-static-apps' ); ?></th>
					<th><?php esc_html_e( 'Nguồn', 'lasan-static-apps' ); ?></th>
					<th></th>
				</tr></thead>
				<tbody>
				<?php foreach ( $app['versions'] as $version => $info ) : ?>
					<?php $current = ( $app['active'] ?? '' ) === (string) $version; ?>
					<tr>
						<td class="<?php echo $current ? 'lsa-current' : ''; ?>"><code><?php echo esc_html( (string) $version ); ?></code><?php echo $current ? ' — ' . esc_html__( 'đang dùng', 'lasan-static-apps' ) : ''; ?></td>
						<td><?php echo esc_html( wp_date( 'd/m/Y H:i', (int) $info['added'] ) ); ?></td>
						<td><?php echo esc_html( size_format( (int) $info['bytes'] ) . ' · ' . (int) $info['files'] . ' file' ); ?></td>
						<td><?php echo esc_html( (string) $info['source'] ); ?></td>
						<td>
							<?php if ( ! $current ) : ?>
								<?php self::action_button( 'activate', $slug, (string) $version, __( 'Dùng bản này', 'lasan-static-apps' ) ); ?>
								<?php self::action_button( 'delete_version', $slug, (string) $version, __( 'Xoá', 'lasan-static-apps' ), __( 'Xoá phiên bản này?', 'lasan-static-apps' ) ); ?>
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			<p>
				<?php
				$confirm = $used
					/* translators: %d: number of pages */
					? sprintf( __( 'App này đang được %d trang dùng; các trang đó sẽ không còn hiển thị công cụ. Xoá app và mọi phiên bản?', 'lasan-static-apps' ), count( $used ) )
					: __( 'Xoá app và mọi phiên bản?', 'lasan-static-apps' );
				self::action_button( 'delete_app', $slug, '', __( 'Xoá app', 'lasan-static-apps' ), $confirm, 'link-delete' );
				?>
			</p>
		</div>
		<?php
	}

	private static function action_button( string $action, string $slug, string $version, string $label, string $confirm = '', string $class = 'small' ): void {
		?>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="lsa-inline"<?php echo $confirm ? ' data-lsa-confirm="' . esc_attr( $confirm ) . '"' : ''; ?>>
			<input type="hidden" name="action" value="lsa_<?php echo esc_attr( $action ); ?>">
			<input type="hidden" name="slug" value="<?php echo esc_attr( $slug ); ?>">
			<input type="hidden" name="version" value="<?php echo esc_attr( $version ); ?>">
			<?php wp_nonce_field( 'lsa_' . $action . '_' . $slug . '_' . $version ); ?>
			<button type="submit" class="button button-<?php echo esc_attr( $class ); ?>"><?php echo esc_html( $label ); ?></button>
		</form>
		<?php
	}

	/* ---------------------------------------------------------------------
	 * Actions
	 * ------------------------------------------------------------------ */

	public static function handle_upload(): void {
		self::guard( 'lsa_upload' );
		$file = $_FILES['lsa_zip'] ?? null; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
		if ( ! $file || UPLOAD_ERR_OK !== (int) $file['error'] || ! is_uploaded_file( (string) $file['tmp_name'] ) ) {
			self::back( 'error', __( 'Chưa nhận được file (hoặc file vượt giới hạn tải lên của máy chủ).', 'lasan-static-apps' ) );
		}
		if ( 'zip' !== strtolower( pathinfo( (string) $file['name'], PATHINFO_EXTENSION ) ) ) {
			self::back( 'error', __( 'Chỉ nhận file .zip.', 'lasan-static-apps' ) );
		}
		$target = Store::sanitize_slug( sanitize_text_field( wp_unslash( $_POST['lsa_target'] ?? '' ) ) );
		$title  = sanitize_text_field( wp_unslash( $_POST['lsa_title'] ?? '' ) );
		$slug   = '' !== $target ? $target : Store::sanitize_slug( sanitize_text_field( wp_unslash( $_POST['lsa_slug'] ?? '' ) ) ?: $title );
		if ( '' === $target && Store::get( $slug ) ) {
			/* translators: %s: app slug */
			self::back( 'error', sprintf( __( 'Mã "%s" đã có app khác dùng. Chọn app đó trong ô “Cho app” để tải phiên bản mới, hoặc đặt mã khác.', 'lasan-static-apps' ), $slug ) );
		}
		$result = Store::install_zip( (string) $file['tmp_name'], $slug, $title );
		if ( is_wp_error( $result ) ) {
			self::back( 'error', $result->get_error_message() );
		}
		/* translators: 1: app slug, 2: version */
		self::back( 'success', sprintf( __( 'Đã cài %1$s, phiên bản %2$s, và đặt làm bản đang dùng.', 'lasan-static-apps' ), $slug, $result ) );
	}

	public static function handle_activate(): void {
		[ $slug, $version ] = self::target( 'activate' );
		Store::activate( $slug, $version )
			/* translators: 1: app slug, 2: version */
			? self::back( 'success', sprintf( __( '%1$s đang dùng phiên bản %2$s.', 'lasan-static-apps' ), $slug, $version ) )
			: self::back( 'error', __( 'Không đổi được phiên bản.', 'lasan-static-apps' ) );
	}

	public static function handle_delete_version(): void {
		[ $slug, $version ] = self::target( 'delete_version' );
		Store::delete_version( $slug, $version )
			? self::back( 'success', __( 'Đã xoá phiên bản.', 'lasan-static-apps' ) )
			: self::back( 'error', __( 'Không xoá được (không xoá được bản đang dùng).', 'lasan-static-apps' ) );
	}

	public static function handle_delete_app(): void {
		[ $slug ] = self::target( 'delete_app' );
		Store::delete_app( $slug )
			? self::back( 'success', __( 'Đã xoá app.', 'lasan-static-apps' ) )
			: self::back( 'error', __( 'Không xoá được app.', 'lasan-static-apps' ) );
	}

	public static function handle_rename(): void {
		$slug = Store::sanitize_slug( sanitize_text_field( wp_unslash( $_POST['slug'] ?? '' ) ) );
		self::guard( 'lsa_rename_' . $slug );
		Store::rename( $slug, sanitize_text_field( wp_unslash( $_POST['title'] ?? '' ) ) );
		self::back( 'success', __( 'Đã đổi tên.', 'lasan-static-apps' ) );
	}

	public static function handle_import_theme(): void {
		self::guard( 'lsa_import_theme' );
		$done = array();
		foreach ( self::theme_apps_not_imported() as $slug => $label ) {
			$r = Store::install_dir( self::theme_apps_dir() . '/' . $slug, $slug, $label );
			if ( ! is_wp_error( $r ) ) {
				$done[] = $slug;
			}
		}
		/* translators: %s: list of app slugs */
		self::back( 'success', sprintf( __( 'Đã nhập: %s', 'lasan-static-apps' ), $done ? implode( ', ', $done ) : '—' ) );
	}

	/* ---------------------------------------------------------------------
	 * Helpers
	 * ------------------------------------------------------------------ */

	private static function guard( string $nonce_action ): void {
		if ( ! current_user_can( self::CAP ) ) {
			wp_die( esc_html__( 'Bạn không có quyền làm việc này.', 'lasan-static-apps' ), 403 );
		}
		check_admin_referer( $nonce_action );
	}

	/** @return array{0:string,1:string} */
	private static function target( string $action ): array {
		$slug    = Store::sanitize_slug( sanitize_text_field( wp_unslash( $_POST['slug'] ?? '' ) ) );
		$version = (string) preg_replace( '/[^0-9-]/', '', (string) wp_unslash( $_POST['version'] ?? '' ) );
		self::guard( 'lsa_' . $action . '_' . $slug . '_' . $version );
		return array( $slug, $version );
	}

	/** @return never */
	private static function back( string $type, string $message ): void {
		set_transient( 'lsa_notice_' . get_current_user_id(), array( $type, $message ), 60 );
		wp_safe_redirect( admin_url( 'admin.php?page=' . self::SLUG ) );
		exit;
	}

	private static function notice(): void {
		$key    = 'lsa_notice_' . get_current_user_id();
		$notice = get_transient( $key );
		if ( ! $notice ) {
			return;
		}
		delete_transient( $key );
		printf( '<div class="notice notice-%s is-dismissible"><p>%s</p></div>', esc_attr( 'success' === $notice[0] ? 'success' : 'error' ), esc_html( (string) $notice[1] ) );
	}

	/** Pages whose content embeds this app (an App Embed block with it selected). */
	private static function pages_using( string $slug ): array {
		global $wpdb;
		$like = '%' . $wpdb->esc_like( '"app":"' . $slug . '"' ) . '%';
		$ids  = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM {$wpdb->posts} WHERE post_status = 'publish' AND post_type IN ('page','post') AND post_content LIKE %s ORDER BY post_title", $like ) ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery
		return array_map( 'intval', $ids );
	}

	public static function theme_apps_dir(): string {
		return get_template_directory() . '/apps';
	}

	/** Apps in the theme's apps/ folder that are not in the registry yet. @return array<string,string> */
	public static function theme_apps_not_imported(): array {
		$out = array();
		foreach ( (array) glob( self::theme_apps_dir() . '/*/index.html' ) as $index ) {
			$slug = basename( dirname( (string) $index ) );
			if ( ! Store::get( $slug ) ) {
				$out[ $slug ] = Plugin::theme_app_label( $slug );
			}
		}
		return $out;
	}
}
