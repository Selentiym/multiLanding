<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 01.02.2017
 * Time: 11:51
 */
return [
    'components' => [
        'clientScript' => array(
            'defaultScriptPosition' => CClientScript::POS_READY,
            'defaultScriptFilePosition' => CClientScript::POS_BEGIN,
            'coreScriptPosition' => CClientScript::POS_HEAD,
            'packages' => [
            ]
        ),
        'db'=>array(
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=localhost;dbname=cq97848_clinicsl',
            'tablePrefix' => 'tbl_',
            'emulatePrepare' => true,
            'username' => 'cq97848_clinicsl',
            'password' => 'kicker1995',
            'charset' => 'utf8',
        ),
    ],
];