<?php
/**
 * Build the "All Blocks 2" QA page: the blocks added in the second pass —
 * section-intro, rich-text, image-text, accordion, use-case, input-output,
 * proof-strip, quote, cta-banner — each filled with sample content written for
 * that block rather than the generic "Mẫu <Label>" filler, so the page can be
 * reviewed as a layout and not only as a smoke test.
 *
 * Shares the field-walking logic with make-all-blocks-page.php; only the block
 * list and the sample copy differ.
 *
 * Idempotent: re-running updates the same page (matched by _lasan_content_key).
 *
 * Run from the WordPress root:
 *   php tools/make-all-blocks-page-2.php
 */

declare(strict_types=1);

$wp_load = dirname( __DIR__ ) . '/wp-load.php';
if ( ! is_file( $wp_load ) ) {
	fwrite( STDERR, "Cannot locate wp-load.php\n" );
	exit( 1 );
}
require_once $wp_load;

/** @return array<int, array<string, mixed>> */
function ab_field_defs( string $slug ): array {
	$file = get_stylesheet_directory() . "/blocks/{$slug}/{$slug}.json";
	$json = is_file( $file ) ? json_decode( (string) file_get_contents( $file ), true ) : null;

	return ( is_array( $json ) && ! empty( $json['fields'] ) && is_array( $json['fields'] ) ) ? $json['fields'] : array();
}

/** Synthesise a plausible value for one field definition. */
function ab_sample_value( array $def, int $row = 0 ) {
	$type  = (string) ( $def['type'] ?? '' );
	$label = (string) ( $def['label'] ?? ucfirst( (string) ( $def['name'] ?? 'Field' ) ) );
	$name  = (string) ( $def['name'] ?? '' );

	switch ( $type ) {
		case 'textarea':
		case 'wysiwyg':
			$text = "Nội dung mẫu cho {$label}. Đoạn văn ngắn để kiểm tra bố cục, khoảng cách và cách khối hiển thị trên trang.";
			return 'wysiwyg' === $type ? '<p>' . $text . '</p>' : $text;

		case 'number':
			if ( isset( $def['default_value'] ) && is_numeric( $def['default_value'] ) ) {
				return (int) $def['default_value'];
			}
			return in_array( $name, array( 'x', 'y' ), true ) ? ( 20 + $row * 12 ) : ( 4 + $row );

		case 'email':
			return 'lien-he@lasanmarine.vn';

		case 'select':
			if ( isset( $def['default_value'] ) && '' !== $def['default_value'] ) {
				return $def['default_value'];
			}
			$choices = isset( $def['choices'] ) && is_array( $def['choices'] ) ? array_keys( $def['choices'] ) : array();
			return $choices ? $choices[0] : '';

		case 'link':
			return array( 'title' => $label, 'url' => home_url( '/lien-he/' ), 'target' => '' );

		case 'image':
		case 'file':
			return ''; // Let the block fall back to its placeholder.

		case 'post_object':
		case 'taxonomy':
			return ''; // Empty -> block resolves its own default (latest posts, etc.).

		case 'true_false':
			return 1;

		case 'text':
		default:
			if ( isset( $def['default_value'] ) && '' !== $def['default_value'] ) {
				return (string) $def['default_value'];
			}
			// Short, index-ish values read better for the common repeater fields.
			if ( 'index' === $name ) {
				return str_pad( (string) ( $row + 1 ), 2, '0', STR_PAD_LEFT );
			}
			if ( in_array( $name, array( 'value', 'kw', 'strength', 'factor', 'span', 'year', 'rpm', 'size' ), true ) ) {
				return (string) ( 10 + $row * 5 );
			}
			if ( 'suffix' === $name ) {
				return '+';
			}
			return 0 === $row ? "Mẫu {$label}" : "Mẫu {$label} {$row}";
	}
}

/**
 * @param array<string, mixed> $out
 * @param array<int, array<string, mixed>> $defs
 */
