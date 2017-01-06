<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 05.01.2017
 * Time: 12:16
 */
$cs = Yii::app() -> getClientScript();
$cs -> registerPackage('jquery');
$cs -> registerScript('baseUrl','
    baseUrl = "'.Yii::app() -> baseUrl.'";
    baseThemeUrl = "'.Yii::app() -> theme -> baseUrl.'";
',CClientScript::POS_BEGIN);
echo $content;
