<?php
/**
 *
 * @var \clinics|\doctors $model
 */

$showPretty = $model -> partner;
$phone = $model -> getPhoneObject();
if ($showPretty) {
    $city = $model->getFirstTriggerValue('area')->verbiage;
    if (!in_array($city,['spb','msc'])) {
        $city = 'spb';
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
        if ($phone -> getFormatted()) {
            echo "<div class='phone'>".$phone -> getFormatted()."</div>";
        } else {
            echo "<div>К сожалению, данных по телефону нет</div>";
        }
    ?>
<?php } ?>

