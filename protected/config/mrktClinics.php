<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 20.12.2016
 * Time: 20:28
 */
return CMap::mergeArray(
    require_once(dirname(__FILE__).'/baseMrtToGo.php'),
    array(
        'name' => 'Лучшие МРТ и КТ клиники в СПб',
        'theme' => 'mainMrtToGo/mrktClinics',
        'language' => 'mrktClinics',
        'modules'=>array(
        ),
        'components'=>array(
            'phone' => [
                'number' => '8 (812) 313-27-04'
            ],
        ),
        'params'=>array(
            'siteId' => 'mrktClinics',
            'formLine' => -7
        ),
    )
);