<?php

Kirby::plugin( 'andreasnymark/kirby-route-protect', [
	'options' => [
		'slugs' => [],
	],
	'hooks' => [
		'page.create:before' => require __DIR__ . '/hooks/page-create-before.php',
		'page.changeSlug:before' => require __DIR__ . '/hooks/page-changeSlug-before.php',
	],
]);
