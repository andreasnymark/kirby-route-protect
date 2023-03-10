<?php

return function ( $event, $page, $slug ) {
	require dirname( __DIR__, 1 ) . '/route-protect.php';
};