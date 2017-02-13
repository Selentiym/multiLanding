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
        'name'=>'Общество добросовестных докторов',
        'theme' => 'mainClinics/goodDoctors',
        'language' => 'goodDoctors',
        'modules'=>array(
            'clinics' => [
                'class' => 'application.modules.clinics.clinicsModule',
                'dbConfig' => 'dbClinics'
            ]
        ),
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
                ),
            ),
            'dbClinics'=>array(
                'class' => 'CDbConnection',
                'connectionString' => 'mysql:host=localhost;dbname=cq97848_gdoc',
                'tablePrefix' => 'cl_',
                'emulatePrepare' => true,
                'username' => 'cq97848_gdoc',
                'password' => 'kicker1995',
                'charset' => 'utf8',
            ),


            'dbTracker'=>array(
                'class' => 'CDbConnection',
                'connectionString' => 'mysql:host=localhost;dbname=cq97848_gdoc',
                'tablePrefix' => 'gdoc_',
                'emulatePrepare' => true,
                'username' => 'cq97848_gdoc',
                'password' => 'kicker1995',
                'charset' => 'utf8',
            ),
        ),
        'params'=>array(
            'siteId' => 'goodDoctors',
            'formLine' => '-9'
        ),
    )
);