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
    $prices = ObjectPrice::calculateMinValues($prices,$triggers,$criteria);
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
