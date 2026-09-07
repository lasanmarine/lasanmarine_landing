<?php
/**
 * Design Brief — the form an engineer fills in to open a design job.
 *
 * Lookup lists come from two places: the ones that are already maintained in
 * Site Settings → Tools (engines, shaft materials) are read from there so the
 * form never drifts from the calculators, and the rest live in
 * blocks/design-brief/inc/catalogs.json.
 *
 * Nothing is stored on the server: the brief is one JSON object — whatever was
 * typed, keyed by field name — kept in the browser while it is being written
 * and posted through Contact Form 7 when it is sent.
 *
 * @package Starter_Flexible
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** @return array<string, mixed> */
function starter_flexible_design_brief_catalogs(): array {
	static $cache = null;
	if ( null !== $cache ) {
		return $cache;
	}
	$file = __DIR__ . '/catalogs.json';
	$json = is_file( $file ) ? json_decode( (string) file_get_contents( $file ), true ) : null;

	return $cache = is_array( $json ) ? $json : array();
}

final class Starter_Flexible_Block_Design_Brief extends Starter_Flexible_Abstract_Block {
	protected function defaults(): array {
		return array(
			'label'        => 'NHIỆM VỤ THƯ',
			'heading'      => 'Xây dựng nhiệm vụ thư thiết kế',
			'intro'        => '',
			'cf7_form'     => 0,
			'doc_org'      => '',
			'doc_place'    => 'Khánh Hòa',
			'doc_symbol'   => 'NVT-LSM',
			'custom_class' => '',
		);
	}

	protected function base_class(): string {
		return 'block container db';
	}

	protected function prepare( array $data ): array {

		$catalogs = starter_flexible_design_brief_catalogs();

		// Engines drive three fields at once: picking a model fills in power and
		// rpm, which the shaft diameter is then computed from.
		$engines = array();
		foreach ( starter_flexible_machines() as $row ) {
			$make  = (string) ( $row['make'] ?? '' );
			$model = (string) ( $row['model'] ?? '' );
			if ( '' === trim( $make ) || '' === trim( $model ) ) {
				continue;
			}
			$engines[] = array(
				'make'  => $make,
				'model' => $model,
				'kw'    => isset( $row['kw'] ) ? (float) $row['kw'] : 0.0,
				'rpm'   => isset( $row['rpm'] ) ? (float) $row['rpm'] : 0.0,
			);
		}

		$materials = array();
		foreach ( starter_flexible_shaft_materials() as $i => $material ) {
			$materials[] = array(
				'code' => sprintf( 'VL-%03d', $i + 1 ),
				'name' => (string) $material['name'],
				'note' => (string) $material['note'],
				'k3'   => (float) $material['k3'],
			);
		}

		$cf7 = is_object( $data['cf7_form'] ) ? (int) $data['cf7_form']->ID : (int) $data['cf7_form'];

		$data['cf7_id']        = $cf7 && 'wpcf7_contact_form' === get_post_type( $cf7 ) ? $cf7 : 0;
		$data['catalogs']      = $catalogs;
		$data['engines']       = $engines;
		$data['materials']     = $materials;
		$data['has_intro']     = '' !== trim( (string) $data['intro'] );
		$data['should_render'] = true;

		$data['engines_json'] = $this->json( $data['engines'] );

		$data['form_html'] = $data['cf7_id'] > 0 ? do_shortcode( sprintf( '[contact-form-7 id="%d"]', $data['cf7_id'] ) ) : '';

		// Dimensions are read one family at a time — hull, then each cabin deck —
		// so a row on screen is a row a surveyor measures in one go.
		$data['dimension_rows'] = array(
			array(
				array( 'lmax', 'Chiều dài Lmax', 'm' ),
				array( 'bmax', 'Chiều rộng Bmax', 'm' ),
				array( 'depth', 'Chiều cao mạn D', 'm' ),
				array( 'frame_space', 'Khoảng cách sườn', 'mm' ),
			),
			array(
				array( 'cabin1_l', 'Cabin tầng 1 — dài', 'm' ),
				array( 'cabin1_b', 'Cabin tầng 1 — rộng', 'm' ),
				array( 'cabin1_h', 'Cabin tầng 1 — cao', 'm' ),
			),
			array(
				array( 'cabin2_l', 'Cabin tầng 2 — dài', 'm' ),
				array( 'cabin2_b', 'Cabin tầng 2 — rộng', 'm' ),
				array( 'cabin2_h', 'Cabin tầng 2 — cao', 'm' ),
			),
		);

		// Hull members keep their old hull_0…hull_35 names: the catalogue groups
		// them for the eye, the running index keeps drafts readable.
		$data['hull_groups'] = array();
		$index               = 0;
		foreach ( (array) ( $catalogs['hull_members'] ?? array() ) as $title => $members ) {
			$fields = array();
			foreach ( (array) $members as $member ) {
				$fields[] = array( 'name' => 'hull_' . $index, 'label' => (string) $member );
				++$index;
			}
			$data['hull_groups'][] = array( 'title' => (string) $title, 'fields' => $fields );
		}

		$data['catalog_options']['design_types'] = starter_flexible_design_brief_options( (array) $catalogs['design_types'] );
		$data['catalog_options']['provinces']    = starter_flexible_design_brief_options( (array) $catalogs['provinces'] );
		$data['catalog_options']['registries']   = starter_flexible_design_brief_options( (array) $catalogs['registries'] );

		$data['material_options'] = array_map(
			static fn( array $m ): array => array(
				'value' => $m['code'],
				'label' => $m['code'] . ' · ' . $m['name'],
				'data'  => array( 'k3' => $m['k3'] ),
			),
			$data['materials']
		);

		$data['make_options'] = array_values( array_unique( array_column( $data['engines'], 'make' ) ) );

		// Letterhead for the printed brief. Kept out of the DOM the form uses so
		// the document can be assembled without reading the page's chrome.
		// Blocks saved before these fields existed hand back null, so each one
		// falls back rather than printing an empty letterhead.
		$fallback = static fn( $value, string $default ): string => '' !== trim( (string) $value ) ? trim( (string) $value ) : $default;

		$data['doc'] = array(
			'org'     => $fallback( $data['doc_org'], $fallback( starter_flexible_setting( 'legal_name', '' ), 'CÔNG TY TNHH LASAN MARINE' ) ),
			'place'   => $fallback( $data['doc_place'], 'Khánh Hòa' ),
			'symbol'  => $fallback( $data['doc_symbol'], 'NVT-LSM' ),
			'address' => (string) starter_flexible_setting( 'address', '' ),
			'phone'   => (string) starter_flexible_setting( 'phone', '' ),
			'email'   => (string) starter_flexible_setting( 'email', '' ),
			'tax'     => (string) starter_flexible_setting( 'tax_code', '' ),
		);

		$data['doc_json'] = $this->json( $data['doc'] );

		return $data;
	}
}

