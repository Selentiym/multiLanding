<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 06.01.2017
 * Time: 13:18
 */
echo "this is test theme";
$this -> renderPartial('//subs/test',['from' => Yii::app() -> theme]);