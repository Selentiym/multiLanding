<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 17.02.2017
 * Time: 19:48
 */
$modREG = '<moduleVar:(library)>';
$mod = '<moduleVar>';
$contrReg = '<controller:\w+>';
$contr = '<controller>';
return SiteDispatcher::mergeArray(
    require_once(dirname(__FILE__).'/main.php'),
    require_once(dirname(__FILE__).'/clearRules.php'),
    array(
        'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
        'name' => 'library',
        'theme' => 'libraryLanding',
        'sourceLanguage' => 'en_US',
        'import' => [
            'application.components.modified.Html',
            'application.components.modified.CHtml',
            'application.components.callTrackerCustom.*',
            'application.models.experiments.*',
            'application.modules.callTracker.*',
            'application.modules.callTracker.models.*',
            'application.modules.callTracker.components.*',
            'application.modules.rights.*',
            'application.modules.rights.components.*',
        ],
        'modules'=>array(
            'tracker' =>[
                'class' => 'application.modules.callTracker.CallTrackerModule',
                'blocked' => true,
                'numberWhenBlocked' => '00000000000000',
                'formatNumber' => function($number){
                    //asd;
                    $number = preg_replace('/[^\d]/','',$number);
                    $first = substr($number, 0, 1);
                    $code = substr($number, 1, 3);
                    $triple = substr($number, 4, 3);
                    $fDouble = substr($number, 7, 2);
                    $sDouble = substr($number, 9, 2);
                    return "8($code)$triple-$fDouble-$sDouble";
                },
                'afterImport' => function($module){
                    aEnterFactory::setEnterFactory(new CustomEnterFactory($module));
                },
                'dbConfig' => 'dbTracker',
            ],
            'prices' => [
                'class' => 'application.modules.prices.PricesModule',
                'dbConfig' => 'dbCustom',
            ],
            'library' => [
                'class' => 'application.modules.library.LibraryModule',
                'dbConfig' => 'dbLibrary',
            ],
            'rights'=>[
                'install' => true,
                'userNameColumn' => 'fio',
                'dbConfig' => 'dbCustom',
                'superuserName' => 'admin',
            ],
        ),

        'controllerMap'=>array(
            'site' => 'application.sites.library.controllers.SiteController',
        ),

        'components'=>array(
            'phone' => [
                'number' => 'clinics'
            ],
            'urlManager'=>array(
                'urlFormat'=>'path',
                'showScriptName' => false,
                'urlSuffix' => '/',
                'rules' => array(
                    "" => 'site',
                    "rights" => "rights",
                    "$modReg/$contrReg" => "{$mod}/$contr/index",
                    "$modReg/$contrReg/<action:\w+>" => "{$mod}/$contr/<action>",
                    "rights/<c:\w+>/<a:\w+>" => "rights/<c>/<a>"
                ),
            ),
            'errorHandler'=>array(
                'errorAction'=>'error/index',
            ),

            'db'=>array(
                'class' => 'CDbConnection',
                'connectionString' => 'mysql:host=localhost;dbname=cq97848_landing',
                'tablePrefix' => 'l_',
                'emulatePrepare' => true,
                'username' => 'cq97848_landing',
                'password' => 'kicker',
                'charset' => 'utf8',
            ),

            'dbCustom'=>array(
                'class' => 'CDbConnection',
                'connectionString' => 'mysql:host=localhost;dbname=cq97848_landing',
                'tablePrefix' => 'l_',
                'emulatePrepare' => true,
                'username' => 'cq97848_landing',
                'password' => 'kicker',
                'charset' => 'utf8',
            ),

            'dbTracker'=>array(
                'class' => 'CDbConnection',
                'connectionString' => 'mysql:host=localhost;dbname=cq97848_landing',
                'tablePrefix' => 'allmrt_',
                'emulatePrepare' => true,
                'username' => 'cq97848_landing',
                'password' => 'kicker1995',
                'charset' => 'utf8',
            ),
            'user'=>[
                'class'=>'RWebUser'
            ],
            'authManager'=>[
                'class'=>'RDbAuthManager'
            ],
        ),

        'params'=>array(
            'siteId' => 'library',
            'formLine' => -10
        ),
    )
);