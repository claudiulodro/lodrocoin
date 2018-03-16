<?php

/**
 * Generate and output one or more seed hashes for Lodrocoin.
 *
 * @param $argv[1] (optional) The amount of seed hashes to generate. Default: 1
 */

function generate_seed_hash() {
	$hash = '';

	while ( strlen( $hash ) < 8 ) {
		$hash .= rand();
	}

	return substr( $hash, 0, 8 );
}

$amount_to_generate = isset( $argv[1] ) ? (int) $argv[1] : 1;

for ( $i = 0; $i < $amount_to_generate; ++$i ) {
	echo generate_seed_hash() . "\n";
}

