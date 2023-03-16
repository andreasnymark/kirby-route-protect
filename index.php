<?php

Kirby::plugin( 'andreasnymark/kirby-route-protect', [
	'options' => [
		'slugs' => [],
	],
	'hooks' => [
		'page.create:before' => require __DIR__ . '/hooks/page-create-before.php',
		'page.changeSlug:before' => require __DIR__ . '/hooks/page-changeslug-before.php',
	],
	'translations' => [
		'en' => [
			'andreasnymark.kirby-route-protect' => [
				'array' => 'Protected route names needs to be in an array.',
				'protected' => 'The URL-appendix is protected.',
			],
		],
	],
]);
