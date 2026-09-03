<?php
/**
 * The site footer: wave signature, wordmark, company details, map and base row.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$theme_uri = defined( 'STARTER_FLEXIBLE_THEME_URI' ) ? STARTER_FLEXIBLE_THEME_URI : get_template_directory_uri();

$site_name   = (string) starter_flexible_setting( 'site_name', get_bloginfo( 'name' ) );
$legal_name  = (string) starter_flexible_setting( 'legal_name', '' );
$tax_code    = (string) starter_flexible_setting( 'tax_code', '' );
$address     = (string) starter_flexible_setting( 'address', '' );
$phone       = (string) starter_flexible_setting( 'phone', '' );
$email       = (string) starter_flexible_setting( 'email', '' );
$maps_key    = (string) starter_flexible_setting( 'maps_api_key', '' );
$logo_id     = (int) starter_flexible_setting( 'footer_logo', 0 );
$logo_url    = $logo_id ? (string) wp_get_attachment_image_url( $logo_id, 'full' ) : $theme_uri . '/assets/images/footer-logo.svg';
$wordmark    = (string) starter_flexible_setting( 'wordmark', 'ENGINEERING|FOR TOMORROW|OCEAN' );
$footer_cta  = starter_flexible_link( starter_flexible_setting( 'footer_cta', array() ) );
$bank        = (array) starter_flexible_setting( 'bank', array() );
$legal_links = (array) starter_flexible_setting( 'legal_links', array() );

$wordmark_lines = array_values( array_filter( array_map( 'trim', explode( '|', $wordmark ) ) ) );

// Google geocodes the address, so the pin follows the Address setting rather
// than a separately maintained (and easily wrong) coordinate pair.
$query      = rawurlencode( $address );
$map_embed  = '' !== $maps_key
	? 'https://www.google.com/maps/embed/v1/place?key=' . rawurlencode( $maps_key ) . '&q=' . $query . '&zoom=17'
	: 'https://maps.google.com/maps?q=' . $query . '&z=17&hl=vi&output=embed';
$map_link   = 'https://www.google.com/maps/search/?api=1&query=' . $query;

// The wave signature that opens the footer. Generated rather than hand-written
// so the density is one number: it stacks far enough down to run behind the
// wordmark, thinning and fading as it goes.
$wave_lines = 9;
$wave_gap   = 38; // far apart — a slow ripple, not a dense hatch
$waves      = array();
for ( $i = 0; $i < $wave_lines; $i++ ) {
	$y = 46 + $i * $wave_gap;
	// Shallow control points keep the swell gentle at this spacing.
	$waves[] = array(
		'd'       => sprintf(
			'M-80 %1$d C300 %2$d 520 %3$d 830 %4$d C1090 %5$d 1280 %6$d 1520 %7$d',
			$y - 4,
			$y + 26,
			$y - 17,
			$y + 4,
			$y + 21,
			$y + 29,
			$y + 22
		),
		'width'   => number_format( max( 1.6 - $i * 0.09, 0.7 ), 2, '.', '' ),
		'opacity' => number_format( max( 0.72 - $i * 0.075, 0.08 ), 3, '.', '' ),
	);
}
?>
	</main>

	<footer class="ftr">
		<svg viewBox="0 0 1440 420" preserveAspectRatio="none" class="ftr__wave" data-wave="1.2" aria-hidden="true">
			<?php foreach ( $waves as $wave ) : ?>
				<path d="<?php echo esc_attr( $wave['d'] ); ?>" fill="none" stroke="#0A72C8" stroke-width="<?php echo esc_attr( $wave['width'] ); ?>" stroke-opacity="<?php echo esc_attr( $wave['opacity'] ); ?>" />
			<?php endforeach; ?>
		</svg>

		<div class="container ftr__inner">
			<div class="ftr__statement">
				<?php /* The wordmark is part of the brand, not copy — English in both locales. */ ?>
				<h2 class="ftr__wordmark" lang="en">
					<?php
					$last = count( $wordmark_lines ) - 1;
					foreach ( $wordmark_lines as $i => $line ) {
						if ( $i === $last && $last > 0 ) {
							echo '<span>' . esc_html( $line ) . '</span>';
							continue;
						}
						echo esc_html( $line ) . '<br />';
					}
					?>
				</h2>
				<?php if ( '' !== $footer_cta['url'] ) : ?>
					<a href="<?php echo esc_url( $footer_cta['url'] ); ?>" class="link link--fixed">
						<?php echo esc_html( $footer_cta['label'] ); ?>
						<?php echo starter_flexible_icon( 'arrowUpRight' ); // phpcs:ignore ?>
					</a>
				<?php endif; ?>
			</div>

			<div class="ftr__contact">
				<div class="ftr__brand">
					<img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( $site_name ); ?>" width="415" height="220" />

					<div class="ftr__details">
						<p class="ftr__legal"><?php echo esc_html( $legal_name ); ?></p>

						<?php if ( '' !== $tax_code ) : ?>
							<p class="ftr__tax">
								<span><?php esc_html_e( 'MST', 'starter-flexible' ); ?> <?php echo esc_html( $tax_code ); ?></span>
								<button
									type="button"
									class="ftr__copy"
									data-copy="<?php echo esc_attr( $tax_code ); ?>"
									data-copied="<?php esc_attr_e( 'Đã chép', 'starter-flexible' ); ?>"
									aria-label="<?php echo esc_attr( sprintf( /* translators: %s: tax code. */ __( 'Chép mã số thuế %s', 'starter-flexible' ), $tax_code ) ); ?>"
								>
									<?php echo starter_flexible_icon( 'file', 15 ); // phpcs:ignore ?>
									<span data-copy-label><?php esc_html_e( 'Chép', 'starter-flexible' ); ?></span>
								</button>
							</p>
						<?php endif; ?>

						<?php if ( '' !== $address ) : ?>
							<p class="ftr__row">
								<?php echo starter_flexible_icon( 'pin', 17 ); // phpcs:ignore ?>
								<span><?php echo esc_html( $address ); ?></span>
							</p>
						<?php endif; ?>
						<?php if ( '' !== $phone ) : ?>
							<a class="ftr__row" href="tel:<?php echo esc_attr( preg_replace( '/\s/', '', $phone ) ); ?>">
								<?php echo starter_flexible_icon( 'phone', 17 ); // phpcs:ignore ?>
								<span><?php echo esc_html( $phone ); ?></span>
							</a>
						<?php endif; ?>
						<?php if ( '' !== $email ) : ?>
							<a class="ftr__row" href="mailto:<?php echo esc_attr( $email ); ?>">
								<?php echo starter_flexible_icon( 'mail', 17 ); // phpcs:ignore ?>
								<span><?php echo esc_html( $email ); ?></span>
							</a>
						<?php endif; ?>
					</div>

					<?php if ( ! empty( array_filter( $bank ) ) ) : ?>
						<dl class="ftr__bank">
							<p class="ftr__bank-title"><?php esc_html_e( 'THÔNG TIN TÀI KHOẢN', 'starter-flexible' ); ?></p>

							<div>
								<dt><?php esc_html_e( 'Chủ tài khoản', 'starter-flexible' ); ?></dt>
								<dd><?php echo esc_html( (string) ( $bank['holder'] ?? '' ) ); ?></dd>
							</div>
							<div>
								<dt><?php esc_html_e( 'Số tài khoản', 'starter-flexible' ); ?></dt>
								<dd>
									<?php echo esc_html( (string) ( $bank['number'] ?? '' ) ); ?> (<?php echo esc_html( (string) ( $bank['currency'] ?? '' ) ); ?>)
									<button
										type="button"
										class="ftr__copy"
										data-copy="<?php echo esc_attr( (string) ( $bank['number'] ?? '' ) ); ?>"
										data-copied="<?php esc_attr_e( 'Đã chép', 'starter-flexible' ); ?>"
										aria-label="<?php echo esc_attr( sprintf( /* translators: %s: account number. */ __( 'Chép số tài khoản %s', 'starter-flexible' ), (string) ( $bank['number'] ?? '' ) ) ); ?>"
									>
										<?php echo starter_flexible_icon( 'file', 14 ); // phpcs:ignore ?>
										<span data-copy-label><?php esc_html_e( 'Chép', 'starter-flexible' ); ?></span>
									</button>
								</dd>
							</div>
							<div>
								<dt><?php esc_html_e( 'Ngân hàng', 'starter-flexible' ); ?></dt>
								<dd><?php echo esc_html( (string) ( $bank['name'] ?? '' ) ); ?></dd>
							</div>
							<div>
								<dt><?php esc_html_e( 'Swift code', 'starter-flexible' ); ?></dt>
								<dd><?php echo esc_html( (string) ( $bank['swift'] ?? '' ) ); ?></dd>
							</div>
						</dl>
					<?php endif; ?>
				</div>

				<?php if ( '' !== $address ) : ?>
					<div class="ftr__map-wrap">
						<div class="ftr__map">
							<iframe
								src="<?php echo esc_url( $map_embed ); ?>"
								title="<?php esc_attr_e( 'Vị trí văn phòng', 'starter-flexible' ); ?>"
								loading="lazy"
								referrerpolicy="no-referrer-when-downgrade"
								allowfullscreen
							></iframe>
						</div>
						<a href="<?php echo esc_url( $map_link ); ?>" target="_blank" rel="noopener" class="btn btn--secondary ftr__map-cta">
							<?php esc_html_e( 'Mở trên Google Maps', 'starter-flexible' ); ?>
							<?php echo starter_flexible_icon( 'arrowUpRight', 18 ); // phpcs:ignore ?>
						</a>
					</div>
				<?php endif; ?>
			</div>

			<?php
			if ( has_nav_menu( 'footer_menu' ) ) {
				wp_nav_menu(
					array(
						'theme_location' => 'footer_menu',
						'container'      => 'nav',
						'container_class' => 'ftr__menu',
						'container_aria_label' => __( 'Menu', 'starter-flexible' ),
						'items_wrap'     => '%3$s',
						'depth'          => 1,
						'fallback_cb'    => false,
					)
				);
			}
			?>

			<div class="ftr__base">
				<div>
					<span>© <?php echo esc_html( (string) gmdate( 'Y' ) ); ?> <?php echo esc_html( $site_name ); ?></span>
					<?php
					foreach ( $legal_links as $row ) :
						$link = starter_flexible_link( $row['link'] ?? array() );
						if ( '' === $link['url'] ) {
							continue;
						}
						?>
						<a href="<?php echo esc_url( $link['url'] ); ?>"><?php echo esc_html( $link['label'] ); ?></a>
					<?php endforeach; ?>
				</div>
				<div>
					<a href="#top" class="ftr__top">
						<?php esc_html_e( 'Lên đầu trang', 'starter-flexible' ); ?>
						<?php echo starter_flexible_icon( 'arrowUp', 16 ); // phpcs:ignore ?>
					</a>
				</div>
			</div>
		</div>
	</footer>

	<?php wp_footer(); ?>
</body>

</html>
