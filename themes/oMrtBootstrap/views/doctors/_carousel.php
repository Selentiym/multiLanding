<?php
/**
 *
 * @var doctors $doctor
 */
if ((file_exists($doctor -> giveImageFolderAbsoluteUrl() . $doctor -> logo)&&($doctor -> logo))) {
    $url = $doctor -> giveImageFolderRelativeUrl() . $doctor -> logo;
} else {
    $url = 'error';
}
?>
<div class="doctor-carousel text-center item">
    <div>
        <img style="max-height: 200px;" class="rounded-circle" src="<?php echo $url; ?>"/>
    </div>
    <div class="text-el">
        <div class="name-el"><?php echo $doctor -> name; ?></div>
        <?php if ($doctor -> experience): ?>
        <div>Стаж работы: <?php echo $doctor -> experience; ?></div>
        <?php endif; ?>
        <?php if ($doctor -> rewards): ?>
        <div>Титулы и достижения: <?php echo $doctor -> rewards; ?></div>
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
