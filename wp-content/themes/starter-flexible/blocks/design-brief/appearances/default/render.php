<?php
/**
 * Design Brief — default appearance.
 *
 * The form is the Svelte island in assets/island.svelte, drawn from the schema
 * in inc/schema.php. Contact Form 7 stays server-rendered beside it: the island
 * writes the brief into the CF7 form's hidden fields and clicks its submit, so
 * mail, validation and the response message remain CF7's job.
 *
 * @var object $data
 * @var bool   $is_preview
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<section class="<?php echo esc_attr( $data->module_class ); ?>" data-reveal<?php if ( $data->anchor ) : ?> id="<?php echo esc_attr( $data->anchor ); ?>"<?php endif; ?>>
	<?php
	$placeholder = '<header class="db__intro">'
		. ( '' !== trim( (string) $data->heading ) ? '<h2 class="h3">' . esc_html( $data->heading ) . '</h2>' : '' )
		. ( $data->has_intro ? '<p class="copy">' . esc_html( $data->intro ) . '</p>' : '' )
		. '</header>'
		. starter_flexible_island_noscript();

	starter_flexible_island( 'design-brief', $data->props, array( 'placeholder' => $placeholder ) );
	?>

	<?php if ( $data->cf7_id ) : ?>
		<div class="db__cf7" data-db-cf7>
			<?php echo $data->form_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- CF7 markup. ?>
		</div>
	<?php endif; ?>
</section>