function ab_fill( array &$out, string $prefix, array $defs, int $row = 0 ): void {
	foreach ( $defs as $def ) {
		$name = (string) ( $def['name'] ?? '' );
		$key  = (string) ( $def['key'] ?? '' );
		$type = (string) ( $def['type'] ?? '' );

		if ( '' === $name || '' === $key || 'tab' === $type || 'message' === $type ) {
			continue;
		}
		if ( 'custom_class' === $name ) {
			$out['custom_class']  = '';
			$out['_custom_class'] = $key;
			continue;
		}

		$path = $prefix . $name;
		$subs = ( isset( $def['sub_fields'] ) && is_array( $def['sub_fields'] ) ) ? $def['sub_fields'] : array();

		if ( 'repeater' === $type ) {
			$count = ( '' !== $prefix ) ? 2 : 3; // fewer rows for nested repeaters
			$out[ $path ]       = $count;
			$out[ '_' . $path ] = $key;
			for ( $i = 0; $i < $count; $i++ ) {
				ab_fill( $out, $path . '_' . $i . '_', $subs, $i );
			}
			continue;
		}

		if ( 'group' === $type ) {
			$out[ '_' . $path ] = $key;
			ab_fill( $out, $path . '_', $subs, $row );
			continue;
		}

		$out[ $path ]       = ab_sample_value( $def, $row );
		$out[ '_' . $path ] = $key;
	}
}

function ab_block( string $slug, array $inner = array() ): array {
	$data = array();
	ab_fill( $data, '', ab_field_defs( $slug ) );

	return array(
		'blockName'    => 'acf/' . $slug,
		'attrs'        => array( 'name' => 'acf/' . $slug, 'data' => $data, 'mode' => 'preview' ),
		'innerBlocks'  => $inner,
		'innerHTML'    => '',
		'innerContent' => $inner ? array_fill( 0, count( $inner ), null ) : array(),
	);
}

/**
 * Sample copy per block. Keys are field paths in the same flattened shape
 * ab_fill() writes, so anything set here wins over the synthesised default and
 * anything omitted still gets one.
 *
 * @return array<string, array<string, mixed>>
 */
