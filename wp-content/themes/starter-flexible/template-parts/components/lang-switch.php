<?php
/**
 * Language switch — VI / EN.
 *
 * Renders nothing unless Polylang is active with more than one language, so a
 * single-language install keeps a clean header.
 *
 * @var array $args class (optional extra class)
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'pll_the_languages' ) || ! function_exists( 'pll_current_language' ) ) {
	return;
}

$languages = pll_the_languages(
	array(
		'raw'                    => 1,
		'hide_if_empty'          => 0,
		// Untranslated pages fall back to that language's front page rather
		// than disappearing, so the switch is always available.
		'hide_if_no_translation' => 0,
	)
);

if ( ! is_array( $languages ) || count( $languages ) < 2 ) {
	return;
}

$extra   = isset( $args['class'] ) ? ' ' . (string) $args['class'] : '';
$current = (string) pll_current_language( 'slug' );
?>
<div class="lang<?php echo esc_attr( $extra ); ?>" role="group" aria-label="<?php esc_attr_e( 'Ngôn ngữ', 'starter-flexible' ); ?>">
	<?php foreach ( $languages as $language ) : ?>
		<?php
		$slug      = (string) ( $language['slug'] ?? '' );
		$is_active = $slug === $current || ! empty( $language['current_lang'] );
		?>
		<?php
		// The language's own name reads clearer than a two-letter code, and
		// Polylang already carries it translated.
		$names = array( 'vi' => 'Tiếng Việt', 'en' => 'English' );
		$name  = $names[ $slug ] ?? (string) ( $language['name'] ?? strtoupper( $slug ) );
		?>
		<a
			class="lang__item<?php echo $is_active ? ' is-active' : ''; ?>"
			href="<?php echo esc_url( (string) ( $language['url'] ?? home_url( '/' ) ) ); ?>"
			hreflang="<?php echo esc_attr( (string) ( $language['locale'] ?? $slug ) ); ?>"
			lang="<?php echo esc_attr( $slug ); ?>"
			<?php echo $is_active ? 'aria-current="true"' : ''; ?>
		>
			<?php echo esc_html( $name ); ?>
		</a>
	<?php endforeach; ?>
</div>
