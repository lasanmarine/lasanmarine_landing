<?php
/**
 * Site settings (ACF Options page + fields for the header and footer).
 *
 * These carry the company facts the Astro site kept in src/data/site.js.
 *
 * @package Starter_Flexible
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function starter_flexible_register_site_settings_options(): void {
	if ( ! function_exists( 'acf_add_options_page' ) ) {
		return;
	}

	acf_add_options_page(
		array(
			'page_title' => __( 'Site Settings', 'starter-flexible' ),
			'menu_title' => __( 'Site Settings', 'starter-flexible' ),
			'menu_slug'  => 'starter-flexible-site-settings',
			'capability' => 'manage_options',
			'redirect'   => false,
		)
	);
}
add_action( 'acf/init', 'starter_flexible_register_site_settings_options' );

function starter_flexible_register_site_settings_fields(): void {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'                   => 'group_starter_flexible_site_settings',
			'title'                 => __( 'Site Settings', 'starter-flexible' ),
			'fields'                => array(
				array( 'key' => 'field_sfs_tab_general', 'label' => __( 'General', 'starter-flexible' ), 'type' => 'tab' ),
				array( 'key' => 'field_sfs_name', 'label' => __( 'Site Name', 'starter-flexible' ), 'name' => 'site_name', 'type' => 'text' ),
				array( 'key' => 'field_sfs_legal_name', 'label' => __( 'Legal Name', 'starter-flexible' ), 'name' => 'legal_name', 'type' => 'text' ),
				array( 'key' => 'field_sfs_tax_code', 'label' => __( 'Tax Code', 'starter-flexible' ), 'name' => 'tax_code', 'type' => 'text' ),
				array( 'key' => 'field_sfs_address', 'label' => __( 'Address', 'starter-flexible' ), 'name' => 'address', 'type' => 'textarea', 'rows' => 2, 'new_lines' => '' ),
				array( 'key' => 'field_sfs_phone', 'label' => __( 'Phone', 'starter-flexible' ), 'name' => 'phone', 'type' => 'text' ),
				array( 'key' => 'field_sfs_email', 'label' => __( 'Email', 'starter-flexible' ), 'name' => 'email', 'type' => 'email' ),
				array(
					'key'           => 'field_sfs_maps_api_key',
					'label'         => __( 'Google Maps Embed API Key', 'starter-flexible' ),
					'name'          => 'maps_api_key',
					'type'          => 'text',
					'instructions'  => __( 'Bỏ trống thì dùng bản nhúng Google không cần khoá. Bản đồ định vị theo Address ở trên.', 'starter-flexible' ),
				),

				array( 'key' => 'field_sfs_tab_header', 'label' => __( 'Header', 'starter-flexible' ), 'type' => 'tab' ),
				array(
					'key'           => 'field_sfs_logo',
					'label'         => __( 'Header Logo', 'starter-flexible' ),
					'name'          => 'header_logo',
					'type'          => 'image',
					'return_format' => 'id',
					'preview_size'  => 'medium',
					'library'       => 'all',
					'instructions'  => __( 'Để trống thì dùng logo mặc định của theme.', 'starter-flexible' ),
				),
				array( 'key' => 'field_sfs_announcement_text', 'label' => __( 'Announcement Text', 'starter-flexible' ), 'name' => 'announcement_text', 'type' => 'text', 'instructions' => __( 'Để trống thì ẩn dải thông báo.', 'starter-flexible' ) ),
				array( 'key' => 'field_sfs_announcement_cta', 'label' => __( 'Announcement CTA', 'starter-flexible' ), 'name' => 'announcement_cta', 'type' => 'link', 'return_format' => 'array' ),
				array( 'key' => 'field_sfs_header_cta', 'label' => __( 'Header CTA', 'starter-flexible' ), 'name' => 'header_cta', 'type' => 'link', 'return_format' => 'array' ),
				array(
					'key'          => 'field_sfs_mega_title',
					'label'        => __( 'Mega Menu Title', 'starter-flexible' ),
					'name'         => 'mega_title',
					'type'         => 'text',
					'instructions' => __( 'Gán class "has-mega" cho một mục menu để mở bảng mega dựng từ các mục con của nó.', 'starter-flexible' ),
				),

				array( 'key' => 'field_sfs_tab_footer', 'label' => __( 'Footer', 'starter-flexible' ), 'type' => 'tab' ),
				array(
					'key'           => 'field_sfs_footer_logo',
					'label'         => __( 'Footer Logo', 'starter-flexible' ),
					'name'          => 'footer_logo',
					'type'          => 'image',
					'return_format' => 'id',
					'preview_size'  => 'medium',
					'library'       => 'all',
				),
				array( 'key' => 'field_sfs_wordmark', 'label' => __( 'Wordmark', 'starter-flexible' ), 'name' => 'wordmark', 'type' => 'text', 'instructions' => __( 'Ba dòng, ngăn bằng "|". Dòng cuối tô màu marine.', 'starter-flexible' ), 'default_value' => 'ENGINEERING|FOR TOMORROW|OCEAN' ),
				array( 'key' => 'field_sfs_footer_cta', 'label' => __( 'Footer CTA', 'starter-flexible' ), 'name' => 'footer_cta', 'type' => 'link', 'return_format' => 'array' ),
				array(
					'key'        => 'field_sfs_bank',
					'label'      => __( 'Bank Details', 'starter-flexible' ),
					'name'       => 'bank',
					'type'       => 'group',
					'sub_fields' => array(
						array( 'key' => 'field_sfs_bank_holder', 'label' => __( 'Account Holder', 'starter-flexible' ), 'name' => 'holder', 'type' => 'text' ),
						array( 'key' => 'field_sfs_bank_number', 'label' => __( 'Account Number', 'starter-flexible' ), 'name' => 'number', 'type' => 'text' ),
						array( 'key' => 'field_sfs_bank_currency', 'label' => __( 'Currency', 'starter-flexible' ), 'name' => 'currency', 'type' => 'text', 'default_value' => 'VND' ),
						array( 'key' => 'field_sfs_bank_name', 'label' => __( 'Bank', 'starter-flexible' ), 'name' => 'name', 'type' => 'text' ),
						array( 'key' => 'field_sfs_bank_swift', 'label' => __( 'Swift Code', 'starter-flexible' ), 'name' => 'swift', 'type' => 'text' ),
					),
				),
				array(
					'key'          => 'field_sfs_social',
					'label'        => __( 'Social', 'starter-flexible' ),
					'name'         => 'social',
					'type'         => 'repeater',
					'layout'       => 'table',
					'button_label' => __( 'Add Link', 'starter-flexible' ),
					'sub_fields'   => array(
						array( 'key' => 'field_sfs_social_link', 'label' => __( 'Link', 'starter-flexible' ), 'name' => 'link', 'type' => 'link', 'return_format' => 'array' ),
					),
				),
				array(
					'key'          => 'field_sfs_legal_links',
					'label'        => __( 'Legal Links', 'starter-flexible' ),
					'name'         => 'legal_links',
					'type'         => 'repeater',
					'layout'       => 'table',
					'button_label' => __( 'Add Link', 'starter-flexible' ),
					'sub_fields'   => array(
						array( 'key' => 'field_sfs_legal_link', 'label' => __( 'Link', 'starter-flexible' ), 'name' => 'link', 'type' => 'link', 'return_format' => 'array' ),
					),
				),

				array( 'key' => 'field_sfs_tab_tools', 'label' => __( 'Tools', 'starter-flexible' ), 'type' => 'tab' ),
				array(
					'key'          => 'field_sfs_machines',
					'label'        => __( 'Machine List', 'starter-flexible' ),
					'name'         => 'machines',
					'type'         => 'repeater',
					'layout'       => 'table',
					'button_label' => __( 'Add Machine', 'starter-flexible' ),
					'instructions' => __( 'Dữ liệu cho công cụ Tra cứu động cơ (Engine Lookup).', 'starter-flexible' ),
					'sub_fields'   => array(
						array( 'key' => 'field_sfs_machine_make', 'label' => __( 'Make', 'starter-flexible' ), 'name' => 'make', 'type' => 'text' ),
						array( 'key' => 'field_sfs_machine_model', 'label' => __( 'Model', 'starter-flexible' ), 'name' => 'model', 'type' => 'text' ),
						array( 'key' => 'field_sfs_machine_kw', 'label' => __( 'kW', 'starter-flexible' ), 'name' => 'kw', 'type' => 'number', 'step' => 'any' ),
						array( 'key' => 'field_sfs_machine_rpm', 'label' => __( 'RPM', 'starter-flexible' ), 'name' => 'rpm', 'type' => 'number', 'step' => 'any' ),
					),
				),
				array(
					'key'          => 'field_sfs_shaft_materials',
					'label'        => __( 'Vật liệu trục chân vịt', 'starter-flexible' ),
					'name'         => 'shaft_materials',
					'type'         => 'repeater',
					'layout'       => 'table',
					'button_label' => __( 'Add Material', 'starter-flexible' ),
					'instructions' => __( 'Dữ liệu cho công cụ Tính đường kính trục (Shaft Diameter). Điền cả bản dịch tiếng Anh để hiển thị khi site chuyển sang EN.', 'starter-flexible' ),
					'sub_fields'   => array(
						array( 'key' => 'field_sfs_material_name', 'label' => __( 'Name (VI)', 'starter-flexible' ), 'name' => 'name', 'type' => 'text' ),
						array( 'key' => 'field_sfs_material_name_en', 'label' => __( 'Name (EN)', 'starter-flexible' ), 'name' => 'name_en', 'type' => 'text' ),
						array( 'key' => 'field_sfs_material_note', 'label' => __( 'Note (VI)', 'starter-flexible' ), 'name' => 'note', 'type' => 'text' ),
						array( 'key' => 'field_sfs_material_note_en', 'label' => __( 'Note (EN)', 'starter-flexible' ), 'name' => 'note_en', 'type' => 'text' ),
						array( 'key' => 'field_sfs_material_k3', 'label' => __( 'Hệ số k3', 'starter-flexible' ), 'name' => 'k3', 'type' => 'number', 'step' => 'any' ),
					),
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'starter-flexible-site-settings',
					),
				),
			),
			'menu_order'            => 0,
			'active'                => true,
			'instruction_placement' => 'label',
		)
	);
}
add_action( 'acf/init', 'starter_flexible_register_site_settings_fields', 5 );

/**
 * Seed the Machine List and Vật liệu trục chân vịt repeaters once, the first
 * time the options page is used, so the tools keep working out of the box.
 * Admins can then edit or clear the rows normally from Site Settings.
 */