function ab2_copy(): array {
	return array(
		'section-intro' => array(
			'label'   => 'Năng lực',
			'heading' => 'Chúng tôi làm việc trên bản vẽ trước khi làm việc trên thép',
			'content' => '<p>Mỗi hạng mục đều bắt đầu bằng một bộ số liệu kiểm chứng được: công suất trục, chế độ khai thác, giới hạn khoang máy. Phần còn lại của trang này đi theo đúng thứ tự đó.</p>',
			'width'   => 'narrow',
			'cta'     => array( 'title' => 'Xem quy trình', 'url' => home_url( '/nang-luc/' ), 'target' => '' ),
		),
		'rich-text' => array(
			'label'   => 'Ghi chú kỹ thuật',
			'heading' => 'Vì sao đường kính trục không phải là con số chọn theo kinh nghiệm',
			'content' => '<p>Đường kính trục chân vịt được quyết định bởi mô-men xoắn truyền qua trục, vật liệu chế tạo và hệ số an toàn của cấp đăng kiểm áp dụng cho con tàu. Ba yếu tố đó ràng buộc nhau, nên thay một yếu tố là phải tính lại cả bộ.</p><h3>Ba nhóm số liệu cần có trước khi tính</h3><ul><li>Công suất liên tục lớn nhất và vòng quay tương ứng tại đầu ra hộp số.</li><li>Vật liệu trục và giới hạn bền kéo của mác thép được duyệt.</li><li>Cấp đăng kiểm và hệ số tương ứng trong quy phạm đang áp dụng.</li></ul><p>Thiếu một trong ba, kết quả chỉ là ước lượng để tham khảo — <strong>không dùng để đặt hàng gia công</strong>.</p>',
			'align'   => 'left',
			'width'   => 'medium',
		),
		'image-text' => array(
			'label'          => 'Hiện trường',
			'heading'        => 'Đo đạc tại chỗ, không dựa vào bản vẽ hoàn công cũ',
			'content'        => '<p>Trên tàu đang khai thác, bản vẽ lưu trữ và thực tế thường lệch nhau sau vài lần sửa chữa. Chúng tôi dựng lại kích thước thật bằng máy quét trước khi đề xuất phương án.</p><ul><li>Quét 3D khoang máy và tuyến trục</li><li>Đối chiếu với hồ sơ đăng kiểm hiện hành</li><li>Bàn giao mô hình dùng được cho lần sửa sau</li></ul>',
			'placeholder'    => 'Ảnh hiện trường',
			'caption'        => 'Quét khoang máy',
			'image_position' => 'right',
			'split'          => 'even',
			'ratio'          => 'ratio-4-3',
			'cta'            => array( 'title' => 'Xem dịch vụ khảo sát', 'url' => home_url( '/dich-vu/' ), 'target' => '' ),
		),
		'accordion' => array(
			'label'      => 'Câu hỏi thường gặp',
			'heading'    => 'Những điều chủ tàu hay hỏi trước khi bắt đầu',
			'intro'      => 'Nếu câu hỏi của bạn không có ở đây, gửi thẳng cho đội kỹ thuật — chúng tôi trả lời trong ngày làm việc.',
			'open_first' => 1,
			'items_0_title'   => 'Cần gửi trước những tài liệu gì?',
			'items_0_content' => '<p>Tối thiểu là bản vẽ tuyến trục, thông số máy chính và hộp số, cùng cấp đăng kiểm đang áp dụng. Nếu chưa có bản vẽ, chúng tôi khảo sát và dựng lại.</p>',
			'items_1_title'   => 'Mất bao lâu để có phương án sơ bộ?',
			'items_1_content' => '<p>Với hồ sơ đầy đủ, phương án sơ bộ kèm dải kích thước đề xuất được gửi trong ba đến năm ngày làm việc.</p>',
			'items_2_title'   => 'Kết quả có dùng để trình đăng kiểm được không?',
			'items_2_content' => '<p>Bộ hồ sơ bàn giao được lập theo quy phạm của cấp đăng kiểm bạn đang áp dụng, kèm thuyết minh tính toán để trình duyệt.</p>',
		),
		'use-case' => array(
			'label'   => 'Tình huống',
			'heading' => 'Khách tìm đến chúng tôi trong ba hoàn cảnh này',
			'intro'   => 'Không phải ai cũng bắt đầu từ một bản vẽ sạch. Dưới đây là điểm xuất phát thật của phần lớn hạng mục.',
			'items_0_problem'  => 'Trục rung bất thường sau kỳ sửa chữa',
			'items_0_context'  => 'Tàu vừa lên đà thay bạc, khi chạy lại thì rung ở dải vòng quay khai thác và không rõ nguyên nhân nằm ở trục hay ở căn chỉnh.',
			'items_0_solution' => 'Đo lại độ đồng trục toàn tuyến, dựng mô hình và khoanh vùng nguồn rung trước khi động vào phần cứng.',
			'items_0_link'     => array( 'title' => 'Dịch vụ đo tuyến trục', 'url' => home_url( '/dich-vu/' ), 'target' => '' ),
			'items_1_problem'  => 'Thay máy chính, chưa biết trục cũ còn dùng được không',
			'items_1_context'  => 'Máy mới công suất lớn hơn, chủ tàu muốn giữ lại tuyến trục hiện hữu để giảm chi phí và thời gian nằm đà.',
			'items_1_solution' => 'Tính lại đường kính trục theo công suất mới và cấp đăng kiểm, trả lời được hay không kèm số liệu.',
			'items_1_link'     => array( 'title' => 'Công cụ tính đường kính trục', 'url' => home_url( '/cong-cu/' ), 'target' => '' ),
			'items_2_problem'  => 'Không còn bản vẽ của con tàu',
			'items_2_context'  => 'Tàu đóng đã lâu, hồ sơ thất lạc, mỗi lần sửa chữa lại phải đo đạc thủ công từ đầu.',
			'items_2_solution' => 'Quét 3D và dựng lại bộ bản vẽ dùng được lâu dài, bàn giao cả file gốc cho chủ tàu.',
			'items_2_link'     => array( 'title' => 'Dịch vụ quét 3D', 'url' => home_url( '/dich-vu/' ), 'target' => '' ),
		),
		'input-output' => array(
			'label'         => 'Cách làm việc',
			'heading'       => 'Bạn đưa gì, chúng tôi làm gì, bạn nhận lại gì',
			'intro'         => 'Ba cột dưới đây là toàn bộ phạm vi của một hạng mục tính toán tuyến trục.',
			'input_title'   => 'Bạn đưa',
			'process_title' => 'Chúng tôi làm',
			'output_title'  => 'Bạn nhận',
			'input_0_text'   => 'Thông số máy chính và hộp số',
			'input_1_text'   => 'Bản vẽ tuyến trục hiện hữu',
			'input_2_text'   => 'Cấp đăng kiểm đang áp dụng',
			'process_0_text' => 'Kiểm tra tính nhất quán của số liệu đầu vào',
			'process_1_text' => 'Tính toán theo quy phạm và dựng mô hình',
			'process_2_text' => 'Rà soát chéo trong đội kỹ thuật',
			'output_0_text'  => 'Thuyết minh tính toán trình đăng kiểm',
			'output_1_text'  => 'Bản vẽ chế tạo kèm dung sai',
			'output_2_text'  => 'File mô hình gốc để dùng cho lần sau',
		),
		'proof-strip' => array(
			'items_0_value' => '18',
			'items_0_label' => 'Năm trong ngành hàng hải',
			'items_0_note'  => 'Từ 2007 đến nay',
			'items_1_value' => '240+',
			'items_1_label' => 'Hạng mục đã bàn giao',
			'items_1_note'  => 'Tàu hàng, tàu dịch vụ, sà lan',
			'items_2_value' => '5',
			'items_2_label' => 'Cấp đăng kiểm quen thuộc',
			'items_2_note'  => 'VR, NK, BV, DNV, LR',
			'items_3_value' => '3-5',
			'items_3_label' => 'Ngày cho phương án sơ bộ',
			'items_3_note'  => 'Tính từ khi đủ hồ sơ',
		),
		'quote' => array(
			'quote'   => 'Điều chúng tôi cần không phải là một con số đẹp, mà là một con số dám ký tên vào. LASAN đưa cả phần tính toán ra để chúng tôi tự kiểm.',
			'author'  => 'Nguyễn Văn Hải',
			'role'    => 'Trưởng phòng kỹ thuật',
			'company' => 'Công ty Vận tải biển Đông Phong',
		),
		'cta-banner' => array(
			'label'         => 'Bắt đầu',
			'heading'       => 'Gửi thông số tàu, nhận lại phương án sơ bộ',
			'content'       => 'Không cần hồ sơ hoàn chỉnh. Có gì gửi nấy, đội kỹ thuật sẽ nói rõ còn thiếu những gì.',
			'theme'         => 'navy',
			'primary_cta'   => array( 'title' => 'Gửi yêu cầu', 'url' => home_url( '/lien-he/' ), 'target' => '' ),
			'secondary_cta' => array( 'title' => 'Xem năng lực', 'url' => home_url( '/nang-luc/' ), 'target' => '' ),
		),
	);
}

