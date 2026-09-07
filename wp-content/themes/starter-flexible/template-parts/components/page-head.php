<?php
/**
 * Page head — the navy band that opens a listing: where you are, what you are
 * looking at, and how much of it.
 *
 * The same header serves the post archives and the project taxonomies, so a
 * reader never lands on a page that looks like it belongs to another site.
 *
 * @var array $args crumbs (array of ['label','url']), eyebrow, title, lead,
 *                  note, aside (pre-rendered HTML placed at the right)
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$crumbs  = isset( $args['crumbs'] ) && is_array( $args['crumbs'] ) ? $args['crumbs'] : array();
$eyebrow = isset( $args['eyebrow'] ) ? (string) $args['eyebrow'] : '';
$title   = isset( $args['title'] ) ? (string) $args['title'] : '';
$lead    = isset( $args['lead'] ) ? (string) $args['lead'] : '';
$note    = isset( $args['note'] ) ? (string) $args['note'] : '';
$aside   = isset( $args['aside'] ) ? (string) $args['aside'] : '';
?>
<header class="phead">
	<span class="phead__scrim" aria-hidden="true"></span>
	<div class="container phead__inner">
		<div class="phead__copy">
			<?php if ( $crumbs ) : ?>
				<nav class="phead__crumbs" aria-label="<?php esc_attr_e( 'Đường dẫn', 'starter-flexible' ); ?>">
					<?php foreach ( $crumbs as $i => $crumb ) : ?>
						<?php if ( $i > 0 ) : ?>
							<span class="phead__sep" aria-hidden="true">/</span>
						<?php endif; ?>
						<?php if ( ! empty( $crumb['url'] ) ) : ?>
							<a href="<?php echo esc_url( (string) $crumb['url'] ); ?>"><?php echo esc_html( (string) $crumb['label'] ); ?></a>
						<?php else : ?>
							<span aria-current="page"><?php echo esc_html( (string) $crumb['label'] ); ?></span>
						<?php endif; ?>
					<?php endforeach; ?>
				</nav>
			<?php endif; ?>

			<?php if ( '' !== $eyebrow ) : ?>
				<span class="phead__eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
			<?php endif; ?>

			<h1 class="phead__title"><?php echo esc_html( $title ); ?></h1>

			<?php if ( '' !== $lead ) : ?>
				<p class="phead__lead"><?php echo esc_html( $lead ); ?></p>
			<?php endif; ?>
			<?php if ( '' !== $note ) : ?>
				<p class="phead__note"><?php echo esc_html( $note ); ?></p>
			<?php endif; ?>
		</div>

		<?php if ( '' !== $aside ) : ?>
			<div class="phead__aside"><?php echo $aside; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- built by the caller. ?></div>
		<?php endif; ?>
	</div>
</header>
