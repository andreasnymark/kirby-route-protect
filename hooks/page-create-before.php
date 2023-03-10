<?php

return function ( $event, $page, $input ) {
	require dirname( __DIR__, 1 ) . '/route-protect.php';
};