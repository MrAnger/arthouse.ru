<?php

return [
	'class' => yii\web\UrlManager::class,

	'scriptUrl' => '/index.php',

	// Конфигурируйте этот параметр в main-local.php
	// 'baseUrl' => '',

	'enablePrettyUrl' => true,
	'showScriptName'  => false,
	'rules'           => [
		''           => '/site/index',
		'index.html' => '/',

		['pattern' => 'sitemap', 'route' => 'sitemap/default/index', 'suffix' => '.xml'],

		['pattern' => 'contacts', 'route' => '/site/contacts', 'suffix' => '/'],

		['pattern' => 'news', 'route' => '/news/index', 'suffix' => '/'],
		['pattern' => 'news/<slug>', 'route' => '/news/view-by-slug', 'suffix' => '/'],

		['pattern' => 'author', 'route' => '/author/index', 'suffix' => '/'],
		['pattern' => 'author/<username>', 'route' => '/author/view', 'suffix' => '/'],

		['pattern' => 'author/<username>/news/<slug>', 'route' => '/author/view-news-by-slug', 'suffix' => '/'],
		['pattern' => 'author/<username>/cinema/<slug>', 'route' => '/author/view-cinema-by-slug', 'suffix' => '/'],
		['pattern' => 'author/<username>/writer-work/<slug>', 'route' => '/author/view-writer-work-by-slug', 'suffix' => '/'],
		['pattern' => 'author/<username>/music-work/<slug>', 'route' => '/author/view-music-work-by-slug', 'suffix' => '/'],
		['pattern' => 'author/<username>/painter-work/<slug>', 'route' => '/author/view-painter-work-by-slug', 'suffix' => '/'],
	],
];
