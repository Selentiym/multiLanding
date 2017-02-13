<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 06.01.2017
 * Time: 16:12
 */
return SiteDispatcher::mergeArray(
    require_once(dirname(__FILE__).'/main.php'),
    //require_once(dirname(__FILE__).'/clearRules.php'),
    array(
        'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
        'name' => 'clinics',
        'theme' => 'mainClinics',
        'sourceLanguage' => 'en_US',
        'import' => [
            'application.components.modified.Html',
            'application.components.modified.CHtml',
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
                    '<moduleClinics:(clinics)>' => '<moduleClinics>/admin/index',
                    '<moduleClinics:(clinics)>/admin/<modelName:(clinics|doctors)>PricelistCreate/<id:\d+>' => '<moduleClinics>/admin/PricelistCreate',
                    '<moduleClinics:(clinics)>/admin/<modelName:(clinics|doctors)>Pricelists/<id:\d+>' => '<moduleClinics>/admin/Pricelists',
                    '<moduleClinics:(clinics)>/admin/PricelistDelete/<id:\d+>' => '<moduleClinics>/admin/PricelistDelete',
                    '<moduleClinics:(clinics)>/admin/PricelistUpdate/<id:\d+>' => '<moduleClinics>/admin/PricelistUpdate',
                    '<moduleClinics:(clinics)>/admin/<modelName:(clinics|doctors)>' => '<moduleClinics>/admin/Models',
                    '<moduleClinics:(clinics)>/admin/<modelName:(clinics|doctors)>Filters' => '<moduleClinics>/admin/Filters',
                    '<moduleClinics:(clinics)>/admin/<modelName:(clinics|doctors)>FilterCreate' => '<moduleClinics>/admin/FilterCreate',
                    '<moduleClinics:(clinics)>/admin/<modelName:(clinics|doctors)>Create' => '<moduleClinics>/admin/ObjectCreate',
                    '<moduleClinics:(clinics)>/admin/<modelName:(clinics|doctors)>ExportCsv' => '<moduleClinics>/admin/ExportCsv',
                    '<moduleClinics:(clinics)>/admin/<modelName:(clinics|doctors)>ImportCsv' => '<moduleClinics>/admin/ImportCsv',
                    '<moduleClinics:(clinics)>/admin/<modelName:(clinics|doctors)>FieldsGlobal' => '<moduleClinics>/admin/FieldsGlobal',
                    '<moduleClinics:(clinics)>/admin/<modelName:(clinics|doctors)>FieldCreateGlobal' => '<moduleClinics>/admin/FieldCreateGlobal',
                    '<moduleClinics:(clinics)>/admin/<modelName:(clinics|doctors)>Fields/<id:\d+>' => '<moduleClinics>/admin/Fields',
                    '<moduleClinics:(clinics)>/admin/<modelName:(clinics|doctors)>FieldsCreate/<id:\d+>' => '<moduleClinics>/admin/FieldsCreate',
                    '<moduleClinics:(clinics)>/admin/<modelName:(clinics|doctors)>FieldsUpdate/<id:\d+>' => '<moduleClinics>/admin/FieldsUpdate',
                    '<moduleClinics:(clinics)>/admin/FieldUpdateGlobal/<id:\d+>' => '<moduleClinics>/admin/FieldUpdateGlobal',
                    '<moduleClinics:(clinics)>/admin/FieldDeleteGlobal/<id:\d+>' => '<moduleClinics>/admin/FieldDeleteGlobal',
                    '<moduleClinics:(clinics)>/admin/<modelName:(clinics|doctors)>Delete/<id:\d+>' => '<moduleClinics>/admin/ObjectDelete',
                    '<moduleClinics:(clinics)>/admin/<modelName:(clinics|doctors)>Update/<id:\d+>' => '<moduleClinics>/admin/ObjectUpdate',


                    '<moduleClinics:(clinics)>/admin/<modelName:(clinics|doctors)><modelClass:(Price)><act:(Update|Delete|Create)>/<id:\d+>' => '<moduleClinics>/admin/<modelClass><act>',
                    '<moduleClinics:(clinics)>/admin/<modelClass:(Price|PriceBlock)><act:(Update|Delete|Create)>/<id:\d+>' => '<moduleClinics>/admin/<modelClass><act>',
                    '<moduleClinics:(clinics)>/admin/<modelName:(clinics|doctors)><modelClass:(Price)><act:(Create)>' => '<moduleClinics>/admin/<modelClass><act>',
                    '<moduleClinics:(clinics)>/admin/<modelClass:(Price|PriceBlock)><act:(Create)>' => '<moduleClinics>/admin/<modelClass><act>',
                    '<moduleClinics:(clinics)>/admin/<modelName:(clinics|doctors)><modelClass:(Price)>List' => '<moduleClinics>/admin/<modelClass>List',

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
                'username' => 'cq97848_landing',
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