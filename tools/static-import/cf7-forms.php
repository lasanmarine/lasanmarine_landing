<?php
/**
 * Recreate the two enquiry forms (Contact Form 7 + Conditional Fields) the
 * enquiry-form block points at: slugs enquiry-form-vi / enquiry-form-en.
 * Safe to re-run: forms are matched by slug and overwritten.
 *
 *   docker exec -u www-data lasan_wp php /var/www/html/tools/static-import/cf7-forms.php
 *
 * The mail tab is not in the static export; it sends to the site admin email.
 *
 * @package Starter_Flexible
 */

$_SERVER['HTTP_HOST']   = $_SERVER['HTTP_HOST'] ?? ( parse_url( getenv( 'WP_HOME' ) ?: 'http://localhost', PHP_URL_HOST ) . ( parse_url( getenv( 'WP_HOME' ) ?: '', PHP_URL_PORT ) ? ':' . parse_url( getenv( 'WP_HOME' ), PHP_URL_PORT ) : '' ) );
$_SERVER['REQUEST_URI'] = '/';
require dirname( __DIR__, 2 ) . '/wp-load.php';

if ( ! class_exists( 'WPCF7_ContactForm' ) ) {
	fwrite( STDERR, "Contact Form 7 chưa bật\n" );
	exit( 1 );
}

$forms = array(
	'vi' => array(
		'slug'       => 'enquiry-form-vi',
		'title'      => 'Form tư vấn (VI)',
		'customer'   => array( 'Bạn là khách hàng', 'Cá nhân', 'Doanh nghiệp' ),
		'name'       => array( 'Họ và tên', 'Nguyễn Văn A' ),
		'company'    => array( 'Tên công ty / Đơn vị', 'Tên công ty hoặc đơn vị' ),
		'person'     => array( 'Người liên hệ', 'Họ và tên người liên hệ' ),
		'phone'      => array( 'Số điện thoại', '090 123 4567' ),
		'email'      => array( 'Email', 'email@example.com' ),
		'service'    => array( 'Dịch vụ cần tư vấn', 'Thiết kế tàu', 'Dịch vụ CNTT' ),
		'message'    => array( 'Nội dung yêu cầu', 'Mô tả nhu cầu hoặc vấn đề bạn cần tư vấn' ),
		'submit'     => 'Gửi yêu cầu tư vấn',
		'subject'    => 'Yêu cầu tư vấn từ website',
	),
	'en' => array(
		'slug'       => 'enquiry-form-en',
		'title'      => 'Enquiry form (EN)',
		'customer'   => array( 'You are', 'Individual', 'Business' ),
		'name'       => array( 'Full name', 'Your full name' ),
		'company'    => array( 'Company / Organisation', 'Company or organisation name' ),
		'person'     => array( 'Contact person', "Contact person's full name" ),
		'phone'      => array( 'Phone number', '090 123 4567' ),
		'email'      => array( 'Email', 'email@example.com' ),
		'service'    => array( 'Service needed', 'Ship design', 'Software & IT' ),
		'message'    => array( 'Your request', "Describe what you need or the problem you'd like help with" ),
		'submit'     => 'Send request',
		'subject'    => 'Enquiry from the website',
	),
);

$label = static fn( string $text, bool $required = true ): string => "<label class=\"form-label\">\n{$text}" . ( $required ? ' <span>*</span>' : '' ) . "\n</label>\n";
$ph    = static fn( string $s ): string => 'placeholder "' . str_replace( '"', '', $s ) . '"';

