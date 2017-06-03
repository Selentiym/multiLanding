<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 01.04.2017
 * Time: 10:56
 */
$cs = Yii::app() -> getClientScript();
$cs -> registerCoreScript('bootstrap4css');
$cs -> registerCoreScript('bootstrap4js');
$cs -> registerCoreScript('font-awesome');
$cs -> registerCoreScript('scrollToTopActivate');
$cs -> registerCoreScript('maskedInput');

$cs -> registerScript('initiate_popup_forms','
    $(".signUpForm #phone").mask("+7(999)999-99-99");
    $(".signUpButton").attr("data-target","#signUpFormModal").attr("data-toggle","modal").attr("data-keyboard","true");
    $(".signUpButton").modal({
        keyboard:true,
        show:false,
        focus:true
    });
    $("form.signUpForm").submit(function(e){
    var toSubmit = $(this).find("[type=\'submit\']");
    toSubmit.attr("disabled",true);
    toSubmit.addClass("loading");
    var toAlert = true;
    setTimeout(function () {
        if (toAlert) {
            toSubmit.attr("disabled",false);
            toSubmit.removeClass("loading");
            alert("По какой-то причине ответ от сервера не пришел. Проверьте интернет-соединение и попробуйте еще раз, пожалуйста.");
        }
    }, 10000);
    $.get("'.$this -> createUrl('/form/submit').'",$(this).serialize()).done(function(date){
            alert("Ваша заявка успешно принята!");
        }).fail(function(){
            alert("Возникла ошибка при отправке. Пожалуйста, попробуйте еще раз или воспользуйтесь одним из указанных телефонных номеров.");
        }).always(function () {
            toAlert = false;
            toSubmit.attr("disabled",false);
            toSubmit.removeClass("loading");
        });

    return false;
});

',CClientScript::POS_READY);

$cs->registerCssFile(Yii::app() -> theme -> baseUrl.'/css/styles.css');

$triggers = $_GET;
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="<?php echo Yii::app() -> theme -> baseUrl."/images/favicon.ico"; ?>" rel="shortcut icon" type="image/x-icon" />
    <!--    <link rel="icon" href="../../favicon.ico">-->

    <?php
    $title = $this -> getPageTitle();
    $title = $title ? $title : Yii::app() -> name;
    ?>
    <title><?php echo $title; ?></title>

</head>

<body>
<?php echo Yii::t('scripts', 'yandexCounter'); ?>
<?php echo Yii::t('scripts', 'GA'); ?>
<header class="container-fluid">
    <div class="row align-items-start justify-content-between text-center">
        <div class="col-md-12 d-flex justify-content-around justify-content-md-end pt-3 p-md-3 align-items-center">
            <div class="mr-auto"><a href="/"><img class="img-fluid" style="max-height:70px" src="<?php echo Yii::app() -> theme -> baseUrl; ?>/images/logo.png" alt="Логотип" /></a></div>
            <div class="d-flex pr-4 align-items-center">
                <i class="fa fa-phone fa-2x" style="color:green" aria-hidden="true"></i><div class="d-inline-block ">Запись на<br/> МРТ/КТ</div>
            </div>
            <div class="row align-items-center pr-1 pr-md-3">
                <div class="pr-2 col-12 col-md-auto ">
                    Режим работы 8.00-21.00
                </div>
                <div class="pr-1 col-12 col-md-auto font-weight-bold ">
                    <i class="fa fa-phone" aria-hidden="true"></i> <noindex><a rel="nofollow" href="tel:<?php echo Yii::app() -> phone -> getUnformatted(); ?>"><?php echo Yii::app() -> phone -> getFormatted(); ?></a></noindex>
                </div>
            </div>
        </div>
        <nav class="navbar navbar-toggleable-md col-12  navbar-inverse p-3 flex-md-last">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
<!--                    <li class="nav-item --><?php //echo $triggers['area'] == 'spb' ? 'active' : ''; ?><!--">-->
<!--                        <a class="nav-link" href="--><?php //echo $this -> createUrl('home/clinics',['area' => 'spb']); ?><!--">МРТ в Санкт-Петербурге</a>-->
<!--                    </li>-->
<!--                    <li class="nav-item --><?php //echo $triggers['area'] == 'msc' ? 'active' : ''; ?><!--">-->
<!--                        <a class="nav-link" href="--><?php //echo Yii::app() -> controller -> createUrl('home/clinics',['area' => 'msc']); ?><!--">МРТ в Москве</a>-->
<!--                    </li>-->
                    <li class="nav-item <?php echo ( $triggers['area'] != 'spb' && $triggers['area'] != 'msc' ) ? 'active' : ''; ?>">
<!--                        <a class="nav-link" href="--><?php //echo Yii::app() -> controller -> createUrl('home/articles'); ?><!--">Все о МРТ и КТ</a>-->
                        <a class="nav-link" href="<?php echo "/"; ?>">Все о МРТ, КТ и ПЭТ</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>
<main class="mb-3" role="main">
    <?php
        echo $content;
    ?>
</main>
<footer class="p-3 text-center">
    <div class="container-fluid">
        <div class="row justify-content-around align-items-center">
            <div class="col-6 col-md-3 mb-3 mb-md-0"><?php echo date('Y'); ?>, все права защищены</div>
            <div class="col-12 col-md-3 flex-last flex-md-unordered">
                <button class="btn signUpButton">Записаться на МРТ/КТ</button>
            </div>
            <div class="col-6 col-md-3 mb-3 mb-md-0">
                <span>Звоните круглосуточно</span><br/>
                <span><noindex><a rel="nofollow" href="tel:<?php echo Yii::app() -> phone -> getUnformatted(); ?>"><?php echo Yii::app() -> phone -> getFormatted(); ?></a></noindex></span>
            </div>
        </div>
    </div>
</footer>


<div class="modal fade" id="signUpFormModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mainColor" id="exampleModalLabel">Записаться на МРТ или КТ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="signUpForm" id="signUpForm">
            <div class="modal-body">
                <div class="form-group">
                    <label for="recipient-name" class="form-control-label">Ваше имя:</label>
                    <input type="text" class="form-control" id="recipient-name" name="name" placeholder="Введите имя">
                </div>
                <div class="form-group">
                    <label for="phone" class="form-control-label">Ваш телефон:</label>
                    <input type="tel" name="phone" class="form-control" id="phone" placeholder="Введите номер телефона">
                </div>
            </div>
            <div class="modal-footer text-center">
                <button type="submit" class="btn">Записаться</button>
            </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>

