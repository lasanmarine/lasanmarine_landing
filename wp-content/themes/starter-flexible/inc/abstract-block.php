<?php
/**
 * Shared data pipeline for ACF blocks. Templates receive prepared data only.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class Starter_Flexible_Abstract_Block {
	protected array $block;

	public function __construct( array $block ) {
		$this->block = $block;
	}

	abstract protected function defaults(): array;

	abstract protected function base_class(): string;

	abstract protected function prepare( array $data ): array;

	final public function data(): object {
		$data = $this->prepare( array_merge( $this->defaults(), starter_flexible_get_block_fields( $this->block ) ) );
		$data['module_class'] = starter_flexible_build_module_class( $this->base_class(), (string) ( $data['custom_class'] ?? '' ) );
		$data['anchor'] = (string) ( ! empty( $this->block['anchor'] ) ? $this->block['anchor'] : ( $data['anchor'] ?? '' ) );
		$data['spacing_style'] = starter_flexible_module_spacing_style( $this->block );
		$data['should_render'] = $data['should_render'] ?? true;

		return (object) $data;
	}

	protected function has_text( $value ): bool {
		return '' !== trim( (string) $value );
	}

	protected function unique_id( string $prefix ): string {
		return wp_unique_id( $prefix );
	}

	/** Safe for embedding in an application/json script element. */
	protected function json( $value ): string {
		$json = wp_json_encode( $value, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT );
		return false === $json ? 'null' : $json;
	}
}
