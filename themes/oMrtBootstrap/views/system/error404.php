<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 18.04.2017
 * Time: 17:18
 */
$cs = Yii::app() -> getClientScript();
$cs -> registerCoreScript('bootstrap4css');
$cs -> registerCssFile(Yii::app() -> theme -> baseUrl.'/css/styles.css');
?>
<div class="container-fluid">
    <img class="w-100" src="<?php echo Yii::app() -> theme -> baseUrl . '/images/lost.jpg'; ?>" alt="beautiful image"/>
    <div style="position: absolute;top:35%;left:15%;width:40%;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 text-center font-weight-bold mainColor" style="font-size: 1.5em; font-size:2.0vw;">Похоже Вы промахнулись.</div>
                <div class="col-12 text-center"><img style="width: 50%" src="<?php echo Yii::app() -> theme -> baseUrl . '/images/404-image.png'; ?>" alt="404 numbers" /></div>
                <div class="col-12 text-center"><a href="/" style="font-size: 1.5em; font-size:2.0vw;">На главную</a></div>
            </div>
        </div>
    </div>
</div>
