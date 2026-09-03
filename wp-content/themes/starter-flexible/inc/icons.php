<?php
/**
 * Icon set — Lucide, stroke 1.5, the only icon set the system uses.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Inner paths for every icon, keyed by the name used in markup.
 *
 * @return array<string, string>
 */
function starter_flexible_icon_paths(): array {
	static $paths = null;

	if ( null !== $paths ) {
		return $paths;
	}

	$paths = array(
		'arrow'        => '<path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path>',
		'arrowUpRight' => '<path d="M7 7h10v10"></path><path d="M7 17 17 7"></path>',
		'arrowLeft'    => '<path d="m12 19-7-7 7-7"></path><path d="M19 12H5"></path>',
		'arrowUp'      => '<path d="m5 12 7-7 7 7"></path><path d="M12 19V5"></path>',
		'chevronLeft'  => '<path d="m15 18-6-6 6-6"></path>',
		'chevronRight' => '<path d="m9 18 6-6-6-6"></path>',
		'download'     => '<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><path d="m7 10 5 5 5-5"></path><path d="M12 15V3"></path>',
		'file'         => '<path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path><path d="M14 2v4a2 2 0 0 0 2 2h4"></path>',
		'phone'        => '<path d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384"></path>',
		'mail'         => '<path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"></path><rect x="2" y="4" width="20" height="16" rx="2"></rect>',
		'pin'          => '<path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0"></path><circle cx="12" cy="10" r="3"></circle>',
		'ship'         => '<path d="M2 21c.6.5 1.2 1 2.5 1 2.5 0 2.5-2 5-2 2.5 0 2.5 2 5 2 1.3 0 1.9-.5 2.5-1"></path><path d="M19.38 20A11.6 11.6 0 0 0 21 14l-9-4-9 4c0 2.9.94 5.34 2.81 7.76"></path><path d="M19 13V7a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v6"></path><path d="M12 10v4"></path><path d="M12 2v3"></path>',
		'waves'        => '<path d="M2 6c.6.5 1.2 1 2.5 1C7 7 7 5 9.5 5c2.6 0 2.4 2 5 2 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1"></path><path d="M2 12c.6.5 1.2 1 2.5 1 2.5 0 2.5-2 5-2 2.6 0 2.4 2 5 2 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1"></path><path d="M2 18c.6.5 1.2 1 2.5 1 2.5 0 2.5-2 5-2 2.6 0 2.4 2 5 2 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1"></path>',
		'ruler'        => '<path d="M21.3 15.3a2.4 2.4 0 0 1 0 3.4l-2.6 2.6a2.4 2.4 0 0 1-3.4 0L2.7 8.7a2.41 2.41 0 0 1 0-3.4l2.6-2.6a2.41 2.41 0 0 1 3.4 0Z"></path><path d="m14.5 12.5 2-2"></path><path d="m11.5 9.5 2-2"></path><path d="m8.5 6.5 2-2"></path><path d="m17.5 15.5 2-2"></path>',
		'link'         => '<path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path>',
		'scan'         => '<path d="M3 7V5a2 2 0 0 1 2-2h2"></path><path d="M17 3h2a2 2 0 0 1 2 2v2"></path><path d="M21 17v2a2 2 0 0 1-2 2h-2"></path><path d="M7 21H5a2 2 0 0 1-2-2v-2"></path><circle cx="12" cy="12" r="3"></circle><path d="m16 16-1.9-1.9"></path>',
		'wrench'       => '<path d="m15 12-8.5 8.5a2.12 2.12 0 1 1-3-3L12 9"></path><path d="M17.64 15 22 10.64"></path><path d="M20.91 11.7l-1.25-1.25c-.6-.6-.93-1.4-.93-2.25v-.86L16.01 4.6a5.56 5.56 0 0 0-3.94-1.64H9l.92.82A6.18 6.18 0 0 1 12 8.4v1.56l2 2h2.47l2.26 1.91"></path>',
		'compass'      => '<circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="4"></circle><path d="m4.93 4.93 4.24 4.24"></path><path d="m14.83 9.17 4.24-4.24"></path><path d="m14.83 14.83 4.24 4.24"></path><path d="m4.93 19.07 4.24-4.24"></path>',
		'award'        => '<path d="M15.477 12.89 17.5 22l-5.5-3.5L6.5 22l2.023-9.11"></path><circle cx="12" cy="8" r="6"></circle>',
		'check'        => '<path d="M21.801 10A10 10 0 1 1 17 3.335"></path><path d="m9 11 3 3L22 4"></path>',
		'close'        => '<path d="M18 6 6 18"></path><path d="m6 6 12 12"></path>',
		'plus'         => '<path d="M5 12h14"></path><path d="M12 5v14"></path>',
		'calculator'   => '<rect width="16" height="20" x="4" y="2" rx="2"></rect><line x1="8" x2="16" y1="6" y2="6"></line><line x1="16" x2="16" y1="14" y2="18"></line><path d="M16 10h.01"></path><path d="M12 10h.01"></path><path d="M8 10h.01"></path><path d="M12 14h.01"></path><path d="M8 14h.01"></path><path d="M12 18h.01"></path><path d="M8 18h.01"></path>',
		'gauge'        => '<path d="m12 14 4-4"></path><path d="M3.34 19a10 10 0 1 1 17.32 0"></path>',
		'search'       => '<circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path>',
	);

	return $paths;
}

/**
 * Return one icon as an inline SVG string. Unknown names fall back to `arrow`,
 * matching the Astro component.
 *
 * @param string $name   Icon key.
 * @param int    $size   Width and height in px.
 * @param string $class  Extra classes on the <svg>.
 * @param float  $stroke Stroke width.
 */
function starter_flexible_icon( string $name, int $size = 19, string $class = '', float $stroke = 1.5 ): string {
	$paths = starter_flexible_icon_paths();
	$inner = $paths[ $name ] ?? $paths['arrow'];

	return sprintf(
		'<svg width="%1$d" height="%1$d" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="%2$s" stroke-linecap="round" stroke-linejoin="round" class="%3$s" style="flex:none" aria-hidden="true">%4$s</svg>',
		$size,
		esc_attr( (string) $stroke ),
		esc_attr( $class ),
		$inner
	);
}

/**
 * Allow the icon markup through wp_kses when a caller needs to escape it.
 *
 * @return array<string, array<string, bool>>
 */
function starter_flexible_icon_kses(): array {
	return array(
		'svg'    => array(
			'width' => true, 'height' => true, 'viewbox' => true, 'fill' => true,
			'stroke' => true, 'stroke-width' => true, 'stroke-linecap' => true,
			'stroke-linejoin' => true, 'class' => true, 'style' => true,
			'aria-hidden' => true, 'preserveaspectratio' => true, 'data-wave' => true,
		),
		'path'   => array( 'd' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true ),
		'circle' => array( 'cx' => true, 'cy' => true, 'r' => true ),
		'rect'   => array( 'x' => true, 'y' => true, 'width' => true, 'height' => true, 'rx' => true ),
		'line'   => array( 'x1' => true, 'x2' => true, 'y1' => true, 'y2' => true ),
	);
}
