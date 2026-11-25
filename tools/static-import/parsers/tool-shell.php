<?php
/**
 * Tool Shell. Its only own field is custom_class; the calculator is an inner
 * block (power-converter / shaft-diameter / engine-lookup), see ls_tool_shell_inner().
 */

/**
 * Inner block entries of a static tool shell: one {type, fields} per island.
 *
 * @return array<int, array<string, mixed>>
 */
if ( ! function_exists( 'ls_tool_shell_inner' ) ) {
	function ls_tool_shell_inner( DOMElement $s ): array {
		$inner = array();
		foreach ( ls_all( $s, '.island' ) as $island ) {
			$slug = (string) $island->getAttribute( 'data-island' );
			if ( '' === $slug ) {
				continue;
			}
			$parser = __DIR__ . '/' . $slug . '.php';
			$fields = is_file( $parser ) ? ( require $parser )( $island, array() ) : array();
			$inner[] = array( 'type' => $slug, 'fields' => $fields );
		}
		return $inner;
	}
}

return static function ( DOMElement $s, array $page ): array {
	$custom = array_diff( ls_classes( $s ), array( 'block', 'container', 'lasanmarine-tool-shell' ) );
	return array( 'custom_class' => implode( ' ', $custom ) );
};
