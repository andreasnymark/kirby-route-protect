<?php

$user_protected = option( 'andreasnymark.kirby-route-protect.slugs' );
$protected = [];
$check = '';

if ( gettype( $user_protected ) != 'array' ) throw new Exception( 'Protected route names needs to be in an array.' );

switch ( $event ) {
	case 'page.changeSlug:before' :
		$parts = explode( '/', $page );
		if ( count( $parts ) > 1 ) {
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

foreach ( kirby()->routes() as $route ) {
	$pattern = $route[ 'pattern' ];
	$pattern_array = array_values( array_filter( explode( '/', $pattern ), 'strlen' ) );

	if ( count( $pattern_array ) > 0 ) {
		$protected[] = $pattern_array[ 0 ];
	}
}

$protected = array_values( array_unique( array_merge( $user_protected, $protected ) ) );
foreach ( $protected as $item ) {
	if ( $check == $item ) {
		throw new Exception( 'The URL-appendix is protected.' );
	}
}

