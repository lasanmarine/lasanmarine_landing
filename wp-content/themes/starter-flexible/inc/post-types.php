<?php
/**
 * Custom post types.
 *
 * Projects are their own post type rather than repeater rows on a page: each
 * vessel has a spec sheet, photographs and a page of its own, and the same
 * record is listed from several places.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The Projects post type plus the two axes every vessel is filed under.
 *
 * `has_archive` is off on purpose: the curated /du-an/ page is the index, and
 * it lists projects through the Project Index block.
 */
function starter_flexible_register_project_post_type(): void {
	register_post_type(
		'project',
		array(
			'labels'        => array(
				'name'               => __( 'Dự án', 'starter-flexible' ),
				'singular_name'      => __( 'Dự án', 'starter-flexible' ),
				'add_new'            => __( 'Thêm dự án', 'starter-flexible' ),
				'add_new_item'       => __( 'Thêm dự án mới', 'starter-flexible' ),
				'edit_item'          => __( 'Sửa dự án', 'starter-flexible' ),
				'new_item'           => __( 'Dự án mới', 'starter-flexible' ),
				'view_item'          => __( 'Xem dự án', 'starter-flexible' ),
				'search_items'       => __( 'Tìm dự án', 'starter-flexible' ),
				'not_found'          => __( 'Chưa có dự án nào.', 'starter-flexible' ),
				'not_found_in_trash' => __( 'Không có dự án trong thùng rác.', 'starter-flexible' ),
				'all_items'          => __( 'Tất cả dự án', 'starter-flexible' ),
				'menu_name'          => __( 'Dự án', 'starter-flexible' ),
			),
			'public'        => true,
			'has_archive'   => false,
			'menu_icon'     => 'dashicons-visibility',
			'menu_position' => 21,
			'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes', 'revisions' ),
			'rewrite'       => array( 'slug' => 'du-an', 'with_front' => false ),
			'show_in_rest'  => true,
			'hierarchical'  => false,
		)
	);

	$shared = array(
		'public'            => true,
		'hierarchical'      => true,
		'show_admin_column' => true,
		'show_in_rest'      => true,
	);

	register_taxonomy(
		'project_material',
		'project',
		array_merge(
			$shared,
			array(
				'labels'  => array(
					'name'          => __( 'Vật liệu', 'starter-flexible' ),
					'singular_name' => __( 'Vật liệu', 'starter-flexible' ),
					'menu_name'     => __( 'Vật liệu', 'starter-flexible' ),
				),
				'rewrite' => array( 'slug' => 'vat-lieu', 'with_front' => false ),
			)
		)
	);

	register_taxonomy(
		'project_use',
		'project',
		array_merge(
			$shared,
			array(
				'labels'  => array(
					'name'          => __( 'Công dụng', 'starter-flexible' ),
					'singular_name' => __( 'Công dụng', 'starter-flexible' ),
					'menu_name'     => __( 'Công dụng', 'starter-flexible' ),
				),
				'rewrite' => array( 'slug' => 'cong-dung', 'with_front' => false ),
			)
		)
	);
}
add_action( 'init', 'starter_flexible_register_project_post_type' );

/**
 * Field groups that belong to post types rather than blocks, read from
 * inc/fields/*.json so the CLI and the editor share one definition.
 */
function starter_flexible_load_post_type_field_groups(): void {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	foreach ( (array) glob( __DIR__ . '/fields/*.json' ) as $file ) {
		$group = json_decode( (string) file_get_contents( (string) $file ), true );
		if ( is_array( $group ) && ! empty( $group['key'] ) ) {
			acf_add_local_field_group( $group );
		}
	}
}
add_action( 'acf/init', 'starter_flexible_load_post_type_field_groups' );

/**
 * Rewrite rules are only regenerated when the registered types change, so the
 * stored signature is compared on every load and flushed once when it moves.
 */
function starter_flexible_maybe_flush_rewrites(): void {
	$signature = 'project:du-an|vat-lieu|cong-dung:v1';
	if ( get_option( 'starter_flexible_rewrite_signature' ) === $signature ) {
		return;
	}
	flush_rewrite_rules( false );
	update_option( 'starter_flexible_rewrite_signature', $signature );
}
add_action( 'init', 'starter_flexible_maybe_flush_rewrites', 20 );

/**
 * One project prepared for a card: the fields every listing needs, already
 * formatted, so templates and blocks do not each re-implement the maths.
 *
 * @return array<string, mixed>
 */
