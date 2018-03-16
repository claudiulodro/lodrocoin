<?php

/**
 * Output the image hash for a file.
 *
 * @param $argv[1] Path to image file
 */

require 'util.php';

$img = isset( $argv[1] ) ? $argv[1] : '';
if ( ! $img ) {
	throw new Exception( 'No image specified' );
}

echo get_image_hash( $img ) . "\n";
