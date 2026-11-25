<?php
/**
 * Shared by the hero/vessel-finder/value-grid/capability-matrix parsers:
 * recognise a theme icon from its inline SVG.
 */

if ( ! function_exists( 'ls_icon_match' ) ) {
	/** Theme icon key whose paths match an inline <svg>, or ''. */
	function ls_icon_match( ?DOMElement $svg ): string {
		if ( ! $svg || ! function_exists( 'starter_flexible_icon_paths' ) ) {
			return '';
		}
		$norm = static fn( string $h ) => (string) preg_replace( array( '/\s+/', '/\s*\/?>/' ), array( ' ', '>' ), trim( $h ) );
		$want = $norm( ls_inner_html( $svg ) );
		foreach ( starter_flexible_icon_paths() as $name => $inner ) {
			$d = ls_load_html( '<html><body><svg id="__i">' . $inner . '</svg></body></html>' );
			if ( $norm( ls_inner_html( ls_one( $d, '#__i' ) ) ) === $want ) {
				return (string) $name;
			}
		}
		return '';
	}
}

