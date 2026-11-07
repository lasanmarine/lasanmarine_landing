import { defineConfig } from 'vite';
import { svelte } from '@sveltejs/vite-plugin-svelte';
import { resolve } from 'path';
import { fileURLToPath } from 'url';
import { writeFileSync, unlinkSync, readdirSync, existsSync } from 'fs';
import glob from 'fast-glob';
import fullReload from 'vite-plugin-full-reload';

const __dirname = fileURLToPath(new URL('.', import.meta.url));
const themeRoot = resolve(__dirname, '..');
const blocksDir = resolve(themeRoot, 'blocks');

/**
 * One CSS entry per block: blocks/{slug}/assets/style.scss → dist/blocks/{slug}/assets/style.css.
 * PHP inlines the ones a page renders (inc/vite.php). Scripts are no longer
 * per-block entries: behaviours ship in app.js and islands are lazy chunks
 * reached from it (fe/src/runtime).
 */
function blockStyleEntries() {
	if (!existsSync(blocksDir)) return {};
	return Object.fromEntries(
		readdirSync(blocksDir, { withFileTypes: true })
			.filter((d) => d.isDirectory() && existsSync(resolve(blocksDir, d.name, 'assets/style.scss')))
			.map((d) => [`blocks/${d.name}/style`, resolve(blocksDir, d.name, 'assets/style.scss')]),
	);
}

/** fe/src/styles/blocks.scss forwards every block stylesheet (dev + editor). */
function generateBlockStyles() {
	const outputFile = resolve(__dirname, 'src/styles/blocks.scss');
	const write = () => {
		const files = glob.sync('blocks/*/assets/style.scss', { cwd: themeRoot });
		const content = files.length
			? files.map((f) => `@forward '../../../${f.replace(/\\/g, '/')}';`).join('\n') + '\n'
			: '\n';
		writeFileSync(outputFile, content);
	};
	return {
		name: 'generate-block-styles',
		buildStart: write,
		buildEnd: write,
		handleHotUpdate({ file }) {
			if (file.replace(/\\/g, '/').includes('blocks/') && file.endsWith('style.scss')) write();
		},
	};
}

/** A chunk's source module, as a theme-relative path with forward slashes. */
const relToTheme = (id) => (id ? id.replace(/\\/g, '/').replace(themeRoot.replace(/\\/g, '/') + '/', '') : '');

export default defineConfig({
	root: resolve(__dirname, 'src'),
	base: './',
	resolve: {
		alias: {
			'@blocks': blocksDir,
			$lib: resolve(__dirname, 'src/lib'),
			$components: resolve(__dirname, 'src/components'),
		},
	},
	build: {
		outDir: resolve(__dirname, 'dist'),
		emptyOutDir: true,
		manifest: true,
		minify: 'terser',
		terserOptions: {
			compress: { drop_console: false, drop_debugger: true },
			format: { comments: false },
		},
		cssMinify: true,
		rollupOptions: {
			input: {
				main: resolve(__dirname, 'src/main.js'),
				...blockStyleEntries(),
			},
			output: {
				entryFileNames: (chunk) => {
					if (chunk.name === 'main') return 'app.js';
					const block = chunk.name.match(/^blocks\/([^/]+)\//);
					return block ? `blocks/${block[1]}/assets/style.js` : '[name].js';
				},
				// Islands keep a path PHP can map back to a block slug:
				//   blocks/{slug}/assets/island.svelte → dist/blocks/{slug}/assets/island.js
				//   src/islands/{Name}.svelte          → dist/islands/{Name}.js
				chunkFileNames: (chunk) => {
					const src = relToTheme(chunk.facadeModuleId);
					const block = src.match(/^blocks\/([^/]+)\/assets\/island\.svelte$/);
					if (block) return `blocks/${block[1]}/assets/island.js`;
					const site = src.match(/^fe\/src\/islands\/([^/]+)\.svelte$/);
					if (site) return `islands/${site[1]}.js`;
					if (chunk.name === 'vendor' || chunk.name === 'core') return `${chunk.name}.js`;
					return 'chunks/[name]-[hash].js';
				},
				assetFileNames: (asset) => {
					const name = asset.names?.[0] || asset.name || '';
					if (name.endsWith('.css')) {
						const block = name.match(/^blocks\/([^/]+)\//);
						if (block) return `blocks/${block[1]}/assets/style.css`;
						// Only the main entry's own CSS is app.css.
						return name.startsWith('main') ? 'app.css' : name;
					}
					return name;
				},
				// Nothing may import app.js itself: PHP loads it as app.js?ver=…,
				// and a chunk importing plain app.js would make the browser run
				// the entry a second time. So the code islands share with app.js
				// (lib, components, runtime) goes into core.js.
				manualChunks: (id) => {
					const src = id.split('\\').join('/');
					if (src.includes('node_modules')) return 'vendor';
					if (/\/fe\/src\/(lib|components)\//.test(src) || /\/fe\/src\/runtime\/islands\.js$/.test(src)) return 'core';
				},
			},
		},
	},
	css: {
		preprocessorOptions: {
			scss: { api: 'modern-compiler', silenceDeprecations: ['legacy-js-api'] },
		},
	},
	server: {
		host: 'localhost',
		port: 5173,
		strictPort: true,
		hmr: { protocol: 'ws', host: 'localhost', port: 5173 },
		watch: { usePolling: true, ignored: ['**/node_modules/**', '**/dist/**'] },
		cors: true,
		fs: { allow: [themeRoot] },
	},
	plugins: [
		svelte({ compilerOptions: { runes: true } }),
		generateBlockStyles(),
		{
			name: 'vite-dev-flag',
			configureServer(server) {
				server.httpServer?.once('listening', () => writeFileSync(resolve(__dirname, '.vite-dev'), ''));
			},
			buildEnd() {
				try {
					unlinkSync(resolve(__dirname, '.vite-dev'));
				} catch {
					/* not there */
				}
			},
		},
		fullReload(['../**/*.php']),
	],
	test: {
		root: __dirname,
		include: ['tests/**/*.test.js'],
		environment: 'jsdom',
	},
});
