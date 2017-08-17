<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 20.12.2016
 * Time: 20:28
 */
return SiteDispatcher::mergeArray(
    require_once(dirname(__FILE__).'/main.php'),
    require_once(dirname(__FILE__).'/clearRules.php'),
    array(
        'name' => 'о-мрт.рф',
        'theme' => 'oMrt/oMrtBootstrap',
        'language' => 'oMrt',
        'defaultController' => 'home',
        'import' => [
            'application.sites.catalogCommon.HomeControllerCatalogCommon'
        ],
        'modules'=>array(
            'clinics' => [
                'class' => 'application.modules.clinics.ClinicsModule',
                'dbConfig' => 'dbClinics',
                'dbArticles' => 'dbClinics',
                'filesPath' => 'files/mrkt',
                'clinicsComments' => function () {return Yii::app() -> getModule('clinicsComments'); }
            ],
            'clinicsComments' => [
                'class' => 'application.modules.VKComments.VKCommentsModule',
                'dbConfig' => 'dbClinicComments',
                'bankConfig' => 'dbComments',
            ],
            'taskgen' => [
                'class' => 'application.modules.taskgen.TaskGenModule',
                'dbConfig' => 'dbTaskGen'
            ]
        ),
        'onBeginRequest' => function(){
            Yii::app() -> getModule('clinics');
        },
        'controllerMap' => [
            'home' => 'application.sites.oMrt.controllers.HomeController',
        ],
        'components'=>array(
            'phone' => [
                'class' => 'application.components.constantPhoneComponent',
                'number' => '8 (812) 407-29-86'
            ],
            'cache' => [
                'class'=>'CFileCache'
            ],
//            'cache'=>[
//                'class' => 'CMemCache',
//                'servers' => [
//                    [
//                        'host' => '127.0.0.1',
//                        'port' => 11211,
//                        'weight' => 64
//                    ],
//                ]
//            ],
            'phoneMSC' => [
                'class' => 'application.components.constantPhoneComponent',
                'number' => '8 (495) 125-29-54'
            ],
            'bootstrap'=>array(
                'class'=>'application.extensions.bootstrap.components.Bootstrap'
            ),
            'urlManager'=>array(
                'appendParams' => false,
                //'urlFormat' => null,
                'rules' => array(
                    '' => 'home/articles',
                    'robots.txt' => 'seo/robots',
                    'sitemap<name:(SPB|MSC|News)>.xml' => 'seo/sitemap',
                    //'clinics' => 'home/clinics',
                    '<module:(clinics)>/admin' => '<module>/admin/login',
                    '<module:(taskgen)>/task/<action:(getText)>' => '<module>/task/<action>',
                    '<module:(taskgen)>/task/<action:(getText)>/<id:\d+>' => '<module>/task/<action>',
                    //'<area:(spb|msc)>' => 'home/landing',
                    '<modelName:(clinics|doctors)>-<area:(spb|msc)>/show/<verbiage:[\w-_]+>' => 'home/modelView',
                    '<modelName:(clinics|doctors)>/show/<verbiage:[\w-_]+>' => 'home/modelView',
                    'article' => 'home/articles',
                    'tomography' => 'home/tomography',
                    'article/<verbiage:[\w-_]+>' => 'home/articleView',
                    [
                        'class' => 'application.components.urlRules.ModelAttributeUrlRule',
                        'modelClass' => 'ObjectPrice',
                        'attribute' => 'verbiage',
                        'attributeInPattern' => 'research',
                        'route' => 'home/<modelName>',
                        'pattern' => '<modelName:(clinics|doctors)>-<area:(spb|msc)>/<research:[\w-_]+>'
                    ],
                    [
                        'class' => 'application.components.urlRules.ModelAttributeUrlRule',
                        'modelClass' => 'ObjectPrice',
                        'attribute' => 'verbiage',
                        'attributeInPattern' => 'research',
                        'route' => 'home/<modelName>Link',
                        'pattern' => '<modelName:(clinics|doctors)>/<research::[\w-_]+>'
                    ],
                    '<modelName:(clinics|doctors)>' => 'home/<modelName>Link',
                    'clinics-<area:(spb|msc)>' => 'home/clinics',
                    'service-<area:(spb|msc)>' => 'home/service',
                    'news-<area:(spb|msc)>' => 'home/news',
                    'news-<area:(spb|msc)>/show/<id:\d+>' => 'home/showNews',
                    'news/show/<id:\d+>' => 'home/showNews',
                    'news' => 'home/news',
                    //'service/*' => 'error/404',
                    'home/clinics/*' => 'error/404'
                ),
            ),
            'dbClinics'=>mainTable('tbl_'),
            'dbClinicComments'=>mainTable('tbl_clc_'),
            'dbComments'=>mainTable('tbl_c_'),
            'dbTaskGen'=>require(__DIR__."/dbs/dbTaskgenDasha.pss.php"),
            'errorHandler' => [
                'errorAction' => 'home/error'
            ]
        ),
        'params'=>array(
            'siteId' => 'oMrt',
            'formLine' => -9,
            'dd.credentials' => 'partner.2751:JhZdjiuk'
        ),
    )
);