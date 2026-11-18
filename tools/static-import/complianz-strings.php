<?php
/**
 * Complianz strings the plugin translates with gettext (not its settings):
 * banner labels, the map placeholder, the cookie-policy document. There is no
 * Vietnamese language pack for Complianz, so complianz.php compiles these into
 * wp-content/languages/plugins/complianz-gdpr-{locale}.mo.
 *
 * Each row: array( context|null, English source string, translation ).
 * The source strings must match the plugin's exactly (v7.5.7); when an update
 * changes one, its row simply stops applying and the English shows through.
 *
 * en_US only overrides what the EU template says that is wrong for this site
 * (the EEA scope, the shopping cart, the "Data Protection Authority").
 *
 * @package Starter_Flexible
 */

$doc   = 'Legal document cookie policy';
$title = 'Legal document cookie policy:paragraph title';

return array(
	'vi'    => array(
		// Banner, manage-consent area, placeholders.
		array( null, 'Close dialog', 'Đóng hộp thoại' ),
		array( null, 'Always active', 'Luôn bật' ),
		array( null, 'Manage options', 'Quản lý tùy chọn' ),
		array( null, 'Manage services', 'Quản lý dịch vụ' ),
		array( null, 'Manage %s vendors', 'Quản lý %s nhà cung cấp' ),
		array( null, 'Read more about these purposes', 'Tìm hiểu thêm về các mục đích này' ),
		array( null, 'Read more about TCF purposes on Cookie Database', 'Tìm hiểu thêm về các mục đích TCF trên Cookie Database' ),
		array( null, 'Manage consent', 'Quản lý đồng ý' ),
		array( null, 'Cookie Policy', 'Chính sách cookie' ),
		array( null, 'Click button to enable {service}', 'Nhấn nút để bật {service}' ),
		array( null, 'Click to accept the cookies for this service', 'Nhấn để chấp nhận cookie của dịch vụ này' ),
		array( null, 'Click to accept marketing cookies', 'Nhấn để chấp nhận cookie tiếp thị' ),
		array( 'as in: click to accept statistics cookies', 'statistics', 'thống kê' ),
		array( 'as in: click to accept marketing cookies', 'marketing', 'tiếp thị' ),
		array( 'cookie policy', 'We have received a privacy signal from your browser. For this reason we have set your privacy settings on this website to strictly necessary. If you want to have full functionality, please consider excluding %s from your privacy settings.', 'Trình duyệt của bạn đã gửi tín hiệu bảo vệ quyền riêng tư (Do Not Track / Global Privacy Control), vì vậy website này chỉ dùng các cookie thật sự cần thiết. Nếu muốn dùng đầy đủ chức năng, bạn có thể loại trừ %s khỏi cài đặt quyền riêng tư của trình duyệt.' ),

		// Cookie policy document (config/documents/cookie-policy-eu.php).
		array( $doc, 'This Cookie Policy was last updated on %s and applies to citizens and legal permanent residents of the European Economic Area and Switzerland.', 'Chính sách cookie này được cập nhật lần cuối ngày %s và áp dụng cho mọi người truy cập website.' ),
		array( $title, 'Introduction', 'Giới thiệu' ),
		array( $doc, 'Our website, %s (hereinafter: "the website") uses cookies and other related technologies (for convenience all technologies are referred to as "cookies"). Cookies are also placed by third parties we have engaged. In the document below we inform you about the use of cookies on our website.', 'Website của chúng tôi, %s (sau đây gọi là “website”), sử dụng cookie và các công nghệ liên quan (gọi chung là “cookie”). Một số cookie do bên thứ ba mà chúng tôi sử dụng dịch vụ đặt. Văn bản dưới đây giải thích cách website sử dụng cookie.' ),
		array( $title, 'What are cookies?', 'Cookie là gì?' ),
		array( $doc, 'A cookie is a small simple file that is sent along with pages of this website and stored by your browser on the hard drive of your computer or another device. The information stored therein may be returned to our servers or to the servers of the relevant third parties during a subsequent visit.', 'Cookie là một tệp nhỏ được gửi kèm các trang của website này và được trình duyệt lưu trên máy tính hoặc thiết bị của bạn. Thông tin trong cookie có thể được gửi lại máy chủ của chúng tôi hoặc của bên thứ ba liên quan trong những lần truy cập sau.' ),
		array( $title, 'What are scripts?', 'Script là gì?' ),
		array( $doc, 'A script is a piece of program code that is used to make our website function properly and interactively. This code is executed on our server or on your device.', 'Script là một đoạn mã chương trình giúp website hoạt động đúng và có tính tương tác. Mã này chạy trên máy chủ của chúng tôi hoặc trên thiết bị của bạn.' ),
		array( $title, 'What is a web beacon?', 'Web beacon là gì?' ),
		array( $doc, 'A web beacon (or a pixel tag) is a small, invisible piece of text or image on a website that is used to monitor traffic on a website. In order to do this, various data about you is stored using web beacons.', 'Web beacon (hay pixel tag) là một đoạn văn bản hoặc hình ảnh nhỏ, không nhìn thấy được trên website, dùng để theo dõi lưu lượng truy cập. Để làm việc này, một số dữ liệu về bạn được lưu lại thông qua web beacon.' ),
		array( $title, 'Cookies', 'Cookie' ),
		array( $title, 'Technical or functional cookies', 'Cookie kỹ thuật hoặc chức năng' ),
		array( $doc, 'Some cookies ensure that certain parts of the website work properly and that your user preferences remain known. By placing functional cookies, we make it easier for you to visit our website. This way, you do not need to repeatedly enter the same information when visiting our website and, for example, the items remain in your shopping cart until you have paid. We may place these cookies without your consent.', 'Một số cookie giúp các phần của website hoạt động đúng và ghi nhớ lựa chọn của bạn, chẳng hạn ngôn ngữ hiển thị, để bạn không phải chọn lại mỗi lần truy cập. Chúng tôi có thể đặt các cookie này mà không cần bạn đồng ý.' ),
		array( $title, 'Statistics cookies', 'Cookie thống kê' ),
		array( $doc, 'We use statistics cookies to optimize the website experience for our users. With these statistics cookies we get insights in the usage of our website.', 'Chúng tôi dùng cookie thống kê để cải thiện trải nghiệm trên website. Cookie thống kê cho chúng tôi biết website được sử dụng như thế nào.' ),
		array( $doc, 'We ask your permission to place statistics cookies.', 'Chúng tôi chỉ đặt cookie thống kê khi bạn cho phép.' ),
		array( $doc, 'Because statistics are being tracked anonymously, no permission is asked to place statistics cookies.', 'Vì số liệu thống kê được thu thập ẩn danh, chúng tôi không xin phép trước khi đặt cookie thống kê.' ),
		array( 'cookie policy', 'Marketing/Tracking cookies', 'Cookie tiếp thị/theo dõi' ),
		array( 'cookie policy', 'Marketing/Tracking cookies are cookies or any other form of local storage, used to create user profiles to display advertising or to track the user on this website or across several websites for similar marketing purposes.', 'Cookie tiếp thị/theo dõi là cookie hoặc bất kỳ hình thức lưu trữ cục bộ nào dùng để tạo hồ sơ người dùng nhằm hiển thị quảng cáo, hoặc để theo dõi người dùng trên website này hay trên nhiều website cho mục đích tiếp thị tương tự. Trên website này, đó là nội dung nhúng của bên thứ ba như bản đồ Google Maps.' ),
		array( $title, 'Placed cookies', 'Các cookie được sử dụng' ),
		array( $title, 'Consent', 'Sự đồng ý' ),
		array( $doc, 'When you visit our website for the first time, we will show you a pop-up with an explanation about cookies. As soon as you click on "%s", you consent to us using all cookies and plug-ins as described in the pop-up and this Cookie Policy. You can disable the use of cookies via your browser, but please note that our website may no longer work properly.', 'Khi bạn truy cập website lần đầu, chúng tôi hiển thị một hộp thông báo giải thích về cookie. Khi bạn nhấn “%s”, bạn đồng ý cho chúng tôi sử dụng mọi cookie và plug-in như mô tả trong hộp thông báo và trong Chính sách cookie này. Bạn có thể tắt cookie trong trình duyệt, nhưng khi đó website có thể không hoạt động đầy đủ.' ),
		array( $doc, 'When you visit our website for the first time, we will show you a pop-up with an explanation about cookies. As soon as you click on "%s", you consent to us using the categories of cookies and plug-ins you selected in the pop-up, as described in this Cookie Policy. You can disable the use of cookies via your browser, but please note that our website may no longer work properly.', 'Khi bạn truy cập website lần đầu, chúng tôi hiển thị một hộp thông báo giải thích về cookie. Khi bạn nhấn “%s”, bạn đồng ý cho chúng tôi sử dụng các nhóm cookie và plug-in bạn đã chọn trong hộp thông báo, như mô tả trong Chính sách cookie này. Nút “Từ chối” chỉ giữ lại các cookie cần thiết. Bạn cũng có thể tắt cookie trong trình duyệt, nhưng khi đó website có thể không hoạt động đầy đủ.' ),
		array( $title, 'Manage your consent settings', 'Quản lý lựa chọn đồng ý' ),
		array( 'cookie policy', 'You have loaded the Cookie Policy without javascript support.', 'Trang này đang được xem khi JavaScript bị tắt.' ),
		array( 'cookie policy', 'On AMP, you can use the manage consent button on the bottom of the page.', 'Trên trang AMP, bạn có thể dùng nút quản lý đồng ý ở cuối trang.' ),
		array( $title, 'Enabling/disabling and deleting cookies', 'Bật/tắt và xóa cookie' ),
		array( $doc, 'You can use your internet browser to automatically or manually delete cookies. You can also specify that certain cookies may not be placed. Another option is to change the settings of your internet browser so that you receive a message each time a cookie is placed. For more information about these options, please refer to the instructions in the Help section of your browser.', 'Bạn có thể dùng trình duyệt để xóa cookie tự động hoặc thủ công, chặn một số cookie, hoặc cài đặt để được báo mỗi khi có cookie được đặt. Xem hướng dẫn trong mục Trợ giúp của trình duyệt để biết thêm.' ),
		array( $doc, 'Please note that our website may not work properly if all cookies are disabled. If you do delete the cookies in your browser, they will be placed again after your consent when you visit our website again.', 'Lưu ý: website có thể không hoạt động đúng nếu tắt toàn bộ cookie. Nếu bạn xóa cookie trong trình duyệt, chúng sẽ được đặt lại sau khi bạn đồng ý ở lần truy cập tiếp theo.' ),
		array( $title, 'Your rights with respect to personal data', 'Quyền của bạn đối với dữ liệu cá nhân' ),
		array( $doc, 'You have the following rights with respect to your personal data:', 'Bạn có các quyền sau đối với dữ liệu cá nhân của mình:' ),
		array( $doc, 'You have the right to know why your personal data is needed, what will happen to it, and how long it will be retained for.', 'Quyền được biết: vì sao dữ liệu cá nhân của bạn cần được xử lý, sẽ được xử lý thế nào và lưu giữ trong bao lâu.' ),
		array( $doc, 'Right of access: You have the right to access your personal data that is known to us.', 'Quyền truy cập: bạn có quyền xem dữ liệu cá nhân của mình mà chúng tôi đang lưu giữ.' ),
		array( $doc, 'Right to rectification: you have the right to supplement, correct, have deleted or blocked your personal data whenever you wish.', 'Quyền chỉnh sửa: bạn có quyền bổ sung, chỉnh sửa, yêu cầu xóa hoặc hạn chế xử lý dữ liệu cá nhân của mình bất cứ lúc nào.' ),
		array( $doc, 'If you give us your consent to process your data, you have the right to revoke that consent and to have your personal data deleted.', 'Quyền rút lại sự đồng ý: nếu bạn đã đồng ý cho chúng tôi xử lý dữ liệu, bạn có quyền rút lại sự đồng ý đó và yêu cầu xóa dữ liệu cá nhân của mình.' ),
		array( $doc, 'Right to transfer your data: you have the right to request all your personal data from the controller and transfer it in its entirety to another controller.', 'Quyền chuyển dữ liệu: bạn có quyền yêu cầu nhận toàn bộ dữ liệu cá nhân của mình để chuyển cho một bên kiểm soát dữ liệu khác.' ),
		array( $doc, 'Right to object: you may object to the processing of your data. We comply with this, unless there are justified grounds for processing.', 'Quyền phản đối: bạn có thể phản đối việc xử lý dữ liệu của mình; chúng tôi sẽ tôn trọng, trừ khi có căn cứ chính đáng để tiếp tục xử lý.' ),
		array( $doc, 'To exercise these rights, please contact us. Please refer to the contact details at the bottom of this Cookie Policy. If you have a complaint about how we handle your data, we would like to hear from you, but you also have the right to submit a complaint to the supervisory authority (the Data Protection Authority).', 'Để thực hiện các quyền này, vui lòng liên hệ với chúng tôi theo thông tin ở cuối Chính sách cookie này. Nếu bạn có khiếu nại về cách chúng tôi xử lý dữ liệu, chúng tôi rất mong được nghe ý kiến của bạn; bạn cũng có quyền gửi khiếu nại đến cơ quan có thẩm quyền về bảo vệ dữ liệu cá nhân (tại Việt Nam là Bộ Công an).' ),
		array( $title, 'Contact details', 'Thông tin liên hệ' ),
		array( $doc, 'For questions and/or comments about our Cookie Policy and this statement, please contact us by using the following contact details:', 'Mọi câu hỏi hoặc góp ý về Chính sách cookie này, vui lòng liên hệ:' ),
		array( $doc, 'Website:', 'Website:' ),
		array( $doc, 'Email:', 'Email:' ),
		array( null, 'Phone number:', 'Điện thoại:' ),
		array( null, 'Viet Nam', 'Việt Nam' ),
		array( $doc, 'This Cookie Policy was synchronized with %scookiedatabase.org%s on %s.', 'Chính sách cookie này được đồng bộ với %scookiedatabase.org%s ngày %s.' ),

		// The cookie list (functions.php cmplz_used_cookies, templates/cookiepolicy).
		array( 'cookie policy', 'Usage', 'Mục đích sử dụng' ),
		array( $doc, 'Sharing data', 'Chia sẻ dữ liệu' ),
		array( null, 'Name', 'Tên' ),
		array( null, 'Expiration', 'Thời hạn' ),
		array( null, 'Function', 'Công dụng' ),
		array( null, 'This data is not shared with third parties.', 'Dữ liệu này không được chia sẻ với bên thứ ba.' ),
		array( null, 'For more information, please read the %s%s Privacy Statement%s.', 'Để biết thêm, vui lòng đọc %1$sChính sách quyền riêng tư của %2$s%3$s.' ),
		array( $doc, 'We use %s for %s.', 'Chúng tôi dùng %s để %s.' ),
		array( null, '%s days', '%s ngày' ),
		array( null, 'Miscellaneous', 'Khác' ),
		array( null, 'Purpose pending investigation', 'Mục đích đang được xác định' ),
		array( null, 'Sharing of data is pending investigation', 'Việc chia sẻ dữ liệu đang được xác định' ),
		array( null, 'and', 'và' ),
		array( null, '%1$s at %2$s', '%1$s lúc %2$s' ),
		array( null, '(not synced yet)', '(chưa đồng bộ)' ),
	),

	'en_US' => array(
		array( $doc, 'This Cookie Policy was last updated on %s and applies to citizens and legal permanent residents of the European Economic Area and Switzerland.', 'This Cookie Policy was last updated on %s and applies to everyone visiting this website.' ),
		array( $doc, 'Some cookies ensure that certain parts of the website work properly and that your user preferences remain known. By placing functional cookies, we make it easier for you to visit our website. This way, you do not need to repeatedly enter the same information when visiting our website and, for example, the items remain in your shopping cart until you have paid. We may place these cookies without your consent.', 'Some cookies ensure that parts of the website work properly and that your choices, such as the display language, are remembered, so you do not need to choose again on every visit. We may place these cookies without your consent.' ),
		array( 'cookie policy', 'Marketing/Tracking cookies are cookies or any other form of local storage, used to create user profiles to display advertising or to track the user on this website or across several websites for similar marketing purposes.', 'Marketing/Tracking cookies are cookies or any other form of local storage, used to create user profiles to display advertising or to track the user on this website or across several websites for similar marketing purposes. On this website, that is embedded third-party content such as the Google Maps map.' ),
		array( $doc, 'When you visit our website for the first time, we will show you a pop-up with an explanation about cookies. As soon as you click on "%s", you consent to us using the categories of cookies and plug-ins you selected in the pop-up, as described in this Cookie Policy. You can disable the use of cookies via your browser, but please note that our website may no longer work properly.', 'When you visit our website for the first time, we will show you a pop-up with an explanation about cookies. As soon as you click on "%s", you consent to us using the categories of cookies and plug-ins you selected in the pop-up, as described in this Cookie Policy. "Deny" keeps only the necessary cookies. You can also disable cookies via your browser, but please note that our website may no longer work properly.' ),
		array( $doc, 'To exercise these rights, please contact us. Please refer to the contact details at the bottom of this Cookie Policy. If you have a complaint about how we handle your data, we would like to hear from you, but you also have the right to submit a complaint to the supervisory authority (the Data Protection Authority).', 'To exercise these rights, please contact us. Please refer to the contact details at the bottom of this Cookie Policy. If you have a complaint about how we handle your data, we would like to hear from you, but you also have the right to submit a complaint to the competent personal data protection authority (in Vietnam, the Ministry of Public Security).' ),
		array( null, 'Viet Nam', 'Vietnam' ),
	),
);
