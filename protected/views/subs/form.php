<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12.04.2016
 * Time: 19:38
 */
?>
<div class="main_form">

    <p class="dashed "> <img class="doctor" src="<?php echo Yii::app() -> baseUrl; ?>/img/doctor.png" alt="Доктор">
        Что бы записаться на КТ и/или МРТ исследования заполни форму:
    </p>
    <p><a name="form"></a></p>
    <div class="form">
        <form action="<?php echo Yii::app() -> baseUrl;?>/post" method="POST">
            <img src="<?php echo Yii::app() -> baseUrl; ?>/img/fio.png" class="form_fio" alt="fio">
            <input type="text" name="name" required placeholder="Ваше ФИО" ><br>
            <img class="form_mobile" src="<?php echo Yii::app() -> baseUrl; ?>/img/mobile.png" alt="mobile">
            <input type="text" name="name2" required placeholder="Ваш телефон"><br>
            <button type="submit" class="pointer"><img src="<?php echo Yii::app() -> baseUrl; ?>/img/submit.png" alt="submit"></button>
        </form>
    </div>
</div>
