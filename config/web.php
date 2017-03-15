<?php

$params = require(__DIR__ . '/params.php');

$config = [
	'id' => 'Qplan',
	'language' => 'es',
	'sourceLanguage' => 'es_CL',
	'timeZone' => 'America/Santiago',
	'basePath' => dirname(__DIR__),
	'bootstrap' => ['log'],
	'components' => [
		'request' => [
			'cookieValidationKey' => '9MW5pkuQfR6YKvG4lPUQsI6e10V3EQ5u',
			'enableCsrfValidation' => false,
			'parsers' => [
				'application/json' => 'yii\web\JsonParser',
			]
		],
		'cache' => [
			'class' => 'yii\caching\FileCache',
		],
		'user' => [
			'identityClass' => 'app\models\user\User',
			'enableAutoLogin' => false,
		],
		'errorHandler' => [
			'errorAction' => 'site/error',
		],
		'mailer' => [
			'class' => 'yii\swiftmailer\Mailer',
			'useFileTransport' => true,
		],
		'log' => [
			'traceLevel' => YII_DEBUG ? 3 : 0,
			'targets' => [
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['error', 'warning'],
				],
			],
		],
		'db' => require(__DIR__ . '/db.php'),
		'urlManager' => [
			'enablePrettyUrl' => true,
			'enableStrictParsing' => true,
			'showScriptName' => false,
			'rules' => [
				[
					'class' => 'yii\rest\UrlRule',
					'controller' => [
						'authorization',
						'v1/users',
					]
				],				
				[
					'class' => 'yii\rest\UrlRule',
					'controller' => [
						'v1/test',
					],
					'extraPatterns' => [
						'GET search' => 'search'
					],
					'pluralize' => false,
				],
				// 'GET,HEAD <ns:\w+>/<controller:\w+>' => '<ns>/<controller>/index',
				// 'GET,HEAD <ns:\w+>/<controller:\w+>/<id:\d+>' => '<ns>/<controller>/view',
				// 'POST <controller:\w+>' => '<controller>/create',
				// 'PUT,PATCH <controller:\w+>/<id:\d+>' => '<controller>/update',
				// 'DELETE <controller:\w+>/<id:\d+>' => '<controller>/delete',
				// 'OPTIONS <controller:\w+>' => '<controller>/options',
				// 'OPTIONS <controller:\w+>/<id:\d+>' => '<controller>/options',
				// //Url Personalizadas
				// 'GET <ns:\w+>/<controller:\w+>/<id:\d+>/<action:\w+>' => '<ns>/<controller>/<action>',
				// 'GET <ns:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>' => '<ns>/<controller>/<action>',
				// 'degub/<action:\w+>' => 'degub/<action>',
				// 'degub' => 'degub/index',
				// '<controller:\w+>/<action:\w+><id:\d+>'=>'<controller>/<action>',
				// '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				// '<controller:\w+>/<action:\w+>/<id:\w+>'=>'<controller>/<action>',
				// 'GET <ns:\w+>/<controller:\w+>/<action:\w+>' => '<ns>/<controller>/<action>',
				'POST authentication/<action:\w+>' => 'authentication/<action>',
			],
		],
	],
	'modules' => [
		'v1' => [
			'class' => 'app\modules\v1\module',
		],
	],
	'params' => $params,
];

if (YII_ENV_DEV) {
	// configuration adjustments for 'dev' environment
	$config['bootstrap'][] = 'debug';
	$config['modules']['debug'] = [
		'class' => 'yii\debug\Module',
		// uncomment the following to add your IP if you are not connecting from localhost.
		//'allowedIPs' => ['127.0.0.1', '::1'],
	];

	$config['bootstrap'][] = 'gii';
	$config['modules']['gii'] = [
		'class' => 'yii\gii\Module',
		'allowedIPs' => ['127.0.0.1', '::1'],
	];
}

return $config;
