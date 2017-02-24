<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 23.02.2017
 * Time: 13:24
 */
$mod = Yii::app() -> getModule('clinics');
$clinics = $mod -> getClinics($_GET);
Yii::app()->getClientScript()->registerCssFile(Yii::app() -> theme -> baseUrl.'/css/objects_list.css');
foreach ($clinics as $clinic) {
    $this -> renderPartial('/clinics/_single_clinics',['data' => $clinic]);
}