function starter_flexible_seed_site_settings_tool_data(): void {
	if ( ! function_exists( 'get_field' ) || ! function_exists( 'update_field' ) ) {
		return;
	}

	if ( ! get_option( 'starter_flexible_tools_seeded' ) ) {
		$machines = get_field( 'machines', 'option' );
		if ( empty( $machines ) ) {
			$json = file_get_contents( __DIR__ . '/../blocks/engine-lookup/inc/engines.json' ); // phpcs:ignore WordPress.WP.AlternativeFunctions
			$rows = false !== $json ? (array) json_decode( $json, true ) : array();
			if ( ! empty( $rows ) ) {
				update_field( 'machines', $rows, 'option' );
			}
		}

		$materials = get_field( 'shaft_materials', 'option' );
		if ( empty( $materials ) ) {
			update_field(
				'shaft_materials',
				array(
					array( 'name' => 'Thép các bon và thép các bon măng gan', 'name_en' => 'Carbon steel and carbon-manganese steel', 'note' => '', 'note_en' => '', 'k3' => 119.7 ),
					array( 'name' => 'Thép không rỉ 316', 'name_en' => 'Stainless steel 316', 'note' => '', 'note_en' => '', 'k3' => 98.8 ),
					array( 'name' => 'Thép không rỉ 431', 'name_en' => 'Stainless steel 431', 'note' => '', 'note_en' => '', 'k3' => 89.3 ),
					array( 'name' => 'Đồng măng gan', 'name_en' => 'Manganese bronze', 'note' => '', 'note_en' => '', 'k3' => 87.4 ),
					array( 'name' => 'Đồng nhôm nikken / Hợp kim đồng nikken K400', 'name_en' => 'Nickel-aluminium bronze / Nickel copper alloy K400', 'note' => '', 'note_en' => '', 'k3' => 80.7 ),
					array( 'name' => 'Hợp kim đồng nikken K500', 'name_en' => 'Nickel copper alloy K500', 'note' => '', 'note_en' => '', 'k3' => 67.5 ),
					array( 'name' => 'L<15m', 'name_en' => 'L<15m', 'note' => '', 'note_en' => '', 'k3' => 100 ),
				),
				'option'
			);
		}

		update_option( 'starter_flexible_tools_seeded', 1 );
	}
}
add_action( 'acf/init', 'starter_flexible_seed_site_settings_tool_data', 20 );

