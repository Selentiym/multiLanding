<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 03.04.2017
 * Time: 14:05
 *
 * @type ObjectPriceBlock $priceBlock
 * @type ObjectPrice $mainPrice
 */
if (empty($priceBlock -> prices)) {
    return;
}
if ($mainPrice -> id_block == $priceBlock -> id) {
    $expanded = 'aria-expanded="true"';
    $show = ' show';
} else {
    $expanded = '';
    $show = '';
}
$id = str2url($priceBlock -> name);
?>
<div class="card">
    <div class="card-header" role="tab" id="heading<?php echo $id; ?>">
        <h5 class="mb-0">
            <a data-toggle="collapse" data-parent="#accordion" <?php echo $expanded; ?> href="#collapse<?php echo $id; ?>" aria-controls="collapse<?php echo $id; ?>">
                <?php echo $priceBlock -> name; ?>
            </a>
        </h5>
    </div>

    <div id="collapse<?php echo $id; ?>" class="collapse<?php echo $show; ?>" role="tabpanel" aria-labelledby="heading<?php echo $id; ?>">
        <div class="card-block">
            <div class="list-group">
            <?php foreach ($priceBlock -> prices as $price) {
                $this -> renderPartial('/prices/_single_price', ['price' => $price, 'mainPrice' => $mainPrice]);
            } ?>
            </div>
        </div>
    </div>
</div>
