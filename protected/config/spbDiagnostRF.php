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
        'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
        'name' => 'МРТ и КТ диагностика в СПб',
        'theme' => 'mainClinics/spbDiagnostRF',
        'language' => 'spbDiagnostRF',

        'modules'=>array(
        ),
        'components'=>array(
            'phone' => [
                'number' => '8 (812) 241-10-56'
            ],
        ),
        'params'=>array(
            'siteId' => 'spbDiagnostRF'
        ),
    )
);