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
        'name' => 'Common specialized',
        'theme' => 'oMrt/oMrtBootstrap/mainSpecLib',
        'language' => 'mainSpecLib',
        'defaultController' => 'home',
        'import' => [
            'application.sites.catalogCommon.HomeControllerCatalogCommon',
            'application.sites.baseSpec.components.baseSpecHelpers',
        ],
        'modules'=>array(
            'clinics' => [
                'class' => 'application.modules.clinics.ClinicsModule',
                'dbConfig' => 'dbClinics',
                'dbArticles' => 'dbArticles',
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
            'home' => 'application.sites.baseSpec.controllers.SpecSiteHomeController',
        ],
        'components'=>array(
            'phone' => [
                'class' => 'application.components.constantPhoneComponent',
                'number' => '8 (812) 407-29-86'
            ],
            'phoneMSC' => [
                'class' => 'application.components.constantPhoneComponent',
                'number' => '8 (495) 125-29-54'
            ],
            'bootstrap'=>array(
                'class'=>'application.extensions.bootstrap.components.Bootstrap'
            ),
            'urlManager'=>array(
                //'urlFormat' => null,
                'rules' => array(
                    '' => 'home/articles',
                    'robots.txt' => 'seo/robots',
                    'sitemap<name:(SPB|MSC|News)>.xml' => 'seo/sitemap',
                    //'clinics' => 'home/clinics',
                    '<module:(clinics)>/admin' => '<module>/admin/login',
                    '<module:(taskgen)>/task/<action:(getText)>' => '<module>/task/<action>',
                    '<module:(taskgen)>/task/<action:(getText)>/<id:\d+>' => '<module>/task/<action>',
                    '<area:(spb|msc)>' => 'home/landing',
                    '<modelName:(clinics|doctors)>-<area:(spb|msc)>/show/<verbiage:[\w-_]+>' => 'home/modelView',
                    '<modelName:(clinics|doctors)>/show/<verbiage:[\w-_]+>' => 'home/modelView',
                    'article' => 'home/articles',
//                    'tomography' => 'home/tomography',
                    'service-<area:(spb|msc)>' => 'home/service',
                    'article/<verbiage:[\w-_]+>' => 'home/articleView',
                    'sales-<area:(spb|msc)>' => 'home/news',
                    'sales-<area:(spb|msc)>/show/<id:\d+>' => 'home/showNews',
                    'sales/show/<id:\d+>' => 'home/showNews',
                    'sales' => 'home/news',
                    [
                        'class' => 'application.components.urlRules.ModelAttributeUrlRule',
                        'modelClass' => 'ObjectPrice',
                        'attribute' => 'verbiage',
                        'attributeInPattern' => 'research',
                        'route' => 'home/<modelName>',
                        'validateModel' => function($model){
                            return in_array($model -> id_block, Yii::app() -> params['priceBlocks']);
                        },
                        'pattern' => '<modelName:(clinics|doctors)>-<area:(spb|msc)>/<research:[\w-_]+>'
                    ],
                    [
                        'class' => 'application.components.urlRules.ModelAttributeUrlRule',
                        'modelClass' => 'ObjectPrice',
                        'attribute' => 'verbiage',
                        'attributeInPattern' => 'research',
                        'route' => 'home/<modelName>Link',
                        'validateModel' => function($model){
                            return in_array($model -> id_block, Yii::app() -> params['priceBlocks']);
                        },
                        'pattern' => '<modelName:(clinics|doctors)>/<research::[\w-_]+>'
                    ],
                    '<modelName:(clinics|doctors)>' => 'home/<modelName>Link',
                    'clinics-<area:(spb|msc)>' => 'home/clinics',
                ),
            ),
            'dbClinics'=>mainTable('tbl_'),
            'dbClinicComments'=>mainTable('tbl_clc_'),
            'dbComments'=>mainTable('tbl_c_'),
            'dbTaskGen'=> require(__DIR__ . '/dbs/dbTaskgenDasha.pss.php'),
            'errorHandler' => [
                'errorAction' => 'home/error'
            ]
        ),
        'params'=>array(
            'siteId' => 'oMrt',
            'formLine' => -9,
            'dd.credentials' => 'partner.2751:JhZdjiuk',
            'clinicPrefix' => 'Центр диагностики',
        ),
    )
);