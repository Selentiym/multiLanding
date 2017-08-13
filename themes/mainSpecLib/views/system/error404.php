<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 18.04.2017
 * Time: 17:18
 */
$cs = Yii::app() -> getClientScript();
$cs -> registerCoreScript('bootstrap4css');
$cs -> registerCoreScript('bootstrap4js');
$cs -> registerCoreScript('maskedInput');

//$cs -> registerCssFile(Yii::app() -> theme -> baseUrl.'/css/styles.css');
?>
<div class="container-fluid">
    <img class="w-100" src="<?php echo Yii::app() -> themeManager -> getTheme('mainSpecLib') -> baseUrl . '/images/404_animal.jpg'; ?>" alt="beautiful image"/>
    <div style="position:absolute;top:10%;left:0;width:100%;text-align:center;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 text-center font-weight-bold mainColor" style="font-size: 1.5em; font-size:2.0vw; color:white;">Упс! Искомая страница не найдена.</div>
                <div class="col-12 text-center" style="font-size: 1.5em; font-size:2.0vw;color:white;">Вы можете начать поиск <a href="<?php echo Yii::app() -> baseUrl; ?>/" style="color:white; border-bottom:1px dotted white;">с начала</a></div>
                <div class="col-12 text-center" style="font-size: 1.5em; font-size:2.0vw;color:white;">Или <button class="btn btn-primary signUpButton">получить консультацию</button></div>
            </div>
        </div>
    </div>
</div>
<?php
$this -> renderPartial('/layouts/_popupForms');
?>