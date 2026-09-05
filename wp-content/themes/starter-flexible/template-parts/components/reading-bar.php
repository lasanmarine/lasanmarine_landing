<?php
/**
 * Reading bar — the strip that appears under the header once the reader has
 * scrolled past the opening: what they are reading, who wrote it, and how far
 * along they are.
 *
 * @var array $args title, byline
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$title  = isset( $args['title'] ) ? (string) $args['title'] : '';
$byline = isset( $args['byline'] ) ? (string) $args['byline'] : '';
?>
<div class="reading-bar" data-reading-bar hidden>
	<div class="container reading-bar__inner">
		<span class="reading-bar__title"><?php echo esc_html( $title ); ?></span>
		<?php if ( '' !== $byline ) : ?>
			<span class="reading-bar__byline"><?php echo esc_html( $byline ); ?></span>
		<?php endif; ?>
	</div>
	<span class="reading-bar__rail" aria-hidden="true">
		<span class="reading-bar__fill" data-post-progress></span>
	</span>
</div>
