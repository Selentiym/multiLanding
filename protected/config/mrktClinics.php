<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 20.12.2016
 * Time: 20:28
 */
return SiteDispatcher::mergeArray(
    require_once(dirname(__FILE__).'/baseMrtToGo.php'),
    array(
        'import' => [
            'application.components.callTrackerCustom.*',
            'application.modules.callTracker.CallTrackerModule',
            'application.models.experiments.*',
        ],
        'name' => 'Лучшие МРТ и КТ клиники в СПб',
        'theme' => 'mainMrtToGo/mrktClinics',
        'language' => 'mrktClinics',
        'modules'=>array(
            'tracker' =>[
                'class' => 'application.modules.callTracker.CallTrackerModule',
                'blocked' => false,
                'numberWhenBlocked' => '8 (812) 313-27-04',
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
                'dbConfig' => 'dbCustom',
            ],
        ),
        'components'=>array(
            'phone' => [
                'class' => 'application.components.CallTrackerPhoneComponent',
                'moduleId' => 'tracker',
                'number' => null
            ],
            'dbCustom'=>array(
                'class' => 'CDbConnection',
                'connectionString' => 'mysql:host=localhost;dbname=cq97848_landing',
                'tablePrefix' => 'mrkt_',
                'emulatePrepare' => true,
                'username' => 'cq97848_landing',
                'password' => 'kicker',
                'charset' => 'utf8',
            ),
            'urlManager' => [
                'rules' => [
                    'tracker' => 'tracker',
                    '<action:\w+>' => null,
                    //'<action:\w+>' => 'site/<action>',
                ]
            ]
        ),


        'params'=>array(
            'siteId' => 'mrktClinics',
            'formLine' => -7
        ),
    )
);