<?php

require 'util.php';

define( 'LEDGER_FILE', 'ledger.md' );

$seed_hash = isset( $argv[1] ) ? alphanumeric_uppercase( $argv[1] ) : '';
$img = isset( $argv[2] ) ? $argv[2] : '';
$owner = isset( $argv[3] ) ? alphanumeric_uppercase( $argv[3] ) : '';

if ( ! $seed_hash || ! $img || ! $owner ) {
	throw new Exception( 'Missing input argument' );
}

$img_hash = get_image_hash( $img );


$ledger = [];
$file = fopen( LEDGER_FILE, 'rw' );
if ( ! $file ) {
	throw new Exception( 'Error reading ledger file' );
}

$seed_hash_line = -1;
$current_line = 0;
while ( $line = fgets( $file ) ) {
	$ledger[] = trim( $line );
	if ( $img_hash == substr( $line, 40, 40 ) ) {
		fclose( $file );
		throw new Exception( 'Duplicate image' );
	}

	if ( '## ' . $seed_hash == trim( $line ) ) {
		$seed_hash_line = $current_line;
	}

	++$current_line;
}

fclose( $file );

if ( -1 == $seed_hash_line ) {
	throw new Exception( 'Seed hash not found' );
}

// Take ownership.
$owner_position = $seed_hash_line + 1;
$owner_line = '### OWNER: ' . $owner;
array_splice( $ledger, $owner_position, 1, [ $owner_line ] );

// Add new line to ledger.
$new_line_position = $seed_hash_line + 3;
$new_line = generate_ledger_line( $ledger[ $new_line_position ], $img, $owner );
array_splice( $ledger, $new_line_position, 0, [ $new_line ] );

$file_output = implode( "\n", $ledger );

echo $new_line . "\n";

file_put_contents( LEDGER_FILE, $file_output );

