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
$logo_id     = (int) starter_flexible_setting( 'header_logo', 0 );
$logo_url    = $logo_id ? (string) wp_get_attachment_image_url( $logo_id, 'full' ) : $theme_uri . '/assets/images/logo-lasan.svg';
$legal_name  = (string) starter_flexible_setting( 'legal_name', '' );
$tax_code    = (string) starter_flexible_setting( 'tax_code', '' );
$address     = (string) starter_flexible_setting( 'address', '' );
$phone       = (string) starter_flexible_setting( 'phone', '' );
$email       = (string) starter_flexible_setting( 'email', '' );
$maps_key    = (string) starter_flexible_setting( 'maps_api_key', '' );
$wordmark    = (string) starter_flexible_setting( 'wordmark', 'ENGINEERING|FOR TOMORROW|OCEAN' );
$footer_cta  = starter_flexible_link( starter_flexible_setting( 'footer_cta', array() ) );
$bank        = (array) starter_flexible_setting( 'bank', array() );
$legal_links = (array) starter_flexible_setting( 'legal_links', array() );
$is_english  = function_exists( 'pll_current_language' ) && 'en' === pll_current_language( 'slug' );

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
						<?php echo starter_flexible_icon_swap( 'arrowUpRight', 28 ); // phpcs:ignore ?>
					</a>
				<?php endif; ?>
			</div>

			<div class="ftr__contact">
				<div class="ftr__brand">
					<div class="ftr__details">
						<p class="ftr__group-title"><?php echo esc_html( $is_english ? 'Company details' : 'Thông tin doanh nghiệp' ); ?></p>

						<?php /* The same ruled label–leader–value rows the Contact Statement uses. */ ?>
						<div class="ftr__specs" data-reveal-stagger>
							<?php if ( '' !== $legal_name ) : ?>
								<div class="spec">
									<span class="spec__label"><?php echo esc_html( $is_english ? 'Company' : 'Tên công ty' ); ?></span>
									<span class="spec__leader"></span>
									<span class="spec__value"><?php echo esc_html( $legal_name ); ?></span>
								</div>
							<?php endif; ?>

							<?php if ( '' !== $tax_code ) : ?>
								<div class="spec">
									<span class="spec__label"><?php echo esc_html( $is_english ? 'Tax ID' : 'MST' ); ?></span>
									<span class="spec__leader"></span>
									<span class="spec__value">
										<?php echo esc_html( $tax_code ); ?>
										<button
											type="button"
											class="ftr__copy"
											data-copy="<?php echo esc_attr( $tax_code ); ?>"
											data-copied="<?php echo esc_attr( $is_english ? 'Copied' : 'Đã chép' ); ?>"
											aria-label="<?php echo esc_attr( sprintf( /* translators: %s: tax code. */ __( 'Chép mã số thuế %s', 'starter-flexible' ), $tax_code ) ); ?>"
										>
											<?php echo starter_flexible_icon( 'file', 14 ); // phpcs:ignore ?>
											<span data-copy-label><?php echo esc_html( $is_english ? 'Copy' : 'Chép' ); ?></span>
										</button>
									</span>
								</div>
							<?php endif; ?>

							<?php if ( '' !== $address ) : ?>
								<div class="spec">
									<span class="spec__label"><?php echo esc_html( $is_english ? 'Address' : 'Địa chỉ' ); ?></span>
									<span class="spec__leader"></span>
									<span class="spec__value"><?php echo esc_html( $address ); ?></span>
								</div>
							<?php endif; ?>

							<?php if ( '' !== $phone ) : ?>
								<div class="spec">
									<span class="spec__label"><?php echo esc_html( $is_english ? 'Phone' : 'Điện thoại' ); ?></span>
									<span class="spec__leader"></span>
									<a class="spec__value" href="tel:<?php echo esc_attr( preg_replace( '/\s/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a>
								</div>
							<?php endif; ?>

							<?php if ( '' !== $email ) : ?>
								<div class="spec">
									<span class="spec__label">Email</span>
									<span class="spec__leader"></span>
									<a class="spec__value" href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
								</div>
							<?php endif; ?>
						</div>
					</div>

					<?php if ( ! empty( array_filter( $bank ) ) ) : ?>
						<div class="ftr__bank">
							<p class="ftr__group-title"><?php echo esc_html( $is_english ? 'Bank details' : 'Thông tin tài khoản' ); ?></p>

							<div class="ftr__specs" data-reveal-stagger>
								<div class="spec">
									<span class="spec__label"><?php echo esc_html( $is_english ? 'Account holder' : 'Chủ tài khoản' ); ?></span>
									<span class="spec__leader"></span>
									<span class="spec__value"><?php echo esc_html( (string) ( $bank['holder'] ?? '' ) ); ?></span>
								</div>
								<div class="spec">
									<span class="spec__label"><?php echo esc_html( $is_english ? 'Account number' : 'Số tài khoản' ); ?></span>
									<span class="spec__leader"></span>
									<span class="spec__value">
										<?php echo esc_html( (string) ( $bank['number'] ?? '' ) ); ?> (<?php echo esc_html( (string) ( $bank['currency'] ?? '' ) ); ?>)
										<button
											type="button"
											class="ftr__copy"
											data-copy="<?php echo esc_attr( (string) ( $bank['number'] ?? '' ) ); ?>"
											data-copied="<?php echo esc_attr( $is_english ? 'Copied' : 'Đã chép' ); ?>"
											aria-label="<?php echo esc_attr( sprintf( /* translators: %s: account number. */ __( 'Chép số tài khoản %s', 'starter-flexible' ), (string) ( $bank['number'] ?? '' ) ) ); ?>"
										>
											<?php echo starter_flexible_icon( 'file', 14 ); // phpcs:ignore ?>
											<span data-copy-label><?php echo esc_html( $is_english ? 'Copy' : 'Chép' ); ?></span>
										</button>
									</span>
								</div>
								<div class="spec">
									<span class="spec__label"><?php echo esc_html( $is_english ? 'Bank' : 'Ngân hàng' ); ?></span>
									<span class="spec__leader"></span>
									<span class="spec__value"><?php echo esc_html( (string) ( $bank['name'] ?? '' ) ); ?></span>
								</div>
								<div class="spec">
									<span class="spec__label"><?php esc_html_e( 'Swift code', 'starter-flexible' ); ?></span>
									<span class="spec__leader"></span>
									<span class="spec__value"><?php echo esc_html( (string) ( $bank['swift'] ?? '' ) ); ?></span>
								</div>
							</div>
						</div>
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
							<?php echo esc_html( $is_english ? 'Open in Google Maps' : 'Mở trên Google Maps' ); ?>
							<?php echo starter_flexible_icon( 'arrowUpRight', 18 ); // phpcs:ignore ?>
						</a>
					</div>
				<?php endif; ?>
			</div>

			<?php
			/* The closing group: the menu runs along the top, then a rule, then
			   the mark, the year and — at the far edge — the two controls that
			   have to stay reachable. The legal links join the menu list rather
			   than open a row of their own. */
			$legal_items = '';
			foreach ( $legal_links as $row ) {
				$link = starter_flexible_link( $row['link'] ?? array() );
				if ( '' === $link['url'] ) {
					continue;
				}
				$legal_items .= sprintf(
					'<li class="ftr__menu-legal"><a href="%s">%s</a></li>',
					esc_url( $link['url'] ),
					esc_html( $link['label'] )
				);
			}
			?>
			<div class="ftr__end">
				<?php
				if ( has_nav_menu( 'footer_menu' ) ) {
					wp_nav_menu(
						array(
							'theme_location'       => 'footer_menu',
							'container'            => 'nav',
							'container_class'      => 'ftr__menu',
							'container_aria_label' => __( 'Menu', 'starter-flexible' ),
							// items_wrap goes through sprintf, so a per cent sign in a
							// legal link would be read as a placeholder.
							'items_wrap'           => '<ul class="ftr__menu-list">%3$s' . str_replace( '%', '%%', $legal_items ) . '</ul>',
							'depth'                => 1,
							'fallback_cb'          => false,
						)
					);
				} elseif ( '' !== $legal_items ) {
					printf(
						'<nav class="ftr__menu" aria-label="%s"><ul class="ftr__menu-list">%s</ul></nav>',
						esc_attr__( 'Menu', 'starter-flexible' ),
						$legal_items // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- built escaped above.
					);
				}
				?>

				<div class="ftr__end-row">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="ftr__mark" aria-label="<?php echo esc_attr( $site_name ); ?>">
						<img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( $site_name ); ?>" width="150" height="34" loading="lazy" />
					</a>

					<span class="ftr__year">&copy; <?php echo esc_html( (string) gmdate( 'Y' ) ); ?></span>

					<div class="ftr__end-aside">
						<?php get_template_part( 'template-parts/components/lang-switch', null, array( 'class' => 'lang--footer' ) ); ?>
						<?php /* A link, not a button: the row carries no boxes. */ ?>
						<a href="#top" class="ftr__top">
							<?php echo esc_html( $is_english ? 'Back to top' : 'Lên đầu trang' ); ?>
							<?php echo starter_flexible_icon_swap( 'arrowUpRight', 22 ); // phpcs:ignore ?>
						</a>
					</div>
				</div>
			</div>
		</div>
	</footer>

	<?php wp_footer(); ?>
</body>

</html>
