<?php
/**
 * The site header: announcement strip, fixed bar and the full-screen nav overlay.
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

				<nav class="hdr__nav" aria-label="<?php echo esc_attr( $is_english ? 'Primary' : 'Chính' ); ?>" data-bar-nav>
					<?php starter_flexible_render_bar_nav(); ?>
				</nav>

				<div class="hdr__actions">
					<?php if ( '' !== $header_cta['url'] ) : ?>
						<a href="<?php echo esc_url( $header_cta['url'] ); ?>" class="btn btn--sm hdr__cta">
							<?php echo esc_html( $header_cta['label'] ); ?>
							<?php echo starter_flexible_icon_swap( 'arrowUpRight', 20 ); // phpcs:ignore ?>
						</a>
					<?php endif; ?>

					<?php /* Below the nav's breakpoint this opens the full-screen overlay. */ ?>
					<button
						type="button"
						class="hdr__menu"
						data-nav-toggle
						aria-expanded="false"
						aria-controls="site-nav"
					>
						<span class="hdr__menu-word" aria-hidden="true">
							<span data-word-open><?php echo esc_html( $is_english ? 'Menu' : 'Menu' ); ?></span>
							<span data-word-close><?php echo esc_html( $is_english ? 'Close' : 'Đóng' ); ?></span>
						</span>
						<span class="hdr__menu-icon" aria-hidden="true"><span></span><span></span></span>
						<span class="sr-only"><?php echo esc_html( $is_english ? 'Open menu' : 'Mở menu' ); ?></span>
					</button>
				</div>
			</div>
		</div>

		<?php /* One full-bleed strip below the bar: four columns need the width. */ ?>
		<div class="hdr__panels" data-panels>
			<?php starter_flexible_render_bar_panels(); ?>
		</div>
	</header>

	<?php
	starter_flexible_render_nav_overlay(
		$header_cta,
		array(
			'phone'  => $phone,
			'email'  => $email,
			'social' => $social,
		)
	);
	?>

	<main id="main">