/**
 * Read one Site Settings value, with a fallback when ACF is absent.
 *
 * @param string $name    Field name.
 * @param mixed  $default Value returned when the field is empty.
 * @return mixed
 */
function starter_flexible_setting( string $name, $default = '' ) {
	if ( ! function_exists( 'get_field' ) ) {
		return $default;
	}

	$value = get_field( $name, 'option' );

	if ( function_exists( 'pll_current_language' ) && 'en' === pll_current_language( 'slug' ) ) {
		$english = array(
			'announcement_text' => 'The 2026 price list is now available',
			'announcement_cta'  => array( 'title' => 'View now!', 'url' => home_url( '/en/capabilities/' ), 'target' => '_self' ),
			'header_cta'        => array( 'title' => 'Contact', 'url' => home_url( '/en/contact/' ), 'target' => '_self' ),
			'mega_title'        => 'Services',
			'footer_cta'        => array( 'title' => 'Start a project', 'url' => home_url( '/en/contact/' ), 'target' => '_self' ),
			'address'           => 'No. 03 Tran Lu Street, Bac Nha Trang Ward, Khanh Hoa Province, Vietnam',
			'legal_name'        => 'LASAN MARINE COMPANY LIMITED',
			'legal_links'       => array(
				array( 'link' => array( 'title' => 'Privacy', 'url' => home_url( '/en/contact/' ), 'target' => '_self' ) ),
				array( 'link' => array( 'title' => 'Terms', 'url' => home_url( '/en/contact/' ), 'target' => '_self' ) ),
			),
		);
		if ( array_key_exists( $name, $english ) ) {
			$value = $english[ $name ];
		}
		if ( 'bank' === $name && is_array( $value ) ) {
			$value['holder'] = 'LASAN MARINE COMPANY LIMITED';
			$value['name']   = 'Techcombank – Ma Vong Branch';
		}
	}

	if ( null === $value || '' === $value || array() === $value ) {
		return $default;
	}

	return $value;
}

