<?php
/**
 * Idempotent Astro Vietnamese-content importer for the local WordPress site.
 *
 * Run from the WordPress root:
 * php tools/import-lasan-content.php
 */

declare(strict_types=1);

$wp_load = dirname(__DIR__) . '/wp-load.php';
if ( ! is_file( $wp_load ) ) {
	fwrite( STDERR, "Cannot locate wp-load.php\n" );
	exit( 1 );
}
require_once $wp_load;

$theme_dir = get_stylesheet_directory();
$json_file = $theme_dir . '/inc/content/vi.json';
$data      = json_decode( (string) file_get_contents( $json_file ), true );
if ( ! is_array( $data ) ) {
	fwrite( STDERR, "Invalid Vietnamese content snapshot\n" );
	exit( 1 );
}

function lasan_link( array $link ): array {
	return array(
		'url'    => home_url( (string) ( $link['href'] ?? '/' ) ),
		'title'  => (string) ( $link['label'] ?? '' ),
		'target' => '_self',
	);
}

function lasan_rows( array $values, string $key = 'text' ): array {
	return array_map( static fn( $value ): array => array( $key => (string) $value ), $values );
}

/**
 * Top-level ACF field definitions for a block, read from blocks/<slug>/<slug>.json.
 *
 * @return array<int, array<string, mixed>>
 */
function lasan_block_field_defs( string $slug ): array {
	static $cache = array();
	if ( isset( $cache[ $slug ] ) ) {
		return $cache[ $slug ];
	}
	$file = get_stylesheet_directory() . "/blocks/{$slug}/{$slug}.json";
	$json = is_file( $file ) ? json_decode( (string) file_get_contents( $file ), true ) : null;

	return $cache[ $slug ] = ( is_array( $json ) && ! empty( $json['fields'] ) && is_array( $json['fields'] ) )
		? $json['fields']
		: array();
}

/**
 * Recursively flatten a nested value array into ACF's block-data / post-meta
 * shape: every field emits `path => value` plus `_path => field_key`, repeaters
 * emit a row count and per-row keys. Without the `_key` pointers the block
 * editor cannot map stored values back to fields and wipes them on first save.
 *
 * @param array<string, mixed> $out
 * @param array<string, mixed> $values
 * @param array<int, array<string, mixed>> $defs
 */
function lasan_acf_fill( array &$out, string $prefix, array $values, array $defs ): void {
	foreach ( $defs as $def ) {
		$name = (string) ( $def['name'] ?? '' );
		$key  = (string) ( $def['key'] ?? '' );
		$type = (string) ( $def['type'] ?? '' );

		if ( '' === $name || '' === $key || 'tab' === $type || 'message' === $type ) {
			continue;
		}
		if ( ! array_key_exists( $name, $values ) ) {
			continue;
		}

		$value = $values[ $name ];
		$path  = $prefix . $name;
		$subs  = ( isset( $def['sub_fields'] ) && is_array( $def['sub_fields'] ) ) ? $def['sub_fields'] : array();

		if ( 'repeater' === $type ) {
			$rows = is_array( $value ) ? array_values( $value ) : array();
			$out[ $path ]        = count( $rows );
			$out[ '_' . $path ]  = $key;
			foreach ( $rows as $i => $row ) {
				if ( is_array( $row ) ) {
					lasan_acf_fill( $out, $path . '_' . $i . '_', $row, $subs );
				}
			}
			continue;
		}

		if ( 'group' === $type ) {
			$out[ '_' . $path ] = $key;
			if ( is_array( $value ) ) {
				lasan_acf_fill( $out, $path . '_', $value, $subs );
			}
			continue;
		}

		$out[ $path ]       = $value;
		$out[ '_' . $path ] = $key;
	}
}

/** Build an ACF-editor-compatible `data` attribute for a block. */
function lasan_acf_block_data( string $slug, array $fields ): array {
	$defs = lasan_block_field_defs( $slug );
	if ( ! $defs ) {
		return $fields; // Unknown block — leave the raw shape untouched.
	}
	$out = array();
	lasan_acf_fill( $out, '', $fields, $defs );

	return $out;
}

function lasan_block( string $slug, array $fields, array $inner_blocks = array() ): array {
	$attrs = array(
		'name' => 'acf/' . $slug,
		'data' => lasan_acf_block_data( $slug, $fields ),
		'mode' => 'preview',
	);

	return array(
		'blockName'    => 'acf/' . $slug,
		'attrs'        => $attrs,
		'innerBlocks'  => $inner_blocks,
		'innerHTML'    => '',
		'innerContent' => $inner_blocks ? array( null ) : array(),
	);
}

function lasan_page_content( array $blocks ): string {
	return implode( "\n\n", array_map( 'serialize_block', $blocks ) );
}

function lasan_capabilities( array $items ): array {
	return array_map(
		static function ( array $item, int $position ): array {
			return array(
				'index'    => str_pad( (string) ( $position + 1 ), 2, '0', STR_PAD_LEFT ),
				'icon'     => (string) ( $item['icon'] ?? 'ship' ),
				'name'     => (string) ( $item['name'] ?? '' ),
				'desc'     => (string) ( $item['desc'] ?? '' ),
				'link'     => lasan_link( array( 'label' => $item['name'] ?? '', 'href' => $item['href'] ?? '#' ) ),
				'children' => array_map( static fn( array $child ): array => array( 'name' => (string) ( $child['name'] ?? '' ) ), (array) ( $item['children'] ?? array() ) ),
			);
		},
		$items,
		array_keys( $items )
	);
}

