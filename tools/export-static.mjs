#!/usr/bin/env node
/**
 * Export the WordPress site as static files for GitHub Pages.
 *
 * Crawls the running site from its pages, sitemaps and every internal link,
 * keeps only what the pages actually load (stylesheets, scripts, images incl.
 * srcset, fonts and images inside CSS), rewrites the WordPress origin to the
 * public domain, writes redirect pages for retired paths, and replaces the
 * export directory while keeping the paths listed in `preserve`.
 *
 * usage: node tools/export-static.mjs <out dir> [config]
 *   e.g. node tools/export-static.mjs ../lasanmarine.github.io/docs
 * then:  python3 tools/check-static-export.py ../lasanmarine.github.io/docs
 */
import { cp, mkdir, readFile, readdir, rm, writeFile } from 'node:fs/promises';
import { existsSync } from 'node:fs';
import { dirname, join, resolve } from 'node:path';
import { fileURLToPath } from 'node:url';

const here = dirname(fileURLToPath(import.meta.url));
const outDir = resolve(process.argv[2] || '');
const config = JSON.parse(await readFile(process.argv[3] || join(here, 'static-export.json'), 'utf8'));
if (!process.argv[2]) {
	console.error('usage: node tools/export-static.mjs <out dir> [config]');
	process.exit(2);
}

const origin = new URL(config.origin);
const target = new URL(config.target);
const exclude = config.exclude.map((p) => new RegExp(p));
const stage = outDir + '.export-tmp';

