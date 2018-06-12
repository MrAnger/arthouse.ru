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

		['pattern' => 'author/<username>/news', 'route' => '/author-news/index', 'suffix' => '/'],
		['pattern' => 'author/<username>/news/<slug>', 'route' => '/author-news/view', 'suffix' => '/'],
		['pattern' => 'author/<username>/cinema-work', 'route' => '/author-cinematographer/index', 'suffix' => '/'],
		['pattern' => 'author/<username>/cinema-work/<slug>', 'route' => '/author-cinematographer/view', 'suffix' => '/'],
		['pattern' => 'author/<username>/writer-work', 'route' => '/author-writer/index', 'suffix' => '/'],
		['pattern' => 'author/<username>/writer-work/<slug>', 'route' => '/author-writer/view', 'suffix' => '/'],
		['pattern' => 'author/<username>/music-work', 'route' => '/author-musician/index', 'suffix' => '/'],
		['pattern' => 'author/<username>/music-work/<slug>', 'route' => '/author-musician/view', 'suffix' => '/'],
		['pattern' => 'author/<username>/painter-work', 'route' => '/author-painter/index', 'suffix' => '/'],
		['pattern' => 'author/<username>/painter-work/<slug>', 'route' => '/author-painter/view', 'suffix' => '/'],
	],
];