function lasan_contact_block( array $data ): array {
	$contact = $data['home']['contact'];
	return lasan_block(
		'contact-statement',
		array(
			'label'   => 'LIÊN HỆ',
			'heading' => (string) $contact['heading'],
			'phone'   => (string) $data['site']['phone'],
			'email'   => (string) $data['site']['email'],
			'cta'     => lasan_link( $contact['cta'] ),
		)
	);
}

function lasan_page_hero( array $hero ): array {
	return lasan_block(
		'page-hero',
		array(
			'headline'      => (string) ( $hero['headline'] ?? '' ),
			'lead'          => (string) ( $hero['lead'] ?? '' ),
			'placeholder'   => (string) ( $hero['placeholder'] ?? '' ),
			'heading_level' => 'h1',
		)
	);
}

function lasan_enquiry( array $form, string $label = 'GỬI YÊU CẦU' ): array {
	$fields = (array) ( $form['fields'] ?? array() );
	return lasan_block(
		'enquiry-form',
		array(
			'label'   => $label,
			'heading' => (string) ( $form['heading'] ?? '' ),
			'note'    => (string) ( $form['note'] ?? '' ),
			'fields'  => array(
				'name'        => (string) ( $fields['name'] ?? '' ),
				'company'     => (string) ( $fields['company'] ?? '' ),
				'email'       => (string) ( $fields['email'] ?? '' ),
				'phone'       => (string) ( $fields['phone'] ?? '' ),
				'interest'    => (string) ( $fields['interest'] ?? $fields['role'] ?? '' ),
				'message'     => (string) ( $fields['message'] ?? '' ),
				'attach'      => (string) ( $fields['attach'] ?? '' ),
				'attach_hint' => (string) ( $fields['attachHint'] ?? '' ),
				'submit'      => (string) ( $fields['submit'] ?? '' ),
			),
			'choices'    => lasan_rows( (array) ( $form['interests'] ?? array() ) ),
			'error_text' => 'Vui lòng điền đầy đủ các trường bắt buộc.',
			'toast_text' => (string) ( $form['success'] ?? 'Đã gửi yêu cầu' ),
		)
	);
}

$caps         = lasan_capabilities( $data['capabilities'] );
$home         = $data['home'];
$about        = $data['about'];
$cap_page     = $data['capabilitiesPage'];
$projects     = $data['projects'];
$insights     = $data['insights'];
$careers      = $data['careers'];
$contact      = $data['contact'];
$tools        = $data['tools'];
$contact_block = lasan_contact_block( $data );

