<?php

$userProtected = option( 'andreasnymark.kirby-route-protect.slugs' ) ?? [];
$protected = [];
$check = '';

// make sure user provides slugs as array
if ( gettype( $userProtected ) != 'array' ) throw new Exception( t( 'andreasnymark.kirby-route-protect.array', 'Protected route names needs to be in an array.' ) );

// setup check var depending on hook event
switch ( $event ) {
	case 'page.changeSlug:before' :
		$parts = explode( '/', $page );
		if ( count( $parts ) > 1 ) {
			// remove last word, adding new slug
			array_pop( $parts );
			$check = implode( '/', $parts ) . $slug;
		} else {
			$check = $slug;
		}
		break;
	case 'page.create:before' :
		$check = $page;
		break;
}

// loop through all existing routes, pick
// first word and add to array
foreach ( kirby()->routes() as $route ) {
	$pattern = $route[ 'pattern' ];
	$patternArray = array_values( array_filter( explode( '/', $pattern ), 'strlen' ) );

	// avoiding empty arrays
	if ( count( $patternArray ) > 0 ) {
		$protected[] = $patternArray[ 0 ];
	}
}
// merge, keep unique, and remove empty
$protected = array_values( array_unique( array_merge( $userProtected, $protected ) ) );

// loop through all routes + user protected
// and throw error if it’s a match
foreach ( $protected as $item ) {
	if ( $check == $item ) {
		throw new Exception( t( 'andreasnymark.kirby-route-protect.protected', 'The URL-appendix is protected.' ) );
	}
}

