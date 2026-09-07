<?php
/**
 * Navigation: the header bar's menu button and the full-screen nav overlay.
 *
 * The Astro site drove its nav from a data file; here it comes from the
 * Header Menu location. Every top-level item becomes one numbered row in the
 * overlay; an item with children carries a panel of its own — on a wide screen
 * the panel opens in the right half beside the list, on a narrow one it drops
 * as an accordion under the row it belongs to. The `has-mega` class the old
 * dropdown needed is no longer read: children alone decide who gets a panel.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const STARTER_FLEXIBLE_MENU_IMAGE_KEY = '_starter_flexible_menu_image';

/**
 * Resolve the preview image for one menu item.
 *
 * The field set on the menu item wins; failing that the linked page's own
 * featured image stands in, so a menu is useful before anyone fills the field.
 *
 * @param WP_Post $item Nav menu item.
 * @return string Image URL, or '' when the row should fall back to the gradient.
 */
function starter_flexible_menu_item_image( WP_Post $item ): string {
	$custom = get_post_meta( $item->ID, STARTER_FLEXIBLE_MENU_IMAGE_KEY, true );

	if ( is_numeric( $custom ) && (int) $custom > 0 ) {
		$url = wp_get_attachment_image_url( (int) $custom, 'large' );
		if ( $url ) {
			return (string) $url;
		}
	} elseif ( is_string( $custom ) && '' !== trim( $custom ) ) {
		return esc_url_raw( trim( $custom ) );
	}

	if ( 'post_type' === $item->type ) {
		$url = get_the_post_thumbnail_url( (int) $item->object_id, 'large' );
		if ( $url ) {
			return (string) $url;
		}
	}

	return '';
}

/**
 * Fetch the header menu as a top-level list, each item carrying its children.
 *
 * @return array<int, array<string, mixed>>
 */
function starter_flexible_header_menu_tree(): array {
	$locations = get_nav_menu_locations();
	$menu_id   = isset( $locations['header_menu'] ) ? (int) $locations['header_menu'] : 0;

	if ( ! $menu_id ) {
		return array();
	}

	$items = wp_get_nav_menu_items( $menu_id );
	if ( ! $items ) {
		return array();
	}

	$by_parent = array();
	foreach ( $items as $item ) {
		$by_parent[ (int) $item->menu_item_parent ][] = $item;
	}

	$current = trailingslashit( wp_parse_url( home_url( add_query_arg( array() ) ), PHP_URL_PATH ) ?? '/' );
	$tree    = array();

	foreach ( $by_parent[0] ?? array() as $item ) {
		$children = array();

		foreach ( $by_parent[ (int) $item->ID ] ?? array() as $child ) {
			$grandchildren = array();
			foreach ( $by_parent[ (int) $child->ID ] ?? array() as $grandchild ) {
				$grandchildren[] = array(
					'label' => (string) $grandchild->title,
					'url'   => (string) $grandchild->url,
				);
			}

			$children[] = array(
				'id'          => (int) $child->ID,
				'label'       => (string) $child->title,
				'url'         => (string) $child->url,
				'description' => (string) $child->description,
				'image'       => starter_flexible_menu_item_image( $child ),
				'children'    => $grandchildren,
			);
		}

		$path = trailingslashit( (string) ( wp_parse_url( (string) $item->url, PHP_URL_PATH ) ?? '/' ) );

		$tree[] = array(
			'id'          => (int) $item->ID,
			'label'       => (string) $item->title,
			'url'         => (string) $item->url,
			'description' => (string) $item->description,
			'image'       => starter_flexible_menu_item_image( $item ),
			'current'     => '/' === $path ? $current === $path : str_starts_with( $current, $path ),
			'children'    => $children,
		);
	}

	return $tree;
}

/**
 * Split an item's children into the two shapes a panel can draw.
 *
 * A child that has children of its own becomes a column headed by its name.
 * A child that has none is a destination in its own right, and those collect
 * into a single list column rather than each taking a column of its own —
 * four one-line columns read as an empty panel.
 *
 * @param array<int, array<string, mixed>> $children Second-level items.
 * @return array{groups: array<int, array<string, mixed>>, loose: array<int, array<string, mixed>>}
 */