/** Import the Astro insight cards as editable native WordPress posts. */
$blog_term = term_exists( 'bai-viet', 'category' );
if ( ! $blog_term ) {
	$blog_term = wp_insert_term( 'Bài viết', 'category', array( 'slug' => 'bai-viet' ) );
}
$blog_term_id = is_array( $blog_term ) ? (int) $blog_term['term_id'] : (int) $blog_term;
$source_posts = array_merge( array( array_merge( $insights['featured'], array( 'featured' => true ) ) ), $insights['articles'] );
$sample_post_bodies = array(
	0 => '<p>Chuyển hoán nghề không chỉ là thay thiết bị khai thác trên boong. Khối lượng, vị trí đặt máy móc và cách vận hành mới đều có thể làm thay đổi trọng tâm, ổn định và tải trọng cục bộ của tàu.</p><h2>Bắt đầu từ hiện trạng chính xác</h2><p>Hồ sơ nên bắt đầu bằng khảo sát kích thước, mớn nước, két, khoang và toàn bộ thiết bị hiện hữu. Các khối lượng tháo bỏ hoặc lắp mới phải được ghi nhận cùng tọa độ để cập nhật bảng trọng lượng.</p><ul><li>Kiểm tra bố trí chung và lối thoát.</li><li>Xác định khối lượng tời, cần, tang lưới và ngư cụ.</li><li>Đo lại mớn nước và xác nhận trạng thái tải khảo sát.</li></ul><h2>Tính lại ổn định và kết cấu</h2><p>Khi trọng tâm đứng KG tăng, cánh tay đòn phục hồi có thể giảm rõ rệt. Bên cạnh thông báo ổn định, vùng đặt tời và thiết bị nghề cần được kiểm tra tải tập trung, liên kết chân đế và đường truyền lực xuống kết cấu chính.</p><blockquote>Phương án tốt là phương án chứng minh được bằng số liệu, không chỉ vừa trên bản vẽ bố trí.</blockquote><h2>Hồ sơ trình thẩm định</h2><p>Bộ hồ sơ thường gồm bố trí chung sau chuyển đổi, bảng trọng lượng, tính ổn định, bản vẽ gia cường và thuyết minh vận hành. Phạm vi cuối cùng phụ thuộc loại tàu, vùng hoạt động và yêu cầu của cơ quan đăng kiểm.</p>',
	1 => '<p>Tuyến hình quyết định phần lớn sức cản của thân tàu, nhưng hiệu quả nhiên liệu chỉ xuất hiện khi hình dáng thân, lượng chiếm nước, chân vịt và chế độ khai thác được xem xét cùng nhau.</p><h2>Không tối ưu một thông số riêng lẻ</h2><p>Giảm diện tích mặt ướt có thể có lợi ở một dải tốc độ nhưng lại ảnh hưởng thể tích khoang hoặc ổn định. Vì vậy phương án cần được so sánh trên cùng tải trọng, mớn nước và tốc độ khai thác.</p><ul><li>Kiểm tra hệ số béo thể tích và phân bố lượng chiếm nước.</li><li>Giữ chuyển tiếp đường nước và sườn hình trơn.</li><li>Đánh giá độ chúi ở các trạng thái tải chính.</li></ul><h2>Ghép thân tàu với hệ động lực</h2><p>Đường kính, bước chân vịt và vòng quay làm việc cần phù hợp với đặc tính động cơ. Một tuyến hình tốt nhưng chân vịt làm việc ngoài vùng hiệu suất vẫn dẫn tới tiêu hao nhiên liệu cao.</p><h2>Xác nhận bằng dữ liệu vận hành</h2><p>Sau khi tàu chạy thử, nên lưu tốc độ, vòng quay, tải máy, mớn nước và điều kiện sóng gió. Dữ liệu này giúp hiệu chỉnh dự báo và làm cơ sở cho những thiết kế tiếp theo.</p>',
	2 => '<p>Hồ sơ kỹ thuật tàu cá vỏ thép là chuỗi tài liệu liên kết với nhau. Một thay đổi ở bố trí chung có thể kéo theo cập nhật kết cấu, tải trọng, ổn định và hệ thống máy.</p><h2>Nhóm bản vẽ nền tảng</h2><ul><li>Tuyến hình, bố trí chung và mặt cắt ngang.</li><li>Kết cấu cơ bản, tôn bao và các cơ cấu chính.</li><li>Bố trí buồng máy, hệ trục và chân vịt.</li><li>Các hệ thống ống, điện, cứu sinh và phòng cháy.</li></ul><h2>Thuyết minh tính toán</h2><p>Các bảng tính cần dùng thống nhất kích thước, vật liệu và tải trọng với bản vẽ. Đặc biệt, bảng trọng lượng phải khớp với trạng thái tải trong thông báo ổn định.</p><h2>Kiểm soát phiên bản</h2><p>Mỗi lần phản hồi thẩm định nên có bảng theo dõi ý kiến, số hiệu bản vẽ và ngày sửa đổi. Cách làm này giảm nguy cơ dùng nhầm bản cũ tại xưởng và rút ngắn thời gian đóng hồ sơ.</p>',
	3 => '<p>Thông báo ổn định mô tả giới hạn tải an toàn của tàu. Người vận hành cần hiểu các trạng thái tải mẫu và biết cách đối chiếu với tình trạng thực tế trước khi rời bến.</p><h2>Những đại lượng cần đọc</h2><p>Lượng chiếm nước, KG, GM, mớn nước và độ chúi là nhóm thông số đầu tiên. Chúng cho biết tàu đang nặng bao nhiêu, trọng tâm ở đâu và biên ổn định ban đầu còn lại thế nào.</p><ul><li>Không tự ý cộng tải lên cao mà không cập nhật KG.</li><li>Kiểm tra ảnh hưởng mặt thoáng của két chưa đầy.</li><li>Duy trì mạn khô và tầm nhìn theo hồ sơ được duyệt.</li></ul><h2>Thông báo ổn định không thay thế thao tác an toàn</h2><p>Các trạng thái mẫu không thể bao phủ mọi tình huống trên biển. Thuyền trưởng vẫn phải xét thời tiết, nước tràn boong, ngư cụ treo ngoài mạn và sự dịch chuyển của hàng hoặc sản phẩm khai thác.</p>',
	4 => '<p>Đóng mới và hoán cải cần được so sánh trên toàn bộ vòng đời, thay vì chỉ nhìn chi phí đầu tư ban đầu. Phương án rẻ hơn lúc ký hợp đồng có thể phát sinh nhiều giới hạn trong khai thác.</p><h2>Khi hoán cải có lợi</h2><p>Hoán cải phù hợp khi thân vỏ còn tốt, kích thước chính đáp ứng công năng mới và phạm vi thay đổi không làm phát sinh quá nhiều gia cường. Thời gian dừng khai thác thường ngắn hơn đóng mới.</p><h2>Khi nên đóng mới</h2><p>Nếu phải thay đổi lớn về tải trọng, vùng hoạt động, hệ động lực hoặc bố trí khoang, đóng mới cho phép tối ưu đồng bộ và tránh bị ràng buộc bởi kết cấu cũ.</p><h2>Các khoản cần đưa vào so sánh</h2><ul><li>Khảo sát, thiết kế và thẩm định.</li><li>Vật tư, nhân công và thời gian nằm xưởng.</li><li>Mức tiêu hao nhiên liệu sau bàn giao.</li><li>Tuổi thọ còn lại và chi phí bảo trì.</li></ul>',
	5 => '<p>Nâng công suất máy chính làm tăng mô-men, lực đẩy và tải động truyền vào kết cấu bệ máy. Việc kiểm tra không nên dừng ở kích thước bu-lông hoặc bản đệm.</p><h2>Xác định đường truyền lực</h2><p>Tải từ chân máy đi qua bản mặt, mã, sườn và đà dọc trước khi phân tán vào thân tàu. Mỗi liên kết trên đường truyền lực cần đủ độ cứng và tránh thay đổi tiết diện đột ngột.</p><ul><li>Kiểm tra chiều dày bản mặt và bản thành.</li><li>Đối chiếu vị trí chân máy với đà dọc.</li><li>Kiểm tra mã liên kết và chiều dài đường hàn.</li><li>Đánh giá khoảng hở tháo lắp và căn chỉnh trục.</li></ul><h2>Đừng bỏ qua dao động</h2><p>Kết cấu đủ bền tĩnh vẫn có thể rung nếu tần số riêng gần tần số kích thích của động cơ. Khi thay máy, cần so sánh số xy-lanh, dải vòng quay và sơ đồ gối đỡ với cấu hình cũ.</p>',
	6 => '<p>Mở rộng vùng hoạt động từ VR-SI sang VR-SB làm thay đổi điều kiện môi trường thiết kế và yêu cầu an toàn. Hồ sơ cần chứng minh phương tiện đáp ứng vùng nước có mức độ sóng gió cao hơn.</p><h2>Khảo sát và xác định phạm vi</h2><p>Trước tiên cần rà soát hồ sơ hiện có, tình trạng thân vỏ, máy, trang thiết bị và các hạn chế đang ghi trên giấy chứng nhận. Kết quả khảo sát quyết định phần tính toán và cải tạo cần thực hiện.</p><h2>Các nội dung thường phải kiểm tra lại</h2><ul><li>Sức bền thân tàu và chiều dày còn lại.</li><li>Ổn định nguyên vẹn ở các trạng thái khai thác.</li><li>Mạn khô, tính kín nước và cửa đóng kín thời tiết.</li><li>Trang bị cứu sinh, thông tin liên lạc và phòng cháy.</li></ul><h2>Trình tự thực hiện</h2><p>Phương án nên được trao đổi với đơn vị đăng kiểm trước khi thi công. Sau khi hồ sơ được thống nhất, xưởng thực hiện cải tạo, thử nghiệm và hoàn tất kiểm tra để cập nhật vùng hoạt động trên giấy chứng nhận.</p>',
);
foreach ( $source_posts as $index => $source_post ) {
	$title = (string) $source_post['title'];
	$meta_key = 'insight_' . md5( $title );
	$matched = get_posts( array( 'post_type' => 'post', 'post_status' => 'any', 'posts_per_page' => 1, 'meta_key' => '_lasan_content_key', 'meta_value' => $meta_key ) );
	$date_text = (string) ( $source_post['date'] ?? '' );
	if ( preg_match( '/([0-9]{2})\.([0-9]{2})\.([0-9]{4})/', $date_text, $date_match ) ) {
		$post_date = sprintf( '%s-%s-%s 09:00:00', $date_match[3], $date_match[2], $date_match[1] );
	} else {
		$post_date = current_time( 'mysql' );
	}
	$category_name = (string) ( $source_post['kind'] ?? '' );
	if ( ! $category_name && false !== strpos( $date_text, ' · ' ) ) {
		$category_name = trim( explode( ' · ', $date_text )[0] );
	}
	$category_ids = array( $blog_term_id );
	if ( $category_name ) {
		$category_slug = sanitize_title( $category_name );
		$category_term = term_exists( $category_slug, 'category' );
		if ( ! $category_term ) {
			$category_term = wp_insert_term( $category_name, 'category', array( 'slug' => $category_slug, 'parent' => $blog_term_id ) );
		}
		if ( ! is_wp_error( $category_term ) ) {
			$category_ids[] = is_array( $category_term ) ? (int) $category_term['term_id'] : (int) $category_term;
		}
	}
	$excerpt = (string) ( $source_post['excerpt'] ?? '' );
	$post_id = wp_insert_post(
		wp_slash(
			array(
				'ID'            => $matched ? (int) $matched[0]->ID : 0,
				'post_type'     => 'post',
				'post_status'   => 'publish',
				'post_title'    => $title,
				'post_name'     => sanitize_title( $title ),
				'post_excerpt'  => $excerpt,
				'post_content'  => $sample_post_bodies[ $index ] ?? ( $excerpt ? wpautop( $excerpt ) : '' ),
				'post_date'     => $post_date,
				'post_date_gmt' => get_gmt_from_date( $post_date ),
				'post_category' => $category_ids,
			)
		),
		true
	);
	if ( is_wp_error( $post_id ) ) { throw new RuntimeException( $post_id->get_error_message() ); }
	update_post_meta( (int) $post_id, '_lasan_content_key', $meta_key );
	update_post_meta( (int) $post_id, '_lasan_featured_insight', ! empty( $source_post['featured'] ) ? '1' : '0' );
	update_post_meta( (int) $post_id, '_lasan_image_placeholder', (string) ( $source_post['placeholder'] ?? $title ) );
}

