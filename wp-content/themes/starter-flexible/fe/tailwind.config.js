/** @type {import('tailwindcss').Config} */

/*
 * LASAN Marine — design system v1.
 * Tokens mirror :root in the Astro site's src/styles/system.css one for one.
 * White ground · navy structure · one marine-blue accent · one gradient.
 */
export default {
	darkMode: 'class',
	content: ['./src/**/*.{js,jsx,ts,tsx,scss,php}', '../../**/*.php'],
	theme: {
		extend: {
			colors: {
				// Ink & ground — 65% light / 20% navy / 10% marine / 5% tint.
				paper: '#ffffff',
				navy: '#0b1b4c',
				'navy-deep': '#06122d',
				marine: '#0a72c8',
				'marine-bright': '#4da3e8',
				steel: '#536173',
				mute: '#7b8794',
				tint: '#edf3f8',
				pale: '#f5f8fc',
				line: '#dce5ee',
				'line-soft': '#e9eff5',
			},
			fontFamily: {
				display: ['Manrope Variable', 'Manrope', 'system-ui', 'sans-serif'],
				body: ['Be Vietnam Pro', 'system-ui', 'sans-serif'],
			},
			// Radii — soft, never a pill.
			borderRadius: {
				xs: '2px',
				sm: '3px',
				md: '5px',
				lg: '10px',
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
