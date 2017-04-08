<?php
/**
 *
 * @var \clinics|\doctors $model
 */
if ($model -> partner) {
?>
<button class="btn">Записаться</button>
<div class="mb-1">Или по телефону</div>
<?php } else { ?>
    <div class="mb-1">Зписаться можно по телефону</div>
<?php } ?>
<div class="">Телефон</div>
