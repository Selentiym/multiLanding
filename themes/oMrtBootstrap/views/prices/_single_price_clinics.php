<?php
/**
 *
 * @var ObjectPrice $price
 * @var clinics $model
 * @var mixed[] $triggers
 */
$val = false;
if ($model instanceof clinics) {
    $val = $model->getPriceValue($price->id)->value;
}
?>
<div class="w-100 single-price d-flex justify-content-between p-3 mb-1">
    <?php if($val) : ?>
        <div class="col text-left"><?php echo $price -> name; ?></div>
        <div class="col-auto font-weight-bold mr-5"><?php echo $val; ?>руб</div>
    <?php else:
        $triggers['research'] = $price -> verbiage;
//        $triggers['modelName'] = 'clinics';
        ?>
        <div class="col text-left"><?php echo CHtml::link($price -> name,$this -> createUrl('home/clinics',$triggers,'&',false,true)); ?></div>
    <?php endif; ?>
</div>
