#!/usr/bin/env python3
"""Check a Simply Static export before it is pushed to GitHub Pages.

Every file a page refers to — stylesheets, scripts, images (srcset too), fonts
and images inside CSS, sitemap URLs — must exist in the export, and no URL may
still point at a WordPress host. Exits 1 when anything is wrong, so it can gate
the push.

usage: python3 tools/check-static-export.py <export dir> [site host]
       e.g. python3 tools/check-static-export.py output/lasanmarine.github.io/docs lasanmarine.com

Also run `git status --ignored docs` in the Pages repo: an ignore rule such as
`dist/` silently drops the theme's compiled CSS/JS (fe/dist) from the commit.
"""
import html
import os
import re
import sys
from collections import defaultdict
from urllib.parse import unquote, urlparse

root = sys.argv[1]
host = sys.argv[2] if len(sys.argv) > 2 else open(os.path.join(root, 'CNAME')).read().strip()

files = set()
for dp, _, fns in os.walk(root):
    for fn in fns:
        files.add(os.path.relpath(os.path.join(dp, fn), root).replace(os.sep, '/'))
pages = {f[: -len('index.html')].rstrip('/') for f in files if f.endswith('index.html')}

# Attributes that hold a URL. `content` only counts on meta tags that carry one
# (og:image, twitter:image…), never on type/description metas.
URL_ATTR = re.compile(r'''\s(?:href|src|poster|data-src)\s*=\s*(["'])(.*?)\1''', re.I | re.S)
SRCSET = re.compile(r'''\s(?:srcset|data-srcset|imagesrcset)\s*=\s*(["'])(.*?)\1''', re.I | re.S)
META_URL = re.compile(r'''<meta[^>]+content\s*=\s*(["'])((?:https?:)?/[^"']*)\1''', re.I)
CSS_URL = re.compile(r'''url\(\s*(["']?)([^"')]+)\1\s*\)''', re.I)
WP_HOST = re.compile(r'localhost|127\.0\.0\.1|dev\.' + re.escape(host), re.I)

missing = defaultdict(set)
wp_links = defaultdict(set)


def local_path(ref, page):
    # Minified CSS can escape or encode a fragment: url(\"#a\"), url(%23a).
    ref = html.unescape(ref.strip()).strip('\\"\'')
    if ref.startswith('%23'):
        return None
    if not ref or ref.startswith(('#', 'data:', 'mailto:', 'tel:', 'javascript:', 'blob:')):
        return None
    u = urlparse(ref)
    if u.scheme in ('http', 'https') or ref.startswith('//'):
        if WP_HOST.search(u.netloc):
            wp_links[u.netloc].add(page)
            return None
        if u.netloc not in (host, 'www.' + host):
            return None
        path = u.path
    elif u.scheme:
        return None
    else:
        path = u.path if u.path.startswith('/') else os.path.normpath(
            os.path.join(os.path.dirname('/' + page), u.path)).replace(os.sep, '/')
    return unquote(path)


def present(path):
    p = path.lstrip('/')
    return p in files or p.rstrip('/') in pages or (p == '' and 'index.html' in files)


for rel in sorted(files):
    ext = rel.rsplit('.', 1)[-1].lower()
    if ext not in ('html', 'css', 'xml'):
        continue
    text = open(os.path.join(root, rel), encoding='utf8', errors='replace').read()
    refs = []
    if ext == 'html':
        # Inline script bodies are code, not markup: `URL.createObjectURL(r)`
        # would otherwise read as a CSS url(). Their src attributes stay.
        text = re.sub(r'(<script\b[^>]*>).*?(</script>)', r'\1\2', text, flags=re.I | re.S)
        refs += [m[1] for m in URL_ATTR.findall(text)]
        refs += [c.strip().split()[0] for m in SRCSET.findall(text) for c in m[1].split(',') if c.strip()]
        refs += [m[1] for m in META_URL.findall(text)]
        refs += [m[1] for m in CSS_URL.findall(text)]
    elif ext == 'css':
        refs += [m[1] for m in CSS_URL.findall(text)]
    else:
        refs += re.findall(r'<loc>\s*(.*?)\s*</loc>', text)
    for ref in refs:
        path = local_path(ref, rel)
        if path is not None and not present(path):
            missing[path].add(rel)

print(f'{len(files)} files checked in {root}')
if missing:
    print(f'\nMISSING ({len(missing)}): referenced but not in the export')
    for path, srcs in sorted(missing.items(), key=lambda x: (-len(x[1]), x[0])):
        print(f'  {path}  <- {len(srcs)} file(s), e.g. {sorted(srcs)[0]}')
if wp_links:
    print(f'\nWORDPRESS HOST still linked ({len(wp_links)}):')
    for h, srcs in wp_links.items():
        print(f'  {h}  in {len(srcs)} file(s), e.g. {sorted(srcs)[0]}')
if missing or wp_links:
    sys.exit(1)
print('OK: nothing missing, no WordPress host left in the export.')
