<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 11.06.2017
 * Time: 17:52
 */
?>
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

<div class="card mx-1">
    <div class="card-heading">
        <h4 class="card-title text-center"><?php echo $doctor -> name; ?></h4>
    </div>
    <div class="card-block row ">
        <div class="col-12 col-md-4 ">
        <img class="rounded-circle" style="width:100%; height:auto;" src="<?php echo $url; ?>"/>
        </div>
        <div class="col-12 col-md-8 media-body">
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
</div>