import { defineConfig } from 'vite';
import { resolve } from 'path';
import { fileURLToPath } from 'url';
import { writeFileSync, unlinkSync, readdirSync, existsSync } from 'fs';
import glob from 'fast-glob';
import fullReload from 'vite-plugin-full-reload';

const __dirname = fileURLToPath(new URL('.', import.meta.url));
const themeRoot = resolve(__dirname, '..');
const viteRoot = resolve(__dirname, 'src');
const blocksSrcDir = resolve(themeRoot, 'blocks');

/**
 * Get all block asset entries from the theme-level blocks directory.
 */
function getBlockAssetsEntries() {
	const entries = {};
	const blocksPath = blocksSrcDir;

	if (!existsSync(blocksPath)) {
		return entries;
	}

	const blockFolders = readdirSync(blocksPath, { withFileTypes: true })
		.filter(dirent => dirent.isDirectory())
		.map(dirent => dirent.name);

	blockFolders.forEach(blockName => {
		const blockPath = resolve(blocksPath, blockName);
		
		// Block assets: blocks/{block-name}/assets/{script.js|style.scss}
		const assetsDir = resolve(blockPath, 'assets');
		if (existsSync(assetsDir)) {
			const scriptFile = resolve(assetsDir, 'script.js');
			const styleFile = resolve(assetsDir, 'style.scss');
			
			if (existsSync(scriptFile)) {
				const entryKey = `blocks/${blockName}/script`;
				entries[entryKey] = scriptFile;
			}
			
			if (existsSync(styleFile)) {
				const entryKey = `blocks/${blockName}/style`;
				entries[entryKey] = styleFile;
			}
		}

		// Appearance assets: blocks/{block-name}/appearances/{appearance}/assets/{script.js|style.scss}
		const appearancesDir = resolve(blockPath, 'appearances');
		if (existsSync(appearancesDir)) {
			const appearanceFolders = readdirSync(appearancesDir, { withFileTypes: true })
				.filter(dirent => dirent.isDirectory())
				.map(dirent => dirent.name);

			appearanceFolders.forEach(appearanceName => {
				const appearanceAssetsDir = resolve(appearancesDir, appearanceName, 'assets');
				if (existsSync(appearanceAssetsDir)) {
					const scriptFile = resolve(appearanceAssetsDir, 'script.js');
					const styleFile = resolve(appearanceAssetsDir, 'style.scss');
					
					if (existsSync(scriptFile)) {
						const entryKey = `blocks/${blockName}/appearances/${appearanceName}/script`;
						entries[entryKey] = scriptFile;
					}
					
					if (existsSync(styleFile)) {
						const entryKey = `blocks/${blockName}/appearances/${appearanceName}/style`;
						entries[entryKey] = styleFile;
					}
				}
			});
		}
	});

	return entries;
}

const blockEntries = getBlockAssetsEntries();

/**
 * Generate block styles SCSS file
 */
function createBlockStylesContent() {
	const files = glob.sync('blocks/*/assets/style.scss', {
		cwd: themeRoot,
		absolute: false,
	});

	if (!files.length) {
		return '\n';
	}

	return (
		files
			.map((filePath) => {
				const normalizedPath = filePath.replace(/\\/g, '/');
				return `@forward '../../../${normalizedPath}';`;
			})
			.join('\n') + '\n'
	);
}

function generateBlockStyles() {
	const outputFile = resolve(__dirname, 'src/styles/blocks.scss');

	return {
		name: 'generate-block-styles',
		buildStart() {
			const content = createBlockStylesContent();
			writeFileSync(outputFile, content);
		},
		handleHotUpdate({ file }) {
			if (file.includes('blocks/') && file.endsWith('style.scss')) {
				const content = createBlockStylesContent();
				writeFileSync(outputFile, content);
			}
		},
		buildEnd() {
			const content = createBlockStylesContent();
			writeFileSync(outputFile, content);
		},
	};
}

