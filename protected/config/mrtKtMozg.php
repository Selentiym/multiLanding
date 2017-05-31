<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 24.04.2017
 * Time: 21:21
 */
return SiteDispatcher::mergeArray(
    require_once(dirname(__FILE__).'/oMrt.php'),
    array(
        'name' => 'Самая крупная сеть МРТ и КТ диагностических центров',
        'theme' => 'oMrt/oMrtBootstrap/mrtKtMozg',
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
            'urlManager'=>array(
                //'urlFormat' => null,
                'rules' => array(
                    '' => 'home/articles',
                    'robots.txt' => 'seo/robots',
//                    'sitemap.xml' => 'seo/sitemap',
                    //'clinics' => 'home/clinics',
                    '<module:(clinics)>/admin' => '<module>/admin/login',
                    '<module:(taskgen)>/task/<action:(getText)>' => '<module>/task/<action>',
                    '<module:(taskgen)>/task/<action:(getText)>/<id:\d+>' => '<module>/task/<action>',
                    '<area:(spb|msc)>' => 'home/landing',
//                        '<modelName:(clinics|doctors)>-<area:(spb|msc)>/show/<verbiage:[\w-_]+>' => 'home/modelView',
//                        '<modelName:(clinics|doctors)>/show/<verbiage:[\w-_]+>' => 'home/modelView',
                    'article' => 'home/articles',
                    'article/<verbiage:[\w-]+>' => 'home/articleView',
//                        [
//                            'class' => 'application.components.urlRules.ModelAttributeUrlRule',
//                            'modelClass' => 'ObjectPrice',
//                            'attribute' => 'verbiage',
//                            'attributeInPattern' => 'research',
//                            'route' => 'home/<modelName>',
//                            'pattern' => '<modelName:(clinics|doctors)>-<area:(spb|msc)>/<research:\w+>'
//                        ],

//                        [
//                            'class' => 'application.components.urlRules.ModelAttributeUrlRule',
//                            'modelClass' => 'ObjectPrice',
//                            'attribute' => 'verbiage',
//                            'attributeInPattern' => 'research',
//                            'route' => 'home/<modelName>Link',
//                            'pattern' => '<modelName:(clinics|doctors)>/<research:\w+>'
//                        ],
//                        '<modelName:(clinics|doctors)>' => 'home/<modelName>Link',
//                        'clinics-<area:(spb|msc)>' => 'home/clinics',
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