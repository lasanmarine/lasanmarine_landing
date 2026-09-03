<?php
/**
 * Enquiry Form — default appearance.
 *
 * @var object $data
 * @var array  $block
 * @var bool   $is_preview
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( empty( $data->should_render ) ) {
	if ( $is_preview ) {
		printf( '<div class="module-placeholder">%s</div>', esc_html__( 'Nhập tiêu đề và nhãn các trường ở thanh bên.', 'starter-flexible' ) );
	}
	return;
}

$fields = $data->fields;
$anchor = ! empty( $block['anchor'] ) ? (string) $block['anchor'] : 'apply';
?>
<section id="<?php echo esc_attr( $anchor ); ?>" class="<?php echo esc_attr( $data->module_class ); ?>" data-reveal>
	<?php get_template_part( 'template-parts/components/block-head', null, array( 'label' => $data->label ) ); ?>
	<div class="ef">
		<div class="ef__intro">
			<h2 class="h4"><?php echo esc_html( $data->heading ); ?></h2>
			<?php if ( $data->has_note ) : ?>
				<p class="copy ef__note"><?php echo esc_html( $data->note ); ?></p>
			<?php endif; ?>
		</div>

		<form class="ef__form" data-enquiry novalidate data-reveal-stagger data-error-text="<?php echo esc_attr( $data->error_text ); ?>" data-toast-text="<?php echo esc_attr( $data->toast_text ); ?>">
			<?php
			get_template_part(
				'template-parts/components/input',
				null,
				array( 'label' => $fields['name'], 'name' => 'name', 'required' => true, 'attrs' => array( 'autocomplete' => 'name' ) )
			);

			if ( '' !== $fields['company'] ) {
				get_template_part(
					'template-parts/components/input',
					null,
					array( 'label' => $fields['company'], 'name' => 'company', 'attrs' => array( 'autocomplete' => 'organization' ) )
				);
			}

			get_template_part(
				'template-parts/components/input',
				null,
				array( 'label' => $fields['email'], 'name' => 'email', 'type' => 'email', 'required' => true, 'attrs' => array( 'autocomplete' => 'email' ) )
			);

			if ( '' !== $fields['phone'] ) {
				get_template_part(
					'template-parts/components/input',
					null,
					array( 'label' => $fields['phone'], 'name' => 'phone', 'type' => 'tel', 'attrs' => array( 'autocomplete' => 'tel' ) )
				);
			}

			if ( ! empty( $data->choices ) ) {
				get_template_part(
					'template-parts/components/select',
					null,
					array( 'label' => $fields['interest'], 'name' => 'interest', 'options' => $data->choices )
				);
			}

			get_template_part(
				'template-parts/components/textarea',
				null,
				array( 'label' => $fields['message'], 'name' => 'message', 'required' => true )
			);

			get_template_part(
				'template-parts/components/file-field',
				null,
				array( 'label' => $fields['attach'], 'action' => $fields['attach_hint'], 'name' => 'attachment', 'hint' => $fields['attach_hint'] )
			);
			?>

			<div class="ef__actions ef__full">
				<button type="submit" class="btn">
					<?php echo esc_html( $fields['submit'] ); ?>
					<?php echo starter_flexible_icon( 'arrow' ); // phpcs:ignore ?>
				</button>
				<p class="ef__error" data-enquiry-error hidden></p>
			</div>
		</form>
	</div>
</section>

<div class="toast" data-toast hidden>
	<?php echo starter_flexible_icon( 'check', 20, 'toast__icon' ); // phpcs:ignore ?>
	<span class="toast__title" data-toast-title></span>
</div>
