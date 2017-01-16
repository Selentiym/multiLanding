<?php
// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Web Application',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.components.CHtml',
		'application.models.*',
		'application.models.Section',
		'application.components.*',
		'application.components.traits.*',
		'application.components.forThemes.*',
		'application.sites.common.controllers.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'Selentiym_1705',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		'prices' => [
				'class' => 'application.modules.prices.PricesModule',
				'dbConfig' => 'dbPrices'
		],
	),

	'controllerMap'=>array(
		'form' => 'application.sites.common.controllers.FormController'
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		//authManager to enable RBAC - authorization. All info about roles, operations and tasks is stored in a database db.
		'authManager'=>array(
				'class'=>'CPhpAuthManager',
				//'connectionID'=>'db',
		),
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName' => false,
			'rules'=>array(
				'gii'=>'gii',
				'gii/<controller:\w+>'=>'gii/<controller>',
				'gii/<controller:\w+>/<action:\w+>'=>'gii/<controller>/<action>',

				'admin' => 'admin',
				'login' => 'login',
				'admin/<action:(create|update|delete)><modelClass:(CommonRule|Tel)>/<arg:\w*>' => 'admin/<action><modelClass>',
				
				'<action:\w+>' => 'site/<action>',
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),

		'themeManager' => [
			'class' => 'application.components.forThemes.UThemeManager',
			'themeClass' => 'application.components.forThemes.UTheme'
		],
		'phone' => [
			'class' => 'application.components.constantPhoneComponent',
			'number' => '7(812)123-45-67'
		],
		//*/
		'db'=>array(
            'connectionString' => 'mysql:host=localhost;dbname=cq97848_landing',
            'tablePrefix' => 'tbl_',
            'emulatePrepare' => true,
            'username' => 'cq97848_landing',
            'password' => 'kicker',
            'charset' => 'utf8',
        ),
		'dbPrices'=>array(
				'class' => 'CDbConnection',
				'connectionString' => 'mysql:host=localhost;dbname=cq97848_clinicsl',
				'tablePrefix' => 'tbl_',
				'emulatePrepare' => true,
				'username' => 'cq97848_clinicsl',
				'password' => 'kicker1995',
				'charset' => 'utf8',
		),
		// uncomment the following to use a MySQL database
		/*
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=testdrive',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		*/
		'clientScript' => array(
				'defaultScriptPosition' => CClientScript::POS_READY,
				'defaultScriptFilePosition' => CClientScript::POS_BEGIN,
				'coreScriptPosition' => CClientScript::POS_HEAD,
				'packages' => [
						'jquery' => [
							'baseUrl' => '',
							'js' => ['libs/jquery/jquery.min.js']
						],
						'simplePopup' => [
								'baseUrl' => 'libs/simplePopup/',
								'js' => [
										'script.js'
								],
								'css' => [
										'styles.css'
								]
						],
						'smoothDivScroll' => [
								'baseUrl' => 'libs/smoothDivScroll/',
								'js' => [
										'js/jquery.kinetic.min.js',
										'js/jquery.mousewheel.min.js',
										'js/jquery-ui-1.10.3.custom.min.js',
										'js/jquery.smoothdivscroll-1.3-min.js',
								],
								'css' => [
										'css/smoothDivScroll.css'
								],
								'depends' => ['jquery']
						]
				]
		),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'bondartsev.nikita@gmail.com',
		'formLine'=>'-8',
	),
);