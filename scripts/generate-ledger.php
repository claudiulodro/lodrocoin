<?php

/**
 * Generate a Lodrocoin ledger.
 *
 * @param int $argv[1] Number of Lodrocoin to generate
 */

require 'util.php';

define( 'LEDGER_FILE', 'ledger.md' );
define( 'FIRST_OWNER', 'LODRO' );

$num_to_generate = isset( $argv[1] ) ? (int) $argv[1] : 0;
if ( ! $num_to_generate ) {
	throw new Exception( 'Quantity to generate not specified' );
}

$ledger = [];
for ( $i = 0; $i < $num_to_generate; ++$i ) {
	$seed = generate_seed_hash();
	$hash = strtoupper( hash( 'ripemd160', $seed ) );
	$ledger[] = '## ' . $seed;
	$ledger[] = '### OWNER: ' . FIRST_OWNER;
	$ledger[] = '### QUANTITY: 1';
	$ledger[] = $seed . $hash . FIRST_OWNER;
}

$file_output = implode( "\n\n", array_filter( $ledger ) );

file_put_contents( LEDGER_FILE, $file_output );
