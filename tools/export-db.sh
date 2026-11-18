#!/usr/bin/env bash
# Export the local WordPress database for another address, plus the uploads.
#
#   tools/export-db.sh [https://lasanmarine.com]
#
# Writes to output/backup/ (git-ignored):
#   <stamp>-local-raw.sql.gz        the local database as it is (backup)
#   <stamp>-<host>.sql.gz           the same with every URL moved to the target
#   <stamp>-uploads.tar.gz          wp-content/uploads (not deployed by CI)
# The target dump has no CREATE DATABASE: import it into the site's database.
set -euo pipefail

TARGET="${1:-https://lasanmarine.com}"
FROM_URLS=("http://192.168.1.199:49731" "http://localhost:49731")
HERE="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
ROOT="$(cd "$HERE/.." && pwd)"
OUT="$ROOT/output/backup"
STAMP="$(date +%Y%m%d-%H%M)"
HOST_ONLY="${TARGET#*://}"
DB=lasan_db
WP=lasan_wp
ROOTPW=rootpass
TMPDB=wordpress_export

mkdir -p "$OUT"
q() { docker exec -i "$DB" mysql -uroot -p"$ROOTPW" "$@" 2>/dev/null; }
dump() { docker exec "$DB" mysqldump -uroot -p"$ROOTPW" --single-transaction --default-character-set=utf8mb4 --no-tablespaces --skip-comments "$1" 2>/dev/null; }

echo "1/4 backup nguyên trạng"
dump wordpress | gzip > "$OUT/$STAMP-local-raw.sql.gz"

echo "2/4 bản sao tạm $TMPDB"
q -e "DROP DATABASE IF EXISTS $TMPDB; CREATE DATABASE $TMPDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
gunzip -c "$OUT/$STAMP-local-raw.sql.gz" | q "$TMPDB"

echo "3/4 đổi đường dẫn → $TARGET"
pairs=()
for f in "${FROM_URLS[@]}"; do pairs+=("$f" "$TARGET" "${f#*://}" "$HOST_ONLY"); done
# Mail sender addresses carry the bare host, without the port.
pairs+=("@192.168.1.199" "@$HOST_ONLY" "@localhost" "@$HOST_ONLY")
docker cp "$HERE/export-db.php" "$WP":/tmp/export-db.php
docker exec "$WP" php /tmp/export-db.php db root "$ROOTPW" "$TMPDB" "${pairs[@]}"
docker exec "$WP" rm -f /tmp/export-db.php
# Caches that hold URLs and rebuild themselves on the live site.
q "$TMPDB" -e "
	DELETE FROM wp_options WHERE option_name LIKE '\_transient\_%' OR option_name LIKE '\_site\_transient\_%';
	TRUNCATE wp_yoast_indexable; TRUNCATE wp_yoast_indexable_hierarchy; TRUNCATE wp_yoast_seo_links;
	UPDATE wp_options SET option_value = '' WHERE option_name = 'rewrite_rules';
	UPDATE wp_options SET option_value = '$TARGET' WHERE option_name IN ('siteurl', 'home');
" || true
q "$TMPDB" -e "SELECT option_name, option_value FROM wp_options WHERE option_name IN ('siteurl','home');"
left=$(q -N "$TMPDB" -e "SELECT COUNT(*) FROM wp_posts WHERE post_content LIKE '%192.168.1.199%'")
echo "   bài/trang còn chứa 192.168.1.199: $left"

echo "4/4 xuất file"
dump "$TMPDB" | gzip > "$OUT/$STAMP-$HOST_ONLY.sql.gz"
q -e "DROP DATABASE $TMPDB;"
tar -czf "$OUT/$STAMP-uploads.tar.gz" -C "$ROOT/wp-content" uploads
ls -lh "$OUT" | grep "$STAMP"
