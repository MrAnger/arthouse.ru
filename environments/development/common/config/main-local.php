<?php

return [
	'modules'    => [
		'user' => [
			'mailParams' => [
				'fromEmail' => 'noreply@artxayc.ru',
			],
		],
	],
	'components' => [
		'db'     => [
			'class'    => 'yii\db\Connection',
			'dsn'      => 'mysql:host=localhost;dbname=database_name',
			'username' => 'root',
			'password' => '',
			'charset'  => 'utf8',
		],
		'mailer' => [
			'class'            => 'yii\swiftmailer\Mailer',
			'viewPath'         => '@common/mail',
			'useFileTransport' => true,
		],
		'backendUrlManager' => [
			'baseUrl' => 'http://arthouse.loc/cp',
		],
		'frontendUrlManager' => [
			'baseUrl' => 'http://arthouse.loc',
		],
	],
];