$manifesto = static fn( array $value ): array => lasan_block(
	'manifesto',
	array(
		'label'   => 'LASAN MARINE',
		'heading' => (string) ( $value['heading'] ?? '' ),
		'lead'    => (string) ( $value['lead'] ?? '' ),
		'body'    => lasan_rows( (array) ( $value['body'] ?? array() ) ),
		'cta'     => isset( $value['cta'] ) ? lasan_link( $value['cta'] ) : array(),
	)
);

$capability_block = lasan_block( 'capability-matrix', array( 'label' => 'NĂNG LỰC', 'heading' => 'Dịch vụ kỹ thuật.', 'items' => $caps ) );
$spotlight_block  = lasan_block(
	'service-spotlight',
	array(
		'label'       => 'DỊCH VỤ TIÊU BIỂU',
		'placeholder' => (string) ( $home['spotlight']['placeholder'] ?? '' ),
		'caption'     => (string) $home['spotlight']['caption'],
		'heading'     => (string) $home['spotlight']['heading'],
		'body'        => (string) $home['spotlight']['body'],
		'items'       => lasan_rows( $home['spotlight']['items'] ),
		'cta'         => lasan_link( $home['spotlight']['cta'] ),
	)
);

$service_arch = lasan_block(
	'service-architecture',
	array(
		'label'    => (string) $home['services']['caption'],
		'heading'  => (string) $home['services']['heading'],
		'caption'  => 'Dịch vụ',
		'view_all' => 'Xem tất cả dịch vụ',
		'view_all_link' => lasan_link( array( 'label' => 'Xem tất cả dịch vụ', 'href' => '/nang-luc/' ) ),
		'items'    => $caps,
	)
);