export default defineConfig({
	root: resolve(__dirname, 'src'),
	base: './',
	resolve: {
		alias: {
			'@blocks': resolve(themeRoot, 'blocks'),
		},
	},
	build: {
		outDir: resolve(__dirname, 'dist'),
		emptyOutDir: true,
		manifest: true,
		minify: 'terser',
		terserOptions: {
			compress: {
				drop_console: false,
				drop_debugger: true,
			},
			format: {
				comments: false,
			},
		},
		cssMinify: true,
		rollupOptions: {
			input: {
				main: resolve(__dirname, 'src/main.js'),
				...blockEntries,
			},
			output: {
				entryFileNames: (chunkInfo) => {
					if (chunkInfo.name === 'main') {
						return 'app.js';
					}
					if (chunkInfo.name.includes('blocks/')) {
						const parts = chunkInfo.name.split('/');
						const blockName = parts[1];
						const assetType = parts[parts.length - 1];
						if (parts.length === 4) {
							const appearanceName = parts[2];
							return `blocks/${blockName}/appearances/${appearanceName}/assets/${assetType}.js`;
						}
						return `blocks/${blockName}/assets/${assetType}.js`;
					}
					return '[name].js';
				},
				chunkFileNames: (chunkInfo) => {
					if (chunkInfo.name === 'main') {
						return 'vendor.js';
					}
					return '[name].js';
				},
				assetFileNames: (assetInfo) => {
					if (assetInfo.name.endsWith('.css')) {
						const name = assetInfo.names?.[0] || assetInfo.name;
						if (name.includes('blocks/')) {
							const parts = name.split('/');
							const blockName = parts[1];
							const assetType = parts[parts.length - 1].replace(/\.(scss|css)$/, '');
							if (parts.length === 4) {
								const appearanceName = parts[2];
								return `blocks/${blockName}/appearances/${appearanceName}/assets/${assetType}.css`;
							}
							return `blocks/${blockName}/assets/${assetType}.css`;
						}
						// Only the main entry's own CSS is app.css; a dependency's
						// stylesheet (AOS) keeps its own name rather than pushing
						// the theme's out to app2.css.
						return name.startsWith('main') ? 'app.css' : name;
					}
					return assetInfo.name;
				},
				manualChunks: (id) => {
					if (id.includes('node_modules')) {
						return 'vendor';
					}
				},
			},
		},
	},
	css: {
		preprocessorOptions: {
			scss: {
				api: 'modern-compiler',
				silenceDeprecations: ['legacy-js-api'],
			},
		},
	},
	server: {
		host: 'localhost',
		port: 5173,
		strictPort: true,
		hmr: {
			protocol: 'ws',
			host: 'localhost',
			port: 5173,
		},
		watch: {
			usePolling: true,
			ignored: ['**/node_modules/**', '**/dist/**'],
		},
		cors: true,
		fs: {
			allow: [
				themeRoot,
			],
		},
	},
	plugins: [
		generateBlockStyles(),
		{
			name: 'vite-dev-flag',
			configureServer(server) {
				server.httpServer?.once('listening', () => {
					const flagFile = resolve(__dirname, '.vite-dev');
					writeFileSync(flagFile, '');
				});
			},
			buildEnd() {
				const flagFile = resolve(__dirname, '.vite-dev');
				try {
					unlinkSync(flagFile);
				} catch (e) {
					// File doesn't exist, ignore
				}
			},
		},
		{
			name: 'block-assets-middleware',
			configureServer(server) {
				server.middlewares.use((req, res, next) => {
					if (req.url.startsWith('/blocks/')) {
						const match = req.url.match(/^\/blocks\/([^\/]+)\/(script|style)\.(js|scss|css)$/);
						if (match) {
							const [, blockName, assetType] = match;
							const entryKey = `blocks/${blockName}/${assetType}`;
							if (blockEntries[entryKey]) {
								const filePath = blockEntries[entryKey];
								const relativeFromViteRoot = filePath.replace(viteRoot + '\\', '').replace(viteRoot + '/', '').replace(/\\/g, '/');
								req.url = '/' + relativeFromViteRoot;
							}
						}
					}
					next();
				});
			},
		},
		// Full reload plugin for PHP files
		fullReload([
			'../**/*.php', // Watch all PHP files in theme directory
		]),
	],
});
