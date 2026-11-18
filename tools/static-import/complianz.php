<?php
/**
 * Complianz (cookie consent) for this site — re-runnable.
 *
 *   docker exec -u www-data -e WP_HOME=http://192.168.1.199:49731 lasan_wp \
 *     php /var/www/html/tools/static-import/complianz.php [--dry-run]
 *
 * What it sets, and why:
 *
 * - Opt-in everywhere (Complianz's EU/GDPR region). Vietnam's Decree 13/2023
 *   needs prior, explicit consent; the free plugin has no geo-IP, so the one
 *   region applies to every visitor.
 * - What the site actually uses: `pll_language` (Polylang, functional), the
 *   Google Maps embed in the footer (marketing — Complianz blocks the iframe
 *   and shows a placeholder until consent), Google Analytics 4 through Site Kit
 *   on production (statistics, via Google Consent Mode v2: Complianz prints the
 *   consent defaults before Site Kit's gtag and updates them on a choice).
 *   Complianz does not insert a tag itself ("configuration_by_complianz" off):
 *   Site Kit owns the tag, and there is no tag ID on staging to insert.
 * - Nothing leaves the site: no cookiedatabase.org API or links, no website
 *   scan service, no proof-of-consent cloud, no e-mail reports. The cookie and
 *   service descriptions are written here instead of synced.
 * - Banner texts in Vietnamese (the default language) and their English
 *   versions as Polylang string translations (Languages → Translations, group
 *   "complianz"), so /en/ gets an English banner.
 * - The Complianz strings that are not settings (the "Always active" label,
 *   the cookie-policy document) have no Vietnamese language pack; this writes
 *   wp-content/languages/plugins/complianz-gdpr-vi.mo (and a few en_US
 *   overrides of the EU-only wording) from complianz-strings.php.
 * - A Complianz cookie policy page per language, linked as Polylang
 *   translations; the banner and the map placeholder link to it, and it holds
 *   the "manage consent" controls.
 *
 * Safe to run again: options are overwritten, the banner is updated in place,
 * pages and cookie rows are found again rather than duplicated.
 *
 * @package Starter_Flexible
 */

declare(strict_types=1);

if ( 'cli' !== PHP_SAPI ) {
	exit( 1 );
}

$root = dirname( __DIR__, 2 );
$home = getenv( 'WP_HOME' ) ?: 'http://localhost';
$_SERVER['HTTP_HOST']   = $_SERVER['HTTP_HOST'] ?? ( parse_url( $home, PHP_URL_HOST ) . ( parse_url( $home, PHP_URL_PORT ) ? ':' . parse_url( $home, PHP_URL_PORT ) : '' ) );
$_SERVER['REQUEST_URI'] = $_SERVER['REQUEST_URI'] ?? '/wp-admin/';

// Complianz only loads its settings code in wp-admin for a privacy manager (or
// for its own system-status context, which is what this constant is).
define( 'WP_ADMIN', true );
define( 'CMPLZ_DOING_SYSTEM_STATUS', true );

error_reporting( E_ALL & ~E_DEPRECATED & ~E_NOTICE & ~E_WARNING );
require_once $root . '/wp-load.php';
error_reporting( E_ALL & ~E_DEPRECATED & ~E_NOTICE & ~E_WARNING );

$dry = in_array( '--dry-run', $argv, true );

if ( ! class_exists( 'COMPLIANZ' ) || ! function_exists( 'cmplz_update_option' ) ) {
	fwrite( STDERR, "Complianz chưa được kích hoạt.\n" );
	exit( 1 );
}

// Act as the first administrator; Complianz checks `manage_privacy`.
cmplz_add_manage_privacy_capability( false );
$admins = get_users( array( 'role' => 'administrator', 'number' => 1, 'orderby' => 'ID', 'fields' => 'ID' ) );
if ( ! $admins ) {
	fwrite( STDERR, "Không có tài khoản quản trị.\n" );
	exit( 1 );
}
wp_set_current_user( (int) $admins[0] );

$translations = require __DIR__ . '/complianz-strings.php';

// Polylang's WPML layer "carries over" translations whenever Complianz
// re-registers a string name with a new value (each cookie row does), which
// leaves odd entries such as "Statistics" => "Functional" in the English
// strings. Remember what was there before this run; step 8 puts it back.
$pll_before = array();
if ( function_exists( 'PLL' ) && class_exists( 'PLL_MO' ) ) {
	foreach ( PLL()->model->get_languages_list() as $language ) {
		$mo = new PLL_MO();
		$mo->import_from_db( $language );
		$pll_before[ $language->slug ] = array_map( static fn( $e ) => $e->translations[0] ?? '', $mo->entries );
	}
}

/* ---------------------------------------------------------------------------
 * Company data, from the theme's site settings (ACF options).
 * ------------------------------------------------------------------------ */

$opt = static function ( string $name ): string {
	$value = function_exists( 'get_field' ) ? get_field( $name, 'option' ) : '';
	return is_string( $value ) ? trim( $value ) : '';
};