$geo = lasan_block( 'geo-operations', array( 'label' => 'PHẠM VI HOẠT ĐỘNG', 'heading' => $about['locations']['heading'], 'note' => $about['locations']['note'] ) );
$insights_block = lasan_block(
	'insights',
	array(
		'label'         => 'BÀI VIẾT',
		'view_all'      => 'Xem tất cả bài viết',
		'view_all_link' => lasan_link( array( 'label' => 'Xem tất cả bài viết', 'href' => '/tin-tuc/' ) ),
		'read_more'     => 'Đọc tiếp',
		'posts_per_page'=> 6,
	)
);

$pages = array();
$pages['home'] = array(
	'title' => 'Trang chủ', 'slug' => 'trang-chu', 'parent' => '', 'front' => true,
	'blocks' => array(
		lasan_block( 'hero', array( 'headline' => $home['hero']['headline'], 'headline_accent' => $home['hero']['headlineAccent'], 'headline_tail' => $home['hero']['headlineTail'], 'lead' => $home['hero']['lead'], 'primary' => lasan_link( $home['hero']['primary'] ), 'secondary' => lasan_link( $home['hero']['secondary'] ), 'heading_level' => 'h1' ) ),
		$manifesto( $home['manifesto'] ),
		lasan_block( 'key-numbers', array( 'label' => 'SỐ LIỆU', 'stats' => $home['stats'] ) ),
		$service_arch, $spotlight_block, $capability_block, $geo, $insights_block, $contact_block,
	),
);
$pages['about'] = array(
	'title' => 'Giới thiệu', 'slug' => 'gioi-thieu', 'parent' => '',
	'blocks' => array( lasan_page_hero( $about['hero'] ), $manifesto( array( 'heading' => $about['letter']['heading'], 'lead' => $about['letter']['signature'], 'body' => $about['letter']['body'] ) ), lasan_block( 'key-numbers', array( 'label' => 'SỐ LIỆU', 'stats' => $home['stats'] ) ), lasan_block( 'value-grid', array( 'label' => 'SƠ LƯỢC VỀ CÔNG TY', 'items' => $about['values'] ) ), lasan_block( 'process-timeline', array( 'label' => 'QUY TRÌNH', 'heading' => $about['process']['heading'], 'steps' => $about['process']['steps'] ) ), lasan_block( 'standards', array( 'label' => 'TIÊU CHUẨN', 'heading' => $about['standards']['heading'], 'items' => $about['standards']['items'], 'note' => $about['standards']['note'] ) ), $geo, lasan_block( 'team', array( 'label' => 'ĐỘI NGŨ', 'heading' => $about['team']['heading'], 'placeholder' => $about['team']['placeholder'], 'people' => $about['team']['people'] ) ), lasan_block( 'spec-list', array( 'label' => 'PHÁP LÝ', 'heading' => $about['legal']['heading'], 'rows' => $about['legal']['rows'], 'note' => $about['legal']['note'] ) ), $contact_block ),
);
$pages['capabilities'] = array(
	'title' => 'Năng lực', 'slug' => 'nang-luc', 'parent' => '',
	'blocks' => array( lasan_page_hero( $cap_page['hero'] ), $capability_block, $spotlight_block, lasan_block( 'spec-list', array( 'label' => 'PHẠM VI', 'heading' => $cap_page['specs']['heading'], 'note' => $cap_page['specs']['note'], 'rows' => $cap_page['specs']['rows'] ) ), lasan_block( 'document-center', array( 'label' => 'TÀI LIỆU', 'filters' => lasan_rows( $cap_page['documents']['filters'], 'name' ), 'items' => $cap_page['documents']['items'], 'empty_text' => 'Không có kết quả.' ) ), $contact_block ),
);

