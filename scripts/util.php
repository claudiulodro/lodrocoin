<?php

/**
 * Convert a string hash to a numeric hash.
 *
 * @param string $hash
 * @return string
 */
function hash_to_num( $hash ) {
	$num = '';

	foreach ( str_split( $hash ) as $char ) {
		if ( is_numeric( $char ) ) {
			$num .= $char;
		} else {
			$num .= ord( $char );
		}
	}

	return $num;
}

/**
 * Convert a string to uppercase alphanumeric chars.
 *
 * @param string $input
 * @return string
 */
function alphanumeric_uppercase( $input ) {
	return preg_replace( "/[^a-zA-Z0-9]+/", "", strtoupper( $input ) );
}

function get_image_hash( $img ) {
	return strtoupper( hash_file( 'ripemd160', $img ) );
}

function generate_ledger_line( $previous_line, $img, $user ) {
	return strtoupper( hash( 'ripemd160', $previous_line ) ) . get_image_hash( $img ) . alphanumeric_uppercase( $user );
}