$legal_name = $opt( 'legal_name' ) ?: 'CÔNG TY TNHH LASAN MARINE';
// The ACF value is the letterhead's all-caps; documents read "Công ty TNHH …".
$legal_name = preg_replace( '/^CÔNG TY TNHH\s+/u', 'Công ty TNHH ', $legal_name );
// Complianz prints the country on its own line after the address.
$address    = preg_replace( '/,\s*Việt Nam$/u', '', $opt( 'address' ) );
$email      = $opt( 'email' ) ?: 'hello@lasanmarine.com';
$phone      = $opt( 'phone' );

/* ---------------------------------------------------------------------------
 * 1. First-run housekeeping Complianz normally does on its first admin page
 *    load: tables, the default banner. Its activation switches the
 *    cookiedatabase.org API on; that is switched off again below.
 * ------------------------------------------------------------------------ */

if ( ! $dry ) {
	if ( get_option( 'cmplz_run_activation' ) && isset( COMPLIANZ::$admin ) ) {
		COMPLIANZ::$admin->activation();
	}
	do_action( 'cmplz_install_tables' );
}

/* ---------------------------------------------------------------------------
 * 2. Wizard + settings (cmplz_options), saved the way the settings screen
 *    saves them, so Complianz's own hooks run (services table, cookie policy
 *    date, banner refresh…).
 * ------------------------------------------------------------------------ */

$settings = array(
	// Visitors.
	'regions'                          => 'eu',
	'other_region_behaviour'           => 'none',
	'eu_consent_regions'               => 'no',
	'wp_admin_access_users'            => 'no',
	// Documents: Complianz writes the cookie policy; the site has no privacy
	// statement / imprint page yet (see the report — the owner should add one).
	'cookie-statement'                 => 'generated',
	'privacy-statement'                => 'none',
	'impressum'                        => 'none',
	'disclaimer'                       => 'none',
	// Website information.
	'organisation_name'                => $legal_name,
	'address_company'                  => $address,
	'country_company'                  => 'VN',
	'email_company'                    => $email,
	'telephone_company'                => $phone,
	'purpose_personaldata'             => array( 'contact', 'statistics' ),
	// Security & consent.
	'records_of_consent'               => 'no',
	'datarequest'                      => 'no',
	'respect_dnt'                      => 'yes',
	'sensitive_information_processed'  => 'no',
	// Statistics: GA4 via Site Kit, Consent Mode v2, consent asked.
	'compile_statistics'               => 'google-analytics',
	'compile_statistics_more_info'     => array(),
	'consent_for_anonymous_stats'      => 'yes',
	'configuration_by_complianz'       => 'no',
	'consent-mode'                     => 'yes',
	'gtag-basic-consent-mode'          => 'no',
	'cmplz-gtag-urlpassthrough'        => 'no',
	'cmplz-gtag-ads_data_redaction'    => 'yes',
	'ua_code'                          => '',
	// Services.
	'consent_per_service'              => 'no',
	'uses_thirdparty_services'         => 'yes',
	'thirdparty_services_on_site'      => array( 'google-maps' ),
	'block_recaptcha_service'          => 'no',
	'uses_social_media'                => 'no',
	'socialmedia_on_site'              => array(),
	'uses_firstparty_marketing_cookies' => 'no',
	'uses_ad_cookies'                  => 'no',
	'uses_ad_cookies_personalized'     => 'no',
	'uses_wordpress_comments'          => 'no',
	'block_wordpress_comment_cookies'  => 'yes',
	// Documents menu.
	'region_redirect'                  => 'no',
	// Finish.
	'enable_cookie_banner'             => 'yes',
	'enable_cookie_blocker'            => 'yes',
	// General settings — nothing sent to external services.
	'use_cdb_api'                      => 'no',
	'use_cdb_links'                    => 'no',
	'send_notifications_email'         => 0,
	'cookie_expiry'                    => 365,
	'enable_cookieblocker_ajax'        => 0,
	'set_cookies_on_root'              => 0,
	'enable_iapi_navigation'           => 0,
	'a_b_testing'                      => 0,
	'a_b_testing_buttons'              => 0,
	'wsc_batch_scan_enabled'           => 0,
	'safe_mode'                        => 0,
	// Placeholders. No {category} token: its word comes from a gettext
	// context string, the sentence below names the category itself.
	'dont_use_placeholders'            => 0,
	'blocked_content_text'             => 'Bản đồ Google Maps chỉ hiển thị khi bạn đồng ý cookie tiếp thị. Nhấn để đồng ý và xem bản đồ.',
	'placeholder_style'                => 'light',
	'google-maps-format'               => '1280x920',
	// Documents.
	'use_document_css'                 => 1,
	'use_custom_document_css'          => 0,
);

// English versions of the translatable settings above (Polylang strings).
$settings_en = array(
	'Bản đồ Google Maps chỉ hiển thị khi bạn đồng ý cookie tiếp thị. Nhấn để đồng ý và xem bản đồ.'
		=> 'The Google Maps map only loads once you accept marketing cookies. Click to accept and show the map.',
);

$config_fields = COMPLIANZ::$config->fields;
$config_ids    = array_column( $config_fields, 'id' );
$options       = get_option( 'cmplz_options', array() );
$options       = is_array( $options ) ? $options : array();
$saved         = array();

