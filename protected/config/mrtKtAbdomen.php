<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10.06.2017
 * Time: 15:21
 */
return SiteDispatcher::mergeArray(
    require_once(dirname(__FILE__).'/baseSpecLib.php'),
    array(
        'name' => 'МРТ и КТ брюшной полости',
        'theme' => 'oMrt/oMrtBootstrap/mainSpecLib/mrtKtAbdomen',
        'language' => 'mrtKtAbdomen',
        'import' => [
            'application.sites.catalogCommon.HomeControllerCatalogCommon'
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
                'number' => '8 (812) 241-10-46'
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
                //'rules' => array(),
            ),
            'dbClinics'=>require(__DIR__.DIRECTORY_SEPARATOR.'dbs'.DIRECTORY_SEPARATOR.'dbClinics.pss.php'),
            'dbClinicComments'=>array(
                'class' => 'CDbConnection',
                'connectionString' => 'mysql:host=localhost;dbname=cq97848_clmod',
                'tablePrefix' => 'abd_clc_',
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
            'dbArticles'=>array(
                'class' => 'CDbConnection',
                'connectionString' => 'mysql:host=localhost;dbname=cq97848_clmod',
                'tablePrefix' => 'abd_',
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
            'errorHandler' => [
                'errorAction' => 'home/error'
            ]
        ),
        'params'=>array(
            'siteId' => 'mrtKtAbdomen',
            'formLine' => -9,
            'dd.credentials' => 'partner.2751:JhZdjiuk',
            'priceBlocks' => [
                7,//mrtAbdomen
                8,//ktAbdomen
            ],
            'researchText' => 'МРТ и КТ брюшной полости',
            'clinicPrefix' => 'Центр диагностики брюшной полости'
        ),
    )
);