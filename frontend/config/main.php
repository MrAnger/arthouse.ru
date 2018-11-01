<?php

$params = array_merge(
	require(__DIR__ . '/../../common/config/params.php'),
	require(__DIR__ . '/../../common/config/params-local.php'),
	require(__DIR__ . '/params.php'),
	require(__DIR__ . '/params-local.php')
);

$config = [
	'id'                  => 'app-frontend',
	'basePath'            => dirname(__DIR__),
	'controllerNamespace' => 'frontend\controllers',
	'modules'             => [
		'user'    => [
			'enableFlashMessages' => false,
			'controllerMap'       => [
				'security'     => 'frontend\controllers\SecurityController',
				'recovery'     => 'frontend\controllers\RecoveryController',
				'registration' => 'frontend\controllers\RegistrationController',
				'settings'     => 'frontend\controllers\SettingsController',
			],
		],
		'sitemap' => [
			'models' => [
				\common\models\News::class,
				\common\models\Cinema::class,
				\common\models\WriterWork::class,
				\common\models\MusicWork::class,
				\common\models\PainterWork::class,
			],
			'urls'   => require(__DIR__ . '/sitemap-urls.php'),
		],
	],
	'bootstrap'           => [
		'log',
		'frontend\components\StartUp',
	],
	'components'          => [
		'request'      => [
			'baseUrl' => '',
		],
		'urlManager'   => function () {
			return Yii::$app->frontendUrlManager;
		},
		'cache'        => [
			'class' => 'yii\caching\FileCache',
		],
		'assetManager' => [
			'appendTimestamp' => true,
		],
		'errorHandler' => [
			'errorAction' => 'site/error',
		],
		'view'         => [
			'theme' => [
				'pathMap' => [
					'@Da/User/resources/views' => '@app/views/usuario',
				],
			],
		],
	],
	'params'              => $params,
];

return $config;