foreach ( $settings as $id => $value ) {
	$index = array_search( $id, $config_ids, true );
	if ( false === $index ) {
		// Fields that only exist under some conditions (e.g. a Site Kit
		// integration hides the tag fields) — store them anyway.
		$type = is_array( $value ) ? 'multicheckbox' : 'text';
	} else {
		$type = cmplz_sanitize_field_type( $config_fields[ $index ]['type'] ?? 'text' );
	}
	$value      = cmplz_sanitize_field( $value, $type, $id );
	$prev_value = $options[ $id ] ?? false;
	$saved[]    = array(
		'id'           => $id,
		'type'         => $type,
		'value'        => $value,
		'prev_value'   => $prev_value,
		'translatable' => false !== $index && ! empty( $config_fields[ $index ]['translatable'] ),
	);
	printf( "  %-34s %s\n", $id, is_array( $value ) ? '[' . implode( ', ', $value ) . ']' : (string) $value );
}

if ( ! $dry ) {
	foreach ( $saved as $field ) {
		do_action( 'cmplz_before_save_option', $field['id'], $field['value'], $field['prev_value'], $field['type'] );
		$options[ $field['id'] ] = $field['value'];
	}
	foreach ( $saved as $field ) {
		$options = apply_filters( 'cmplz_before_save_options', $options, $field['id'], $field['value'], $field['prev_value'], $field['type'] );
	}
	update_option( 'cmplz_options', $options );
	foreach ( $saved as $field ) {
		if ( $field['translatable'] && is_string( $field['value'] ) ) {
			cmplz_register_translation( $field['value'], $field['id'] );
		}
		do_action( 'cmplz_after_save_field', $field['id'], $field['value'], $field['prev_value'], $field['type'] );
	}
	do_action( 'cmplz_after_saved_fields', $saved );
	cmplz_delete_transient( 'cmplz_blocked_scripts' );

	// Website-scan service and its onboarding modal stay off.
	update_option( 'cmplz_wsc_status', 'disabled', false );
}

/* ---------------------------------------------------------------------------
 * 3. The consent banner: Vietnamese texts, site colours.
 * ------------------------------------------------------------------------ */

$navy  = '#0b1b4c';
$texts = array(
	// field                     => array( vi, en )
	// Short and plain on purpose (site owner's brief): two sentences, no asides.
	'header'                    => array( 'Cookie trên website', 'Cookies on this website' ),
	'message_optin'             => array(
		'Chúng tôi dùng cookie cần thiết để website hoạt động. Với sự đồng ý của bạn, chúng tôi đo lượng truy cập và hiển thị bản đồ Google.',
		'We use necessary cookies to make this website work. With your consent, we also measure visits and show the Google map.',
	),
	'message_optout'            => array(
		'Chúng tôi dùng cookie để website hoạt động, đo lượng truy cập và hiển thị bản đồ Google.',
		'We use cookies to make this website work, measure visits and show the Google map.',
	),
	'accept'                    => array( 'Đồng ý', 'Accept' ),
	'accept_informational'      => array( 'Đồng ý', 'Accept' ),
	'dismiss'                   => array( 'Từ chối', 'Deny' ),
	'view_preferences'          => array( 'Tuỳ chọn', 'Preferences' ),
	'save_preferences'          => array( 'Lưu lựa chọn', 'Save choices' ),
	'revoke'                    => array( 'Quản lý đồng ý', 'Manage consent' ),
	'category_functional'       => array( 'Cần thiết', 'Necessary' ),
	'functional_text'           => array(
		'Bắt buộc để website hoạt động theo yêu cầu của bạn: ghi nhớ ngôn ngữ đã chọn và lựa chọn cookie này. Không thể tắt.',
		'Required for the website to work as you asked: remembering your language and this cookie choice. Cannot be switched off.',
	),
	'category_prefs'            => array( 'Tuỳ chỉnh', 'Preferences' ),
	'preferences_text'          => array(
		'Ghi nhớ các tuỳ chỉnh bạn không trực tiếp yêu cầu, ví dụ cá nhân hóa của dịch vụ Google.',
		'Stores preferences you did not directly ask for, such as personalisation in Google services.',
	),
	'category_stats'            => array( 'Thống kê', 'Statistics' ),
	'statistics_text'           => array(
		'Chỉ dùng cho mục đích thống kê (Google Analytics): giúp chúng tôi biết trang nào hữu ích để cải thiện website.',
		'Used only for statistics (Google Analytics): tells us which pages are useful so we can improve the website.',
	),
	'statistics_text_anonymous' => array(
		'Chỉ dùng cho mục đích thống kê ẩn danh.',
		'Used only for anonymous statistics.',
	),
	'category_all'              => array( 'Tiếp thị & bên thứ ba', 'Marketing & third parties' ),
	'marketing_text'            => array(
		'Cho phép nội dung của bên thứ ba như bản đồ Google Maps; các dịch vụ này có thể đặt cookie và nhận diện bạn trên các website khác.',
		'Allows third-party content such as the Google Maps map; these services may set cookies and recognise you across other websites.',
	),
);

