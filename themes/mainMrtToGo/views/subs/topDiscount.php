<?php
/**
 * @var CommonRule $model
 * @var string $base
 */
?>
<div class="row">
    <div class="col-md-6 col-sm-8">
        <div class="discount-header">
            <div class="discount-top"><img src="<?php echo $base; ?>/img/discount-top.png"></div>
            <div class="discount-content">
                <span class="discount-name"><?php echo $model -> price -> text; ?></span>
                <span class="discount-old-price"><?php echo $model -> price -> price_old;?>р.</span>
                <span class="discount-price"><?php echo $model -> price -> price;?>р.</span>
            </div>
            <div class="discount-bottom"><img src="<?php echo $base; ?>/img/discount-bottom.png"></div>
        </div>
    </div>
    <div class="col-md-6 col-sm-4">

        <a href="#callback-registration" class="fancybox" id="order-button"> <span class="btn-title">Записаться <br> на МРТ и КТ</span> <span class="day-and-night">Круглосуточно!</span></a>
    </div>
</div>
