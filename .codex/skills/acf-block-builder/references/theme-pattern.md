# Starter Flexible Block Pattern

Use these project-specific rules for ACF blocks in this theme.

## Paths

- Theme root: `wp-content/themes/starter-flexible`
- Shared helpers: `wp-content/themes/starter-flexible/inc/helpers.php`
- Block registry/render bootstrap: `wp-content/themes/starter-flexible/inc/blocks.php`
- Block folder pattern:
  - `blocks/<slug>/block.json`
  - `blocks/<slug>/<slug>.json`
  - `blocks/<slug>/inc/helpers.php`
  - `blocks/<slug>/appearances/default/render.php`

## Current Standards

- `inc/helpers.php` is the source of truth for:
  - merged defaults
  - placeholder content
  - ACF field normalization
  - repeater item preparation
  - derived display flags
- `render.php` should stay thin and should not contain:
  - field parsing
  - image/link normalization
  - `continue`-driven cleanup loops
  - `full_html` override branches

## Shared Helper Usage

- Use `starter_flexible_get_block_fields( $block )` to fetch normalized ACF fields.
- Use `starter_flexible_build_module_class()` to combine base and custom classes.
- The shared helper already removes `full_html`.
- The shared helper already applies placeholder content for empty top-level text-like fields.

## Editing Guidance

- Prefer updating existing block helpers over adding ad hoc logic in templates.
- If a block has repeaters, prepare clean rows in helpers and render only the final values.
- If a block is missing defaults, add them in the block helper with `array_merge`.
- Keep naming consistent with existing functions: `starter_flexible_block_data_<slug>`.

## UI Guidance

- Read `wp-content/themes/starter-flexible/fe/src/styles/_base.scss` first when touching UI.
- Reuse existing typography, spacing, form, button, and layout rules before adding custom CSS.
- If the user did not request a specific visual direction, keep the result flat, restrained, and close to Material Design.
- Do not embellish descriptions or content copy. Render the content the user asked for, without adding decorative marketing language.