foreach ( $data['servicePages'] as $index => $service ) {
	$cap = $capabilities_by_index[ $index ];
	$blocks = array( lasan_page_hero( array( 'headline' => $cap['name'], 'lead' => $service['intro'] ) ) );
	if ( ! empty( $service['items'] ) ) $blocks[] = lasan_block( 'value-grid', array( 'label' => 'CÁC HẠNG MỤC', 'items' => array_map( static fn( array $row, int $i ): array => array( 'index' => str_pad( (string) ( $i + 1 ), 2, '0', STR_PAD_LEFT ), 'title' => $row['name'], 'desc' => $row['desc'] ), $service['items'], array_keys( $service['items'] ) ) ) );
	if ( '01' === $index ) $blocks[] = $spotlight_block;
	if ( ! empty( $service['specs'] ) ) $blocks[] = lasan_block( 'spec-list', array( 'label' => 'PHẠM VI', 'heading' => $service['specs']['heading'], 'rows' => $service['specs']['rows'] ) );
	if ( ! empty( $service['process'] ) ) $blocks[] = lasan_block( 'process-timeline', array( 'label' => 'QUY TRÌNH', 'heading' => $service['process']['heading'], 'steps' => $service['process']['steps'] ) );
	if ( ! empty( $service['standards'] ) ) $blocks[] = lasan_block( 'standards', array( 'label' => 'TIÊU CHUẨN', 'heading' => $about['standards']['heading'], 'items' => $about['standards']['items'], 'note' => $about['standards']['note'] ) );
	foreach ( $service['sections'] ?? array() as $section ) {
		if ( ! empty( $section['items'] ) ) $blocks[] = lasan_block( 'value-grid', array( 'label' => 'PHƯƠNG TIỆN THỦY NỘI ĐỊA', 'items' => array_map( static fn( array $row, int $i ): array => array( 'index' => str_pad( (string) ( $i + 1 ), 2, '0', STR_PAD_LEFT ), 'title' => $row['name'], 'desc' => $row['desc'] ), $section['items'], array_keys( $section['items'] ) ) ) );
		if ( ! empty( $section['specs'] ) ) $blocks[] = lasan_block( 'spec-list', array( 'label' => 'PHẠM VI', 'heading' => 'Phạm vi phương tiện thủy nội địa', 'rows' => $section['specs']['rows'] ) );
	}
	$blocks[] = $contact_block;
	$slugs = array( '01' => 'thiet-ke-tau', '03' => 'dich-vu-cntt' );
	$pages['service_' . $index] = array( 'title' => $cap['name'], 'slug' => $slugs[ $index ], 'parent' => 'capabilities', 'blocks' => $blocks );
}

$pages['projects'] = array( 'title' => 'Dự án', 'slug' => 'du-an', 'parent' => '', 'blocks' => array( lasan_page_hero( $projects['hero'] ), lasan_block( 'project-showcase', array( 'label' => 'DỰ ÁN TIÊU BIỂU', 'items' => $projects['showcase'] ) ), lasan_block( 'project-grid', array( 'label' => 'DỰ ÁN', 'items' => $projects['grid'] ) ), lasan_block( 'project-metrics', array( 'label' => 'THÔNG SỐ DỰ ÁN', 'rows' => $projects['metrics']['rows'], 'stats' => $projects['metrics']['stats'] ) ), lasan_block( 'image-story', array( 'label' => 'HÌNH ẢNH', 'items' => $projects['gallery']['items'], 'note' => $projects['gallery']['note'] ) ), $contact_block ) );
$pages['insights'] = array( 'title' => 'Tin tức', 'slug' => 'tin-tuc', 'parent' => '', 'blocks' => array( lasan_page_hero( $insights['hero'] ), $insights_block, lasan_block( 'document-center', array( 'label' => 'TÀI LIỆU KỸ THUẬT', 'filters' => lasan_rows( $cap_page['documents']['filters'], 'name' ), 'items' => $cap_page['documents']['items'], 'empty_text' => 'Không có kết quả.' ) ), $contact_block ) );
$pages['careers'] = array( 'title' => 'Tuyển dụng', 'slug' => 'tuyen-dung', 'parent' => '', 'blocks' => array( lasan_page_hero( $careers['hero'] ), lasan_block( 'value-grid', array( 'label' => 'CÁCH CHÚNG TÔI LÀM VIỆC', 'items' => $careers['values'] ) ), lasan_block( 'job-list', array( 'label' => 'VỊ TRÍ ĐANG TUYỂN', 'apply_link' => lasan_link( array( 'label' => 'Ứng tuyển', 'href' => '/lien-he/' ) ), 'items' => $careers['openings'] ) ), lasan_block( 'team', array( 'label' => 'ĐỘI NGŨ', 'heading' => $about['team']['heading'], 'placeholder' => $about['team']['placeholder'], 'people' => $about['team']['people'] ) ), lasan_enquiry( $careers['form'], 'ỨNG TUYỂN' ) ) );
$pages['contact'] = array( 'title' => 'Liên hệ', 'slug' => 'lien-he', 'parent' => '', 'blocks' => array( lasan_page_hero( $contact['hero'] ), lasan_block( 'value-grid', array( 'label' => 'ĐỊA ĐIỂM', 'items' => array_map( static fn( array $row, int $i ): array => array( 'index' => str_pad( (string) ( $i + 1 ), 2, '0', STR_PAD_LEFT ), 'title' => $row['name'], 'desc' => $row['address'] . ' — ' . $row['meta'] ), $contact['offices'], array_keys( $contact['offices'] ) ) ) ), lasan_enquiry( $contact['form'] ), $contact_block ) );

