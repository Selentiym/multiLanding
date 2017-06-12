<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 11.06.2017
 * Time: 15:31
 * @var clinics $model
 */
if ($model -> partner) {
    if ($model->getFirstTriggerValue('area')->verbiage == 'msc') {
        $phone = Yii::app()->phoneMSC;
    } else {
        $phone = Yii::app()->phone;
    }
    $this -> renderPartial('/clinics/_icon',['iClass' => 'fa-phone', 'text' => CHtml::link($phone -> getFormatted(),'tel:'.$phone -> getUnformatted())]);
}
$this -> renderPartial('/clinics/_icon', ['iClass' => 'fa-map', 'text' => $model -> address]);
$this -> renderPartial('/clinics/_icon', ['iClass' => 'fa-train', 'text' => $model -> getSortedMetroString()]);
$this -> renderPartial('/clinics/_icon', ['iClass' => 'fa-calendar-check-o', 'text' => $model -> working_hours]);
$this -> renderPartial('/clinics/_icon', ['iClass' => 'fa-hand-stop-o', 'text' => $model -> restrictions]);
?>
