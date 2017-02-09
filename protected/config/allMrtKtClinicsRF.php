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
                'class' => 'application.modules.clinics.clinicsModule'
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
                'urlFormat'=>'path',
                'showScriptName' => false,
                'urlSuffix' => '/',
                'rules' => array(
                    '<module:(clinics)>/admin' => '<module>/admin/index',
                ),
            ),
        ),
        'params'=>array(
            'siteId' => 'allMrtKtClinicsRF',
            'formLine' => -4
        ),
    )
);