<?php
/**
 * 404 — the page that is not there.
 *
 * A full navy band with the number set large over the swell, a search and the
 * two ways home; then the sections a lost reader most likely wanted, and the
 * newest vessels so the page still has something worth reading.
 *
 * @package Starter_Flexible
 * @since 1.0.0
 */

$contact   = starter_flexible_content_page_url( 'contact', 'lien-he' );

// The pages a reader is most likely looking for, by the content key that
// survives a slug change.
$shortcuts = array(
	array( 'key' => 'capabilities', 'slug' => 'nang-luc', 'icon' => 'compass', 'label' => __( 'Năng lực', 'starter-flexible' ), 'note' => __( 'Thiết kế tàu, R&D và phần mềm', 'starter-flexible' ) ),
	array( 'key' => 'service_01', 'slug' => 'thiet-ke-tau', 'icon' => 'ruler', 'label' => __( 'Thiết kế tàu', 'starter-flexible' ), 'note' => __( 'Đóng mới, cải hoán và hồ sơ kỹ thuật', 'starter-flexible' ) ),
	array( 'key' => 'projects', 'slug' => 'du-an', 'icon' => 'ship', 'label' => __( 'Dự án', 'starter-flexible' ), 'note' => __( 'Danh mục tàu đã thực hiện', 'starter-flexible' ) ),
	array( 'key' => 'tools', 'slug' => 'cong-cu', 'icon' => 'calculator', 'label' => __( 'Công cụ', 'starter-flexible' ), 'note' => __( 'Tra cứu và tính toán nhanh', 'starter-flexible' ) ),
	array( 'key' => 'insights', 'slug' => 'tin-tuc', 'icon' => 'file', 'label' => __( 'Tin tức', 'starter-flexible' ), 'note' => __( 'Ghi chú kỹ thuật và cập nhật', 'starter-flexible' ) ),
	array( 'key' => 'contact', 'slug' => 'lien-he', 'icon' => 'mail', 'label' => __( 'Liên hệ', 'starter-flexible' ), 'note' => __( 'Gửi yêu cầu hoặc hồ sơ dự án', 'starter-flexible' ) ),
);

$latest = get_posts(
	array(
		'post_type'      => 'project',
		'post_status'    => 'publish',
		'posts_per_page' => 3,
	)
);
?>

<section class="e404">
	<div class="e404__ground" aria-hidden="true">
		<svg viewBox="0 0 1440 620" preserveAspectRatio="none" class="e404__wave">
			<?php for ( $i = 0; $i < 8; $i++ ) : ?>
				<?php $y = 90 + $i * 64; ?>
				<path
					d="M-60 <?php echo esc_attr( (string) $y ); ?> C300 <?php echo esc_attr( (string) ( $y + 48 ) ); ?> 560 <?php echo esc_attr( (string) ( $y - 34 ) ); ?> 860 <?php echo esc_attr( (string) ( $y + 8 ) ); ?> C1120 <?php echo esc_attr( (string) ( $y + 44 ) ); ?> 1300 <?php echo esc_attr( (string) ( $y + 56 ) ); ?> 1520 <?php echo esc_attr( (string) ( $y + 30 ) ); ?>"
					fill="none"
					stroke="#0A72C8"
					stroke-width="<?php echo esc_attr( number_format( max( 2 - $i * 0.14, 0.8 ), 2, '.', '' ) ); ?>"
					stroke-opacity="<?php echo esc_attr( number_format( max( 0.46 - $i * 0.05, 0.08 ), 3, '.', '' ) ); ?>"
				/>
			<?php endfor; ?>
		</svg>
	</div>

	<div class="container e404__inner">
		<p class="e404__code" aria-hidden="true">404</p>

		<div class="e404__copy">
			<h1 class="e404__title"><?php esc_html_e( 'Trang này đã lạc khỏi hải trình.', 'starter-flexible' ); ?></h1>
			<p class="e404__lead">
				<?php esc_html_e( 'Đường dẫn có thể đã thay đổi hoặc trang đã được gỡ. Tìm lại nội dung bạn cần, hoặc quay về bến.', 'starter-flexible' ); ?>
			</p>

			<form class="srch__form e404__search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
				<label class="screen-reader-text" for="err-search"><?php esc_html_e( 'Tìm trên website', 'starter-flexible' ); ?></label>
				<?php echo starter_flexible_icon( 'search', 22, 'srch__form-icon' ); // phpcs:ignore ?>
				<input
					class="srch__input"
					id="err-search"
					type="search"
					name="s"
					placeholder="<?php esc_attr_e( 'Tên tàu, dịch vụ, chủ đề kỹ thuật…', 'starter-flexible' ); ?>"
				/>
				<button class="btn srch__submit" type="submit"><?php esc_html_e( 'Tìm', 'starter-flexible' ); ?></button>
			</form>

			<div class="e404__actions">
				<a class="btn" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php esc_html_e( 'Về trang chủ', 'starter-flexible' ); ?>
					<?php echo starter_flexible_icon_swap( 'arrow', 18 ); // phpcs:ignore ?>
				</a>
				<?php if ( '' !== $contact ) : ?>
					<a class="btn e404__ghost" href="<?php echo esc_url( $contact ); ?>">
						<?php esc_html_e( 'Báo lỗi đường dẫn', 'starter-flexible' ); ?>
						<?php echo starter_flexible_icon_swap( 'arrowUpRight', 18 ); // phpcs:ignore ?>
					</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