$banner_settings = array(
	'title'                        => 'LASAN Marine',
	'use_categories'               => 'view-preferences',
	// Reopen tab: hover-reveal on desktop, always visible on phones (no hover there).
	'manage_consent_options'       => 'hover-show-mobile',
	'disable_cookiebanner'         => false,
	'dismiss_on_scroll'            => false,
	'dismiss_on_timeout'           => false,
	'soft_cookiewall'              => false,
	'position'                     => 'bottom-left',
	// No fade: the banner shows with the page (no entrance on first paint); a
	// 2s fade left it see-through, with the page text reading through it.
	'animation'                    => 'none',
	'banner_width'                 => 520,
	'checkbox_style'               => 'slider',
	'legal_documents'              => true,
	'use_logo'                     => 'hide',
	'close_button'                 => false,
	'use_box_shadow'               => true,
	'header_footer_shadow'         => false,
	'colorpalette_border_radius'   => array( 'top' => '20', 'right' => '20', 'bottom' => '20', 'left' => '20', 'type' => 'px' ),
	'border_width'                 => array( 'top' => '1', 'right' => '1', 'bottom' => '1', 'left' => '1' ),
	'buttons_border_radius'        => array( 'top' => '999', 'right' => '999', 'bottom' => '999', 'left' => '999', 'type' => 'px' ),
	'font_size'                    => 16,
	'colorpalette_background'      => array( 'color' => '#ffffff', 'border' => '#e3e9f0' ),
	'colorpalette_text'            => array( 'color' => '#0b1b4c', 'hyperlink' => '#0a72c8' ),
	'colorpalette_toggles'         => array( 'background' => $navy, 'bullet' => '#ffffff', 'inactive' => '#8a96a6' ),
	// Accept and Deny carry the same weight: refusing must be as easy as agreeing.
	'colorpalette_button_accept'   => array( 'background' => $navy, 'border' => $navy, 'text' => '#ffffff' ),
	'colorpalette_button_deny'     => array( 'background' => $navy, 'border' => $navy, 'text' => '#ffffff' ),
	'colorpalette_button_settings' => array( 'background' => '#ffffff', 'border' => $navy, 'text' => $navy ),
	'disable_width_correction'     => false,
	'use_custom_cookie_css'        => true,
	'custom_css'                   => <<<'CSS'
/* LASAN: the site's type, 16px/1.55 body copy, room between text and buttons. */
.cmplz-cookiebanner, #cmplz-manage-consent .cmplz-manage-consent { font-family: 'Be Vietnam Pro', system-ui, sans-serif; }
.cmplz-cookiebanner { padding: 20px 24px; grid-row-gap: 12px; }
.cmplz-cookiebanner .cmplz-header { grid-template-columns: 1fr auto; }
.cmplz-cookiebanner .cmplz-title { display: block !important; grid-column: 1 / -1; justify-self: start; font-family: 'Manrope Variable', Manrope, system-ui, sans-serif; font-weight: 700; font-size: 18px; line-height: 1.3; color: #0b1b4c; }
.cmplz-cookiebanner .cmplz-message { font-size: 16px; line-height: 1.55; max-width: 65ch; margin-top: -4px; margin-bottom: 8px; color: #0b1b4c; }
.cmplz-cookiebanner .cmplz-categories .cmplz-category .cmplz-description { font-size: 15px; line-height: 1.55; }
.cmplz-cookiebanner .cmplz-categories .cmplz-category, .cmplz-manage-consent-container .cmplz-category { background-color: #f4f7fb; border-radius: 10px; }
.cmplz-cookiebanner .cmplz-category .cmplz-category-title { font-size: 15px; color: #0b1b4c; }
:root { --cmplz_category_header_always_active_color: #0b1b4c; --cmplz_category_header_active_font_size: 13px; }
.cmplz-cookiebanner .cmplz-categories .cmplz-category .cmplz-category-header .cmplz-always-active, .cmplz-manage-consent-container .cmplz-always-active { color: #0b1b4c; font-weight: 600; font-size: 13px; }
.cmplz-cookiebanner .cmplz-buttons { gap: 10px; }
.cmplz-cookiebanner .cmplz-buttons .cmplz-btn { font-family: 'Manrope Variable', Manrope, system-ui, sans-serif; font-weight: 600; font-size: 15px; min-height: 46px; }
.cmplz-cookiebanner .cmplz-links .cmplz-link { font-size: 15px; text-decoration: underline; text-underline-offset: 3px; }
.cmplz-cookiebanner .cmplz-btn:focus-visible, .cmplz-cookiebanner a:focus-visible, #cmplz-manage-consent .cmplz-manage-consent:focus-visible { outline: 2px solid #0a72c8; outline-offset: 2px; }
/* Phones: a card across the screen, 8px from each edge (the WP
   Accessibility toolbar moves up under the header while the banner is open —
   theme: _a11y-toolbar.scss). One column: Complianz's own `.cmplz-body
   { min-width: 300px }` made the content wider than a phone's card and
   pushed the buttons out past its right edge. */
@media (max-width: 768px) {
	.cmplz-cookiebanner.cmplz-bottom-left { left: 8px; right: 8px; bottom: 8px; width: auto; max-width: none; max-height: calc(100vh - 96px); padding: 18px; grid-template-columns: minmax(0, 1fr); }
	.cmplz-cookiebanner .cmplz-body { min-width: 0; }
	.cmplz-cookiebanner .cmplz-header, .cmplz-cookiebanner .cmplz-body, .cmplz-cookiebanner .cmplz-message, .cmplz-cookiebanner .cmplz-categories, .cmplz-cookiebanner .cmplz-links, .cmplz-cookiebanner .cmplz-buttons, .cmplz-cookiebanner .cmplz-divider { grid-column: 1 / -1; min-width: 0; width: 100%; }
	/* Accept and Deny side by side, same size; Preferences below. */
	.cmplz-cookiebanner .cmplz-buttons { flex-direction: row; flex-wrap: wrap; }
	.cmplz-cookiebanner .cmplz-buttons .cmplz-btn { flex: 1 1 calc(50% - 5px); width: auto; }
	.cmplz-cookiebanner .cmplz-buttons .cmplz-btn.cmplz-view-preferences, .cmplz-cookiebanner .cmplz-buttons .cmplz-btn.cmplz-save-preferences { flex-basis: 100%; }
}
CSS,
);

$banners = cmplz_get_cookiebanners();
if ( ! $dry ) {
	if ( ! $banners ) {
		$banner        = new CMPLZ_COOKIEBANNER();
		$banner->title = 'LASAN Marine';
		$banner->save();
		wp_cache_flush();
		$banners = cmplz_get_cookiebanners();
	}
	$banner = cmplz_get_cookiebanner( $banners[0]->ID );
	if ( ! $banner->default ) {
		$banner->enable_default();
	}
	foreach ( $banner_settings as $field => $value ) {
		$banner->{$field} = $value;
	}
	foreach ( $texts as $field => $pair ) {
		if ( is_array( $banner->{$field} ) ) {
			$banner->{$field} = array( 'text' => $pair[0], 'show' => true );
		} else {
			$banner->{$field} = $pair[0];
		}
	}
	$banner->save();
	printf( "  banner #%d  v%d\n", $banner->ID, $banner->banner_version );
}

/* ---------------------------------------------------------------------------
 * 4. Cookie policy pages, one per language, Polylang translations of each
 *    other. Built like the site's other inner pages: a page hero, then the
 *    document in the rich-text column.
 * ------------------------------------------------------------------------ */

$policy_pages = array(
	'vi' => array(
		'title' => 'Chính sách cookie',
		'slug'  => 'chinh-sach-cookie',
		'lead'  => 'Website dùng những cookie nào, để làm gì, và cách bạn thay đổi lựa chọn đồng ý của mình.',
	),
	'en' => array(
		'title' => 'Cookie Policy',
		'slug'  => 'cookie-policy',
		'lead'  => 'Which cookies this website uses, what for, and how to change your consent.',
	),
);

$page_content = static function ( array $page ): string {
	$hero = array(
		'name' => 'acf/page-hero',
		'data' => array(
			'headline'       => $page['title'],
			'_headline'      => 'field_page_hero_headline',
			'lead'           => $page['lead'],
			'_lead'          => 'field_page_hero_lead',
			'actions'        => 0,
			'_actions'       => 'field_page_hero_actions',
			'heading_level'  => 'h1',
			'_heading_level' => 'field_page_hero_heading_level',
			'height'         => 320,
			'_height'        => 'field_page_hero_height',
		),
		'mode' => 'preview',
	);
	// The shortcode sits in an HTML block (not in the rich-text block, whose
	// content is kses-filtered, not run through shortcodes) so Complianz finds
	// the page by it and renders the document; the wrapper borrows the
	// rich-text block's classes for the reading column.
	return '<!-- wp:acf/page-hero ' . wp_json_encode( $hero, JSON_UNESCAPED_UNICODE ) . " /-->\n\n"
		. "<!-- wp:html -->\n"
		. '<section class="block container lasanmarine-rich-text cmplz-policy"><div class="rt__column rt--medium"><div class="prose rt__body">'
		. '[cmplz-document type="cookie-statement" region="eu"]'
		. "</div></div></section>\n"
		. '<!-- /wp:html -->';
};

$page_ids = array();
foreach ( $policy_pages as $lang => $page ) {
	$found = get_posts(
		array(
			'post_type'        => 'page',
			'post_status'      => 'any',
			'meta_key'         => '_lasan_cmplz_document',
			'meta_value'       => 'cookie-statement-' . $lang,
			'numberposts'      => 1,
			'fields'           => 'ids',
			'suppress_filters' => true,
			'lang'             => '',
		)
	);
	$id = $found ? (int) $found[0] : 0;
	printf( "  page %-3s %-22s %s\n", $lang, $page['slug'], $id ? "#$id" : '(mới)' );
	if ( $dry ) {
		continue;
	}
	$postarr = array(
		'ID'           => $id,
		'post_type'    => 'page',
		'post_status'  => 'publish',
		'post_title'   => $page['title'],
		'post_name'    => $page['slug'],
		'post_content' => $page_content( $page ),
		'post_author'  => get_current_user_id(),
	);
	$id = (int) wp_insert_post( wp_slash( $postarr ), true );
	if ( ! $id ) {
		fwrite( STDERR, "  không tạo được trang {$lang}\n" );
		continue;
	}
	update_post_meta( $id, '_lasan_cmplz_document', 'cookie-statement-' . $lang );
	if ( function_exists( 'pll_set_post_language' ) ) {
		pll_set_post_language( $id, $lang );
	}
	// Yoast: a legal page, not a landing page.
	update_post_meta( $id, '_yoast_wpseo_meta-robots-noindex', '0' );
	$page_ids[ $lang ] = $id;
}
if ( ! $dry && function_exists( 'pll_save_post_translations' ) && count( $page_ids ) > 1 ) {
	pll_save_post_translations( $page_ids );
}

/* ---------------------------------------------------------------------------
 * 5. English for everything Complianz runs through Polylang: banner texts,
 *    translatable settings, the policy page title.
 * ------------------------------------------------------------------------ */

if ( ! $dry && function_exists( 'PLL' ) && class_exists( 'PLL_MO' ) ) {
	$en_strings = $settings_en;
	foreach ( $texts as $pair ) {
		$en_strings[ $pair[0] ] = $pair[1];
	}
	$en_strings[ $policy_pages['vi']['title'] ] = $policy_pages['en']['title'];
	// Saving each policy page registers its title as the link text; the
	// English page, saved last, would win and Polylang would then "translate"
	// it back into Vietnamese. Register the Vietnamese (source) title again.
	cmplz_register_translation( $policy_pages['vi']['title'], 'cmplz_link_title_cookie-statement' );
	foreach ( PLL()->model->get_languages_list() as $language ) {
		if ( 'en' !== $language->slug ) {
			continue;
		}
		$mo = new PLL_MO();
		$mo->import_from_db( $language );
		unset( $mo->entries[ $policy_pages['en']['title'] ] );
		// Drop what an earlier run added for texts that have since changed.
		foreach ( (array) get_option( 'lasan_cmplz_pll_sources', array() ) as $old_source ) {
			if ( ! isset( $en_strings[ $old_source ] ) ) {
				unset( $mo->entries[ $old_source ] );
			}
		}
		foreach ( $en_strings as $source => $translation ) {
			$mo->add_entry( $mo->make_entry( $source, $translation ) );
		}
		$mo->export_to_db( $language );
		update_option( 'lasan_cmplz_pll_sources', array_keys( $en_strings ), false );
		printf( "  polylang en: %d chuỗi\n", count( $en_strings ) );
	}
}

/* ---------------------------------------------------------------------------
 * 6. The cookie list on the policy page. Without the cookiedatabase.org sync
 *    Complianz knows names only; describe each one here, per language.
 *    Measured on the site: Polylang's cookie, Complianz's own, the WP
 *    Accessibility toolbar's session cookies, the theme's localStorage keys;
 *    Google Analytics (Site Kit, production) and Google Maps (third party).
 * ------------------------------------------------------------------------ */

$purpose = array(
	'functional' => array( 'vi' => 'Chức năng', 'en' => 'Functional' ),
	'statistics' => array( 'vi' => 'Thống kê', 'en' => 'Statistics' ),
	'marketing'  => array( 'vi' => 'Tiếp thị', 'en' => 'Marketing' ),
);
$year  = array( 'vi' => '1 năm', 'en' => '1 year' );
$two_y = array( 'vi' => '2 năm', 'en' => '2 years' );
$sess  = array( 'vi' => 'Phiên trình duyệt', 'en' => 'Browser session' );
$kept  = array( 'vi' => 'Lưu lâu dài (localStorage)', 'en' => 'Persistent (localStorage)' );
$consent_fn = array( 'vi' => 'Lưu lựa chọn đồng ý cookie của bạn', 'en' => 'Stores your cookie consent choice' );

$services = array(
	'Complianz'         => array(
		'category' => 'functional',
		'type'     => array( 'vi' => 'lưu lựa chọn đồng ý cookie', 'en' => 'storing cookie consent choices' ),
		'shares'   => false,
		'own'      => true,
		'cookies'  => array(
			// Retention of cmplz_* is set by Complianz itself (cookie_expiry days).
			'cmplz_functional'    => array( $year, $consent_fn ),
			'cmplz_preferences'   => array( $year, $consent_fn ),
			'cmplz_statistics'    => array( $year, $consent_fn ),
			'cmplz_marketing'     => array( $year, $consent_fn ),
			'cmplz_policy_id'     => array( $year, array( 'vi' => 'Ghi nhận phiên bản chính sách cookie bạn đã đồng ý', 'en' => 'Records which cookie policy version you agreed to' ) ),
			'cmplz_consented_services' => array( $year, $consent_fn ),
			'cmplz_banner-status' => array( $year, array( 'vi' => 'Ghi nhớ banner cookie đã được đóng', 'en' => 'Remembers that the cookie banner was dismissed' ) ),
		),
	),
	'Polylang'          => array(
		'category' => 'functional',
		'type'     => array( 'vi' => 'ghi nhớ ngôn ngữ hiển thị', 'en' => 'remembering the display language' ),
		'shares'   => false,
		'own'      => true,
		'cookies'  => array(
			'pll_language' => array( $year, array( 'vi' => 'Lưu ngôn ngữ (Tiếng Việt / English) bạn đang xem', 'en' => 'Stores the language (Vietnamese / English) you are viewing' ) ),
		),
	),
	'WP Accessibility'  => array(
		'category' => 'functional',
		'type'     => array( 'vi' => 'cung cấp thanh công cụ trợ năng (cỡ chữ, độ tương phản)', 'en' => 'the accessibility toolbar (text size, contrast)' ),
		'shares'   => false,
		'own'      => true,
		'cookies'  => array(
			'a11y-larger-fontsize' => array( $sess, array( 'vi' => 'Giữ chế độ chữ lớn bạn đã bật', 'en' => 'Keeps the larger text you switched on' ) ),
			'a11y-high-contrast'   => array( $sess, array( 'vi' => 'Giữ chế độ tương phản cao bạn đã bật', 'en' => 'Keeps the high contrast you switched on' ) ),
		),
	),
	'LASAN Marine'      => array(
		'category' => 'functional',
		'type'     => array( 'vi' => 'lưu tùy chọn hiển thị và bản nháp biểu mẫu trên chính thiết bị của bạn', 'en' => 'storing display preferences and form drafts on your own device' ),
		'shares'   => false,
		'own'      => true,
		'cookies'  => array(
			'lm-motion'             => array( $kept, array( 'vi' => 'Ghi nhớ lựa chọn giảm chuyển động', 'en' => 'Remembers the reduced-motion choice' ) ),
			'lasan-design-brief:*'  => array( $kept, array( 'vi' => 'Bản nháp nhiệm vụ thư bạn đang soạn, xóa khi gửi', 'en' => 'Draft of the design brief you are writing, cleared when sent' ) ),
			'ktt_help_seen'         => array( $kept, array( 'vi' => 'Ghi nhớ đã xem hướng dẫn của công cụ mô phỏng', 'en' => 'Remembers that the simulator help was seen' ) ),
		),
	),
	'Google Analytics'  => array(
		'category' => 'statistics',
		'type'     => array( 'vi' => 'thống kê lượt truy cập website', 'en' => 'website statistics' ),
		'shares'   => true,
		'own'      => true,
		'privacy'  => 'https://policies.google.com/privacy',
		'cookies'  => array(
			'_ga'   => array( $two_y, array( 'vi' => 'Phân biệt các lượt truy cập để thống kê', 'en' => 'Distinguishes visits for statistics' ) ),
			'_ga_*' => array( $two_y, array( 'vi' => 'Lưu trạng thái phiên truy cập để thống kê', 'en' => 'Stores the visit session state for statistics' ) ),
		),
	),
	'Google Maps'       => array(
		'category' => 'marketing',
		'type'     => array( 'vi' => 'hiển thị bản đồ vị trí văn phòng', 'en' => 'showing the office location map' ),
		'shares'   => true,
		'own'      => false,
		'privacy'  => 'https://policies.google.com/privacy',
		'cookies'  => array(
			// Not set in a test browser (third-party cookies), but Google may set it.
			'NID' => array( array( 'vi' => '6 tháng', 'en' => '6 months' ), array( 'vi' => 'Google có thể đặt cookie này khi tải bản đồ để lưu tùy chọn và nhận diện trình duyệt', 'en' => 'May be set by Google when the map loads, to store preferences and recognise the browser' ) ),
		),
	),
);

if ( ! $dry && class_exists( 'CMPLZ_SERVICE' ) && class_exists( 'CMPLZ_COOKIE' ) ) {
	$languages  = array( 'en', 'vi' ); // Complianz keeps 'en' as the parent row.
	$keep_names = array();
	foreach ( $services as $service_name => $service ) {
		$parent_id = 0;
		foreach ( $languages as $lang ) {
			$row                      = new CMPLZ_SERVICE( $service_name, $lang );
			$row->name                = $service_name;
			$row->language            = $lang;
			$row->sync                = false;
			$row->category            = 'functional' === $service['category'] ? 'utility' : $service['category'];
			$row->serviceType         = $service['type'][ $lang ];
			$row->sharesData          = $service['shares'];
			$row->secondParty         = $service['shares'] && $service['own'];
			$row->privacyStatementURL = $service['privacy'] ?? '';
			$row->isTranslationFrom   = 'en' === $lang ? 0 : $parent_id;
			$row->save( false, false );
			if ( 'en' === $lang ) {
				$parent_id = (int) $row->ID;
			}
		}
		foreach ( $service['cookies'] as $cookie_name => $cookie ) {
			$keep_names[] = $cookie_name;
			$parent_id    = 0;
			foreach ( $languages as $lang ) {
				$row                    = new CMPLZ_COOKIE( $cookie_name, $lang );
				$row->name              = $cookie_name;
				$row->language          = $lang;
				$row->service           = $service_name;
				$row->sync              = false;
				$row->ignored           = false;
				$row->deleted           = false;
				$row->showOnPolicy      = true;
				$row->isOwnDomainCookie = $service['own'];
				$row->domain            = $service['own'] ? 'self' : 'thirdparty';
				$row->purpose           = $purpose[ $service['category'] ][ $lang ];
				$row->retention         = $cookie[0][ $lang ];
				$row->cookieFunction    = $cookie[1][ $lang ];
				$row->isTranslationFrom = 'en' === $lang ? 0 : $parent_id;
				if ( ! $row->firstAddDate ) {
					$row->firstAddDate = time();
				}
				$row->lastAddDate = time();
				$row->save();
				if ( 'en' === $lang ) {
					$parent_id = (int) $row->ID;
				}
			}
		}
	}
	// Rows Complianz added on its own (or a scan found) that are not listed
	// above stay, but off the policy until someone describes them.
	global $wpdb;
	$listed = implode( ',', array_map( static fn( $n ) => $wpdb->prepare( '%s', $n ), $keep_names ) );
	$wpdb->query( "UPDATE {$wpdb->prefix}cmplz_cookies SET showOnPolicy = 0 WHERE name NOT IN ($listed)" );
	delete_transient( 'cmplz_cookies' );
	printf( "  cookie: %d dịch vụ, %d cookie × %d ngôn ngữ\n", count( $services ), count( $keep_names ), count( $languages ) );
}

/* ---------------------------------------------------------------------------
 * 7. Complianz's own gettext strings: Vietnamese, plus the en_US overrides.
 * ------------------------------------------------------------------------ */

require_once ABSPATH . WPINC . '/pomo/mo.php';
foreach ( $translations as $locale => $rows ) {
	$file = WP_LANG_DIR . '/plugins/complianz-gdpr-' . $locale . '.mo';
	printf( "  %-44s %d chuỗi\n", str_replace( ABSPATH, '', $file ), count( $rows ) );
	if ( $dry ) {
		continue;
	}
	$mo = new MO();
	$mo->set_headers(
		array(
			'Project-Id-Version' => 'Complianz GDPR ' . ( defined( 'CMPLZ_VERSION' ) ? CMPLZ_VERSION : '' ) . ' — LASAN Marine',
			'Language'           => $locale,
			'MIME-Version'       => '1.0',
			'Content-Type'       => 'text/plain; charset=UTF-8',
			'Plural-Forms'       => 'vi' === $locale ? 'nplurals=1; plural=0;' : 'nplurals=2; plural=(n != 1);',
			'X-Generator'        => 'tools/static-import/complianz.php',
		)
	);
	foreach ( $rows as $row ) {
		$mo->add_entry(
			new Translation_Entry(
				array(
					'context'      => $row[0],
					'singular'     => $row[1],
					'translations' => array( $row[2] ),
				)
			)
		);
	}
	wp_mkdir_p( dirname( $file ) );
	if ( ! $mo->export_to_file( $file ) ) {
		fwrite( STDERR, "  không ghi được {$file}\n" );
	}
	// A stale PHP translation file would win over the .mo (WordPress ≥ 6.5).
	$php_file = substr( $file, 0, -3 ) . '.l10n.php';
	if ( is_file( $php_file ) ) {
		unlink( $php_file );
	}
}

/* ---------------------------------------------------------------------------
 * 8. Finish the wizard: this is what lets the banner show at all.
 * ------------------------------------------------------------------------ */

if ( ! $dry ) {
	do_action( 'cmplz_finish_wizard' );
	update_option( 'cmplz_wizard_completed_once', true );

	// Polylang strings: what was there before, plus this script's English.
	if ( function_exists( 'PLL' ) && class_exists( 'PLL_MO' ) ) {
		$managed = (array) get_option( 'lasan_cmplz_pll_sources', array() );
		foreach ( PLL()->model->get_languages_list() as $language ) {
			$mo = new PLL_MO();
			$mo->import_from_db( $language );
			$before = $pll_before[ $language->slug ] ?? array();
			foreach ( $mo->entries as $key => $entry ) {
				if ( 'en' === $language->slug && in_array( $key, $managed, true ) ) {
					continue;
				}
				if ( ! array_key_exists( $key, $before ) ) {
					unset( $mo->entries[ $key ] );
				} elseif ( ( $entry->translations[0] ?? '' ) !== $before[ $key ] ) {
					$mo->add_entry( $mo->make_entry( $key, $before[ $key ] ) );
				}
			}
			$mo->export_to_db( $language );
		}
	}
	delete_transient( 'cmplz_redirect_to_settings_page' );
	// Complianz caches page lookups and the banner's page links.
	global $wpdb;
	$wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE '\_transient\_cmplz\_%' OR option_name LIKE '\_transient\_timeout\_cmplz\_%'" );
	$cmplz_transients = get_option( 'cmplz_transients' );
	if ( false !== $cmplz_transients ) {
		update_option( 'cmplz_transients', array() );
	}
	wp_cache_flush();
}

echo "Xong.\n";
