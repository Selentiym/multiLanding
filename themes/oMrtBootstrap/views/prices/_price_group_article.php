<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 14.04.2017
 * Time: 11:01
 *
 * @type string $id
 * @type string $name
 * @type ObjectPrice $prices
 * @type clinics $model
 * @type bool $show
 */
if (empty($prices)) {
    return;
}
if ($show) {
    $show = ' showDefault';
}
if (!$model) {
    $ids = [];
    foreach ($prices as $price) {
        /**
         * @type ObjectPrice $price
         */
        $ids[] = $price -> id;
        if ($price -> id_replace_price) {
            $ids[] = $price -> id_replace_price;
        }

    }
    if (!empty($ids)) {
        if (!$criteria instanceof CDbCriteria) {
            $criteria = new CDbCriteria();
        }
        $criteria -> addInCondition('price.id',$ids);
        $criteria -> with = ['price' => ['together' => true]];
        $values = [];
        foreach (ObjectPriceValue::searchPriceValues($triggers,$criteria) as $pv) {
            /**
             * @type ObjectPriceValue $pv
             */
            $values[$pv -> id_price][] = $pv;
        }
        foreach ($prices as $pr) {
            /**
             * @type ObjectPrice $pr
             */
            $min = -1;
            $minRepl = -1;
            if (empty($values[$pr -> id])) {
                $values[$pr -> id] = [];
            }
            //Находим минимум по ценам
            foreach ($values[$pr -> id] as $pv) {
                if (($pv -> value < $min) || ($min < 0)) {
                    $min = $pv;
                }
            }
            //А потом по заменителям, если нужно
            if ($min < 0) {
                if (!empty($arr = $values[$pr -> id_replace_price])) {
                    foreach ($arr as $pv) {
                        if (($pv->value < $min) || ($min < 0)) {
                            $min = $pv;
                        }
                    }
                }
            }
            if ($min > 0) {
                $pr -> setCachedPrice($min);
            }
        }
    }
}
?>

<!--<div data-toggle="collapse" data-target="#collapse--><?php //echo $id; ?><!--"  role="tabpanel" id="heading--><?php //echo $id; ?><!--" class="w-100 price-block p-3 mb-1">-->
<div role="tabpanel" id="heading<?php echo $id; ?>" class="w-100 price-block p-3 mb-1 classToggler" data-target="#collapse<?php echo $id; ?>" data-class="opened">
    <div  class="d-flex justify-content-between">
        <?php echo $name; ?>
        <i class="fa arrow"></i>
    </div>
</div>
<div class="hidden-with-preview<?php echo $show; ?>" id="collapse<?php echo $id; ?>">
    <?php
    $out = '';
    foreach ($prices as $name => $price) {
        if ($mainPrice&&($price -> id == $mainPrice -> id_replace_price)) {
            continue;
        }
        $tmp = $this -> renderPartial('/prices/_single_price_article',['price' => $price,'model' => $model,'triggers' => $triggers, 'name' => $name,'mainPrice' => $mainPrice], true);
        if ($mainPrice&&($mainPrice -> id == $price -> id)) {
            $out = $tmp . $out;
        } else {
            $out .= $tmp;
        }
    }
    echo $out;
    ?>
</div>
