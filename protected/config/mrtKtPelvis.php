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
        'name' => 'МРТ и КТ малого таза',
        'theme' => 'oMrt/oMrtBootstrap/mainSpecLib/mrtKtPelvis',
        'language' => 'mrtKtPelvis',
        'components'=>array(
            'dbClinicComments'=>mainTable('pel_clc_'),
            'dbArticles'=>mainTable('pel_'),
        ),
        'params'=>array(
            'siteId' => 'mrtKtPelvis',
            'formLine' => -9,
            'priceBlocks' => [
                9,//mrtPelvis
                10,//ktPelvis
            ],
            'researchText' => 'МРТ и КТ малого таза',
            'clinicPrefix' => 'Центр диагностики малого таза'
        ),
    )
);