/**
 * Build one block: synthesise every field, grow each repeater to the number of
 * rows the hand-written copy defines (so ACF's `_path` key pointers exist for
 * those rows too), then overlay the copy and drop any synthesised row past it.
 */
function ab2_block( string $slug, array $copy ): array {
	$defs  = ab_field_defs( $slug );
	$data  = array();
	ab_fill( $data, '', $defs );

	foreach ( $defs as $def ) {
		if ( 'repeater' !== ( $def['type'] ?? '' ) ) {
			continue;
		}

		$name = (string) ( $def['name'] ?? '' );
		$subs = ( isset( $def['sub_fields'] ) && is_array( $def['sub_fields'] ) ) ? $def['sub_fields'] : array();
		$rows = 0;

		foreach ( array_keys( $copy ) as $path ) {
			if ( preg_match( '/^' . preg_quote( $name, '/' ) . '_(\d+)_/', (string) $path, $m ) ) {
				$rows = max( $rows, (int) $m[1] + 1 );
			}
		}

		if ( 0 === $rows ) {
			continue; // No copy for this repeater — keep the synthesised rows.
		}

		// Drop every synthesised row, then rebuild exactly $rows of them.
		foreach ( array_keys( $data ) as $path ) {
			if ( preg_match( '/^_?' . preg_quote( $name, '/' ) . '_\d+_/', (string) $path ) ) {
				unset( $data[ $path ] );
			}
		}

		$data[ $name ] = $rows;
		for ( $i = 0; $i < $rows; $i++ ) {
			ab_fill( $data, $name . '_' . $i . '_', $subs, $i );
		}
	}

	foreach ( $copy as $path => $value ) {
		$data[ $path ] = $value;
	}

	return array(
		'blockName'    => 'acf/' . $slug,
		'attrs'        => array( 'name' => 'acf/' . $slug, 'data' => $data, 'mode' => 'preview' ),
		'innerBlocks'  => array(),
		'innerHTML'    => '',
		'innerContent' => array(),
	);
}

