---
name: acf-block-builder
description: Build or update WordPress ACF blocks for the Starter Flexible theme. Use when Codex needs to scaffold a new block, refactor an existing block, move logic out of render.php into inc/helpers.php, define ACF field groups in block JSON, remove full_html overrides, or normalize block data so render templates stay thin.
---

# ACF Block Builder

Build blocks with this theme's house style.

Use this structure by default:

- `blocks/<slug>/block.json` registers the block.
- `blocks/<slug>/<slug>.json` defines the ACF field group.
- `blocks/<slug>/inc/helpers.php` defines and normalizes block data.
- `blocks/<slug>/appearances/default/render.php` contains HTML only.

## Workflow

1. Inspect the target block folder and the theme helpers in `wp-content/themes/starter-flexible/inc/`.
2. Keep `render.php` as a thin template. Move normalization, defaults, placeholder content, filtering, and derived values into `inc/helpers.php`.
3. Build block data through `starter_flexible_block_data_<slug>( array $block )`.
4. Return a fully prepared object for rendering:
   - merge fixed defaults first
   - merge ACF values over those defaults
   - precompute booleans like `has_title`, `has_items`, `should_render`
   - precompute UI-ready values like `module_class`, `style`, `class_name`, `content_html`
5. Keep repeaters normalized in helpers. Do not leave `continue`, field parsing, or delay/index calculations inside `render.php` unless there is a strong reason.
6. Remove `full_html` fields and any render override path unless the user explicitly asks for that behavior.

## Conventions

- Name helper functions `starter_flexible_block_data_<slug>()`.
- Use `starter_flexible_get_block_fields( $block )` as the base field source.
- Prefer fixed default arrays in helpers so empty fields still render meaningful placeholder content.
- Let user input override defaults naturally by merging ACF data on top of the defaults.
- Skip placeholder generation for repeater rows unless the user explicitly asks for repeater placeholders.
- Build module classes in helpers, typically through `starter_flexible_build_module_class()`.
- Keep `render.php` focused on `if`, `foreach`, and escaped output.
- Use `wp_kses_post()` for rich text HTML and `esc_html()` for plain text.

## UI Rules

- Do not invent decorative or marketing-heavy description copy. Follow the user's requested content and tone directly.
- When the user has not explicitly asked for a styled or custom visual treatment, keep the UI flat and close to Material Design in clarity and spacing.
- Read existing theme styles before writing UI code, especially `wp-content/themes/starter-flexible/fe/src/styles/_base.scss`.
- Reuse what the project already defines in SCSS, class naming, spacing, typography, and component patterns before adding new styles.
- Check related files such as `fe/src/styles/_components.scss`, `fe/src/styles/blocks.scss`, and existing block styles before creating new patterns.

## Default Pattern

For a new block helper, follow this shape:

```php
function starter_flexible_block_data_example( array $block ) {
	$data = array_merge(
		array(
			'title'        => 'title',
			'description'  => 'description',
			'items'        => array(),
			'custom_class' => '',
		),
		starter_flexible_get_block_fields( $block )
	);

	$data['module_class'] = starter_flexible_build_module_class( 'module-example', (string) $data['custom_class'] );
	$data['has_title']    = '' !== trim( wp_strip_all_tags( (string) $data['title'] ) );

	return (object) $data;
}
```

For a render file, prefer this shape:

```php
<?php if ( ! $data->should_render ) { return; } ?>

<div class="<?php echo esc_attr( $data->module_class ); ?>">
	<?php if ( $data->has_title ) : ?>
		<h2><?php echo esc_html( $data->title ); ?></h2>
	<?php endif; ?>
</div>
```

## Field Rules

- Put top-level placeholder content in helpers for empty text-like fields.
- Do not auto-fill repeater sub-fields unless explicitly requested.
- Normalize link/image/select values before rendering.
- Precompute repeater row metadata such as `delay`, `index`, `class_name`, or HTML fragments.

## References

- Read `references/theme-pattern.md` when creating or refactoring a block in this project.
