<?php
/**
 * Template Name: Ứng dụng toàn màn hình
 *
 * A tool's own address opens the tool itself: the embedded app fills the
 * screen, with no bar around it: the app carries its own logo and title.
 * The introduction lives on a child page (…/gioi-thieu/).
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
		// Same lookup as the block (inc/static-apps.php).
		$sf_data = (array) ( $sf_block['attrs']['data'] ?? array() );
		$sf_app  = array(
			'src'         => starter_flexible_app_src( (string) ( $sf_data['app'] ?? '' ) ),
			'frame_title' => html_entity_decode( (string) ( $sf_data['title'] ?? '' ) ),
		);
		break;
	}
}
$sf_app   = (object) $sf_app;
$sf_title = '' !== trim( (string) ( $sf_app->frame_title ?? '' ) ) ? (string) $sf_app->frame_title : get_the_title( $sf_page );
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
	<?php if ( ! empty( $sf_app->src ) ) : ?>
		<iframe class="appx__frame" src="<?php echo esc_url( $sf_app->src ); ?>" title="<?php echo esc_attr( $sf_title ); ?>" allow="fullscreen; clipboard-write"></iframe>
	<?php else : ?>
		<p class="appx__empty"><?php esc_html_e( 'Chưa chọn ứng dụng cho trang này.', 'starter-flexible' ); ?></p>
	<?php endif; ?>
</div>
<?php wp_footer(); ?>
</body>
</html>
