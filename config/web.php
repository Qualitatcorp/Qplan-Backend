<?php

use kartik\mpdf\Pdf;
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
						'v1/test',
						'v1/clasificacion',
						'v1/clasificacioncategoria',
						'v1/clasificacionperfil',
						'v1/comuna',
						'v1/comunaprovincia',
						'v1/comunaregion',
						'v1/empresa',
						'v1/empresaclasificacion',
						'v1/empresasucursal',
						'v1/empresauser',
						'v1/especialidad',
						'v1/especialidadarea',
						'v1/especialidadcargo',
						'v1/evaluacionalternativa',
						'v1/evaluacionitem',
						'v1/evaluacionpregunta',
						'v1/evaluacionteorica',
						'v1/evaluaciontipo',
						'v1/ficha',
						'v1/fichaitem',
						'v1/fichapractica',
						'v1/ficharespuesta',
						'v1/fichateorico',
						'v1/fichatercero',
						'v1/fichatercerosources',
						'v1/ordentrabajo',
						'v1/ordentrabajosolicitud',
						'v1/ordentrabajotrabajador',
						'v1/pais',
						'v1/perfil',
						'v1/perfilespecialidad',
						'v1/perfilevaluacionteorica',
						'v1/perfilmodulo',
						'v1/psicologicopca',
						'v1/recursos',
						'v1/recursoshasoptions',
						'v1/recursoshassources',
						'v1/recursosoptions',
						'v1/recursossources',
						'v1/report',
						'v1/trabajador',
						'v1/trabajadorevaluador',
						'v1/trabajadorexperiencia',
						'v1/user',
						'v1/userauthentication',
						'v1/userauthorization',
						'v1/userclient',
						'v1/userresource',
						'v1/userresourcechildren',
						'v1/provider',
						'v1/providermetodo'
					],
					'extraPatterns' => [
						'GET search' => 'search'
					],
					'pluralize' => false,
				],
				// '<ns:\w+>/<controller:\w+>' => '<ns>/<controller>/index',
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
				//'<ns:\w+>/<controller:\w+>/<action:\w+>' => '<ns>/<controller>/<action>',
				//'<ns:\w+>/<controller:\w+>' => '<ns>/<controller>/index',
				'POST v1/psicologicopca/gotosurvey' => 'v1/psicologicopca/gotosurvey',
				'POST v1/psicologicopca/test' => 'v1/psicologicopca/test',
				'POST v1/psicologicopca/getresult' => 'v1/psicologicopca/getresult',
				'v1/psicologicopca/<action:\w+>' => 'v1/psicologicopca/<action:\w+>',
				'POST authentication/<action:\w+>' => 'authentication/<action>',
				'report/<controller:\w+>' => 'report/<controller>/index',
				'report/<controller:\w+>/<action:\w+>' => 'report/<controller>/<action>',
				 
			],
		],
		'pdf' => [
	        'class' => Pdf::classname(),
	        'format' => Pdf::FORMAT_A4,
	        'orientation' => Pdf::ORIENT_PORTRAIT,
	        'destination' => Pdf::DEST_BROWSER,
	        // refer settings section for all configuration options
	    ],
	],
	'modules' => [
		'v1' => [
			'class' => 'app\modules\v1\module',
		],
		'report' => [
            'class' => 'app\modules\report\report',
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
