<?php
/**
 * Template Name: Ứng dụng toàn màn hình
 *
 * A tool's own address opens the tool itself: the embedded app fills the
 * screen under a slim bar (brand, tool name, a link to the tool's
 * introduction page and back to all tools). The introduction lives on a
 * child page (…/gioi-thieu/).
 *
 * The app comes from the page's App Embed block (the page's content is that
 * block alone); the frame is the same one the block draws.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$sf_page  = get_queried_object();
$sf_app   = array();
foreach ( parse_blocks( (string) $sf_page->post_content ) as $sf_block ) {
	if ( 'acf/app-embed' === ( $sf_block['blockName'] ?? '' ) ) {
		// Same lookup as the block (blocks/app-embed/inc/helpers.php).
		$sf_data = (array) ( $sf_block['attrs']['data'] ?? array() );
		$sf_slug = sanitize_key( (string) ( $sf_data['app'] ?? '' ) );
		$sf_app  = array(
			'src'         => ( '' !== $sf_slug && is_file( get_template_directory() . '/apps/' . $sf_slug . '/index.html' ) ) ? get_template_directory_uri() . '/apps/' . $sf_slug . '/index.html' : '',
			'frame_title' => html_entity_decode( (string) ( $sf_data['title'] ?? '' ) ),
		);
		break;
	}
}
$sf_app   = (object) $sf_app;
$sf_title = '' !== trim( (string) ( $sf_app->frame_title ?? '' ) ) ? (string) $sf_app->frame_title : get_the_title( $sf_page );
$sf_intro = get_page_by_path( get_page_uri( $sf_page ) . '/gioi-thieu' ) ?: get_page_by_path( get_page_uri( $sf_page ) . '/about' );
$sf_en    = function_exists( 'pll_current_language' ) && 'en' === pll_current_language( 'slug' );
$sf_tools = $sf_page->post_parent ? get_permalink( $sf_page->post_parent ) : home_url( '/' );
$sf_logo  = (int) starter_flexible_setting( 'header_logo', 0 );
$sf_logo  = $sf_logo ? (string) wp_get_attachment_image_url( $sf_logo, 'full' ) : get_template_directory_uri() . '/assets/images/logo-lasan.svg';
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'app-page' ); ?>>
<?php wp_body_open(); ?>
<div class="appx">
	<?php /* The app carries its own logo and title; this strip only links out. */ ?>
	<nav class="appx__bar" aria-label="<?php echo esc_attr( $sf_title ); ?>">
		<a class="appx__link" href="<?php echo esc_url( $sf_tools ); ?>"><?php echo starter_flexible_icon( 'arrowLeft', 16 ); // phpcs:ignore ?><?php echo esc_html( $sf_en ? 'All tools' : 'Tất cả công cụ' ); ?></a>
		<?php if ( $sf_intro instanceof WP_Post ) : ?>
			<a class="appx__link" href="<?php echo esc_url( get_permalink( $sf_intro ) ); ?>"><?php echo esc_html( $sf_en ? 'About this tool' : 'Giới thiệu công cụ' ); ?><?php echo starter_flexible_icon( 'arrow', 16 ); // phpcs:ignore ?></a>
		<?php endif; ?>
	</nav>
	<?php if ( ! empty( $sf_app->src ) ) : ?>
		<iframe class="appx__frame" src="<?php echo esc_url( $sf_app->src ); ?>" title="<?php echo esc_attr( $sf_title ); ?>" allow="fullscreen; clipboard-write"></iframe>
	<?php else : ?>
		<p class="appx__empty"><?php esc_html_e( 'Chưa chọn ứng dụng cho trang này.', 'starter-flexible' ); ?></p>
	<?php endif; ?>
</div>
<?php wp_footer(); ?>
</body>
</html>
