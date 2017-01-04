<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 20.12.2016
 * Time: 20:28
 */
return CMap::mergeArray(
    require_once(dirname(__FILE__).'/main.php'),
    array(
        'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
        'name' => 'Самая крупная сеть МРТ и КТ диагностических центров в СПб',
        'theme' => 'allMrtKtClinicsRF',
        'sourceLanguage' => 'en_US',
        'language' => 'allMrtKtClinicsRF',

        'modules'=>array(
        ),

        'controllerMap'=>array(
            'home' => 'application.sites.allMrtKtClinicsRF.controllers.MainController'
            /*'site'=>'application.sites.common.controllers.SiteController',
            'promo'=>array(
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
                'number' => '8 (812) 241-10-58'
            ],
            'urlManager'=>array(
                'urlFormat'=>'path',
                'showScriptName' => false,
                'urlSuffix' => '/',
                'rules' => array(
                    '' => 'main/index',
                    'clinics' => 'clinics/default/index',
                    'clinics/default/index' => 'clinics/default/index',
                ),
            ),
            /*'errorHandler'=>array(
                'errorAction'=>'site/error',
            ),*/

        ),

        'params'=>array(
            'siteId' => 'allMrtKtClinicsRF',
            'formLine' => -4
        ),
    )
);