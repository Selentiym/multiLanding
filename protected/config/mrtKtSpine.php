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
        'name' => 'МРТ и КТ позвоночника',
        'theme' => 'oMrt/oMrtBootstrap/mainSpecLib/mrtKtSpine',
        'language' => 'mrtKtSpine',
        'components'=>array(
            'dbClinicComments'=>mainTable('spine_clc_'),
            'dbArticles'=>mainTable('spine_'),
        ),
        'params'=>array(
            'siteId' => 'mrtKtSpine',
            'formLine' => -9,
            'priceBlocks' => [
                5,//mrtSpine
                6,//ktSpine
            ],
            'researchText' => 'МРТ и КТ позвоночника',
            'clinicPrefix' => 'Центр диагностики позвоночника'
        ),
    )
);
