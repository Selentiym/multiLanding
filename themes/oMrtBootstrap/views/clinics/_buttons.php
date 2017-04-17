<?php
/**
 *
 * @var \clinics|\doctors $model
 */
if ($model -> partner) {
?>
<button class="btn signUpButton">Записаться</button>
<div class="mb-1">Или по телефону</div>
<div class="phone">
    <a href="tel:7812<?php echo Yii::app() -> phone -> getShort(); ?>"><?php echo Yii::app() -> phone -> getFormatted(); ?></a>
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

