<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10.06.2017
 * Time: 15:21
 */
return SiteDispatcher::mergeArray(
    require_once(dirname(__FILE__).'/baseSpecLib.php'),
    array(
        'name' => 'МРТ и КТ брюшной полости',
        'theme' => 'oMrt/oMrtBootstrap/mainSpecLib/mrtKtAbdomen',
        'language' => 'mrtKtAbdomen',
        'components'=>array(
            'dbClinicComments'=>mainTable('abd_clc_'),
            'dbArticles'=>mainTable('abd_'),
        ),
        'params'=>array(
            'siteId' => 'mrtKtAbdomen',
            'formLine' => -9,
            'priceBlocks' => [
                7,//mrtAbdomen
                8,//ktAbdomen
            ],
            'researchText' => 'МРТ и КТ брюшной полости',
            'clinicPrefix' => 'Центр диагностики брюшной полости'
        ),
    )
);