<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08.06.2017
 * Time: 13:04
 */
$cs = Yii::app() -> getClientScript();
$baseTheme = Yii::app() -> getThemeManager() -> getBaseUrl("mainSpecLib");
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
<?php echo Yii::t('scripts','yandexCounter'); ?>
<!-- Navigation -->
<nav id="topNav" class="navbar navbar-inverse bg-inverse navbar-toggleable-md">
    <button style="margin-top:15px;" class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
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
                <div class="col text-center">
                    <button class="btn btn-success signUpButton">Записаться на МРТ или КТ обследование</button>
                </div>
            </div>
            <!-- /.row -->
        </div>
    </div>

    <div class="small-print">
        <div class="container">
            <p>Все права защищены &copy; <?php echo Yii::app() -> name.', '.date('o'); ?> </p>
        </div>
    </div>
</footer>


<?php
    $this -> renderPartial('/layouts/_popupForms');
?>

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
        $('[data-toggle="tooltip"]').tooltip();
    });

    // Initialize popover component
    $(function () {
        $('[data-toggle="popover"]').popover();
    });
</script>

</body>

</html>

