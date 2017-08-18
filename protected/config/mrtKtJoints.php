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
        'name' => 'МРТ и КТ суставов',
        'theme' => 'oMrt/oMrtBootstrap/mainSpecLib/mrtKtJoints',
        'language' => 'mrtKtJoints',
        'components'=>array(
            'dbClinicComments'=>mainTable('jnt_clc_'),
            'dbArticles'=>mainTable('jnt_'),
        ),
        'params'=>array(
            'siteId' => 'mrtKtJoints',
            'formLine' => -9,
            'priceBlocks' => [
                11,//mrtJoints
                12,//ktJoints
            ],
            'researchText' => 'МРТ и КТ суставов',
            'clinicPrefix' => 'Центр диагностики суставов'
        ),
    )
);
