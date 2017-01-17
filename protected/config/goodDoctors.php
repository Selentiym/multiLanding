<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 20.12.2016
 * Time: 20:28
 */
return SiteDispatcher::mergeArray(
    require_once(dirname(__FILE__).'/baseMrtToGo.php'),
    array(
        'name'=>'Общество добросовестных докторов',
        'theme' => 'mainMrtToGo/goodDoctors',
        'language' => 'goodDoctors',
        'modules'=>array(
        ),
        'components'=>array(
            'phone' => [
                'number' => '8 (812) 241-10-63'
            ],
        ),
        'params'=>array(
            'siteId' => 'goodDoctors',
        ),
    )
);