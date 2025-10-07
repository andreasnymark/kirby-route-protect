<?php

$userProtected = kirby()->option( 'andreasnymark.kirby-route-protect.slugs' ) ?? [];
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
			$check = A::join( $parts, '/' ) . $slug;
		} else {
			$check = $slug;
		}
		break;
	case 'page.create:before' :
		$check = $page;
		break;
}

// loop through all existing routes and store full patterns
foreach ( kirby()->routes() as $route ) {
	$pattern = $route[ 'pattern' ];
	$patternArray = Str::split( $pattern, '/' );

	// avoiding empty arrays
	if ( count( $patternArray ) > 0 ) {
		$protected[] = A::join( $patternArray, '/' );
	}
}

// merge, keep unique, and remove empty
$protected = array_values( array_unique( A::merge( $userProtected, $protected ) ) );

// break down the check path into all levels
$checkParts = Str::split( $check, '/' );
$levelsToCheck = [];
for ( $i = 0; $i < count( $checkParts ); $i++ ) {
	$levelsToCheck[] = A::join( A::slice( $checkParts, 0, $i + 1 ), '/' );
}

// check each level against protected routes
foreach ( $levelsToCheck as $level ) {
	if ( in_array( $level, $protected ) ) {
		throw new Exception( t( 'andreasnymark.kirby-route-protect.protected', 'The URL-appendix is protected or already in use.' ) );
	}
}

