<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 03.04.2017
 * Time: 14:05
 *
 * @type ObjectPriceBlock $block
 * @type ObjectPrice $mainPrice
 */
if (empty($block -> prices)) {return;}
if ($mainPrice -> id_block == $block -> id) {
    $expanded = 'aria-expanded="true"';
    $show = ' show';
} else {
    $expanded = '';
    $show = '';
}
$id = str2url($block -> name).$model -> verbiage;
?>
<!--<div class="card">-->
<!--    <div class="card-header" role="tab" id="heading--><?php //echo $id; ?><!--">-->
<!--        <h5 class="mb-0">-->
<!--            <a data-toggle="collapse" data-parent="#accordion" --><?php //echo $expanded; ?><!-- href="#collapse--><?php //echo $id; ?><!--" aria-controls="collapse--><?php //echo $id; ?><!--">-->
<!--                --><?php //echo $priceBlock -> name; ?>
<!--            </a>-->
<!--        </h5>-->
<!--    </div>-->
<!---->
<!--    <div id="collapse--><?php //echo $id; ?><!--" class="collapse--><?php //echo $show; ?><!--" role="tabpanel" aria-labelledby="heading--><?php //echo $id; ?><!--">-->
<!--        <div class="card-block">-->
<!--            <ul class="list-group">-->
<!--            --><?php //foreach ($priceBlock -> prices as $price) {
//                $this -> renderPartial('/prices/_single_price', ['price' => $price, 'mainPrice' => $mainPrice]);
//            } ?>
<!--            </ul>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

<!-- data-parent="#prices-accordion" -->

<?php $this -> renderPartial('/prices/_price_group', [
    'id' => $id,
    'name' => $block -> name,
    'prices' => $block -> prices,
    'model' => $model,
    'show' => $show
]); ?>

<!--<div data-toggle="collapse" data-target="#collapse--><?php //echo $id; ?><!--"  role="tabpanel" id="heading--><?php //echo $id; ?><!--" class="w-100 price-block p-3 mb-1">-->
<!--    <div  class="d-flex justify-content-between">-->
<!--        --><?php //echo $block -> name; ?>
<!--        <i class="fa arrow"></i>-->
<!--    </div>-->
<!--</div>-->
<!--<div class="collapse --><?php //echo $show; ?><!--" id="collapse--><?php //echo $id; ?><!--">-->
<!--    --><?php //foreach ($block -> prices as $price) {
//        $this -> renderPartial('//prices/_single_price_clinics',['price' => $price,'model' => $model]);
//    } ?>
<!--</div>-->