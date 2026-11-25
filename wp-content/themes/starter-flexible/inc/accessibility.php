<?php
/**
 * Accessibility: the site's own "Hỗ trợ tiếp cận" panel.
 *
 * A button on the right edge opens a panel of reading aids, each stored per
 * browser and applied as a class on <html> before the first paint:
 *
 *   text size      4 steps (zoom, so the theme's px type grows too)
 *   a11y-contrast  darker text and lines, no gradient type, solid captions
 *   a11y-gray      grayscale
 *   a11y-links     every link underlined
 *   a11y-readable  a plain, wide sans-serif (Verdana/Tahoma/Arial)
 *   a11y-spacing   WCAG 1.4.12 text spacing (line 1.5+, letters .12em,
 *                  words .16em, paragraphs 2em)
 *   reduce-motion  the motion store's switch (shared with the footer toggle)
 *   a11y-cursor    a large pointer
 *   a11y-guide     a reading ruler that follows the pointer
 *
 * Behaviour: fe/src/behaviours/a11y-panel.js. Look: layout/_a11y-panel.scss.
 *
 * It replaces the WP Accessibility plugin's toolbar (two buttons, and a font
 * switch that could not grow the theme's px type). The plugin stays for its
 * other fixes; only its toolbar is turned off here, without touching its
 * settings.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// The plugin's toolbar is replaced by the panel below.
foreach ( array( 'wpa_toolbar', 'wpa_toolbar_mobile', 'wpa_toolbar_default', 'wpa_widget_toolbar' ) as $starter_flexible_wpa_option ) {
	add_filter( 'pre_option_' . $starter_flexible_wpa_option, static fn() => '' );
}
add_action(
	'wp_enqueue_scripts',
	static function () {
		foreach ( array( 'wpa-toolbar', 'ui-font', 'wpa-style' ) as $handle ) {
			wp_dequeue_style( $handle );
		}
	},
	100
);

/** The panel's words, in the page's language. */
function starter_flexible_a11y_strings(): array {
	$en = function_exists( 'pll_current_language' ) && 'en' === pll_current_language( 'slug' );
	return $en
		? array(
			'open'      => 'Accessibility options',
			'title'     => 'Accessibility',
			'close'     => 'Close',
			'size'      => 'Text size',
			'smaller'   => 'Smaller text',
			'larger'    => 'Larger text',
			'contrast'  => 'High contrast',
			'gray'      => 'Grayscale',
			'links'     => 'Underline links',
			'readable'  => 'Readable font',
			'spacing'   => 'Text spacing',
			'motion'    => 'Stop animations',
			'cursor'    => 'Large cursor',
			'guide'     => 'Reading guide',
			'reset'     => 'Reset all',
			'statement' => 'Accessibility statement',
			'saved'     => 'Your choices are kept in this browser.',
		)
		: array(
			'open'      => 'Tùy chọn hỗ trợ tiếp cận',
			'title'     => 'Hỗ trợ tiếp cận',
			'close'     => 'Đóng',
			'size'      => 'Cỡ chữ',
			'smaller'   => 'Thu nhỏ chữ',
			'larger'    => 'Phóng to chữ',
			'contrast'  => 'Tương phản cao',
			'gray'      => 'Thang xám',
			'links'     => 'Gạch chân liên kết',
			'readable'  => 'Phông dễ đọc',
			'spacing'   => 'Giãn dòng, giãn chữ',
			'motion'    => 'Dừng hiệu ứng',
			'cursor'    => 'Con trỏ lớn',
			'guide'     => 'Thước đọc',
			'reset'     => 'Đặt lại',
			'statement' => 'Tuyên bố hỗ trợ tiếp cận',
			'saved'     => 'Lựa chọn được lưu trên trình duyệt này.',
		);
}

/** The accessibility statement page in the current language, or 0. */
function starter_flexible_a11y_statement_id(): int {
	static $id = null;
	if ( null !== $id ) {
		return $id;
	}
	$found = get_posts(
		array(
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'meta_key'       => '_lasan_content_key', // phpcs:ignore WordPress.DB.SlowDBQuery
			'meta_value'     => 'accessibility', // phpcs:ignore WordPress.DB.SlowDBQuery
			'lang'           => '',
		)
	);
	$id = $found ? (int) $found[0] : 0;
	if ( $id && function_exists( 'pll_get_post' ) && function_exists( 'pll_current_language' ) ) {
		$id = (int) ( pll_get_post( $id, (string) pll_current_language( 'slug' ) ) ?: $id );
	}
	return $id;
}