function starter_flexible_nav_split_children( array $children ): array {
	$groups = array();
	$loose  = array();

	foreach ( $children as $child ) {
		if ( empty( $child['children'] ) ) {
			$loose[] = $child;
			continue;
		}
		$groups[] = $child;
	}

	return array( 'groups' => $groups, 'loose' => $loose );
}

/**
 * The loose children as one column of large links.
 *
 * @param array<int, array<string, mixed>> $items   Leaf children.
 * @param int                              $index   Position, used to stagger.
 * @param string                           $eyebrow Parent name, or '' to leave it off.
 */
function starter_flexible_nav_list_column( array $items, int $index, string $eyebrow = '' ): void {
	if ( empty( $items ) ) {
		return;
	}
	?>
	<div class="navx__col navx__col--list" style="--c:<?php echo esc_attr( (string) $index ); ?>">
		<?php if ( '' !== $eyebrow ) : ?>
			<span class="navx__col-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
		<?php endif; ?>

		<ul class="navx__biglist">
			<?php foreach ( $items as $leaf ) : ?>
				<li>
					<a href="<?php echo esc_url( $leaf['url'] ); ?>">
						<span><?php echo esc_html( $leaf['label'] ); ?></span>
						<?php echo starter_flexible_icon_swap( 'arrowUpRight', 26 ); // phpcs:ignore ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
	<?php
}

/**
 * One second-level item as a column: its own link, description and the third
 * level under it. The bar's dropdown and the mobile overlay both draw their
 * columns from here, so the two views cannot drift apart.
 *
 * @param array<string, mixed> $column One child item from the menu tree.
 * @param int                  $index  Position, used to stagger the entrance.
 * @param string               $eyebrow Parent name, or '' to leave it off.
 */
function starter_flexible_nav_column( array $column, int $index, string $eyebrow = '' ): void {
	?>
	<div class="navx__col" style="--c:<?php echo esc_attr( (string) $index ); ?>">
		<?php if ( '' !== $column['image'] ) : ?>
			<span class="navx__col-media">
				<img src="<?php echo esc_url( $column['image'] ); ?>" alt="" loading="lazy" decoding="async" />
			</span>
		<?php endif; ?>

		<?php if ( '' !== $eyebrow ) : ?>
			<span class="navx__col-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
		<?php endif; ?>

		<a href="<?php echo esc_url( $column['url'] ); ?>" class="navx__col-name">
			<span><?php echo esc_html( $column['label'] ); ?></span>
			<?php echo starter_flexible_icon_swap( 'arrowUpRight', 26 ); // phpcs:ignore ?>
		</a>

		<?php if ( '' !== trim( $column['description'] ) ) : ?>
			<p class="navx__col-desc"><?php echo esc_html( $column['description'] ); ?></p>
		<?php endif; ?>

		<?php if ( ! empty( $column['children'] ) ) : ?>
			<ul class="navx__sublist">
				<?php foreach ( $column['children'] as $grandchild ) : ?>
					<li>
						<a href="<?php echo esc_url( $grandchild['url'] ); ?>">
							<?php echo esc_html( $grandchild['label'] ); ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
	<?php
}

/**
 * Render the top-level links that live in the bar itself.
 *
 * An item with children carries no panel of its own here: the panels are one
 * full-bleed strip below the bar (see the panels fragment), because a dropdown
 * clipped to a nav item's width has nowhere to put four columns.
 */
function starter_flexible_render_bar_nav_markup(): void {
	foreach ( starter_flexible_header_menu_tree() as $item ) {
		$has_panel = ! empty( $item['children'] );
		$aria      = $item['current'] ? ' aria-current="page"' : '';

		if ( ! $has_panel ) {
			printf(
				'<a href="%s" class="hdr__link"%s>%s</a>',
				esc_url( $item['url'] ),
				$aria, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- fixed literal.
				esc_html( $item['label'] )
			);
			continue;
		}
		?>
		<a
			href="<?php echo esc_url( $item['url'] ); ?>"
			class="hdr__link"
			data-panel-open="<?php echo esc_attr( (string) $item['id'] ); ?>"
			aria-expanded="false"
			aria-controls="hdr-panel-<?php echo esc_attr( (string) $item['id'] ); ?>"
			<?php echo $aria; // phpcs:ignore ?>
		>
			<?php echo esc_html( $item['label'] ); ?>
			<?php echo starter_flexible_icon( 'chevronDown', 15, 'hdr__link-caret' ); // phpcs:ignore ?>
		</a>
		<?php
	}
}

