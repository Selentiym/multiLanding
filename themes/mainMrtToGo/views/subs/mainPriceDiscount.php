<?php
/**
 * @type Controller $this
 */
$this -> renderPartial('//subs/mainPriceDiscountAB',['model' => $model],true);
echo $model -> price -> text. ' <b>'. $model -> price -> price.'р!</b>';