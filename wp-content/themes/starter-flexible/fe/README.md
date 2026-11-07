# Frontend

Svelte 5 (runes) · Vite 7 · SCSS + Tailwind 3 · Vitest. Blocks stay ACF + PHP:
fields, `render.php` markup and `style.scss` are unchanged by the JS layer.

## Commands

```bash
npm install
npm run dev     # Vite dev server on :5173 with HMR (PHP sees fe/.vite-dev and loads from it)
npm run build   # dist/ — run before deploying (CI does it)
npm test        # unit tests in tests/
```

`npm run build` rewrites `src/styles/blocks.scss` with LF endings; `git checkout` it afterwards.

## How the JS is organised

Everything starts in `src/main.js` → `src/runtime/boot.js`, which does two things:

| Kind | What it is | Where | When to use |
| --- | --- | --- | --- |
| **Behaviour** | `export const selector`, `export default (node) => cleanup` — brings PHP-rendered markup to life | `src/behaviours/*.js` (site-wide), `blocks/{slug}/assets/behaviour.js` | The markup matters for SEO/LCP or is plain content: sliders, filters, accordion, header, reveal |
| **Island** | A Svelte component that renders its own UI from JSON props | `blocks/{slug}/assets/island.svelte`, `src/islands/*.svelte` | Interactive tools whose UI is state: calculators, lookup tables, forms |

Behaviours ship in `app.js` and attach wherever their selector matches (optional
`order`, and `once` for page-level ones). Islands are lazy chunks: PHP prints
`starter_flexible_island( $name, $props )` (see `inc/islands.php`), the runtime
mounts the component into that shell, then runs behaviours over it. PHP adds
`<link rel="modulepreload">` for the islands of blocks on the page.

Shared code:

- `src/lib/stores/viewport.svelte.js` — the only scroll/resize listener; subscribe instead of adding your own.
- `src/lib/stores/motion.svelte.js` — `motion.allowed` (OS setting + footer toggle).
- `src/lib/*` — clipboard, number formatting, shaft formula, storage, analytics, print.
- `src/lib/brief/*` — the Design Brief's model and printed document (pure, tested).
- `src/components/*` — `CopyButton`, `MultiSelect`.

Imports: `$lib/…`, `$components/…`.

## Build output

| File | Content |
| --- | --- |
| `dist/app.js` | Entry: runtime + all behaviours (the only `<script>` PHP enqueues) |
| `dist/core.js` | Code shared by app.js and islands. Nothing may import `app.js`: PHP loads it as `app.js?ver=…`, so an import of plain `app.js` would run it twice |
| `dist/vendor.js` | Svelte runtime |
| `dist/blocks/{slug}/assets/island.js` | One block's island |
| `dist/blocks/{slug}/assets/style.css` | One block's CSS, inlined by PHP on pages that render it |
| `dist/app.css` | Site CSS |
