<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10.02.2017
 * Time: 13:48
 */
return SiteDispatcher::mergeArray(
    require(dirname(__FILE__).'/mrktClinics.php'),
    [
        'language' => 'spbTomograf',
        'components' => [

            'dbCustom'=>array(
                'class' => 'CDbConnection',
                'connectionString' => 'mysql:host=localhost;dbname=cq97848_landing',
                'tablePrefix' => 'tomogr_',
                'emulatePrepare' => true,
                'username' => 'cq97848_landing',
                'password' => 'kicker',
                'charset' => 'utf8',
            ),
        ],


        'params'=>array(
            'siteId' => 'spbTomograf',
            'formLine' => -7
        ),

    ]
);