<?php
/**
 * Serialization-safe search and replace over a whole database — the step
 * that turns a copy of the local database into one for another address.
 * A plain text replace corrupts PHP-serialized values (their string lengths
 * change), which silently wipes widget, theme and plugin settings.
 *
 *   php export-db.php <host> <user> <pass> <db> <from> <to> [<from> <to> …]
 *
 * Run by tools/export-db.sh against a throwaway copy, never the live site.
 *
 * @package Starter_Flexible
 */

if ( 'cli' !== PHP_SAPI ) {
	exit( 1 );
}

[ , $host, $user, $pass, $name ] = $argv;
$pairs = array_slice( $argv, 5 );
$map   = array();
for ( $i = 0; $i + 1 < count( $pairs ); $i += 2 ) {
	$map[ $pairs[ $i ] ] = $pairs[ $i + 1 ];
}

mysqli_report( MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT );
$db = new mysqli( $host, $user, $pass, $name );
$db->set_charset( 'utf8mb4' );

/** Replace inside a value, recursing into serialized data and JSON-escaped forms. */
function ls_replace( $value, array $map ) {
	if ( is_array( $value ) ) {
		$out = array();
		foreach ( $value as $k => $v ) {
			$out[ ls_replace( $k, $map ) ] = ls_replace( $v, $map );
		}
		return $out;
	}
	if ( is_object( $value ) ) {
		if ( $value instanceof __PHP_Incomplete_Class ) {
			return $value; // a class not loaded here: leave it alone
		}
		foreach ( get_object_vars( $value ) as $k => $v ) {
			$value->$k = ls_replace( $v, $map );
		}
		return $value;
	}
	if ( ! is_string( $value ) ) {
		return $value;
	}
	if ( is_serialized_string( $value ) ) {
		$data = @unserialize( $value, array( 'allowed_classes' => false ) ); // phpcs:ignore
		if ( false !== $data || 'b:0;' === $value ) {
			return serialize( ls_replace( $data, $map ) );
		}
	}
	return strtr( $value, $map );
}

function is_serialized_string( string $s ): bool {
	$s = trim( $s );
	return (bool) preg_match( '/^(a|O|s|i|d|b):|^N;$/', $s ) && ( 'N;' === $s || preg_match( '/[;}]$/', $s ) );
}

// Each form a URL takes in the database: plain, JSON-escaped, URL-encoded.
$full = array();
foreach ( $map as $from => $to ) {
	$full[ $from ]                                      = $to;
	$full[ str_replace( '/', '\\/', $from ) ]           = str_replace( '/', '\\/', $to );
	$full[ rawurlencode( $from ) ]                      = rawurlencode( $to );
}

$total = 0;
foreach ( $db->query( 'SHOW TABLES' )->fetch_all() as list( $table ) ) {
	$cols = $db->query( "SHOW COLUMNS FROM `{$table}`" )->fetch_all( MYSQLI_ASSOC );
	$pk   = array_values( array_filter( $cols, static fn( $c ) => 'PRI' === $c['Key'] ) );
	if ( count( $pk ) !== 1 ) {
		echo "  skip {$table} (no single primary key)\n";
		continue;
	}
	$key  = $pk[0]['Field'];
	$text = array_column( array_filter( $cols, static fn( $c ) => preg_match( '/char|text|blob/i', $c['Type'] ) ), 'Field' );
	if ( ! $text ) {
		continue;
	}
	$changed = 0;
	$res     = $db->query( "SELECT `{$key}`, `" . implode( '`, `', $text ) . "` FROM `{$table}`" );
	while ( $row = $res->fetch_assoc() ) {
		$set = array();
		foreach ( $text as $col ) {
			if ( null === $row[ $col ] ) {
				continue;
			}
			$new = ls_replace( $row[ $col ], $full );
			if ( $new !== $row[ $col ] ) {
				$set[] = "`{$col}` = '" . $db->real_escape_string( $new ) . "'";
			}
		}
		if ( $set ) {
			$db->query( "UPDATE `{$table}` SET " . implode( ', ', $set ) . " WHERE `{$key}` = '" . $db->real_escape_string( (string) $row[ $key ] ) . "'" );
			++$changed;
		}
	}
	if ( $changed ) {
		printf( "  %-36s %5d hàng\n", $table, $changed );
		$total += $changed;
	}
}
echo "Đã đổi {$total} hàng.\n";