// Page order mirrors how the blocks are meant to sit on a real page: intro,
// editorial, media, evidence, mechanics, objections, testimonial, ask.
$order = array(
	'section-intro',
	'proof-strip',
	'rich-text',
	'image-text',
	'input-output',
	'use-case',
	'quote',
	'accordion',
	'cta-banner',
);

$copy       = ab2_copy();
$blocks_dir = get_stylesheet_directory() . '/blocks';
$block_list = array();
$missing    = array();

foreach ( $order as $slug ) {
	if ( ! is_dir( $blocks_dir . '/' . $slug ) ) {
		$missing[] = $slug;
		continue;
	}
	$block_list[] = ab2_block( $slug, $copy[ $slug ] ?? array() );
}

if ( $missing ) {
	fwrite( STDERR, "Skipped (no block folder): " . implode( ', ', $missing ) . "\n" );
}

$content = implode( "\n\n", array_map( 'serialize_block', $block_list ) );

$key      = 'all_blocks_qa_2';
$existing = get_posts(
	array(
		'post_type'      => 'page',
		'post_status'    => 'any',
		'posts_per_page' => 1,
		'lang'           => '',
		'meta_key'       => '_lasan_content_key',
		'meta_value'     => $key,
	)
);

$post_id = wp_insert_post(
	wp_slash(
		array(
			'ID'           => $existing ? (int) $existing[0]->ID : 0,
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_title'   => 'All Blocks 2',
			'post_name'    => 'all-blocks-2',
			'post_content' => $content,
		)
	),
	true
);

if ( is_wp_error( $post_id ) ) {
	fwrite( STDERR, $post_id->get_error_message() . "\n" );
	exit( 1 );
}

update_post_meta( (int) $post_id, '_lasan_content_key', $key );
if ( function_exists( 'pll_set_post_language' ) && ! pll_get_post_language( (int) $post_id ) ) {
	pll_set_post_language( (int) $post_id, pll_default_language() ?: 'vi' );
}

printf( "All Blocks 2 page #%d (%d blocks): %s\n", (int) $post_id, count( $block_list ), get_permalink( (int) $post_id ) );
