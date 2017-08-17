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
        'name' => 'МРТ и КТ головы и шеи',
        'theme' => 'oMrt/oMrtBootstrap/mainSpecLib/mrtKtMozg',
        'language' => 'mrtKtMozg',
        'components'=>array(
            'dbClinicComments'=>mainTable('mozg_clc_'),
            'dbArticles'=>mainTable('mozg_'),
        ),
        'params'=>array(
            'siteId' => 'mrtKtMozg',
            'formLine' => -9,
            'priceBlocks' => [
                1,//mrtMozg
                2,//ktMozg
                3,//mrtNeck
                4,//ktNeck
            ],
            'researchText' => 'МРТ и КТ головы и шеи',
            'clinicPrefix' => 'Центр диагностики головы и шеи'
        ),
    )
);
