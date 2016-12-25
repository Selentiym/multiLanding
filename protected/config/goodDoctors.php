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
        'name'=>'Общество добросовестных докторов',
        //Тема стандартная
        'theme' => null,
        'sourceLanguage' => 'en_US',
        'language' => 'goodDoctors',

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
                'number' => '8 (812) 241-10-63'
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
            /*'errorHandler'=>array(
                'errorAction'=>'site/error',
            ),*/

        ),
        'params'=>array(
            'siteId' => 'goodDoctors',
        ),
    )
);