/**
 * The Machine List from Site Settings → Tools, for the Engine Lookup tool.
 *
 * @return array<int, array<string, mixed>>
 */
function starter_flexible_machines(): array {
	return (array) starter_flexible_setting( 'machines', array() );
}

/**
 * The Vật liệu trục chân vịt list from Site Settings → Tools, for the Shaft
 * Diameter tool. Picks the English name/note when Polylang is on the EN
 * locale, falling back to the Vietnamese text if no translation was entered.
 *
 * @return array<int, array{name: string, note: string, k3: float}>
 */
function starter_flexible_shaft_materials(): array {
	$rows = (array) starter_flexible_setting( 'shaft_materials', array() );
	$is_en = function_exists( 'pll_current_language' ) && 'en' === pll_current_language( 'slug' );

	$materials = array();
	foreach ( $rows as $row ) {
		$name = $is_en && ! empty( $row['name_en'] ) ? (string) $row['name_en'] : (string) ( $row['name'] ?? '' );
		if ( '' === trim( $name ) ) {
			continue;
		}
		$note = $is_en && ! empty( $row['note_en'] ) ? (string) $row['note_en'] : (string) ( $row['note'] ?? '' );
		$materials[] = array(
			'name' => $name,
			'note' => $note,
			'k3'   => isset( $row['k3'] ) ? (float) $row['k3'] : 0.0,
		);
	}

	return $materials;
}

/**
 * Normalise an ACF link field into url / label / target.
 *
 * @param mixed $link Raw link value.
 * @return array<string, string>
 */
function starter_flexible_link( $link ): array {
	$link = is_array( $link ) ? $link : array();

	return array(
		'url'    => isset( $link['url'] ) ? (string) $link['url'] : '',
		'label'  => isset( $link['title'] ) ? (string) $link['title'] : '',
		'target' => ! empty( $link['target'] ) ? (string) $link['target'] : '_self',
	);
}
