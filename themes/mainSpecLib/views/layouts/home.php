<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08.06.2017
 * Time: 13:04
 */
/**
 * Есть проблема с адресацией layout'ов. Не использует layout предыдущей темы, поэтому создаю
 * вручную симлинки на layout
 */
$cs = Yii::app() -> getClientScript();
$baseTheme = Yii::app() -> getThemeManager() -> getBaseUrl("mainSpecLib");

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
    try {
		if (typeof yaCounter != "undefined") {
			yaCounter.reachGoal("formSent");
		}
	} catch (err) {
		console.log(err);
	}
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

?>
<!DOCTYPE html>
<!-- Template by Quackit.com -->
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <?php
    echo Yii::t('scripts','yandexWM');
    echo Yii::t('scripts','yandexCounter');
    $title = $this -> getPageTitle();
    $title = $title ? $title : Yii::app() -> name;
    ?>
    <title><?php echo $title; ?></title>

    <?php
    $cs -> registerCoreScript('bootstrap4css');
    $cs -> registerCoreScript('bootstrap4js');
    $cs -> registerCoreScript('maskedInput');
    $cs -> registerCoreScript('scrollToTopActivate');
    $cs -> registerCssFile($baseTheme.'/css/custom.css');
    $cs -> registerCoreScript('font-awesome');
    ?>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
<!-- Navigation -->
<nav id="topNav" class="navbar navbar-inverse bg-inverse navbar-toggleable-md">
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#"><img alt="logo" style="height:70px" class="p-2" src="<?php echo $baseTheme.'/images/logo.png'; ?>"/></a>
    <div class="collapse navbar-collapse" id="navbarText">
        <ul class="nav navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="<?php echo Yii::app() -> baseUrl.'/'; ?>">Библиотека</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo Yii::app() -> controller -> createUrl('home/clinics',['area' => 'msc'], '&', true); ?>">Каталог клиник Москвы</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo Yii::app() -> controller -> createUrl('home/clinics',['area' => 'spb'], '&', true); ?>">Каталог клиник Санкт-Петербурга</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo Yii::app() -> controller -> createUrl('home/service',[], '&', true); ?>">Общегородская служба записи на МРТ и КТ</a>
        </li>
    </ul>
    </div>
</nav>

<div class="container-fluid">
    <?php echo $content; ?>
</div><!--/container-fluid-->

<footer>
    <div class="footer-blurb">
        <div class="container">
            <div class="row">
                <div class="col-sm-3 footer-blurb-item">
                    <h3><i class="fa fa-text-height" aria-hidden="true"></i> Dynamic</h3>
                    <p>Collaboratively administrate empowered markets via plug-and-play networks. Dynamically procrastinate B2C users after installed base benefits. Dramatically visualize customer directed convergence without revolutionary ROI.</p>
                    <p><a class="btn btn-primary" href="#">Procrastinate</a></p>
                </div>
                <div class="col-sm-3 footer-blurb-item">
                    <h3><i class="fa fa-wrench" aria-hidden="true"></i> Efficient</h3>
                    <p>Dramatically maintain clicks-and-mortar solutions without functional solutions. Efficiently unleash cross-media information without cross-media value. Quickly maximize timely deliverables for real-time schemas. </p>
                    <p><a class="btn btn-success" href="#">Unleash</a></p>
                </div>
                <div class="col-sm-3 footer-blurb-item">
                    <h3><i class="fa fa-paperclip" aria-hidden="true"></i> Complete</h3>
                    <p>Professionally cultivate one-to-one customer service with robust ideas. Completely synergize resource taxing relationships via premier niche markets. Dynamically innovate resource-leveling customer service for state of the art customer service.</p>
                    <p><a class="btn btn-primary" href="#">Complete</a></p>
                </div>
                <div class="col-sm-3 footer-blurb-item">

                    <!-- Thumbnails -->
                    <h3><i class="fa fa-camera" aria-hidden="true"></i> Phosfluorescent</h3>
                    <div class="row">
                        <div class="col-xs-6">
                            <a href="#" class="img-fluid">
                                <img src="" alt="">
                            </a>
                        </div>
                        <div class="col-xs-6">
                            <a href="#" class="img-fluid">
                                <img src="" alt="">
                            </a>
                        </div>
                        <div class="col-xs-6">
                            <a href="#" class="img-fluid">
                                <img src="" alt="">
                            </a>
                        </div>
                        <div class="col-xs-6">
                            <a href="#" class="img-fluid">
                                <img src="" alt="">
                            </a>
                        </div>
                    </div>

                </div>

            </div>
            <!-- /.row -->
        </div>
    </div>

    <div class="small-print">
        <div class="container">
            <p><a href="#">Terms &amp; Conditions</a> | <a href="#">Privacy Policy</a> | <a href="#">Contact</a></p>
            <p>Copyright &copy; Example.com 2015 </p>
        </div>
    </div>
</footer>


<div class="modal fade" id="signUpFormModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mainColor" id="exampleModalLabel">Оставить заявку на исследование</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="signUpForm" id="signUpForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="form-control-label">Имя:</label>
                        <input type="text" class="form-control" id="recipient-name" name="name" placeholder="Введите имя">
                    </div>
                    <div class="form-group">
                        <label for="phone" class="form-control-label">Телефон:</label>
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


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->

<!-- jQuery library -->
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js" integrity="sha384-THPy051/pYDQGanwU6poAc/hOdQxjnOEXzbT+OuUAFqNqFjL+4IGLBgCJC3ZOShY" crossorigin="anonymous"></script>-->

<!-- Tether -->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js" integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>-->

<!-- Bootstrap 4 JavaScript. This is for the alpha 3 release of Bootstrap 4. This should be updated when Bootstrap 4 is officially released. -->
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.3/js/bootstrap.min.js" integrity="sha384-ux8v3A6CPtOTqOzMKiuo3d/DomGaaClxFYdCu2HPMBEkf6x2xiDyJ7gkXU0MWwaD" crossorigin="anonymous"></script>-->

<!-- Initialize Bootstrap functionality -->
<script>
    // Initialize tooltip component
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

    // Initialize popover component
    $(function () {
        $('[data-toggle="popover"]').popover()
    })
</script>

</body>

</html>

