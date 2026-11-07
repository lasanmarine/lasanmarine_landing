/** @type {import('tailwindcss').Config} */

/*
 * LASAN Marine — design system v1.
 * Tokens mirror :root in the Astro site's src/styles/system.css one for one.
 * White ground · navy structure · marine-blue accent · aqua (xanh ngọc) spark.
 * v1.1 "fresh": a second, brighter accent and softer, rounder shapes.
 * v2 (2026) "light minimal": white ground, quiet surfaces, generous radii,
 * navy as the primary action colour, aqua kept as a small spark only.
 */
export default {
	darkMode: 'class',
	content: ['./src/**/*.{js,jsx,ts,tsx,scss,php}', '../../**/*.php'],
	theme: {
		extend: {
			colors: {
				// Ink & ground — 65% light / 20% navy / 10% marine / 5% tint.
				paper: '#ffffff',
				surface: '#f4f7fb',
				navy: '#0b1b4c',
				'navy-deep': '#06122d',
				marine: '#0a72c8',
				'marine-bright': '#4da3e8',
				// Xanh ngọc — `aqua` lights up dark fields and decoration; `aqua-deep`
				// is the shade that holds 4.5:1 as text on white.
				aqua: '#14c8c8',
				'aqua-deep': '#0a7f7d',
				'aqua-soft': '#e3f8f7',
				steel: '#536173',
				mute: '#637080',
				tint: '#eef3f8',
				pale: '#f5f8fc',
				line: '#e3e9f0',
				'line-soft': '#eef2f7',
			},
			fontFamily: {
				display: ['Manrope Variable', 'Manrope', 'system-ui', 'sans-serif'],
				body: ['Be Vietnam Pro', 'system-ui', 'sans-serif'],
			},
			// Radii — rounded and friendly; buttons and tags are pills.
			borderRadius: {
				xs: '6px',
				sm: '10px',
				md: '14px',
				lg: '20px',
				xl: '28px',
				pill: '999px',
			},
			transitionTimingFunction: {
				marine: 'cubic-bezier(0.2, 0.6, 0.2, 1)',
			},
			maxWidth: {
				shell: '1560px',
			},
		},
	},
	plugins: [],
};



