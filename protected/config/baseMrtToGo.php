<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 06.01.2017
 * Time: 15:59
 */
return CMap::mergeArray(
    require_once(dirname(__FILE__).'/main.php'),
    array(
        'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
        'name' => 'MrtToGo',
        'theme' => 'mainMrtToGo',
        'sourceLanguage' => 'en_US',

        'modules'=>array(
        ),

        'controllerMap'=>array(
            'site' => 'application.sites.common.controllers.SiteController'
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
                'number' => 'mrttogo!'
            ],
            'urlManager'=>array(
                'urlFormat'=>'path',
                'showScriptName' => false,
                'urlSuffix' => '/',
                'rules' => array(
                    ''			=> 'site/index',
                    'promo/'	=> 'promo/index',
                    'support/'	=> 'support/index',
                ),
            ),
        ),

        'params'=>array(
            'siteId' => 'mrtToGo'
        ),
    )
);