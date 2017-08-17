<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 24.04.2017
 * Time: 21:21
 */
return SiteDispatcher::mergeArray(
    require_once(dirname(__FILE__).'/baseSpecLib.php'),
    array(
        'name' => 'Самая крупная сеть МРТ и КТ диагностических центров',
        'theme' => 'oMrt/oMrtBootstrap/mainSpecLib/mrtKtMozg',
        'language' => 'mrtKtMozg',
        'modules'=>array(
            'clinics' => [
                'class' => 'application.modules.clinics.ClinicsModule',
                'dbConfig' => 'dbClinics',
                'dbArticles' => 'dbArticles',
                'filesPath' => 'files/mrtKtMozg',
                'clinicsComments' => function () {return Yii::app() -> getModule('clinicsComments'); }
            ],
            'taskgen' => [
                'class' => 'application.modules.taskgen.TaskGenModule',
                'dbConfig' => 'dbTaskGen'
            ],
        ),
        'components'=>array(
            'phone' => [
                'class' => 'application.components.constantPhoneComponent',
                'number' => 'телефон'
            ],
            'dbClinics'=>array(
                'class' => 'CDbConnection',
                'connectionString' => 'mysql:host=localhost;dbname=cq97848_clmod',
                'tablePrefix' => 'tbl_',
                'emulatePrepare' => true,
                'username' => 'cq97848_clmod',
                'password' => 'kicker1995',
                'charset' => 'utf8',
            ),
            'dbArticles'=>array(
                'class' => 'CDbConnection',
                'connectionString' => 'mysql:host=localhost;dbname=cq97848_clmod',
                'tablePrefix' => 'mozg_',
                'emulatePrepare' => true,
                'username' => 'cq97848_clmod',
                'password' => 'kicker1995',
                'charset' => 'utf8',
            ),
            'dbTaskGen'=>array(
                'class' => 'CDbConnection',
                'connectionString' => 'mysql:host=localhost;dbname=cq97848_newtgen',
                'tablePrefix' => 'tbl_',
                'emulatePrepare' => true,
                'username' => 'cq97848_newtgen',
                'password' => 'kicker1995',
                'charset' => 'utf8',
            ),
        ),
        'params'=>array(
            'siteId' => 'mrtKtMozg',
            'formLine' => -9
        ),
    )
);