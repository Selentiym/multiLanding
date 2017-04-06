<?php
/**
 *
 * @var ObjectPrice $price
 * @var clinics $model
 */
$val = $model -> getPriceValue($price -> id) -> value;
?>
<div class="w-100 single-price d-flex justify-content-between p-3 mb-1">
    <div class="col text-left"><?php echo $price -> name; ?></div>
    <div class="col-auto font-weight-bold mr-5"><?php echo $val; ?>руб</div>
</div>