foreach ( $forms as $lang => $f ) {
	$body = <<<CF7
<div class="consult-form">
	<div class="form-field form-field--full">
		{$label( $f['customer'][0] )}
		[radio customer-type use_label_element default:1 "{$f['customer'][1]}" "{$f['customer'][2]}"]
	</div>
	[group individual]
		<div class="form-field form-field--full">
			{$label( $f['name'][0] )}
			[text* individual-name class:form-control {$ph( $f['name'][1] )}]
		</div>
	[/group]
	[group business]
		<div class="form-grid">
			<div class="form-field">
				{$label( $f['company'][0] )}
				[text* company-name class:form-control {$ph( $f['company'][1] )}]
			</div>
			<div class="form-field">
				{$label( $f['person'][0] )}
				[text* contact-person class:form-control {$ph( $f['person'][1] )}]
			</div>
		</div>
	[/group]
	<div class="form-grid">
		<div class="form-field">
			{$label( $f['phone'][0] )}
			[tel* your-phone class:form-control {$ph( $f['phone'][1] )}]
		</div>
		<div class="form-field">
			{$label( $f['email'][0], false )}
			[email your-email class:form-control {$ph( $f['email'][1] )}]
		</div>
	</div>
	<div class="form-field form-field--full">
		{$label( $f['service'][0] )}
		[radio service use_label_element "{$f['service'][1]}" "{$f['service'][2]}"]
	</div>
	<div class="form-field form-field--full">
		{$label( $f['message'][0] )}
		[textarea* your-message maxlength:2000 class:form-control {$ph( $f['message'][1] )}]
	</div>
	<div class="form-actions">
		[submit class:form-submit "{$f['submit']}"]
	</div>
</div>
CF7;
	// CF7 wants the placeholder value quoted after the option.
	$body = preg_replace( '/placeholder "([^"]*)"/', 'placeholder "$1"', $body );

	$existing = get_posts( array( 'post_type' => 'wpcf7_contact_form', 'name' => $f['slug'], 'post_status' => 'any', 'posts_per_page' => 1, 'lang' => '' ) );
	$form     = $existing ? wpcf7_contact_form( $existing[0]->ID ) : WPCF7_ContactForm::get_template( array( 'title' => $f['title'] ) );
	$form->set_title( $f['title'] );
	$mail             = $form->prop( 'mail' );
	$mail['subject']  = '[_site_title] ' . $f['subject'];
	$mail['recipient'] = '[_site_admin_email]';
	$mail['sender']   = '[_site_title] <wordpress@[_site_domain]>';
	$mail['body']     = "[customer-type]\n[individual-name][company-name] [contact-person]\n[your-phone] [your-email]\n[service]\n\n[your-message]\n\n-- \n[_site_url]";
	$mail['additional_headers'] = 'Reply-To: [your-email]';
	$form->set_properties( array( 'form' => $body, 'mail' => $mail ) );
	$form->set_locale( 'en_US' ); // as on the old site
	$id = $form->save();
	wp_update_post( array( 'ID' => $id, 'post_name' => $f['slug'] ) );

	// Conditional Fields: show the matching group for the customer type.
	update_post_meta(
		$id,
		'wpcf7cf_options',
		array(
			array( 'then_field' => 'individual', 'and_rules' => array( array( 'if_field' => 'customer-type', 'operator' => 'equals', 'if_value' => $f['customer'][1] ) ) ),
			array( 'then_field' => 'business', 'and_rules' => array( array( 'if_field' => 'customer-type', 'operator' => 'equals', 'if_value' => $f['customer'][2] ) ) ),
		)
	);
	echo "  ✓ {$f['slug']} #{$id}\n";
}

// The design brief tool posts the generated brief through this hidden form.
$brief_body = "<p style=\"display:none\">\n[text* brief-code][text brief-customer][text brief-vessel][email brief-email]\n[textarea brief-body maxlength:2000]\n[textarea brief-json maxlength:2000]\n</p>\n[submit \"Gửi nhiệm vụ thư\"]";
$existing   = get_posts( array( 'post_type' => 'wpcf7_contact_form', 'name' => 'nhiem-vu-thu-thiet-ke', 'post_status' => 'any', 'posts_per_page' => 1, 'lang' => '' ) );
$form       = $existing ? wpcf7_contact_form( $existing[0]->ID ) : WPCF7_ContactForm::get_template( array( 'title' => 'Nhiệm vụ thư thiết kế' ) );
$form->set_title( 'Nhiệm vụ thư thiết kế' );
$mail                       = $form->prop( 'mail' );
$mail['subject']            = '[_site_title] Nhiệm vụ thư [brief-code] – [brief-customer]';
$mail['recipient']          = '[_site_admin_email]';
$mail['sender']             = '[_site_title] <wordpress@[_site_domain]>';
$mail['body']               = "Mã: [brief-code]\nKhách hàng: [brief-customer]\nTàu: [brief-vessel]\nEmail: [brief-email]\n\n[brief-body]\n\n[brief-json]";
$mail['additional_headers'] = 'Reply-To: [brief-email]';
$form->set_properties( array( 'form' => $brief_body, 'mail' => $mail ) );
$form->set_locale( 'vi' );
$id = $form->save();
wp_update_post( array( 'ID' => $id, 'post_name' => 'nhiem-vu-thu-thiet-ke' ) );
echo "  ✓ nhiem-vu-thu-thiet-ke #{$id}\n";
