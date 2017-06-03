<?php
/**
 *
 * @var \clinics|\doctors $model
 */
if ($model -> partner) {
    if ($model -> getFirstTriggerValue('area') -> verbiage == 'msc') {
        $phone = Yii::app() -> phoneMSC;
    } else {
        $phone = Yii::app() -> phone;
    }
?>
<button class="btn signUpButton">Записаться</button>
<div class="mb-1">Или по телефону</div>
<div class="phone">
    <!--noindex--><a rel="nofollow" href="tel:<?php echo $phone -> getUnformatted(); ?>"><?php echo $phone -> getFormatted(); ?></a><!--/noindex-->
</div>
<?php } else { ?>
    <div class="mb-1">Зписаться можно по телефону</div>
    <?php
        if ($model -> phone) {
            echo "<div class='phone'>{$model -> phone}</div>";
        } else {
            echo "<div>К сожалению, данных по телефону нет</div>";
        }
    ?>

<?php } ?>

