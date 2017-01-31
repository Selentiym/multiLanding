<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 06.01.2017
 * Time: 16:12
 */
return SiteDispatcher::mergeArray(
    require_once(dirname(__FILE__).'/main.php'),
    array(
        'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
        'name' => 'clinics',
        'theme' => 'mainClinics',
        'sourceLanguage' => 'en_US',

        'import' => [
            'application.components.callTrackerCustom.*',
            'application.models.experiments.*',
            'application.modules.callTracker.*',
            'application.modules.callTracker.models.*',
            'application.modules.callTracker.components.*',
        ],
        'modules'=>array(
            'tracker' =>[
                'class' => 'application.modules.callTracker.CallTrackerModule',
                'blocked' => false,
                'numberWhenBlocked' => 'number',
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
        ),

        'controllerMap'=>array(
            'home' => 'application.sites.allMrtKtClinicsRF.controllers.MainController',
            'main' => 'application.sites.allMrtKtClinicsRF.controllers.MainController',
            'error'=>'application.sites.common.controllers.ErrorController',
            /*'promo'=>array(
                'class' => 'application.sites.mywebsite-ru.controllers.PromoController',
                'viewPrefix' => '/mywebsite-ru/promo/',
            ),
            'support'=>array(
                'class' => 'application.sites.common.controllers.SupportController',
                'viewPrefix' => '/mywebsite-ru/support/',
            ),*/
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
                    '' => 'main',
                    'clinics' => 'clinics/default/index',
                    'clinics/default/index' => 'clinics/default/index',
                ),
            ),
            'errorHandler'=>array(
                'errorAction'=>'error/index',
            ),

            'dbCustom'=>array(
                'class' => 'CDbConnection',
                'connectionString' => 'mysql:host=localhost;dbname=cq97848_clinicsl',
                'tablePrefix' => 'tbl_',
                'emulatePrepare' => true,
                'username' => 'cq97848_clinicsl',
                'password' => 'kicker1995',
                'charset' => 'utf8',
            ),

            'dbTracker'=>array(
                'class' => 'CDbConnection',
                'connectionString' => 'mysql:host=localhost;dbname=cq97848_landing',
                'tablePrefix' => 'allmrt_',
                'emulatePrepare' => true,
                'username' => 'cq97848_clinicsl',
                'password' => 'kicker1995',
                'charset' => 'utf8',
            ),
        ),

        'params'=>array(
            'siteId' => 'clinics!',
            'formLine' => -4
        ),
    )
);