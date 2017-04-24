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
?>

<div data-toggle="collapse" data-target="#collapse<?php echo $id; ?>"  role="tabpanel" id="heading<?php echo $id; ?>" class="w-100 price-block p-3 mb-1">
    <div  class="d-flex justify-content-between">
        <?php echo $name; ?>
        <i class="fa arrow"></i>
    </div>
</div>
<div class="collapse <?php echo $show; ?>" id="collapse<?php echo $id; ?>">
    <?php foreach ($prices as $name => $price) {
        $this -> renderPartial('//prices/_single_price_clinics',['price' => $price,'model' => $model,'triggers' => $triggers, 'name' => $name,'mainPrice' => $mainPrice]);
    } ?>
</div>
