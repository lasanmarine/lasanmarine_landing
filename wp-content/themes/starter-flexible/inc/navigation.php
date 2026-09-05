<?php
/**
 * Navigation rendering for the header bar and the mobile drawer.
 *
 * The Astro site drove its nav from a data file; here it comes from the
 * Header Menu location. A top-level item carrying the CSS class `has-mega`
 * opens the mega panel, built from that item's own children — the same
 * grammar as the Service Architecture block, sized down for a dropdown.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
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
		$classes  = array_filter( (array) $item->classes );
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
				'label'       => (string) $child->title,
				'url'         => (string) $child->url,
				'description' => (string) $child->description,
				'children'    => $grandchildren,
			);
		}

		$path = trailingslashit( (string) ( wp_parse_url( (string) $item->url, PHP_URL_PATH ) ?? '/' ) );

		$tree[] = array(
			'label'       => (string) $item->title,
			'url'         => (string) $item->url,
			'description' => (string) $item->description,
			'mega'        => in_array( 'has-mega', $classes, true ),
			'current'     => '/' === $path ? $current === $path : str_starts_with( $current, $path ),
			'children'    => $children,
		);
	}

	return $tree;
}

/**
 * Render the desktop nav, including the mega panel where one is asked for.
 */
function starter_flexible_render_primary_nav_markup(): void {
	$tree       = starter_flexible_header_menu_tree();
	$mega_title = (string) starter_flexible_setting( 'mega_title', '' );
	$is_english = function_exists( 'pll_current_language' ) && 'en' === pll_current_language( 'slug' );

	foreach ( $tree as $item ) {
		$aria = $item['current'] ? ' aria-current="page"' : '';

		if ( ! $item['mega'] || empty( $item['children'] ) ) {
			printf(
				'<a href="%s" class="hdr__link"%s>%s</a>',
				esc_url( $item['url'] ),
				$aria, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- fixed literal.
				esc_html( $item['label'] )
			);
			continue;
		}
		?>
		<div class="hdr__mega-trigger" data-mega>
			<a href="<?php echo esc_url( $item['url'] ); ?>" class="hdr__link"<?php echo $aria; // phpcs:ignore ?>><?php echo esc_html( $item['label'] ); ?></a>
			<div class="mega" data-mega-panel>
				<div class="container mega__inner">
					<div class="mega__intro">
						<h2 class="mega__title"><?php echo esc_html( '' !== $mega_title ? $mega_title : $item['label'] ); ?></h2>
						<?php if ( '' !== trim( $item['description'] ) ) : ?>
							<p class="copy mega__lead"><?php echo esc_html( $item['description'] ); ?></p>
						<?php endif; ?>
						<a href="<?php echo esc_url( $item['url'] ); ?>" class="link mega__more">
							<?php echo esc_html( $is_english ? 'View details' : 'Xem chi tiết' ); ?>
							<?php echo starter_flexible_icon_swap( 'arrow', 18 ); // phpcs:ignore ?>
						</a>
					</div>

					<div class="mega__sections">
						<?php foreach ( $item['children'] as $child ) : ?>
							<a href="<?php echo esc_url( $child['url'] ); ?>" class="mega__section">
								<span class="mega__text">
									<span class="mega__name"><?php echo esc_html( $child['label'] ); ?></span>
									<?php if ( '' !== trim( $child['description'] ) ) : ?>
										<span class="mega__desc"><?php echo esc_html( $child['description'] ); ?></span>
									<?php endif; ?>
									<?php if ( ! empty( $child['children'] ) ) : ?>
										<span class="mega__children">
											<?php foreach ( $child['children'] as $grandchild ) : ?>
												<span><?php echo esc_html( $grandchild['label'] ); ?></span>
											<?php endforeach; ?>
										</span>
									<?php endif; ?>
								</span>
								<?php echo starter_flexible_icon( 'arrow', 22, 'mega__arrow' ); // phpcs:ignore ?>
							</a>
						<?php endforeach; ?>
					</div>
				</div>
				<span class="mega__rule"></span>
			</div>
		</div>
		<?php
	}
}

/**
 * Render the mobile drawer nav — the same top-level items plus the header CTA.
 *
 * @param array<string, string> $cta Normalised header CTA link.
 */
function starter_flexible_render_drawer_nav_markup( array $cta ): void {
	$items = array();

	foreach ( starter_flexible_header_menu_tree() as $item ) {
		$items[] = array( 'label' => $item['label'], 'url' => $item['url'] );
	}

	if ( '' !== $cta['url'] ) {
		$items[] = array( 'label' => $cta['label'], 'url' => $cta['url'] );
	}

	foreach ( $items as $i => $item ) {
		?>
		<a href="<?php echo esc_url( $item['url'] ); ?>" style="--i:<?php echo esc_attr( (string) $i ); ?>">
			<span class="drawer__label"><?php echo esc_html( $item['label'] ); ?></span>
			<?php echo starter_flexible_icon( 'arrowUpRight', 18, 'drawer__arrow' ); // phpcs:ignore ?>
		</a>
		<?php
	}
}

/**
 * The header markup has two parallel child views (rows and image slides), which
 * cannot be expressed by Walker_Nav_Menu's linear start_el/start_lvl callbacks.
 * These walkers therefore own the complete menu fragment while wp_nav_menu()
 * remains the canonical menu-loading/filtering entry point.
 */
class Starter_Flexible_Primary_Nav_Walker extends Walker_Nav_Menu {
	public function walk( $elements, $max_depth, ...$args ): string { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter
		ob_start();
		starter_flexible_render_primary_nav_markup();
		return (string) ob_get_clean();
	}
}

class Starter_Flexible_Drawer_Nav_Walker extends Walker_Nav_Menu {
	/** @var array<string, string> */
	private array $cta;

	/** @param array<string, string> $cta */
	public function __construct( array $cta ) {
		$this->cta = $cta;
	}

	public function walk( $elements, $max_depth, ...$args ): string { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter
		ob_start();
		starter_flexible_render_drawer_nav_markup( $this->cta );
		return (string) ob_get_clean();
	}
}

function starter_flexible_render_primary_nav(): void {
	wp_nav_menu(
		array(
			'theme_location' => 'header_menu',
			'container'      => false,
			'items_wrap'     => '%3$s',
			'fallback_cb'    => false,
			'walker'         => new Starter_Flexible_Primary_Nav_Walker(),
		)
	);
}

/** @param array<string, string> $cta */
function starter_flexible_render_drawer_nav( array $cta ): void {
	wp_nav_menu(
		array(
			'theme_location' => 'header_menu',
			'container'      => false,
			'items_wrap'     => '%3$s',
			'fallback_cb'    => false,
			'depth'          => 1,
			'walker'         => new Starter_Flexible_Drawer_Nav_Walker( $cta ),
		)
	);
}