// Every spelling of the origin that can turn up in markup, scripts or JSON.
// Aliases are other hosts the database still names (a copy pulled from the dev
// server keeps its URLs in places such as Yoast's og:image): same files, so
// they are fetched from the origin and rewritten to the target too.
const aliasHosts = (config.aliases || []).map((a) => new URL(a).host);
const swaps = [
	...(config.aliases || []).map((a) => [a, config.target]),
	[config.origin, config.target],
	[config.origin.replace(/\//g, '\\/'), config.target.replace(/\//g, '\\/')],
	[encodeURIComponent(config.origin), encodeURIComponent(config.target)],
	['//' + origin.host, '//' + target.host],
];
const rewrite = (text) => swaps.reduce((t, [a, b]) => t.split(a).join(b), text);

const queue = [];
const seen = new Set();
const saved = new Map(); // path -> file
const redirects = new Map(); // path -> target path
const broken = new Map(); // path -> [status, from]

function enqueue(raw, from) {
	let u;
	try {
		u = new URL(raw.trim().replace(/&amp;/g, '&'), new URL(from || '/', origin));
	} catch {
		return;
	}
	if (u.host === target.host || aliasHosts.includes(u.host)) u = new URL(u.pathname + u.search, origin);
	if (u.host !== origin.host || !/^https?:$/.test(u.protocol)) return;
	// Query strings are cache-busters on assets (?ver=) — the file is the same.
	const path = decodeURI(u.pathname);
	if (u.search && !/\.\w+$/.test(path)) return; // ?replytocom=, ?s= …: not pages
	if (exclude.some((re) => re.test(path))) return;
	if (seen.has(path)) return;
	seen.add(path);
	queue.push([path, from]);
}

function fileFor(path, type) {
	const clean = path.replace(/^\/+/, '');
	if (path.endsWith('/')) return clean + 'index.html';
	if (!/\.[a-z0-9]+$/i.test(path) && type.includes('html')) return clean + '/index.html';
	return clean;
}

const ATTR = /\s(?:href|src|poster|data-src)\s*=\s*(["'])(.*?)\1/gis;
const SRCSET = /\s(?:srcset|data-srcset|imagesrcset)\s*=\s*(["'])(.*?)\1/gis;
const META = /<meta[^>]+content\s*=\s*(["'])((?:https?:)?\/[^"']*)\1/gi;
const CSSURL = /url\(\s*(["']?)([^"')]+)\1\s*\)/gi;

function links(text, type, path) {
	const out = [];
	if (type.includes('html')) {
		const markup = text.replace(/(<script\b[^>]*>)[\s\S]*?(<\/script>)/gi, '$1$2');
		for (const m of markup.matchAll(ATTR)) out.push(m[2]);
		for (const m of markup.matchAll(SRCSET)) for (const c of m[2].split(',')) if (c.trim()) out.push(c.trim().split(/\s+/)[0]);
		for (const m of markup.matchAll(META)) out.push(m[2]);
		for (const m of markup.matchAll(CSSURL)) out.push(m[2]);
	} else if (type.includes('css')) {
		for (const m of text.matchAll(CSSURL)) out.push(m[2]);
	} else if (type.includes('xml') || type.includes('xsl')) {
		for (const m of text.matchAll(/<loc>\s*(.*?)\s*<\/loc>/g)) out.push(m[1]);
		for (const m of text.matchAll(/href="([^"]+\.xsl)"/g)) out.push(m[1]);
	} else if (path.endsWith('robots.txt')) {
		for (const m of text.matchAll(/^Sitemap:\s*(\S+)/gim)) out.push(m[1]);
	}
	return out.filter((r) => r && !/^(#|data:|mailto:|tel:|javascript:|blob:|%23)/i.test(r.replace(/^\\?["']/, '')));
}

async function save(file, body) {
	const full = join(stage, file);
	await mkdir(dirname(full), { recursive: true });
	await writeFile(full, body);
}

async function visit([path, from]) {
	const url = new URL(encodeURI(path), origin);
	let res;
	try {
		res = await fetch(url, { redirect: 'manual' });
	} catch (e) {
		broken.set(path, ['fetch failed', from]);
		return;
	}
	if (res.status >= 300 && res.status < 400) {
		const to = new URL(res.headers.get('location'), url);
		if (to.host === origin.host) {
			redirects.set(path, decodeURI(to.pathname) + to.hash);
			enqueue(to.href, path);
		}
		return;
	}
	if (res.status !== 200) {
		// Paths kept from the previous export (apps WordPress does not serve) are fine.
		const kept = config.preserve.some((k) => path.replace(/^\/+|\/+$/g, '') === k.replace(/\/+$/, ''));
		if (!kept) broken.set(path, [res.status, from]);
		return;
	}
	const type = res.headers.get('content-type') || '';
	const isText = /text|xml|javascript|json|svg/.test(type) || /\.(txt|xsl)$/.test(path);
	const file = fileFor(path, type);
	if (!isText) {
		await save(file, Buffer.from(await res.arrayBuffer()));
		saved.set(path, file);
		return;
	}
	const text = await res.text();
	for (const ref of links(text, type, path)) enqueue(ref, path);
	await save(file, rewrite(text));
	saved.set(path, file);
}

// --- crawl ------------------------------------------------------------------
// Fail early and plainly when WordPress isn't up, before anything is touched.
try {
	await fetch(origin, { redirect: 'manual' });
} catch {
	console.error(`${config.origin} is not reachable — start the site (docker compose up -d) and try again.`);
	process.exit(1);
}
await rm(stage, { recursive: true, force: true });
await mkdir(stage, { recursive: true });
for (const p of config.start) enqueue(p);
for (const p of config.redirectsFrom || []) enqueue(p);

const started = Date.now();
// Six workers share the queue; one with nothing to do waits while others are
// still fetching, since their pages may add more.
let active = 0;
async function worker() {
	for (;;) {
		const job = queue.shift();
		if (!job) {
			if (!active) return;
			await new Promise((r) => setTimeout(r, 25));
			continue;
		}
		active++;
		try {
			await visit(job);
		} finally {
			active--;
		}
	}
}
await Promise.all(Array.from({ length: 6 }, worker));

// The not-found page, rendered by WordPress for a path that does not exist.
{
	const res = await fetch(new URL('/__static-export-404__/', origin));
	await save('404.html', rewrite(await res.text()));
}

// Retired URLs WordPress never had (the earlier Astro site's pages, still in
// search indexes) point at their replacement like the 301s below.
for (const [from, to] of Object.entries(config.redirects || {})) {
	if (!redirects.has(from)) redirects.set(from, to);
}

// Redirect pages for paths that 301 in WordPress.
for (const [from, to] of redirects) {
	if (saved.has(from) || /\.\w+$/.test(from)) continue;
	const href = new URL(to, target).href;
	await save(
		fileFor(from.endsWith('/') ? from : from + '/', 'html'),
		`<!doctype html><html><head><meta charset="utf-8"><title>Redirecting…</title>` +
			`<link rel="canonical" href="${href}"><meta name="robots" content="noindex">` +
			`<meta http-equiv="refresh" content="0;url=${href}"></head>` +
			`<body><a href="${href}">${href}</a></body></html>\n`
	);
}

// Files served under a second name: GitHub Pages cannot redirect, so e.g.
// /sitemap.xml (a 301 in WordPress) is written as a copy of the index.
for (const [to, from] of Object.entries(config.copies || {})) {
	const src = join(stage, from.replace(/^\/+/, ''));
	if (existsSync(src)) await cp(src, join(stage, to.replace(/^\/+/, '')));
	else console.warn(`copy skipped: ${from} was not exported`);
}

// --- swap into place, keeping what WordPress does not produce ----------------
// A crawl that came back nearly empty (site down, wrong origin) must not wipe
// the published export.
if (saved.size < 50) {
	console.error(`only ${saved.size} files exported — is ${config.origin} up? Leaving ${outDir} untouched.`);
	await rm(stage, { recursive: true, force: true });
	process.exit(1);
}
// Whole folders copied as they are: built apps load their chunks at run time,
// so the crawler cannot follow them. Paths are relative to the repo root.
for (const [to, from] of Object.entries(config.dirs || {})) {
	const src = resolve(here, '..', from);
	if (existsSync(src)) await cp(src, join(stage, to), { recursive: true });
	else console.warn(`dir skipped: ${from} not found`);
}
for (const keep of config.preserve) {
	const src = join(outDir, keep);
	if (existsSync(src)) await cp(src, join(stage, keep), { recursive: true });
}
if (!existsSync(join(stage, 'CNAME'))) await writeFile(join(stage, 'CNAME'), target.host + '\n');
if (!existsSync(join(stage, '.nojekyll'))) await writeFile(join(stage, '.nojekyll'), '');

if (existsSync(outDir)) {
	for (const entry of await readdir(outDir)) await rm(join(outDir, entry), { recursive: true, force: true });
}
await mkdir(outDir, { recursive: true });
await cp(stage, outDir, { recursive: true });
await rm(stage, { recursive: true, force: true });

console.log(`exported ${saved.size} files and ${redirects.size} redirects in ${Math.round((Date.now() - started) / 1000)}s -> ${outDir}`);
if (broken.size) {
	console.log(`\nbroken links (${broken.size}):`);
	for (const [p, [status, from]] of broken) console.log(`  ${status}  ${p}  <- ${from || '(start)'}`);
}
