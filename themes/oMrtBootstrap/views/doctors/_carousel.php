<?php
/**
 *
 * @var doctors $doctor
 */
if ((file_exists($doctor -> giveImageFolderAbsoluteUrl() . $doctor -> logo)&&($doctor -> logo))) {
    $url = $doctor -> giveImageFolderRelativeUrl() . $doctor -> logo;
} else {
    $url = Yii::app() -> getTheme() -> baseUrl.'/images/doctor-no-logo.png';
}
?>
<div class="p-3 doctor-carousel text-center item">
    <div>
        <img class="rounded-circle mx-auto" style="width:auto; max-height:200px;" src="<?php echo $url; ?>" alt="<?php echo htmlspecialchars($doctor -> name); ?>"/>
    </div>
    <div class="text-el">
        <div class="name-el"><?php echo $doctor -> name; ?></div>
        <?php if ($doctor -> education): ?>
        <div class="font-weight-bold">Образование: <?php echo $doctor -> education; ?></div>
        <?php endif; ?>
        <?php if ($doctor -> curses): ?>
        <div class="font-weight-bold">Курсы повышения квалификации: <?php echo $doctor -> curses; ?></div>
        <?php endif; ?>
        <?php if ($doctor -> experience): ?>
        <div class="font-weight-bold">Стаж работы: <?php echo $doctor -> experience; ?></div>
        <?php endif; ?>
        <?php if ($doctor -> rewards): ?>
        <div class="font-weight-bold"><?php echo $doctor -> rewards; ?></div>
        <?php endif; ?>
        <?php if ($doctor -> text): ?>
        <div class="text-left font-italic"><?php echo $doctor -> text; ?></div>
        <?php endif; ?>
    </div>
</div>
<!--<div class="slide_item">-->
<!--    <div class="doctor">-->
<!--        --><?php
//
//        //echo $url;
//        if ((file_exists($doctor -> giveImageFolderAbsoluteUrl() . $doctor -> logo)&&($doctor -> logo))) :
//            //if (true) :
//            ?>
<!--            <div class="doctor-img"><img alt="--><?php //echo $doctor -> verbiage; ?><!--" src="--><?php //echo $url;?><!--"></div>-->
<!--        --><?php //endif; ?>
<!--        <h4>--><?php //echo $doctor -> name; ?><!--</h4>-->
<!--        <p>--><?php //echo $doctor -> description; ?><!--</p>-->
<!--    </div>-->
<!--</div>-->
