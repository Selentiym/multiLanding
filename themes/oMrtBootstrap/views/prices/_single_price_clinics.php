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
<div class="w-100 single-price d-flex justify-content-between p-3 mb-1<?php echo $highLight; ?>">
    <?php if($val) :
        if ((!$name)||filter_var($name, FILTER_VALIDATE_INT)) {
            $name = $price -> name;
        }
        ?>
        <div class="col text-left"><?php echo $name; ?></div>
        <div class="col-auto font-weight-bold mr-5"><?php echo $val; ?>руб</div>
    <?php else:
        $triggers['research'] = $price -> verbiage;
//        $triggers['modelName'] = 'clinics';
        ?>
        <div class="col text-left"><?php echo CHtml::link($price -> name,$this -> createUrl('home/clinics',$triggers,'&',false,true)); ?></div>
        <?php if ($price -> getCachedPrice()) :?>
        <div class="col-auto font-weight-bold mr-5">от <?php
            echo CHtml::link($price -> getCachedPrice(),$this -> createUrl('home/clinics',$triggers,'&',false,true));
            ?>руб</div>
        <?php endif; ?>
    <?php endif; ?>
</div>
