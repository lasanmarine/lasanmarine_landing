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

	if ( null === $value || '' === $value || array() === $value ) {
		return $default;
	}

	return $value;
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
