<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 20.12.2016
 * Time: 20:28
 */
return SiteDispatcher::mergeArray(
    require_once(dirname(__FILE__).'/baseClinics.php'),
    array(
        'name' => 'Самая крупная сеть МРТ и КТ диагностических центров в СПб',
        'theme' => 'mainClinics/allMrtKtClinicsRF',
        'language' => 'allMrtKtClinicsRF',
        'modules'=>array(
            'clinics' => [
                'class' => 'application.modules.clinics.ClinicsModule',
                'dbConfig' => 'dbClinics'
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
            'home' => 'application.sites.newDesign.controllers.MainController',
            'main' => 'application.sites.newDesign.controllers.MainController',
        ],
        'components'=>array(
            'phone' => [
                'class' => 'application.components.CallTrackerPhoneComponent',
                'moduleId' => 'tracker',
                'number' => null
            ],
            'bootstrap'=>array(
                'class'=>'application.extensions.bootstrap.components.Bootstrap'
            ),
            'urlManager'=>array(
                'rules' => array(
                    '<module:(clinics)>/admin' => '<module>/admin/index',
                    '<module:(taskgen)>/task/<action:(getText)>' => '<module>/task/<action>',
                    '<module:(taskgen)>/task/<action:(getText)>/<id:\d+>' => '<module>/task/<action>',
                ),
            ),
            'dbClinics'=>array(
                'class' => 'CDbConnection',
                'connectionString' => 'mysql:host=localhost;dbname=cq97848_cl_mod',
                'tablePrefix' => 'tbl_',
                'emulatePrepare' => true,
                'username' => 'cq97848_cl_mod',
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
        ),
        'params'=>array(
            'siteId' => 'allMrtKtClinicsRF',
            'formLine' => -4
        ),
    )
);