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
		'application.components.modified.CHtml',
		'application.models.*',
		'application.models.Section',
		'application.components.*',
		'application.components.traits.*',
		'application.components.forThemes.*',
		'application.components.expressions.*',
		'application.sites.common.controllers.*',
		'application.extensions.identityMap.*'
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
		'form' => 'application.sites.common.controllers.FormController',
		'error' => 'application.sites.common.controllers.ErrorController',
		'seo' => 'application.sites.common.controllers.SeoController'
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
				'robots.txt' => 'seo/robots',
				'sitemap.xml' => 'seo/sitemap',
				'sitemap<name:\w+>.xml' => 'seo/sitemap',
				'gii'=>'gii',
				'gii/<controller:\w+>'=>'gii/<controller>',
				'gii/<controller:\w+>/<action:\w+>'=>'gii/<controller>/<action>',

				'post' => 'form/submit',

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
				'class' => 'application.vendors.yii-EClientScript.EClientScript',
				'combineScriptFiles' => true, // By default this is set to true, set this to true if you'd like to combine the script files
				'combineCssFiles' => true, // By default this is set to true, set this to true if you'd like to combine the css files
				'optimizeScriptFiles' => true,	// @since: 1.1
				'optimizeCssFiles' => true, // @since: 1.1
				'optimizeInlineScript' => false, // @since: 1.6, This may case response slower
				'optimizeInlineCss' => false, // @since: 1.6, This may case response slower

				'defaultScriptPosition' => CClientScript::POS_READY,
				'defaultScriptFilePosition' => CClientScript::POS_BEGIN,
				'coreScriptPosition' => CClientScript::POS_HEAD,
				'packages' => [
						'jquery' => [
							'baseUrl' => '',
							'js' => ['libs/jquery/jquery.min.js']
						],
						'scrollToTop' => [
							'baseUrl' => 'libs/scrollToTop/',
							'js' => [
								'smartScrollToTop.min.js'
							],
							'depends' => ['jquery']
						],
						'scrollToTopActivate' => [
							'baseUrl' => 'libs/scrollToTop/',
							'js' => [
								'activate.js'
							],
							'css' => [
								'totop.css'
							],
							'depends' => ['scrollToTop']
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
						],
						'font-awesome' => [
							'baseUrl' => 'libs/font-awesome/',
							'css' => [
								'css/font-awesome.min.css'
							],
						],
						'prettyFormUrl' => [
							'baseUrl' => 'libs/prettyFormUrl/',
							'js' => [
								'pretty.js'
							],
							'position' => CClientScript::POS_READY,
							'depends' => ['jquery']
						],
						'select2' => [
							'baseUrl' => 'libs/select2/',
							'js' => [
								'select2.full.js'
							],
							'css' => [
								'select2.min.css'
							],
							'position' => CClientScript::POS_END,
							'depends' => ['jquery']
						],
						'select2_4' => [
							'baseUrl' => 'libs/select2_4/',
							'js' => [
								'js/select2.full.min.js'
							],
							'css' => [
								'css/select2.min.css'
							],
							'position' => CClientScript::POS_END,
							'depends' => ['jquery']
						],
						'tether' => [
							'baseUrl' => 'libs/tether',
							'js' => [
								'js/tether.min.js'
							],
							'depends' => [
								'jquery'
							]
						],
						'toggler' => [
							'baseUrl' => 'libs/toggler',
							'js' => [
								'toggler.js'
							],
							'depends' => [
								'jquery'
							]
						],
						'bootstrap4reboot' => [
							'baseUrl' => 'libs/bootstrap4/',
							'css' => [
								'css/bootstrap-reboot.min.css'
							]
						],
						'bootstrap4css' => [
							'baseUrl' => 'libs/bootstrap4/',
							'css' => [
								'css/bootstrap.min.css'
							],
							'depends' => [
								'bootsrtap4reboot'
							]
						],
						'bootstrapBreakpointJS' => [
							'baseUrl' => 'libs/bootstrapBreakpointJS',
							'js' => [
								'script.js'
							],
							'depends' => [
								'bootstrap4css'
							]
						],
						'bootstrap4js' => [
							'baseUrl' => 'libs/bootstrap4/',
							'js' => [
								'js/bootstrap.min.js',
								'js/ie10-viewport-bug-workaround.js'
							],
							'depends' => [
								'tether',
								'jquery'
							]
						],
						'bootstrap4collapseFix' => [
							'baseUrl' => 'libs/bootstrap4/',
							'js' => [
								'js/collapseFix.js',
							],
							'depends' => [
								'bootstrap4js'
							]
						],
						'maskedInput' => [
							'baseUrl' => 'libs/maskedInput/',
							'js' => [
								'jquery.maskedinput.min.js'
							],
						],
						'rateit' => [
							'baseUrl' => 'libs/rateit/',
							'js' => [
								'jquery.rateit.min.js'
							],
							'css' => [
								'rateit.css'
							],
							'depends' => ['jquery']
						],
						'owl' => [
							'baseUrl' => 'libs/owl-carousel/',
							'js' => [
								'owl.carousel.min.js'
							],
							'css' => [
								'assets/owl.carousel.min.css',
								'assets/owl.theme.default.min.css',
							],
							'depends' => ['jquery']
						],
						'old-owl' => [
							'baseUrl' => 'libs/old-owl/',
							'js' => [
								'owl.carousel.min.js'
							],
							'css' => [
								'owl.carousel.css',
							],
							'depends' => ['jquery']
						],
						'jedittable' => [
							'baseUrl' => 'libs/jedittable',
							'js' => [
								'jquery.jeditable.mini.js'
							],
							'depends' => [
								'jquery'
							]
						],
						'bootstrap-editable' => [
							'baseUrl' => 'libs/bootstrap-editable',
							'js' => [
								'js/bootstrap-editable.min.js'
							],
							'css' => [
								'css/bootstrap-editable.css'
							],
							'depends' => ['jquery']
						]
				]
		),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'error/index',
		),
		'log' => [
			'class' => 'CLogRouter',
			'routes' => [
				'db' => [
					'class' => 'CWebLogRoute',
					'categories' => 'system.db.CDbCommand',
				]
			]
		]


	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'bondartsev.nikita@gmail.com',
		'formLine'=>'-8',
	),
);