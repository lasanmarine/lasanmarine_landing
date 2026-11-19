<?php
/**
 * The "App tĩnh" screen: upload numbered versions with release notes, switch
 * and remove versions, and see the apps bundled with the plugin.
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
		add_action( 'admin_init', array( __CLASS__, 'auto_sync' ) );
		foreach ( array( 'upload', 'activate', 'delete_version', 'delete_app', 'rename', 'notes', 'sync' ) as $action ) {
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

	/**
	 * A deploy that brings a new bundled version installs it the next time an
	 * admin opens the dashboard (or the server runs tools/static-apps.php).
	 */
	public static function auto_sync(): void {
		if ( wp_doing_ajax() || ! current_user_can( self::CAP ) ) {
			return;
		}
		$done = Store::sync_bundled();
		if ( $done && ! get_transient( 'lsa_notice_' . get_current_user_id() ) ) {
			set_transient( 'lsa_notice_' . get_current_user_id(), self::sync_message( $done ), 60 );
		}
	}

	/* ---------------------------------------------------------------------
	 * Screen
	 * ------------------------------------------------------------------ */

	public static function render(): void {
		if ( ! current_user_can( self::CAP ) ) {
			return;
		}
		$apps    = Store::all();
		$bundled = Store::bundled();
		$max     = size_format( wp_max_upload_size() );
		?>
		<div class="wrap lsa">
			<h1><?php esc_html_e( 'App tĩnh', 'lasan-static-apps' ); ?></h1>
			<p class="description" style="max-width:760px">
				<?php esc_html_e( 'Các công cụ chạy trong trình duyệt (mô phỏng, máy tính…) được build sẵn thành index.html + assets. Tải file .zip bản build lên đây, rồi chọn app trong khối “App Embed” của trang. Mỗi bản build là một phiên bản có số riêng (1.0.0, 1.1.0…) kèm ghi chú thay đổi; có thể quay lại phiên bản cũ bất cứ lúc nào.', 'lasan-static-apps' ); ?>
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
									<option value="<?php echo esc_attr( $slug ); ?>" data-next="<?php echo esc_attr( Store::next_version( Store::latest( $slug ) ) ); ?>"><?php echo esc_html( $app['title'] . ' (' . $slug . ') — ' . Store::latest( $slug ) ); ?></option>
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
							<p class="description"><?php esc_html_e( 'Chữ thường không dấu, số và gạch ngang. Dùng trong đường dẫn file; đổi được sau này.', 'lasan-static-apps' ); ?></p>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="lsa-version"><?php esc_html_e( 'Phiên bản', 'lasan-static-apps' ); ?></label></th>
						<td>
							<input type="text" id="lsa-version" name="lsa_version" class="small-text code" style="width:9em" pattern="[0-9]+\.[0-9]+\.[0-9]+(-[0-9a-z.]+)?" placeholder="1.0.0">
							<p class="description" id="lsa-version-hint"><?php esc_html_e( 'Dạng MAJOR.MINOR.PATCH: tăng PATCH khi sửa lỗi, MINOR khi thêm tính năng, MAJOR khi thay đổi lớn. Để trống: lấy từ app.json / package.json trong zip, nếu không có thì tự tăng PATCH.', 'lasan-static-apps' ); ?></p>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="lsa-notes"><?php esc_html_e( 'Ghi chú thay đổi', 'lasan-static-apps' ); ?></label></th>
						<td><textarea id="lsa-notes" name="lsa_notes" rows="3" class="large-text" placeholder="<?php esc_attr_e( 'Sửa lỗi tính GZ ở góc nghiêng lớn; thêm xuất PDF…', 'lasan-static-apps' ); ?>"></textarea></td>
					</tr>
					<tr>
						<th scope="row"><?php esc_html_e( 'Sau khi cài', 'lasan-static-apps' ); ?></th>
						<td><label><input type="checkbox" name="lsa_activate" value="1" checked> <?php esc_html_e( 'Dùng ngay bản này trên site', 'lasan-static-apps' ); ?></label>
							<p class="description"><?php esc_html_e( 'Bỏ chọn để cài sẵn, xem thử qua link “Mở”, rồi bấm “Dùng bản này” khi đã ổn.', 'lasan-static-apps' ); ?></p></td>
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

			<?php if ( $bundled ) : ?>
				<h2><?php esc_html_e( 'Gói trong plugin', 'lasan-static-apps' ); ?></h2>
				<p class="description" style="max-width:760px"><?php esc_html_e( 'Các bản build nằm trong thư mục apps/<slug>/ của plugin (kèm app.json ghi số phiên bản), đi theo code khi deploy. Phiên bản mới ở đây được cài tự động khi quản trị viên mở trang quản trị; nếu mới hơn bản đang dùng thì được dùng luôn.', 'lasan-static-apps' ); ?></p>
				<table class="widefat striped lsa-bundled">
					<thead><tr>
						<th><?php esc_html_e( 'App', 'lasan-static-apps' ); ?></th>
						<th><?php esc_html_e( 'Phiên bản trong plugin', 'lasan-static-apps' ); ?></th>
						<th><?php esc_html_e( 'Trên site', 'lasan-static-apps' ); ?></th>
					</tr></thead>
					<tbody>
					<?php foreach ( $bundled as $slug => $b ) : ?>
						<?php $installed = isset( Store::versions( $slug )[ $b['version'] ] ); ?>
						<tr>
							<td><?php echo esc_html( $b['name'] ); ?> <code><?php echo esc_html( $slug ); ?></code></td>
							<td><code><?php echo esc_html( $b['version'] ); ?></code></td>
							<td>
								<?php
								if ( $installed ) {
									echo esc_html( Store::active( $slug ) === $b['version'] ? __( 'đã cài, đang dùng', 'lasan-static-apps' ) : __( 'đã cài', 'lasan-static-apps' ) );
								} else {
									echo esc_html( Store::get( $slug ) ? __( 'chưa cài (đã bỏ qua hoặc đã xoá)', 'lasan-static-apps' ) : __( 'chưa cài', 'lasan-static-apps' ) );
								}
								?>
							</td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" style="margin-top:8px">
					<input type="hidden" name="action" value="lsa_sync">
					<?php wp_nonce_field( 'lsa_sync' ); ?>
					<?php submit_button( __( 'Cài lại các bản chưa có', 'lasan-static-apps' ), 'secondary', 'submit', false ); ?>
				</form>
			<?php endif; ?>
		</div>
		<style>
			.lsa-card{background:#fff;border:1px solid #c3c4c7;border-radius:6px;padding:4px 20px 16px;max-width:900px}
			.lsa-app{background:#fff;border:1px solid #c3c4c7;border-radius:6px;padding:12px 20px 16px;margin:0 0 16px;max-width:1100px;overflow-x:auto}
			.lsa-app td{vertical-align:top}
			.lsa-app h3{margin:.4em 0;display:flex;gap:10px;align-items:baseline;flex-wrap:wrap}
			.lsa-app table{margin-top:8px}
			.lsa-app .lsa-current{font-weight:600}
			.lsa-inline{display:inline}
			.lsa-rename{display:flex;flex-wrap:wrap;gap:8px 16px;align-items:flex-end;margin:6px 0 4px}
			.lsa-rename label{display:flex;flex-direction:column;gap:3px;font-weight:600;font-size:12px}
			.lsa-rename input.code{width:16em}
			.lsa-rename .button{min-height:32px;padding:0 14px}
			.lsa-used{margin:.3em 0 .6em}
			.lsa-badge{display:inline-block;font-size:11px;line-height:1.6;padding:0 6px;border-radius:9px;background:#dcdcde;margin-left:4px;font-weight:600}
			.lsa-badge.is-active{background:#00a32a;color:#fff}
			.lsa-notes{min-width:220px;max-width:340px}
			.lsa-notes-text{white-space:pre-line;margin:0 0 2px}
			.lsa-notes details summary{cursor:pointer;color:#2271b1;font-size:12px;width:max-content}
			.lsa-notes details form{margin:6px 0 0}
			.lsa-notes textarea{display:block;width:100%;min-height:0;margin:0 0 6px;font-size:13px}
			.lsa-bundled{max-width:900px}
		</style>
		<script>
			( function () {
				var sel = document.getElementById( 'lsa-target' );
				var rows = document.querySelectorAll( '.lsa-new' );
				var ver = document.getElementById( 'lsa-version' );
				var sync = function () {
					rows.forEach( function ( r ) { r.style.display = sel.value ? 'none' : ''; } );
					var opt = sel.options[ sel.selectedIndex ];
					ver.placeholder = ( opt && opt.getAttribute( 'data-next' ) ) || '1.0.0';
				};
				sel.addEventListener( 'change', sync ); sync();
				var t = document.getElementById( 'lsa-title' ), s = document.getElementById( 'lsa-slug' ), touched = false;
				s.addEventListener( 'input', function () { touched = true; } );
				t.addEventListener( 'input', function () {
					if ( touched ) { return; }
					s.value = t.value.normalize( 'NFD' ).replace( /[̀-ͯ]/g, '' ).replace( /đ/g, 'd' ).replace( /Đ/g, 'd' ).toLowerCase().replace( /[^a-z0-9]+/g, '-' ).replace( /^-|-$/g, '' );
				} );
				document.querySelectorAll( '.lsa-rename' ).forEach( function ( f ) {
					f.addEventListener( 'submit', function ( e ) {
						var old = f.getAttribute( 'data-lsa-slug' ), now = f.elements.new_slug.value.trim();
						if ( now !== old && ! window.confirm( <?php echo wp_json_encode( __( 'Đổi mã app từ "%1$s" sang "%2$s"? Đường dẫn file của app sẽ đổi; các trang đang dùng được cập nhật tự động, mã cũ vẫn chạy.', 'lasan-static-apps' ) ); ?>.replace( '%1$s', old ).replace( '%2$s', now ) ) ) { e.preventDefault(); }
					} );
				} );
				document.querySelectorAll( '[data-lsa-confirm]' ).forEach( function ( f ) {
					f.addEventListener( 'submit', function ( e ) { if ( ! window.confirm( f.getAttribute( 'data-lsa-confirm' ) ) ) { e.preventDefault(); } } );
				} );
			} )();
		</script>
		<?php
	}

	private static function render_app( string $slug, array $app ): void {
		$url    = Store::url( $slug );
		$used   = self::pages_using( $slug );
		$latest = Store::latest( $slug );
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
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="lsa-rename" data-lsa-slug="<?php echo esc_attr( $slug ); ?>">
				<input type="hidden" name="action" value="lsa_rename">
				<input type="hidden" name="slug" value="<?php echo esc_attr( $slug ); ?>">
				<?php wp_nonce_field( 'lsa_rename_' . $slug ); ?>
				<label><span><?php esc_html_e( 'Tên', 'lasan-static-apps' ); ?></span>
					<input type="text" name="title" value="<?php echo esc_attr( $app['title'] ); ?>" class="regular-text"></label>
				<label><span><?php esc_html_e( 'Mã (slug)', 'lasan-static-apps' ); ?></span>
					<input type="text" name="new_slug" value="<?php echo esc_attr( $slug ); ?>" class="code" pattern="[a-z0-9-]+" required></label>
				<button type="submit" class="button"><?php esc_html_e( 'Lưu tên & mã', 'lasan-static-apps' ); ?></button>
			</form>
			<table class="widefat striped">
				<thead><tr>
					<th><?php esc_html_e( 'Phiên bản', 'lasan-static-apps' ); ?></th>
					<th><?php esc_html_e( 'Ghi chú thay đổi', 'lasan-static-apps' ); ?></th>
					<th><?php esc_html_e( 'Cài lúc', 'lasan-static-apps' ); ?></th>
					<th><?php esc_html_e( 'Dung lượng', 'lasan-static-apps' ); ?></th>
					<th><?php esc_html_e( 'Nguồn', 'lasan-static-apps' ); ?></th>
					<th></th>
				</tr></thead>
				<tbody>
				<?php foreach ( Store::versions( $slug ) as $version => $info ) : ?>
					<?php
					$version = (string) $version;
					$current = ( $app['active'] ?? '' ) === $version;
					?>
					<tr>
						<td class="<?php echo $current ? 'lsa-current' : ''; ?>">
							<a href="<?php echo esc_url( Store::url( $slug, $version ) ); ?>" target="_blank" rel="noopener"><code><?php echo esc_html( $version ); ?></code></a>
							<?php if ( $current ) : ?><span class="lsa-badge is-active"><?php esc_html_e( 'đang dùng', 'lasan-static-apps' ); ?></span><?php endif; ?>
							<?php if ( $latest === $version && ! $current ) : ?><span class="lsa-badge"><?php esc_html_e( 'mới nhất', 'lasan-static-apps' ); ?></span><?php endif; ?>
						</td>
						<td class="lsa-notes">
							<div class="lsa-notes-text"><?php echo '' !== (string) ( $info['notes'] ?? '' ) ? esc_html( (string) $info['notes'] ) : '<em>—</em>'; ?></div>
							<details>
								<summary><?php esc_html_e( 'Sửa', 'lasan-static-apps' ); ?></summary>
								<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
									<input type="hidden" name="action" value="lsa_notes">
									<input type="hidden" name="slug" value="<?php echo esc_attr( $slug ); ?>">
									<input type="hidden" name="version" value="<?php echo esc_attr( $version ); ?>">
									<?php wp_nonce_field( 'lsa_notes_' . $slug . '_' . $version ); ?>
									<textarea name="notes" rows="3"><?php echo esc_textarea( (string) ( $info['notes'] ?? '' ) ); ?></textarea>
									<button type="submit" class="button button-small"><?php esc_html_e( 'Lưu ghi chú', 'lasan-static-apps' ); ?></button>
								</form>
							</details>
						</td>
						<td><?php echo esc_html( wp_date( 'd/m/Y H:i', (int) $info['added'] ) ); ?></td>
						<td><?php echo esc_html( size_format( (int) $info['bytes'] ) . ' · ' . (int) $info['files'] . ' file' ); ?></td>
						<td><?php echo esc_html( (string) $info['source'] ); ?></td>
						<td>
							<?php if ( ! $current ) : ?>
								<?php self::action_button( 'activate', $slug, $version, __( 'Dùng bản này', 'lasan-static-apps' ) ); ?>
								<?php self::action_button( 'delete_version', $slug, $version, __( 'Xoá', 'lasan-static-apps' ), __( 'Xoá phiên bản này?', 'lasan-static-apps' ) ); ?>
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
		$activate = ! empty( $_POST['lsa_activate'] );
		$result   = Store::install_zip(
			(string) $file['tmp_name'],
			$slug,
			$title,
			array(
				'version'  => sanitize_text_field( wp_unslash( $_POST['lsa_version'] ?? '' ) ),
				'notes'    => sanitize_textarea_field( wp_unslash( $_POST['lsa_notes'] ?? '' ) ),
				'activate' => $activate,
			)
		);
		if ( is_wp_error( $result ) ) {
			self::back( 'error', $result->get_error_message() );
		}
		$activate || Store::active( $slug ) === $result
			/* translators: 1: app slug, 2: version */
			? self::back( 'success', sprintf( __( 'Đã cài %1$s phiên bản %2$s và đang dùng bản này.', 'lasan-static-apps' ), $slug, $result ) )
			/* translators: 1: app slug, 2: version */
			: self::back( 'success', sprintf( __( 'Đã cài %1$s phiên bản %2$s (chưa dùng). Mở link phiên bản để xem thử, rồi bấm “Dùng bản này”.', 'lasan-static-apps' ), $slug, $result ) );
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
		$new = Store::sanitize_slug( sanitize_text_field( wp_unslash( $_POST['new_slug'] ?? '' ) ) );
		if ( '' === $new || $new === $slug ) {
			self::back( 'success', __( 'Đã lưu tên.', 'lasan-static-apps' ) );
		}
		$r = Store::change_slug( $slug, $new );
		is_wp_error( $r )
			? self::back( 'error', $r->get_error_message() )
			/* translators: 1: old slug, 2: new slug */
			: self::back( 'success', sprintf( __( 'Đã đổi mã %1$s → %2$s. Các trang đang dùng đã được cập nhật; mã cũ vẫn chạy.', 'lasan-static-apps' ), $slug, $new ) );
	}

	public static function handle_notes(): void {
		[ $slug, $version ] = self::target( 'notes' );
		Store::set_notes( $slug, $version, sanitize_textarea_field( wp_unslash( $_POST['notes'] ?? '' ) ) )
			? self::back( 'success', __( 'Đã lưu ghi chú.', 'lasan-static-apps' ) )
			: self::back( 'error', __( 'Không lưu được ghi chú.', 'lasan-static-apps' ) );
	}

	/** Install bundled versions again, including ones skipped or deleted before. */
	public static function handle_sync(): void {
		self::guard( 'lsa_sync' );
		delete_option( Store::SEEN_OPT );
		$done = Store::sync_bundled();
		$done ? self::back( ...self::sync_message( $done ) ) : self::back( 'success', __( 'Mọi bản trong plugin đã có trên site.', 'lasan-static-apps' ) );
	}

	/** @param array<string, string|\WP_Error> $done */
	private static function sync_message( array $done ): array {
		$ok  = array();
		$bad = array();
		foreach ( $done as $slug => $r ) {
			is_wp_error( $r ) ? $bad[] = $slug . ': ' . $r->get_error_message() : $ok[] = $slug . ' ' . $r;
		}
		/* translators: %s: list of "slug version" */
		$msg = $ok ? sprintf( __( 'Đã cài bản mới từ plugin: %s.', 'lasan-static-apps' ), implode( ', ', $ok ) ) : '';
		/* translators: %s: list of errors */
		$msg .= $bad ? ' ' . sprintf( __( 'Lỗi: %s', 'lasan-static-apps' ), implode( '; ', $bad ) ) : '';
		return array( $bad ? 'error' : 'success', trim( $msg ) );
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
		$version = (string) preg_replace( '/[^0-9a-z.-]/', '', strtolower( (string) wp_unslash( $_POST['version'] ?? '' ) ) );
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
}
