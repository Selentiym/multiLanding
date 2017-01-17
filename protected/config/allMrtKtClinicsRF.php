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
        ),
        'components'=>array(
            'phone' => [
                'number' => '8 (812) 241-10-58'
            ],
        ),
        'params'=>array(
            'siteId' => 'allMrtKtClinicsRF',
            'formLine' => -4
        ),
    )
);