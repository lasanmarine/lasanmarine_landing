<?php
/**
 * The site header: announcement strip, fixed bar, mega menu and mobile drawer.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$theme_uri = defined( 'STARTER_FLEXIBLE_THEME_URI' ) ? STARTER_FLEXIBLE_THEME_URI : get_template_directory_uri();

$site_name    = (string) starter_flexible_setting( 'site_name', get_bloginfo( 'name' ) );
$logo_id      = (int) starter_flexible_setting( 'header_logo', 0 );
$logo_url     = $logo_id ? (string) wp_get_attachment_image_url( $logo_id, 'full' ) : $theme_uri . '/assets/images/logo-lasan.svg';
$announcement = (string) starter_flexible_setting( 'announcement_text', '' );
$announce_cta = starter_flexible_link( starter_flexible_setting( 'announcement_cta', array() ) );
$header_cta   = starter_flexible_link( starter_flexible_setting( 'header_cta', array() ) );
$phone        = (string) starter_flexible_setting( 'phone', '' );
$email        = (string) starter_flexible_setting( 'email', '' );
$social       = (array) starter_flexible_setting( 'social', array() );
$is_english   = function_exists( 'pll_current_language' ) && 'en' === pll_current_language( 'slug' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#06122D">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> id="top">
	<?php wp_body_open(); ?>

	<a href="#main" class="sr-only"><?php echo esc_html( $is_english ? 'Skip to main content' : 'Tới nội dung chính' ); ?></a>

	<header class="hdr" data-header>
		<?php if ( '' !== $announcement ) : ?>
			<div class="hdr__strip">
				<div class="container hdr__strip-inner">
					<span><?php echo esc_html( $announcement ); ?></span>
					<?php if ( '' !== $announce_cta['url'] ) : ?>
						<a href="<?php echo esc_url( $announce_cta['url'] ); ?>"><?php echo esc_html( $announce_cta['label'] ); ?></a>
					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>

		<div class="hdr__bar" data-hdr-bar>
			<div class="container hdr__bar-inner">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hdr__brand" aria-label="<?php echo esc_attr( $site_name ); ?>">
					<img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( $site_name ); ?>" width="150" height="34" />
				</a>

				<nav class="hdr__nav" aria-label="Primary">
					<?php
					starter_flexible_render_primary_nav();

					if ( '' !== $header_cta['url'] ) :
						?>
						<a href="<?php echo esc_url( $header_cta['url'] ); ?>" class="btn btn--sm hdr__cta">
							<?php echo esc_html( $header_cta['label'] ); ?>
							<?php echo starter_flexible_icon_swap( 'arrowUpRight', 20 ); // phpcs:ignore ?>
						</a>
					<?php endif; ?>
				</nav>

				<button type="button" class="hdr__burger" data-burger aria-expanded="false" aria-label="<?php esc_attr_e( 'Menu', 'starter-flexible' ); ?>">
					<span></span><span></span>
				</button>
			</div>
		</div>
	</header>

	<div class="drawer" data-drawer data-open="false" inert>
		<svg viewBox="0 0 600 200" preserveAspectRatio="none" class="drawer__wave" aria-hidden="true">
			<path d="M-40 150 C120 96 240 176 360 140 C470 108 545 70 640 78" fill="none" stroke="#0A72C8" stroke-width="8"></path>
			<path d="M-40 176 C130 126 250 196 370 164 C480 134 550 104 640 110" fill="none" stroke="#0A72C8" stroke-width="3"></path>
		</svg>

		<nav class="drawer__nav" aria-label="<?php echo esc_attr( $is_english ? 'Mobile' : 'Di động' ); ?>">
			<?php starter_flexible_render_drawer_nav( $header_cta ); ?>
		</nav>

		<div class="drawer__foot">
			<?php if ( '' !== $phone ) : ?>
				<a class="drawer__call" href="tel:<?php echo esc_attr( preg_replace( '/\s/', '', $phone ) ); ?>" style="--i:0">
					<?php echo starter_flexible_icon( 'phone', 18 ); // phpcs:ignore ?>
					<?php echo esc_html( $phone ); ?>
				</a>
			<?php endif; ?>
			<?php if ( '' !== $email ) : ?>
				<a class="drawer__call" href="mailto:<?php echo esc_attr( $email ); ?>" style="--i:1">
					<?php echo starter_flexible_icon( 'mail', 18 ); // phpcs:ignore ?>
					<?php echo esc_html( $email ); ?>
				</a>
			<?php endif; ?>

			<div class="drawer__meta" style="--i:2">
				<div class="drawer__social">
					<?php
					foreach ( $social as $row ) :
						$link = starter_flexible_link( $row['link'] ?? array() );
						if ( '' === $link['url'] ) {
							continue;
						}
						?>
						<a href="<?php echo esc_url( $link['url'] ); ?>">
							<?php echo esc_html( $link['label'] ); ?> <?php echo starter_flexible_icon( 'arrowUpRight', 14 ); // phpcs:ignore ?>
						</a>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>

	<main id="main">
