<?php
/**
 * The template for displaying comments
 *
 * @package Starter_Flexible
 * @since 1.0.0
 */

if (post_password_required()) {
	return;
}
?>

<div id="comments" class="comments-area">
	<?php if (have_comments()) : ?>
		<h2 class="comments-title">
			<?php
			$comment_count = get_comments_number();
			if ('1' === $comment_count) {
				printf(
					esc_html__('One thought on &ldquo;%1$s&rdquo;', 'starter-flexible'),
					'<span>' . wp_kses_post(get_the_title()) . '</span>'
				);
			} else {
				printf(
					esc_html(_n('%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $comment_count, 'starter-flexible')),
					number_format_i18n($comment_count),
					'<span>' . wp_kses_post(get_the_title()) . '</span>'
				);
			}
			?>
		</h2>

		<ol class="comment-list">
			<?php
			wp_list_comments(array(
				'style' => 'ol',
				'short_ping' => true,
			));
			?>
		</ol>

		<?php
		the_comments_pagination(array(
			'prev_text' => __('Previous', 'starter-flexible'),
			'next_text' => __('Next', 'starter-flexible'),
		));
		?>
	<?php endif; ?>

	<?php
	if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) {
		?>
		<p class="no-comments"><?php _e('Comments are closed.', 'starter-flexible'); ?></p>
		<?php
	}

	comment_form();
	?>
</div>

