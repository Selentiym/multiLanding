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
$highLight = (($mainPrice -> id)&&(($price->id==$mainPrice->id)||($price->id==$mainPrice->id_replace_price))) ? ' highlighted' : '';
?>
<div class="w-100 single-price justify-content-between p-3 mb-1 align-items-center to-hide-item<?php echo $highLight; ?>">
    <?php if($val) :
        if ((!$name)||filter_var($name, FILTER_VALIDATE_INT)) {
            $name = $price -> name;
        }
        ?>
        <div class="col text-left"><?php echo $name; ?></div>
        <div class="col-auto font-weight-bold mr-2"><?php echo $val; ?>руб</div>
    <?php else:
        $triggers['research'] = $price -> verbiage;
//        $triggers['modelName'] = 'clinics';
        $cached = $price -> getCachedPrice();
        if (($cached -> id_price == $price -> id)||(!$cached)) {
            $showName = $price -> name;
        } else {
            $showName = $price -> replacement -> name. ' (включает '.$price -> name.')';
        }
        ?>
        <div class="col text-left"><?php echo CHtml::link($showName,$this -> createUrl('home/clinics',$triggers,'&',false,true)); ?></div>
        <?php if ($price -> getCachedPrice()) :?>
        <div class="col-auto font-weight-bold mr-2">от <?php
            echo CHtml::link($price -> getCachedPrice(),$this -> createUrl('home/clinics',$triggers,'&',false,true));
            ?> руб</div>
        <?php endif; ?>
    <?php endif; ?>
</div>