/**
 * Render the dropdown panels as one full-bleed strip under the bar.
 */
function starter_flexible_render_bar_panels_markup(): void {
	$tree = starter_flexible_header_menu_tree();

	foreach ( $tree as $item ) {
		if ( empty( $item['children'] ) ) {
			continue;
		}
		?>
		<div
			class="hdr__panel"
			id="hdr-panel-<?php echo esc_attr( (string) $item['id'] ); ?>"
			data-panel="<?php echo esc_attr( (string) $item['id'] ); ?>"
			data-open="false"
		>
			<div class="container hdr__panel-in">
				<div class="hdr__panel-intro">
					<p class="hdr__panel-title"><?php echo esc_html( $item['label'] ); ?></p>
					<?php if ( '' !== trim( $item['description'] ) ) : ?>
						<p class="hdr__panel-lead"><?php echo esc_html( $item['description'] ); ?></p>
					<?php endif; ?>
					<a href="<?php echo esc_url( $item['url'] ); ?>" class="link hdr__panel-more">
						<?php echo esc_html( __( 'Xem tất cả', 'starter-flexible' ) ); ?>
						<?php echo starter_flexible_icon_swap( 'arrow', 18 ); // phpcs:ignore ?>
					</a>
				</div>

				<div class="hdr__panel-cols">
					<?php
					$split = starter_flexible_nav_split_children( $item['children'] );
					$slot  = 0;

					starter_flexible_nav_list_column( $split['loose'], $slot );
					$slot += empty( $split['loose'] ) ? 0 : 1;

					foreach ( $split['groups'] as $column ) {
						starter_flexible_nav_column( $column, $slot );
						++$slot;
					}
					?>
				</div>
			</div>
		</div>
		<?php
	}
}

/**
 * Render the full-screen nav overlay.
 *
 * Nothing here is hidden behind a gesture: the top-level items stand on the
 * left at heading scale, every group of children stands to their right as its
 * own column, and both bands are on screen the moment the overlay opens. The
 * only motion is the entrance — rows and columns arrive in sequence.
 *
 * @param array<string, string> $cta      Normalised header CTA link.
 * @param array<string, mixed>  $contacts phone, email and social rows.
 */
