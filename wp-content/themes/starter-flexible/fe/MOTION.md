# Motion

How things move on this site, and why. Every module has its own entrance and
its own response to the pointer, but all of them come from one system, so the
site moves like one thing.

## Principles

1. **Physics, not timelines.** Curves are springs (`src/lib/motion-math.js`,
   generated into `src/styles/_easing.scss` by `npm run easing`):
   | Token | Spring | Use |
   | --- | --- | --- |
   | `--spring-out` / `--spring-out-ms` (900ms) | critically damped, launched | entrances |
   | `--spring-soft` / `-ms` (600ms) | from rest, ~5% overshoot | things the pointer moves: hover lift, tab thumb, toggles |
   | `--spring-snappy` / `-ms` (380ms) | critically damped, launched | small UI: menus, panels, accordions, list re-flows |
   | `--ease` / `-ms` (900ms) | critically damped, gently launched | everything else |
   Never a raw `ease`, never a hand-typed duration for a new effect.
2. **Compositor only.** Animate `transform` and `opacity` (and `scale`,
   `translate`, `rotate`). Not `height`, `width`, `top`, `box-shadow`,
   `filter`, `clip-path`, `background-position` — each repaints or re-lays out
   every frame. A grow/collapse is `grid-template-rows: 0fr → 1fr` (one
   layout at each end) or a transform.
3. **Meaning decides direction.** Things arrive from where they come from in
   the reading order: text rises (`--reveal-y`), a picture opens (scale), a
   row of steps travels along its row, a grid fills as a diagonal wave
   (`data-reveal-order="grid"`), a set that reads as one picture arrives
   together.
4. **Distances are small, durations bounded.** 16–40px travel, scale from
   ≥ 0.94. Stagger follows `staggerDelay` (60ms apart at first, never more
   than 480ms total) — the last card never waits.
5. **Once.** Entrances run the first time a block is seen, never again.
6. **Respect the reader.** `prefers-reduced-motion` and the footer toggle
   (`html.reduce-motion`) turn every entrance and loop off; content is never
   hidden waiting for an animation that will not run (`reveal-on` gate).
7. **Stacked sheets.** On desktop, blocks are pinned sheets (`stack.js`):
   the sheet itself does not fade; its children make the entrance.
8. **Loops rest off screen** (`behaviours/offscreen.js`).

## The reveal kit

```html
<section data-reveal>                      <!-- the block: gets .is-revealed -->
  <div data-reveal-stagger=".card"         <!-- children that arrive in turn -->
       data-reveal-order="grid">           <!-- (default) | grid | together -->
```

A block tunes its entrance in its own `assets/style.scss`:

```scss
.lasanmarine-value-grid {
	--reveal-y: 24px;
	--reveal-scale: 0.96;
	--reveal-origin: 50% 100%;
	--reveal-ms: var(--spring-out-ms);
}
```

Hover and press responses live next to the element's styles in the same file.

## Modules

| Module | Entrance | Interaction |
| --- | --- | --- |
| hero | headline lines rise one after another; photo settles from 1.06 | slide change: text cross-fades with a short rise, photo cross-fades |
| page-hero | headline rises, lead follows, actions arrive in turn | buttons: soft press (scale .97) |
| vessel-finder | bento fills as a diagonal wave, each photo opens from .94 | card hover: photo zooms 1.04 on `--spring-soft`, caption lifts |
| value-grid | cells rise as a wave; icons pop (scale .6 → 1, soft spring) after their cell | cell hover: icon nudges up |
| project-showcase | cards arrive from the right, in turn | card hover: lift 4px, photo 1.03 |
| capability-matrix | diagonal wave across the matrix | cell hover: arrow travels 4px |
| contact-statement | heading rises, buttons pop in turn, glow swells (scroll-linked) | button press |
| image-text | frame opens (scroll-linked), text arrives from the side opposite the image | — |
| geo-operations | plate opens, pins drop in turn (y −12px, soft spring) | pin hover: scale 1.15 |
| spec-list | rows arrive top to bottom, label then value | — |
| enquiry-form | fields rise in turn | field focus: label shifts, ring grows (`--spring-snappy`) |
| cta-banner | panel scales from .96, text rises | — |
| use-case | cases arrive along the row (x 32px) | card hover lift |
| deliverables | items tick in: marker pops, text follows | — |
| process-timeline | rail fills with the scroll (existing); each node pops as the rail reaches it | — |
| accordion | items rise in turn | open/close: `grid-template-rows` 0fr → 1fr + chevron turns on `--spring-snappy` |
| service-architecture | layers stack up bottom to top | layer hover highlight |
| service-spotlight | photo opens (scroll-linked), panel slides in | — |
| document-center | rows rise in turn | filter: thumb travels, rows re-flow (View Transition) |
| input-output | input column, then arrow, then output — left to right | arrow nudge loop (offscreen-paused) |
| design-brief | sheet rises as one | step change: cross-fade |
| project-index | cards as a grid wave | filter: thumb travels, cards re-flow (View Transition) |
| insights | cards as a grid wave | filter: same as project-index |
| tool-shell | panel rises, inputs then result | result change: number settles (no layout shift) |
| app-embed | frame scales from .97 | — |
| rich-text | paragraphs rise in turn (capped) | — |
| on-page bar / tabs | bar opens (grid rows) | thumb travels (`behaviours/tab-thumb.js`) |
| header | always the pill; no reshaping on scroll | panels open on `--spring-snappy` |
