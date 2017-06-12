<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 11.06.2017
 * Time: 17:23
 * @var clinics $model
 */
$vals = [];
$ignore = ['area', 'isCity', 'city'];
foreach($model -> giveTriggerValuesObjects() as $key => $val) {
    if (!in_array($key, $ignore)) {
        $vals = array_merge($vals, $val);
    }
}
foreach ($vals as $val) {
    echo " <span class='badge badge-info'>".$val->value."</span> ";
}