function starter_flexible_block_data_design_brief( array $block ) {
	return ( new Starter_Flexible_Block_Design_Brief( $block ) )->data();
}

/**
 * Normalise one option into value / label / data, so callers may pass a plain
 * string, or an array carrying data-attributes for the script to read.
 *
 * @param mixed $option Raw option.
 * @return array{value: string, label: string, data: array<string, mixed>}
 */
function starter_flexible_design_brief_option( $option ): array {
	if ( ! is_array( $option ) ) {
		return array( 'value' => (string) $option, 'label' => (string) $option, 'data' => array() );
	}

	return array(
		'value' => (string) ( $option['value'] ?? '' ),
		'label' => (string) ( $option['label'] ?? $option['value'] ?? '' ),
		'data'  => (array) ( $option['data'] ?? array() ),
	);
}

/**
 * One labelled control. `unit` prints a suffix inside the field, `hint` a line
 * under it; everything else is forwarded to the input.
 *
 * A `combo` is a plain text box with the catalogue laid out under it: type
 * anything, or click an entry and it is written into the box. Nothing is
 * locked to a list — a tỉnh or a máy that is not in the catalogue is typed.
 * The wrapper carries name / label / unit, which is all the script needs to
 * turn the form into JSON without walking back up to a `<label for>`.
 *
 * @param array<string, mixed> $args
 */
