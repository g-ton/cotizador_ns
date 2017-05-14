<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

Yii::setPathOfAlias('bootstrap', dirname(__FILE__) . '/../extensions/bootstrap');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Mi Cotizador Nsstore',
	'language'=>'es',
	//'defaultController' => Yii::app()->user->id==NULL ? 'site/login' : 'site/index',
	'defaultController' => Yii::app()->user->id!= NULL ? 'site/index' : 'site/login',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'bootstrap.helpers.TbHtml',
		'application.helpers.*',
		'application.extensions.*' ,
	),
	'timeZone' => 'America/Mexico_City',

	'aliases' => array(
        'bootstrap' => realpath(__DIR__ . '/../extensions/bootstrap'), // change this if necessary
    ),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'Joyeria',
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'admin',
			'generatorPaths' => array('bootstrap.gii'),
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		
	),

	// application components
	'components'=>array(
		'mailer' => array(
	      'class' => 'application.extensions.mailer.EMailer',
	      'pathViews' => 'application.views.email',
	      'pathLayouts' => 'application.views.email.layouts'
   		),

		'authManager'=> array(
			"class"=>"CDbAuthManager",
			"connectionID"=>"db",
		),

		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'returnUrl'=>array('/site'),
		),

		'bootstrap' => array(
            'class' => 'bootstrap.components.TbApi',   
        ),

        'image'=>array(
          'class'=>'application.extensions.image.CImageComponent',
            // GD or ImageMagick
            'driver'=>'GD',
            // ImageMagick setup path
            'params'=>array('directory'=>'/opt/local/bin'),
        ),
		// uncomment the following to enable URLs in path-format
		/*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		*/
		'db'=>array(
            'class'=>'CDbConnection',
            'connectionString'=>'mysql:host=localhost;dbname=nsstore_shop',
            'username'=>'root',
            'password'=>'123456',
            'charset' => 'utf8',
        ),

     	'db1' => array(
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=localhost;dbname=nsstore_store_cp',
            'username' => 'root',
            'password'=>'123456',
            'charset' => 'utf8',
        ),
		// uncomment the following to use a MySQL database
		/*
		'db'=>array(
			'connectionString' => 'mysql:host=mysql.hostinger.mx;dbname=testdrive',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		*/
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
		'adminEmail'=>'webmaster@example.com',
	),
);