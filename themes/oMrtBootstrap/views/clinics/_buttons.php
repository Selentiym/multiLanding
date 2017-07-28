<?php
/**
 *
 * @var \clinics|\doctors $model
 */
if ($model -> partner) {
    if ($model -> getFirstTriggerValue('area') -> verbiage == 'msc') {
        $phone = Yii::app() -> phoneMSC;
        $city = 'msc';
    } else {
        $city = 'spb';
        $phone = Yii::app() -> phone;
    }
?>
<button class="btn signUpButton" data-city="<?php echo $city; ?>">Записаться</button>
<div class="mb-1">Или по телефону</div>
<div class="phone">
    <a href="tel:<?php echo $phone -> getUnformatted(); ?>"><?php echo $phone -> getFormatted(); ?></a>
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

