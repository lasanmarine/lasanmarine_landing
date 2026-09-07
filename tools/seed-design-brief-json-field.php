<?php
/**
 * One-off: give the "Nhiệm vụ thư thiết kế" form its brief-json field.
 *
 * The design brief is not split into records — the whole thing travels as one
 * JSON object. The block writes it into a hidden brief-json field, so the CF7
 * form has to declare that field and the mail has to print it.
 *
 * Run: docker exec lasan_wp php /var/www/html/tools/seed-design-brief-json-field.php
 */

require_once __DIR__ . '/../wp-load.php';

if ( 'cli' !== PHP_SAPI ) {
	exit( "CLI only\n" );
}

$forms = get_posts(
	array(
		'post_type'   => 'wpcf7_contact_form',
		'numberposts' => -1,
	)
);

$touched = 0;

foreach ( $forms as $post ) {
	$form = (string) get_post_meta( $post->ID, '_form', true );
	if ( false === strpos( $form, 'brief-body' ) ) {
		continue;
	}

	if ( false === strpos( $form, 'brief-json' ) ) {
		$form = str_replace( '[textarea brief-body]', "[textarea brief-body]\n[textarea brief-json]", $form );
		update_post_meta( $post->ID, '_form', $form );
		echo "#{$post->ID} form: added brief-json\n";
		++$touched;
	} else {
		echo "#{$post->ID} form: brief-json already there\n";
	}

	$mail = get_post_meta( $post->ID, '_mail', true );
	if ( is_array( $mail ) && false === strpos( (string) $mail['body'], '[brief-json]' ) ) {
		$mail['body'] = rtrim( (string) $mail['body'] ) . "\n\n-- Hồ sơ (JSON) --\n[brief-json]\n";
		update_post_meta( $post->ID, '_mail', $mail );
		echo "#{$post->ID} mail: added [brief-json]\n";
		++$touched;
	}
}

echo $touched ? "Done.\n" : "Nothing to change.\n";
