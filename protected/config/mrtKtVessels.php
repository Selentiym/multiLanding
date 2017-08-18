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
        'name' => 'МРТ и КТ сосудов',
        'theme' => 'oMrt/oMrtBootstrap/mainSpecLib/mrtKtVessels',
        'language' => 'mrtKtVessels',
        'components'=>array(
            'dbClinicComments'=>mainTable('vss_clc_'),
            'dbArticles'=>mainTable('vss_'),
        ),
        'params'=>array(
            'siteId' => 'mrtKtVessels',
            'formLine' => -9,
            'priceBlocks' => [
                15,//mrtVessels
                16,//ktVessels
            ],
            'researchText' => 'МРТ и КТ сосудов',
            'clinicPrefix' => 'Центр диагностики сосудов'
        ),
    )
);