function starter_flexible_design_brief_field( array $args ): void {
	$name  = (string) ( $args['name'] ?? '' );
	$type  = (string) ( $args['type'] ?? 'text' );
	$id    = 'db-' . $name;
	$label = (string) ( $args['label'] ?? '' );
	$unit  = (string) ( $args['unit'] ?? '' );
	$hint  = (string) ( $args['hint'] ?? '' );
	$value = (string) ( $args['value'] ?? '' );

	$attrs = '';
	foreach ( (array) ( $args['attrs'] ?? array() ) as $key => $val ) {
		$attrs .= true === $val ? ' ' . esc_attr( (string) $key ) : sprintf( ' %s="%s"', esc_attr( (string) $key ), esc_attr( (string) $val ) );
	}

	$classes = 'field db__field';
	if ( ! empty( $args['wide'] ) ) {
		$classes .= ' db__field--wide';
	}
	if ( 'combo' === $type ) {
		$classes .= ' db__field--combo';
	}
	?>
	<div class="<?php echo esc_attr( $classes ); ?>" data-db-field data-name="<?php echo esc_attr( $name ); ?>" data-label="<?php echo esc_attr( $label ); ?>"<?php echo '' !== $unit ? ' data-unit="' . esc_attr( $unit ) . '"' : ''; ?><?php echo 'combo' === $type ? $attrs : ''; // phpcs:ignore ?>>

		<label class="field__label" for="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $label ); ?></label>

		<?php if ( 'textarea' === $type ) : ?>
			<textarea class="field__control" id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name ); ?>" rows="3"<?php echo $attrs; // phpcs:ignore ?>><?php echo esc_textarea( $value ); ?></textarea>

		<?php elseif ( 'combo' === $type ) : ?>
			<div class="db__control">
				<input
					class="field__control"
					id="<?php echo esc_attr( $id ); ?>"
					name="<?php echo esc_attr( $name ); ?>"
					type="text"
					value="<?php echo esc_attr( $value ); ?>"
					autocomplete="off"
					data-db-input
					placeholder="<?php echo esc_attr( (string) ( $args['placeholder'] ?? __( 'Nhập hoặc chọn bên dưới', 'starter-flexible' ) ) ); ?>"
				/>
			</div>
			<div class="db__presets<?php echo ! empty( $args['scroll'] ) ? ' db__presets--scroll' : ''; ?>" data-db-presets>
				<?php foreach ( (array) ( $args['options'] ?? array() ) as $raw ) : ?>
					<?php
					$option   = starter_flexible_design_brief_option( $raw );
					$opt_data = '';
					foreach ( $option['data'] as $dk => $dv ) {
						$opt_data .= sprintf( ' data-%s="%s"', esc_attr( (string) $dk ), esc_attr( (string) $dv ) );
					}
					?>
					<button
						type="button"
						class="db__preset"
						data-value="<?php echo esc_attr( $option['label'] ); ?>"
						data-code="<?php echo esc_attr( $option['value'] ); ?>"<?php echo $opt_data; // phpcs:ignore ?>
					><?php echo esc_html( $option['label'] ); ?></button>
				<?php endforeach; ?>
				<?php if ( empty( $args['options'] ) ) : ?>
					<p class="db__presets-empty"><?php echo esc_html( (string) ( $args['empty'] ?? __( 'Chưa có gợi ý.', 'starter-flexible' ) ) ); ?></p>
				<?php endif; ?>
			</div>

		<?php else : ?>
			<div class="db__control<?php echo '' !== $unit ? ' db__control--unit' : ''; ?>">
				<input
					class="field__control"
					id="<?php echo esc_attr( $id ); ?>"
					name="<?php echo esc_attr( $name ); ?>"
					type="<?php echo esc_attr( $type ); ?>"
					value="<?php echo esc_attr( $value ); ?>"
					<?php echo 'number' === $type ? 'step="any" inputmode="decimal"' : ''; ?>
					<?php echo $attrs; // phpcs:ignore ?>
				/>
				<?php if ( '' !== $unit ) : ?>
					<span class="db__unit"><?php echo esc_html( $unit ); ?></span>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( '' !== $hint ) : ?>
			<span class="field__hint"><?php echo esc_html( $hint ); ?></span>
		<?php endif; ?>
	</div>
	<?php
}

/**
 * One row of fields that belong together — the same measurement family, the
 * same piece of equipment — optionally titled.
 *
 * @param array<int, array<string, mixed>> $fields Field argument arrays.
 * @param array<string, mixed>             $args   `cols` (1–5) and `title`.
 */
function starter_flexible_design_brief_row( array $fields, array $args = array() ): void {
	$fields = array_values( array_filter( $fields ) );
	if ( ! $fields ) {
		return;
	}
	$cols  = max( 1, min( 5, (int) ( $args['cols'] ?? count( $fields ) ) ) );
	$title = (string) ( $args['title'] ?? '' );
	?>
	<div class="db__row-group">
		<?php if ( '' !== $title ) : ?>
			<span class="db__row-title"><?php echo esc_html( $title ); ?></span>
		<?php endif; ?>
		<div class="db__row db__row--<?php echo (int) $cols; ?>">
			<?php foreach ( $fields as $field ) : ?>
				<?php starter_flexible_design_brief_field( (array) $field ); ?>
			<?php endforeach; ?>
		</div>
	</div>
	<?php
}

function starter_flexible_design_brief_options( array $rows, string $sep = ' · ' ): array {
	return array_map(
		static fn( array $row ): array => array(
			'value' => $row['code'],
			'label' => $row['code'] . $sep . $row['name'],
		),
		$rows
	);
}