function starter_flexible_project_card( WP_Post $post ): array {
	$field = static function ( string $name ) use ( $post ) {
		return function_exists( 'get_field' ) ? get_field( $name, $post->ID ) : get_post_meta( $post->ID, $name, true );
	};

	$number = static function ( $value, int $decimals = 2 ): string {
		return ( null === $value || '' === $value ) ? '' : number_format( (float) $value, $decimals, ',', '.' );
	};

	$dims = array_filter( array( $number( $field( 'lmax' ) ), $number( $field( 'bmax' ) ), $number( $field( 'depth' ) ) ) );
	$meta = array_filter(
		array(
			$dims ? implode( ' × ', $dims ) . ' m' : '',
			'' !== $number( $field( 'tonnage' ) ) ? $number( $field( 'tonnage' ) ) . ' T' : '',
			'' !== $number( $field( 'power_kw' ), 0 ) ? $number( $field( 'power_kw' ), 0 ) . ' kW' : '',
		)
	);

	$materials = wp_get_post_terms( $post->ID, 'project_material', array( 'fields' => 'names' ) );
	$uses      = wp_get_post_terms( $post->ID, 'project_use', array( 'fields' => 'names' ) );
	$tags      = array_merge( is_array( $materials ) ? $materials : array(), is_array( $uses ) ? $uses : array() );

	$image_id = (int) get_post_thumbnail_id( $post->ID );

	return array(
		'id'          => (int) $post->ID,
		'title'       => get_the_title( $post ),
		'url'         => (string) get_permalink( $post ),
		'image_url'   => $image_id ? (string) wp_get_attachment_image_url( $image_id, 'large' ) : '',
		'placeholder' => (string) ( $field( 'vessel_no' ) ?: get_the_title( $post ) ),
		'tag'         => implode( ' · ', $tags ),
		'meta'        => implode( ' · ', $meta ),
		'region'      => (string) $field( 'region' ),
		'location'    => (string) $field( 'location' ),
		'year'        => (string) $field( 'year' ),
		'status'      => (string) $field( 'status' ),
		'materials'   => array_values( (array) wp_get_post_terms( $post->ID, 'project_material', array( 'fields' => 'slugs' ) ) ),
		'uses'        => array_values( (array) wp_get_post_terms( $post->ID, 'project_use', array( 'fields' => 'slugs' ) ) ),
	);
}

/**
 * The spec sheet rows for one project, skipping whatever was left blank.
 *
 * @return array<int, array<string, string>>
 */
function starter_flexible_project_specs( int $post_id ): array {
	$field = static function ( string $name ) use ( $post_id ) {
		return function_exists( 'get_field' ) ? get_field( $name, $post_id ) : get_post_meta( $post_id, $name, true );
	};
	$number = static function ( $value, int $decimals = 2 ): string {
		return ( null === $value || '' === $value ) ? '' : number_format( (float) $value, $decimals, ',', '.' );
	};

	$materials = wp_get_post_terms( $post_id, 'project_material', array( 'fields' => 'names' ) );
	$uses      = wp_get_post_terms( $post_id, 'project_use', array( 'fields' => 'names' ) );

	$rows = array(
		array( 'label' => __( 'Tên tàu', 'starter-flexible' ), 'value' => (string) $field( 'vessel_name' ) ),
		array( 'label' => __( 'Số hiệu tàu', 'starter-flexible' ), 'value' => (string) $field( 'vessel_no' ) ),
		array( 'label' => __( 'Số ĐKHC / Số đăng kiểm', 'starter-flexible' ), 'value' => (string) $field( 'registry' ) ),
		array( 'label' => __( 'Loại thiết kế', 'starter-flexible' ), 'value' => (string) $field( 'design_type' ) ),
		array( 'label' => __( 'Vật liệu', 'starter-flexible' ), 'value' => is_array( $materials ) ? implode( ', ', $materials ) : '' ),
		array( 'label' => __( 'Công dụng', 'starter-flexible' ), 'value' => is_array( $uses ) ? implode( ', ', $uses ) : '' ),
		array( 'label' => __( 'Lmax', 'starter-flexible' ), 'value' => '' !== $number( $field( 'lmax' ) ) ? $number( $field( 'lmax' ) ) . ' m' : '' ),
		array( 'label' => __( 'Bmax', 'starter-flexible' ), 'value' => '' !== $number( $field( 'bmax' ) ) ? $number( $field( 'bmax' ) ) . ' m' : '' ),
		array( 'label' => __( 'Chiều cao mạn D', 'starter-flexible' ), 'value' => '' !== $number( $field( 'depth' ) ) ? $number( $field( 'depth' ) ) . ' m' : '' ),
		array( 'label' => __( 'Trọng tải', 'starter-flexible' ), 'value' => '' !== $number( $field( 'tonnage' ) ) ? $number( $field( 'tonnage' ) ) . ' T' : '' ),
		array( 'label' => __( 'Công suất máy chính', 'starter-flexible' ), 'value' => '' !== $number( $field( 'power_kw' ), 0 ) ? $number( $field( 'power_kw' ), 0 ) . ' kW' : '' ),
		array( 'label' => __( 'Vùng hoạt động', 'starter-flexible' ), 'value' => (string) $field( 'region' ) ),
		array( 'label' => __( 'Địa phương', 'starter-flexible' ), 'value' => (string) $field( 'location' ) ),
		array( 'label' => __( 'Năm thực hiện', 'starter-flexible' ), 'value' => (string) $field( 'year' ) ),
		array( 'label' => __( 'Trạng thái', 'starter-flexible' ), 'value' => (string) $field( 'status' ) ),
	);

	return array_values( array_filter( $rows, static fn( array $row ): bool => '' !== trim( $row['value'] ) ) );
}
