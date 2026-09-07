<?php
/**
 * 404 — the page that is not there.
 *
 * Opens on the same navy header as every other listing, then offers the way
 * back: a search, and the handful of places a reader was most likely after.
 *
 * @package Starter_Flexible
 * @since 1.0.0
 */

ob_start();
?>
<form class="blog__search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
	<label class="screen-reader-text" for="err-search"><?php esc_html_e( 'Tìm trên website', 'starter-flexible' ); ?></label>
	<input
		class="blog__search-input"
		id="err-search"
		type="search"
		name="s"
		placeholder="<?php esc_attr_e( 'Tìm trên website…', 'starter-flexible' ); ?>"
	/>
	<button class="blog__search-btn" type="submit" aria-label="<?php esc_attr_e( 'Tìm', 'starter-flexible' ); ?>">
		<?php echo starter_flexible_icon( 'search', 18 ); // phpcs:ignore ?>
	</button>
</form>
<?php
$search_form = (string) ob_get_clean();

get_template_part(
	'template-parts/components/page-head',
	null,
	array(
		'crumbs'  => array(
			array( 'label' => __( 'Trang chủ', 'starter-flexible' ), 'url' => home_url( '/' ) ),
			array( 'label' => __( 'Không tìm thấy', 'starter-flexible' ), 'url' => '' ),
		),
		'eyebrow' => __( 'Lỗi 404', 'starter-flexible' ),
		'title'   => __( 'Không tìm thấy trang này', 'starter-flexible' ),
		'lead'    => __( 'Đường dẫn có thể đã thay đổi, hoặc trang đã được gỡ. Bạn thử tìm lại hoặc đi tới một trong những mục dưới đây.', 'starter-flexible' ),
		'aside'   => $search_form,
	)
);

// The pages a reader is most likely looking for, by the content key that
// survives a slug change.
$shortcuts = array(
	array( 'key' => 'capabilities', 'slug' => 'nang-luc', 'label' => __( 'Năng lực', 'starter-flexible' ), 'note' => __( 'Thiết kế tàu, R&D và phần mềm', 'starter-flexible' ) ),
	array( 'key' => 'service_01', 'slug' => 'thiet-ke-tau', 'label' => __( 'Thiết kế tàu', 'starter-flexible' ), 'note' => __( 'Đóng mới, cải hoán và hồ sơ kỹ thuật', 'starter-flexible' ) ),
	array( 'key' => 'projects', 'slug' => 'du-an', 'label' => __( 'Dự án', 'starter-flexible' ), 'note' => __( 'Danh mục tàu đã thực hiện', 'starter-flexible' ) ),
	array( 'key' => 'tools', 'slug' => 'cong-cu', 'label' => __( 'Công cụ', 'starter-flexible' ), 'note' => __( 'Tra cứu và tính toán nhanh', 'starter-flexible' ) ),
	array( 'key' => 'insights', 'slug' => 'tin-tuc', 'label' => __( 'Tin tức', 'starter-flexible' ), 'note' => __( 'Ghi chú kỹ thuật và cập nhật', 'starter-flexible' ) ),
	array( 'key' => 'contact', 'slug' => 'lien-he', 'label' => __( 'Liên hệ', 'starter-flexible' ), 'note' => __( 'Gửi yêu cầu hoặc hồ sơ dự án', 'starter-flexible' ) ),
);
?>

<div class="site-main site-main--blog">
	<div class="container blog__body">
		<div class="err__grid">
			<?php foreach ( $shortcuts as $shortcut ) : ?>
				<?php $url = starter_flexible_content_page_url( $shortcut['key'], $shortcut['slug'] ); ?>
				<?php if ( '' === $url ) : ?>
					<?php continue; ?>
				<?php endif; ?>
				<a class="err__link" href="<?php echo esc_url( $url ); ?>">
					<span class="err__link-body">
						<span class="err__link-label"><?php echo esc_html( $shortcut['label'] ); ?></span>
						<span class="err__link-note"><?php echo esc_html( $shortcut['note'] ); ?></span>
					</span>
					<span class="err__link-go" aria-hidden="true"><?php echo starter_flexible_icon_swap( 'arrow', 22 ); // phpcs:ignore ?></span>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</div>