/*
 * Before the first paint: the stored choices become classes on <html>, so a
 * page never flashes at the default size or contrast first.
 */
add_action(
	'wp_head',
	static function () {
		?>
<script>try{var a=JSON.parse(localStorage.getItem('lm-a11y')||'{}'),h=document.documentElement;if(a.text>0&&a.text<4)h.classList.add('a11y-text-'+a.text);['contrast','gray','links','readable','spacing','cursor','guide'].forEach(function(k){if(a[k])h.classList.add('a11y-'+k)})}catch(e){}</script>
		<?php
	},
	1
);

/* The trigger and the panel. */
add_action(
	'wp_footer',
	static function () {
		$t         = starter_flexible_a11y_strings();
		$statement = starter_flexible_a11y_statement_id();
		$toggles   = array(
			'contrast' => 'contrast',
			'gray'     => 'gray',
			'links'    => 'links',
			'readable' => 'readable',
			'spacing'  => 'spacing',
			'motion'   => 'motion',
			'cursor'   => 'cursor',
			'guide'    => 'guide',
		);
		?>
<div class="a11y" data-a11y>
	<button type="button" class="a11y__trigger" aria-expanded="false" aria-controls="a11y-panel" data-a11y-open>
		<svg viewBox="0 0 24 24" width="26" height="26" aria-hidden="true" focusable="false"><circle cx="12" cy="4.2" r="2.2" fill="currentColor"/><path d="M4 8.2c2.6.8 5.3 1.2 8 1.2s5.4-.4 8-1.2M12 9.4v5.2m0 0-3.2 6.4M12 14.6l3.2 6.4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
		<span class="sr-only"><?php echo esc_html( $t['open'] ); ?></span>
	</button>
	<div class="a11y__panel" id="a11y-panel" role="dialog" aria-modal="false" aria-labelledby="a11y-title" hidden data-a11y-panel>
		<div class="a11y__head">
			<h2 class="a11y__title" id="a11y-title"><?php echo esc_html( $t['title'] ); ?></h2>
			<button type="button" class="a11y__close" data-a11y-close>
				<span aria-hidden="true">×</span><span class="sr-only"><?php echo esc_html( $t['close'] ); ?></span>
			</button>
		</div>
		<div class="a11y__size" role="group" aria-labelledby="a11y-size-label">
			<span class="a11y__label" id="a11y-size-label"><?php echo esc_html( $t['size'] ); ?></span>
			<div class="a11y__stepper">
				<button type="button" class="a11y__step" data-a11y-size="-1" aria-label="<?php echo esc_attr( $t['smaller'] ); ?>">A−</button>
				<output class="a11y__value" data-a11y-size-value aria-live="polite">100%</output>
				<button type="button" class="a11y__step" data-a11y-size="1" aria-label="<?php echo esc_attr( $t['larger'] ); ?>">A+</button>
			</div>
		</div>
		<ul class="a11y__grid">
			<?php foreach ( $toggles as $key => $label_key ) : ?>
				<li>
					<button type="button" class="a11y__toggle a11y__toggle--<?php echo esc_attr( $key ); ?>" aria-pressed="false" data-a11y-toggle="<?php echo esc_attr( $key ); ?>">
						<span class="a11y__glyph" aria-hidden="true"></span>
						<span><?php echo esc_html( $t[ $label_key ] ); ?></span>
					</button>
				</li>
			<?php endforeach; ?>
		</ul>
		<div class="a11y__foot">
			<button type="button" class="a11y__reset" data-a11y-reset><?php echo esc_html( $t['reset'] ); ?></button>
			<?php if ( $statement ) : ?>
				<a class="a11y__link" href="<?php echo esc_url( (string) get_permalink( $statement ) ); ?>"><?php echo esc_html( $t['statement'] ); ?></a>
			<?php endif; ?>
		</div>
		<p class="a11y__note"><?php echo esc_html( $t['saved'] ); ?></p>
	</div>
	<div class="a11y__ruler" aria-hidden="true" data-a11y-ruler></div>
</div>
		<?php
	},
	5
);

/**
 * The statement joins the footer's legal links in every language, so it is
 * reachable from any page without the panel.
 *
 * @param array<int, array<string, mixed>> $links Rows of { link }.
 */
function starter_flexible_a11y_legal_link( array $links ): array {
	$id = starter_flexible_a11y_statement_id();
	if ( $id ) {
		$links[] = array(
			'link' => array(
				'url'    => (string) get_permalink( $id ),
				'title'  => starter_flexible_a11y_strings()['statement'],
				'target' => '',
			),
		);
	}
	return $links;
}