$tool_cards = array();
foreach ( array( 'power', 'shaft', 'engine' ) as $i => $key ) $tool_cards[] = array( 'index' => str_pad( (string) ( $i + 1 ), 2, '0', STR_PAD_LEFT ), 'title' => $tools[ $key ]['headline'], 'desc' => $tools[ $key ]['description'] );
$pages['tools'] = array( 'title' => 'Công cụ', 'slug' => 'cong-cu', 'parent' => '', 'blocks' => array( lasan_page_hero( $tools['index'] ), lasan_block( 'value-grid', array( 'label' => 'CÔNG CỤ', 'items' => $tool_cards ) ), $contact_block ) );

$tool_configs = array(
	'power' => lasan_block( 'power-converter', array( 'input_label' => $tools['power']['inputLabel'], 'unit_label' => $tools['power']['unitLabel'], 'units' => $tools['power']['units'], 'reset_label' => 'Đặt lại' ) ),
	'shaft' => lasan_block( 'shaft-diameter', array( 'label_power' => $tools['shaft']['fields']['power'], 'label_rpm' => $tools['shaft']['fields']['rpm'], 'label_material' => $tools['shaft']['fields']['material'], 'result_label' => $tools['shaft']['resultLabel'], 'materials' => $tools['shaft']['materials'], 'reset_label' => 'Đặt lại', 'error_text' => 'Nhập công suất và vòng quay lớn hơn 0.' ) ),
	'engine' => lasan_block( 'engine-lookup', array( 'per_page' => $tools['engine']['perPage'], 'columns' => array_combine( array( 'make', 'model', 'kw', 'rpm', 'cylinders' ), $tools['engine']['columns'] ), 'labels' => array( 'search' => 'TÌM KIẾM', 'all_makes' => 'Tất cả hãng', 'min_power' => 'CÔNG SUẤT TỐI THIỂU (kW)', 'rows_found' => 'kết quả', 'no_results' => 'Không có kết quả.' ) ) ),
);
$tool_slugs = array( 'power' => 'chuyen-doi-cong-suat', 'shaft' => 'kiem-tra-duong-kinh-truc-chan-vit', 'engine' => 'tra-cuu-dong-co' );
foreach ( $tool_configs as $key => $calculator ) {
	$tool = $tools[ $key ];
	$shell = lasan_block( 'tool-shell', array( 'label' => $tool['label'], 'heading' => 'Nhập thông số', 'lead' => $tool['lead'], 'note' => $tool['note'] ?? '' ), array( $calculator ) );
	$pages['tool_' . $key] = array( 'title' => $tool['headline'], 'slug' => $tool_slugs[ $key ], 'parent' => 'tools', 'blocks' => array( lasan_page_hero( $tool ), $shell, $contact_block ) );
}

$seo = array(
	'home'         => array( $home['title'], $home['description'] ),
	'about'        => array( $about['title'], $about['description'] ),
	'capabilities' => array( $cap_page['title'], $cap_page['description'] ),
	'projects'     => array( $projects['title'], $projects['description'] ),
	'insights'     => array( $insights['title'], $insights['description'] ),
	'careers'      => array( $careers['title'], $careers['description'] ),
	'contact'      => array( $contact['title'], $contact['description'] ),
	'tools'        => array( $tools['index']['title'], $tools['index']['description'] ),
);
foreach ( $data['servicePages'] as $index => $service ) {
	$cap = $capabilities_by_index[ $index ];
	$seo['service_' . $index] = array( $cap['name'] . ' | Lasan Marine', $service['intro'] );
}
foreach ( array( 'power', 'shaft', 'engine' ) as $key ) {
	$seo['tool_' . $key] = array( $tools[ $key ]['title'], $tools[ $key ]['description'] );
}

$page_ids = array();
foreach ( $pages as $key => $page ) {
	$matched = get_posts(
		array(
			'post_type'      => 'page',
			'post_status'    => 'any',
			'posts_per_page' => 1,
			'meta_key'       => '_lasan_content_key',
			'meta_value'     => $key,
		)
	);
	$existing = $matched ? $matched[0] : get_page_by_path( (string) $page['slug'], OBJECT, 'page' );
	if ( ! $existing ) {
		$candidates = get_posts( array( 'post_type' => 'page', 'post_status' => 'any', 'posts_per_page' => -1, 'orderby' => 'ID', 'order' => 'ASC' ) );
		foreach ( $candidates as $candidate ) {
			if ( preg_match( '/^' . preg_quote( (string) $page['slug'], '/' ) . '(?:-[0-9]+)?$/', $candidate->post_name ) ) {
				$existing = $candidate;
				break;
			}
		}
	}
	$postarr  = array( 'ID' => $existing ? (int) $existing->ID : 0, 'post_type' => 'page', 'post_status' => 'publish', 'post_title' => $page['title'], 'post_name' => $page['slug'], 'post_excerpt' => $seo[ $key ][1] ?? '', 'post_content' => lasan_page_content( $page['blocks'] ), 'post_parent' => 0 );
	$id = wp_insert_post( wp_slash( $postarr ), true );
	if ( is_wp_error( $id ) ) throw new RuntimeException( $id->get_error_message() );
	$page_ids[ $key ] = (int) $id;
	update_post_meta( (int) $id, '_lasan_content_key', $key );
	update_post_meta( (int) $id, '_lasan_meta_title', $seo[ $key ][0] ?? $page['title'] );
	update_post_meta( (int) $id, '_lasan_meta_description', $seo[ $key ][1] ?? '' );
}
foreach ( $pages as $key => $page ) if ( $page['parent'] ) wp_update_post( array( 'ID' => $page_ids[ $key ], 'post_parent' => $page_ids[ $page['parent'] ] ) );

