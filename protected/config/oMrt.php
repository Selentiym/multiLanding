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
        'name' => 'Самая крупная сеть МРТ и КТ диагностических центров',
        'theme' => 'oMrt/oMrtBootstrap',
        'language' => 'oMrt',
        'defaultController' => 'home',
        'modules'=>array(
            'clinics' => [
                'class' => 'application.modules.clinics.ClinicsModule',
                'dbConfig' => 'dbClinics',
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
            'bootstrap'=>array(
                'class'=>'application.extensions.bootstrap.components.Bootstrap'
            ),
            'urlManager'=>array(
                //'urlFormat' => null,
                'rules' => array(
                    '' => 'home/articles',
                    'robots.txt' => 'seo/robots',
                    'sitemap<name:(SPB|MSC)>.xml' => 'seo/sitemap',
                    //'clinics' => 'home/clinics',
                    '<module:(clinics)>/admin' => '<module>/admin/login',
                    '<module:(taskgen)>/task/<action:(getText)>' => '<module>/task/<action>',
                    '<module:(taskgen)>/task/<action:(getText)>/<id:\d+>' => '<module>/task/<action>',
                    '<area:(spb|msc)>' => 'home/landing',
                    '<modelName:(clinics|doctors)>-<area:(spb|msc)>/show/<verbiage:[\w-_]+>' => 'home/modelView',
                    '<modelName:(clinics|doctors)>/show/<verbiage:[\w-_]+>' => 'home/modelView',
                    'article' => 'home/articles',
                    'article/<verbiage:[\w-]+>' => 'home/articleView',
                    [
                        'class' => 'application.components.urlRules.ModelAttributeUrlRule',
                        'modelClass' => 'ObjectPrice',
                        'attribute' => 'verbiage',
                        'attributeInPattern' => 'research',
                        'route' => 'home/<modelName>',
                        'pattern' => '<modelName:(clinics|doctors)>-<area:(spb|msc)>/<research:\w+>'
                    ],
                    [
                        'class' => 'application.components.urlRules.ModelAttributeUrlRule',
                        'modelClass' => 'ObjectPrice',
                        'attribute' => 'verbiage',
                        'attributeInPattern' => 'research',
                        'route' => 'home/<modelName>Link',
                        'pattern' => '<modelName:(clinics|doctors)>/<research:\w+>'
                    ],
                    '<modelName:(clinics|doctors)>' => 'home/<modelName>Link',
                    'clinics-<area:(spb|msc)>' => 'home/clinics',
                ),
            ),
            'dbClinics'=>array(
                'class' => 'CDbConnection',
                'connectionString' => 'mysql:host=localhost;dbname=cq97848_clmod',
                'tablePrefix' => 'tbl_',
                'emulatePrepare' => true,
                'username' => 'cq97848_clmod',
                'password' => 'kicker1995',
                'charset' => 'utf8',
            ),
            'dbClinicComments'=>array(
                'class' => 'CDbConnection',
                'connectionString' => 'mysql:host=localhost;dbname=cq97848_clmod',
                'tablePrefix' => 'tbl_clc_',
                'emulatePrepare' => true,
                'username' => 'cq97848_clmod',
                'password' => 'kicker1995',
                'charset' => 'utf8',
            ),
            'dbComments'=>array(
                'class' => 'CDbConnection',
                'connectionString' => 'mysql:host=localhost;dbname=cq97848_clmod',
                'tablePrefix' => 'tbl_c_',
                'emulatePrepare' => true,
                'username' => 'cq97848_clmod',
                'password' => 'kicker1995',
                'charset' => 'utf8',
            ),
            'dbTaskGen'=>array(
                'class' => 'CDbConnection',
                'connectionString' => 'mysql:host=localhost;dbname=cq97848_taskgen',
                'tablePrefix' => 'tbl_',
                'emulatePrepare' => true,
                'username' => 'cq97848_taskgen',
                'password' => 'kicker',
                'charset' => 'utf8',
            ),
            'dbTracker'=>array(
                'class' => 'CDbConnection',
                'connectionString' => 'mysql:host=localhost;dbname=cq97848_landing',
                'tablePrefix' => 'mrkt_',
                'emulatePrepare' => true,
                'username' => 'cq97848_landing',
                'password' => 'kicker',
                'charset' => 'utf8',
            ),
            'errorHandler' => [
                'errorAction' => 'home/error'
            ]
        ),
        'params'=>array(
            'siteId' => 'oMrt',
            'formLine' => -9
        ),
    )
);