<div class="site-main site-main--blog">
	<div class="container blog__body">
		<section aria-labelledby="e404-ways">
			<header class="srch__group-head">
				<h2 class="srch__group-title" id="e404-ways"><?php esc_html_e( 'Có thể bạn đang tìm', 'starter-flexible' ); ?></h2>
			</header>
			<div class="e404__ways">
				<?php foreach ( $shortcuts as $shortcut ) : ?>
					<?php $url = starter_flexible_content_page_url( $shortcut['key'], $shortcut['slug'] ); ?>
					<?php if ( '' === $url ) : ?>
						<?php continue; ?>
					<?php endif; ?>
					<a class="e404__way" href="<?php echo esc_url( $url ); ?>">
						<span class="e404__way-icon" aria-hidden="true"><?php echo starter_flexible_icon( $shortcut['icon'], 24 ); // phpcs:ignore ?></span>
						<span class="e404__way-body">
							<span class="e404__way-label"><?php echo esc_html( $shortcut['label'] ); ?></span>
							<span class="e404__way-note"><?php echo esc_html( $shortcut['note'] ); ?></span>
						</span>
						<span class="e404__way-go" aria-hidden="true"><?php echo starter_flexible_icon_swap( 'arrow', 20 ); // phpcs:ignore ?></span>
					</a>
				<?php endforeach; ?>
			</div>
		</section>

		<?php if ( $latest ) : ?>
			<section class="e404__latest" aria-labelledby="e404-latest">
				<header class="srch__group-head">
					<h2 class="srch__group-title" id="e404-latest"><?php esc_html_e( 'Dự án mới nhất', 'starter-flexible' ); ?></h2>
					<?php $projects_url = starter_flexible_content_page_url( 'projects', 'du-an' ); ?>
					<?php if ( '' !== $projects_url ) : ?>
						<a class="link srch__group-more" href="<?php echo esc_url( $projects_url ); ?>">
							<?php esc_html_e( 'Tất cả dự án', 'starter-flexible' ); ?>
							<?php echo starter_flexible_icon_swap( 'arrow', 18 ); // phpcs:ignore ?>
						</a>
					<?php endif; ?>
				</header>
				<div class="pi__grid srch__grid">
					<?php foreach ( $latest as $vessel ) : ?>
						<?php get_template_part( 'template-parts/components/project-card', null, array( 'item' => starter_flexible_project_card( $vessel ) ) ); ?>
					<?php endforeach; ?>
				</div>
			</section>
		<?php endif; ?>
	</div>
</div>
