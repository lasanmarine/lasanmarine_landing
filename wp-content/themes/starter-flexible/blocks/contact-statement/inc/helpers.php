<?php
/**
 * Contact Statement — the closing statement on a navy field of stacked waves.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Starter_Flexible_Block_Contact_Statement extends Starter_Flexible_Abstract_Block {
	protected function defaults(): array {
		return array(
			'label'        => '',
			'heading'      => '',
			'description'  => '',
			'phone'        => '',
			'email'        => '',
			'zalo'         => '',
			'cta'          => array(),
			'mascot'       => 0,
			'custom_class' => '',
		);
	}

	protected function base_class(): string {
		return 'block';
	}

	protected function prepare( array $data ): array {

		// Ten strokes drawn from the same curve, each one shifted up and fading.
		$waves = array();
		for ( $i = 0; $i < 10; $i++ ) {
			$waves[] = array(
				'd' => sprintf(
					'M-70 %1$d C200 %2$d 380 %3$d 600 %4$d C820 %5$d 1010 %6$d 1270 %7$d',
					346 - $i * 24,
					268 - $i * 24,
					372 - $i * 24,
					316 - $i * 24,
					260 - $i * 24,
					214 - $i * 24,
					228 - $i * 24
				),
				'w' => max( 2.4 - $i * 0.15, 1 ),
				'o' => number_format( 0.5 * pow( 0.78, $i ), 3, '.', '' ),
			);
		}

		$mascot_id = (int) $data['mascot'];

		$cta     = is_array( $data['cta'] ) ? $data['cta'] : array();
		$cta_url = isset( $cta['url'] ) ? (string) $cta['url'] : '';

		$data['waves']      = $waves;
		// No stand-in image: an unset mascot simply leaves the band to the copy.
		$data['mascot_url'] = $mascot_id ? (string) wp_get_attachment_image_url( $mascot_id, 'full' ) : '';
		$data['has_mascot'] = '' !== $data['mascot_url'];
		$data['cta']        = array(
			'url'    => $cta_url,
			'label'  => isset( $cta['title'] ) ? (string) $cta['title'] : '',
			'target' => ! empty( $cta['target'] ) ? (string) $cta['target'] : '_self',
		);
		$data['has_cta']       = '' !== $cta_url && '' !== $data['cta']['label'];
		$data['has_description'] = '' !== trim( wp_strip_all_tags( (string) $data['description'] ) );
		$data['has_label']     = '' !== trim( (string) $data['label'] );
		$data['has_phone']     = '' !== trim( (string) $data['phone'] );
		$data['has_email']     = '' !== trim( (string) $data['email'] );
		$data['phone_href']    = 'tel:' . preg_replace( '/\s/', '', (string) $data['phone'] );
		// Calling or messaging on Zalo is how customers reach us first.
		$zalo_digits          = preg_replace( '/\D/', '', '' !== trim( (string) $data['zalo'] ) ? (string) $data['zalo'] : (string) $data['phone'] );
		$data['zalo_href']    = '' !== $zalo_digits ? 'https://zalo.me/' . $zalo_digits : '';
		$data['is_english']   = function_exists( 'pll_current_language' ) && 'en' === pll_current_language( 'slug' );

		// The contact details read as a ruled spec list beside the statement.
		$contacts = array();
		if ( $data['has_phone'] ) {
			$contacts[] = array(
				'label' => function_exists( 'pll_current_language' ) && 'en' === pll_current_language( 'slug' ) ? 'Phone' : __( 'Điện thoại', 'starter-flexible' ),
				'value' => trim( (string) $data['phone'] ),
				'href'  => $data['phone_href'],
			);
		}
		if ( $data['has_email'] ) {
			$contacts[] = array(
				'label' => __( 'Email', 'starter-flexible' ),
				'value' => trim( (string) $data['email'] ),
				'href'  => 'mailto:' . trim( (string) $data['email'] ),
			);
		}
		// Phone and Zalo are the buttons, and the email sits under them, so the
		// details are not repeated in a second column.
		$data['contacts']    = array();
		$data['has_contact'] = false;
		$data['email_href']  = $data['has_email'] ? 'mailto:' . trim( (string) $data['email'] ) : '';
		$data['should_render'] = '' !== trim( wp_strip_all_tags( (string) $data['heading'] ) ) || $data['has_phone'] || $data['has_email'];

		return $data;
	}
}

function starter_flexible_block_data_contact_statement( array $block ) {
	return ( new Starter_Flexible_Block_Contact_Statement( $block ) )->data();
}