function starter_flexible_render_nav_overlay_markup( array $cta, array $contacts ): void {
	$tree = starter_flexible_header_menu_tree();
	if ( empty( $tree ) ) {
		return;
	}

	$is_english = function_exists( 'pll_current_language' ) && 'en' === pll_current_language( 'slug' );
	$phone      = (string) ( $contacts['phone'] ?? '' );
	$email      = (string) ( $contacts['email'] ?? '' );
	$social     = (array) ( $contacts['social'] ?? array() );

	// Every child of every top-level item becomes one column, tagged with the
	// parent it came from — the whole second level, flattened but not orphaned.
	$columns = array();
	foreach ( $tree as $item ) {
		$split = starter_flexible_nav_split_children( $item['children'] );

		if ( ! empty( $split['loose'] ) ) {
			$columns[] = array( 'list' => $split['loose'], 'parent' => $item['label'] );
		}
		foreach ( $split['groups'] as $child ) {
			$child['parent'] = $item['label'];
			$columns[]       = $child;
		}
	}

	// When every column descends from the same item, its name belongs above the
	// band once rather than repeated as an eyebrow on each column.
	$parents    = array_unique( array_column( $columns, 'parent' ) );
	$band_title = 1 === count( $parents ) ? (string) reset( $parents ) : '';
	?>
	<div class="navx" id="site-nav" data-nav data-open="false" inert>
		<div class="navx__ground" aria-hidden="true">
			<svg viewBox="0 0 1440 620" preserveAspectRatio="none" class="navx__wave">
				<?php for ( $i = 0; $i < 7; $i++ ) : ?>
					<?php $y = 120 + $i * 62; ?>
					<path
						d="M-60 <?php echo esc_attr( (string) $y ); ?> C300 <?php echo esc_attr( (string) ( $y + 44 ) ); ?> 560 <?php echo esc_attr( (string) ( $y - 30 ) ); ?> 860 <?php echo esc_attr( (string) ( $y + 8 ) ); ?> C1120 <?php echo esc_attr( (string) ( $y + 40 ) ); ?> 1300 <?php echo esc_attr( (string) ( $y + 52 ) ); ?> 1520 <?php echo esc_attr( (string) ( $y + 30 ) ); ?>"
						fill="none"
						stroke="#0A72C8"
						stroke-width="<?php echo esc_attr( number_format( max( 2.2 - $i * 0.16, 0.8 ), 2, '.', '' ) ); ?>"
						stroke-opacity="<?php echo esc_attr( number_format( max( 0.5 - $i * 0.06, 0.06 ), 3, '.', '' ) ); ?>"
						style="--i:<?php echo esc_attr( (string) $i ); ?>"
					/>
				<?php endfor; ?>
			</svg>
		</div>

		<div class="navx__scroll">
			<div class="container navx__grid">
				<nav class="navx__primary" aria-label="<?php echo esc_attr( $is_english ? 'Primary' : 'Chính' ); ?>">
					<?php foreach ( $tree as $i => $item ) : ?>
						<a
							href="<?php echo esc_url( $item['url'] ); ?>"
							class="navx__item"
							style="--i:<?php echo esc_attr( (string) $i ); ?>"
							<?php echo $item['current'] ? 'aria-current="page"' : ''; ?>
						>
							<span class="navx__num"><?php echo esc_html( str_pad( (string) ( $i + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
							<span class="navx__label"><?php echo esc_html( $item['label'] ); ?></span>
							<?php echo starter_flexible_icon( 'arrowUpRight', 22, 'navx__go' ); // phpcs:ignore ?>
						</a>
					<?php endforeach; ?>
				</nav>

				<?php if ( ! empty( $columns ) ) : ?>
					<div class="navx__secondary">
						<?php if ( '' !== $band_title ) : ?>
							<p class="navx__band"><?php echo esc_html( $band_title ); ?></p>
						<?php endif; ?>

						<?php
						foreach ( $columns as $c => $column ) {
							$eyebrow = '' === $band_title ? (string) $column['parent'] : '';

							if ( isset( $column['list'] ) ) {
								starter_flexible_nav_list_column( $column['list'], $c, $eyebrow );
								continue;
							}
							starter_flexible_nav_column( $column, $c, $eyebrow );
						}
						?>
					</div>
				<?php endif; ?>
			</div>

			<div class="container navx__foot">
				<div class="navx__reach">
					<?php if ( '' !== $phone ) : ?>
						<a class="navx__reach-item" href="tel:<?php echo esc_attr( preg_replace( '/\s/', '', $phone ) ); ?>">
							<?php echo starter_flexible_icon( 'phone', 17 ); // phpcs:ignore ?>
							<span><?php echo esc_html( $phone ); ?></span>
						</a>
					<?php endif; ?>
					<?php if ( '' !== $email ) : ?>
						<a class="navx__reach-item" href="mailto:<?php echo esc_attr( $email ); ?>">
							<?php echo starter_flexible_icon( 'mail', 17 ); // phpcs:ignore ?>
							<span><?php echo esc_html( $email ); ?></span>
						</a>
					<?php endif; ?>
				</div>

				<div class="navx__foot-end">
					<div class="navx__social">
						<?php
						foreach ( $social as $row ) :
							$link = starter_flexible_link( $row['link'] ?? array() );
							if ( '' === $link['url'] ) {
								continue;
							}
							?>
							<a href="<?php echo esc_url( $link['url'] ); ?>">
								<?php echo esc_html( $link['label'] ); ?>
								<?php echo starter_flexible_icon( 'arrowUpRight', 13 ); // phpcs:ignore ?>
							</a>
						<?php endforeach; ?>
					</div>

					<?php if ( '' !== $cta['url'] ) : ?>
						<a href="<?php echo esc_url( $cta['url'] ); ?>" class="btn btn--sm navx__cta">
							<?php echo esc_html( $cta['label'] ); ?>
							<?php echo starter_flexible_icon_swap( 'arrowUpRight', 18 ); // phpcs:ignore ?>
						</a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
	<?php
}

/**
 * The bar's links, the panel strip and the overlay are three composed
 * fragments rather than linear item lists, which Walker_Nav_Menu's
 * start_el/start_lvl callbacks cannot express. These walkers therefore own
 * their whole fragment while wp_nav_menu() remains the canonical
 * menu-loading and filtering entry point.
 */
class Starter_Flexible_Bar_Nav_Walker extends Walker_Nav_Menu {
	public function walk( $elements, $max_depth, ...$args ): string { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter
		ob_start();
		starter_flexible_render_bar_nav_markup();
		return (string) ob_get_clean();
	}
}

class Starter_Flexible_Bar_Panels_Walker extends Walker_Nav_Menu {
	public function walk( $elements, $max_depth, ...$args ): string { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter
		ob_start();
		starter_flexible_render_bar_panels_markup();
		return (string) ob_get_clean();
	}
}

/**
 * The overlay is one composed fragment rather than a linear item list, which
 * Walker_Nav_Menu's start_el/start_lvl callbacks cannot express. This walker
 * therefore owns the whole fragment while wp_nav_menu() remains the canonical
 * menu-loading and filtering entry point.
 */
class Starter_Flexible_Nav_Overlay_Walker extends Walker_Nav_Menu {
	/** @var array<string, string> */
	private array $cta;

	/** @var array<string, mixed> */
	private array $contacts;

	/**
	 * @param array<string, string> $cta      Normalised header CTA link.
	 * @param array<string, mixed>  $contacts phone, email and social rows.
	 */
	public function __construct( array $cta, array $contacts ) {
		$this->cta      = $cta;
		$this->contacts = $contacts;
	}

	public function walk( $elements, $max_depth, ...$args ): string { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter
		ob_start();
		starter_flexible_render_nav_overlay_markup( $this->cta, $this->contacts );
		return (string) ob_get_clean();
	}
}

/**
 * @param array<string, string> $cta      Normalised header CTA link.
 * @param array<string, mixed>  $contacts phone, email and social rows.
 */
function starter_flexible_render_bar_nav(): void {
	wp_nav_menu(
		array(
			'theme_location' => 'header_menu',
			'container'      => false,
			'items_wrap'     => '%3$s',
			'fallback_cb'    => false,
			'walker'         => new Starter_Flexible_Bar_Nav_Walker(),
		)
	);
}

function starter_flexible_render_bar_panels(): void {
	wp_nav_menu(
		array(
			'theme_location' => 'header_menu',
			'container'      => false,
			'items_wrap'     => '%3$s',
			'fallback_cb'    => false,
			'walker'         => new Starter_Flexible_Bar_Panels_Walker(),
		)
	);
}

function starter_flexible_render_nav_overlay( array $cta, array $contacts ): void {
	wp_nav_menu(
		array(
			'theme_location' => 'header_menu',
			'container'      => false,
			'items_wrap'     => '%3$s',
			'fallback_cb'    => false,
			'walker'         => new Starter_Flexible_Nav_Overlay_Walker( $cta, $contacts ),
		)
	);
}

/* -------------------------------------------------------------------------
 * Admin: the per-item preview image.
 * ---------------------------------------------------------------------- */

/**
 * Add the preview-image control to each item on Appearance → Menus.
 *
 * @param int $item_id Menu item ID.
 */
function starter_flexible_menu_item_image_field( $item_id ): void {
	$value = (string) get_post_meta( (int) $item_id, STARTER_FLEXIBLE_MENU_IMAGE_KEY, true );
	$field = 'starter-flexible-menu-image-' . (int) $item_id;
	$thumb = is_numeric( $value ) && (int) $value > 0 ? wp_get_attachment_image_url( (int) $value, 'thumbnail' ) : $value;
	?>
	<p class="field-starter-flexible-menu-image description description-wide" data-menu-image>
		<label for="<?php echo esc_attr( $field ); ?>">
			<?php esc_html_e( 'Ảnh preview trong menu', 'starter-flexible' ); ?><br />
			<input
				type="text"
				id="<?php echo esc_attr( $field ); ?>"
				class="widefat"
				name="starter_flexible_menu_image[<?php echo esc_attr( (string) (int) $item_id ); ?>]"
				value="<?php echo esc_attr( $value ); ?>"
				data-menu-image-input
			/>
		</label>
		<button type="button" class="button" data-menu-image-pick><?php esc_html_e( 'Chọn ảnh', 'starter-flexible' ); ?></button>
		<button type="button" class="button-link" data-menu-image-clear><?php esc_html_e( 'Xoá', 'starter-flexible' ); ?></button>
		<span class="description">
			<?php esc_html_e( 'Bỏ trống để dùng ảnh đại diện của trang được liên kết.', 'starter-flexible' ); ?>
		</span>
		<img src="<?php echo esc_url( (string) $thumb ); ?>" alt="" data-menu-image-thumb style="<?php echo '' === (string) $thumb ? 'display:none;' : ''; ?>max-width:120px;height:auto;margin-top:6px;display:block" />
	</p>
	<?php
}
add_action( 'wp_nav_menu_item_custom_fields', 'starter_flexible_menu_item_image_field' );

/**
 * Persist the preview image alongside the rest of the menu item.
 *
 * @param int $menu_id      Menu term ID.
 * @param int $menu_item_id Menu item ID.
 */
function starter_flexible_save_menu_item_image( $menu_id, $menu_item_id ): void { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter
	// wp_update_nav_menu_item() already ran the nonce and capability checks for
	// this request; re-reading our own field here needs no second gate.
	// phpcs:disable WordPress.Security.NonceVerification.Missing
	if ( ! isset( $_POST['starter_flexible_menu_image'] ) || ! is_array( $_POST['starter_flexible_menu_image'] ) ) {
		return;
	}

	$raw = wp_unslash( $_POST['starter_flexible_menu_image'] );
	// phpcs:enable WordPress.Security.NonceVerification.Missing

	if ( ! array_key_exists( (int) $menu_item_id, $raw ) ) {
		return;
	}

	$value = trim( (string) $raw[ (int) $menu_item_id ] );

	if ( '' === $value ) {
		delete_post_meta( (int) $menu_item_id, STARTER_FLEXIBLE_MENU_IMAGE_KEY );
		return;
	}

	$value = is_numeric( $value ) ? (string) absint( $value ) : esc_url_raw( $value );
	update_post_meta( (int) $menu_item_id, STARTER_FLEXIBLE_MENU_IMAGE_KEY, $value );
}
add_action( 'wp_update_nav_menu_item', 'starter_flexible_save_menu_item_image', 10, 2 );

/**
 * Wire the field's "Chọn ảnh" button to the media modal.
 *
 * @param string $hook Current admin page.
 */
function starter_flexible_menu_image_admin_assets( $hook ): void {
	if ( 'nav-menus.php' !== $hook ) {
		return;
	}

	wp_enqueue_media();
	wp_add_inline_script(
		'media-editor',
		<<<'JS'
jQuery(function ($) {
	var frame;
	$(document).on('click', '[data-menu-image-pick]', function () {
		var box = $(this).closest('[data-menu-image]');
		frame = wp.media({ title: 'Ảnh preview trong menu', multiple: false, library: { type: 'image' } });
		frame.on('select', function () {
			var img = frame.state().get('selection').first().toJSON();
			box.find('[data-menu-image-input]').val(img.id).trigger('change');
			var src = (img.sizes && img.sizes.thumbnail ? img.sizes.thumbnail.url : img.url);
			box.find('[data-menu-image-thumb]').attr('src', src).show();
		});
		frame.open();
	});
	$(document).on('click', '[data-menu-image-clear]', function () {
		var box = $(this).closest('[data-menu-image]');
		box.find('[data-menu-image-input]').val('').trigger('change');
		box.find('[data-menu-image-thumb]').attr('src', '').hide();
	});
});
JS
	);
}
add_action( 'admin_enqueue_scripts', 'starter_flexible_menu_image_admin_assets' );