update_option( 'show_on_front', 'page' );
update_option( 'page_on_front', $page_ids['home'] );
update_option( 'blogname', $data['site']['name'] );
update_option( 'permalink_structure', '/%postname%/' );
foreach ( array( 'site_name' => 'name', 'legal_name' => 'legalName', 'tax_code' => 'taxCode', 'address' => 'address', 'phone' => 'phone', 'email' => 'email', 'maps_api_key' => 'mapsApiKey' ) as $field => $source ) update_field( $field, $data['site'][ $source ] ?? '', 'option' );
update_field( 'announcement_text', $data['announcement']['text'], 'option' );
update_field( 'announcement_cta', lasan_link( $data['announcement']['cta'] ), 'option' );
update_field( 'header_cta', lasan_link( array( 'label' => 'Liên hệ', 'href' => '/lien-he/' ) ), 'option' );
update_field( 'mega_title', 'Dịch vụ', 'option' );
update_field( 'wordmark', 'ENGINEERING|TOMORROW’S|OCEANS', 'option' );
update_field( 'footer_cta', lasan_link( array( 'label' => 'Bắt đầu dự án', 'href' => '/lien-he/' ) ), 'option' );
update_field( 'bank', $data['site']['bank'], 'option' );
update_field( 'social', array_map( static fn( array $row ): array => array( 'link' => lasan_link( $row ) ), $data['site']['social'] ), 'option' );
update_field(
	'legal_links',
	array(
		array( 'link' => lasan_link( array( 'label' => 'Bảo mật', 'href' => '/lien-he/' ) ) ),
		array( 'link' => lasan_link( array( 'label' => 'Điều khoản', 'href' => '/lien-he/' ) ) ),
	),
	'option'
);

function lasan_import_menu( string $name, array $items, string $location, array $page_ids ): void {
	$menu = wp_get_nav_menu_object( $name );
	$menu_id = $menu ? (int) $menu->term_id : (int) wp_create_nav_menu( $name );
	foreach ( wp_get_nav_menu_items( $menu_id ) ?: array() as $item ) wp_delete_post( (int) $item->ID, true );
	$path_map = array( '/gioi-thieu/' => 'about', '/nang-luc/' => 'capabilities', '/du-an/' => 'projects', '/tin-tuc/' => 'insights', '/cong-cu/' => 'tools', '/nang-luc/thiet-ke-tau/' => 'service_01' );
	foreach ( $items as $item ) {
		$key = $path_map[ $item['href'] ] ?? '';
		$args = array( 'menu-item-title' => $item['label'], 'menu-item-status' => 'publish', 'menu-item-type' => $key ? 'post_type' : 'custom', 'menu-item-object' => $key ? 'page' : '', 'menu-item-object-id' => $key ? $page_ids[ $key ] : 0, 'menu-item-url' => $key ? '' : home_url( $item['href'] ) );
		$id = wp_update_nav_menu_item( $menu_id, 0, $args );
		if ( ! empty( $item['mega'] ) && ! is_wp_error( $id ) ) {
			update_post_meta( $id, '_menu_item_classes', array( 'has-mega' ) );
			foreach ( array( 'service_01', 'service_03' ) as $child_key ) wp_update_nav_menu_item( $menu_id, 0, array( 'menu-item-title' => get_the_title( $page_ids[ $child_key ] ), 'menu-item-status' => 'publish', 'menu-item-type' => 'post_type', 'menu-item-object' => 'page', 'menu-item-object-id' => $page_ids[ $child_key ], 'menu-item-parent-id' => $id ) );
		}
	}
	$locations = get_theme_mod( 'nav_menu_locations', array() );
	$locations[ $location ] = $menu_id;
	set_theme_mod( 'nav_menu_locations', $locations );

	// Polylang stores a separate menu ID per theme/location/language and filters
	// the ordinary nav_menu_locations value on the front end. Imports do not go
	// through the Appearance > Menus request that normally populates this map.
	if ( function_exists( 'PLL' ) && isset( PLL()->options ) ) {
		$menu_language = (string) PLL()->options->get( 'default_lang' );
		if ( '' !== $menu_language ) {
			$nav_menus = (array) PLL()->options->get( 'nav_menus' );
			$nav_menus[ get_stylesheet() ][ $location ][ $menu_language ] = $menu_id;
			PLL()->options->set( 'nav_menus', $nav_menus );
		}
	}
}
lasan_import_menu( 'LASAN Header', $data['nav'], 'header_menu', $page_ids );
lasan_import_menu( 'LASAN Footer', $data['footerNav'], 'footer_menu', $page_ids );
flush_rewrite_rules();

echo 'Imported ' . count( $page_ids ) . " Vietnamese pages, 7 posts, navigation and site settings.\n";
