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
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!--    <link rel="icon" href="../../favicon.ico">-->

    <?php
    $title = $this -> getPageTitle();
    $title = $title ? $title : Yii::app() -> name;
    ?>
    <title><?php echo $title; ?></title>

</head>

<body>

<header class="container-fluid">
    <div class="row align-items-start justify-content-between text-center">
        <div class="col-md-12 col-9 d-flex justify-content-between justify-content-sm-end pt-3 p-md-3 align-items-center">
            <div class="d-flex pr-4 align-items-center">
                <i class="fa fa-phone fa-2x" style="color:green" aria-hidden="true"></i><div class="d-inline-block ">Запись на<br/> МРТ/КТ</div>
            </div>
            <div class="row align-items-center pr-1 pr-md-3">
                <div class="pr-2 col-12 col-md-auto ">
                    Режим работы 8.00-21.00
                </div>
                <div class="pr-1 col-12 col-md-auto font-weight-bold ">
                    <i class="fa fa-phone" aria-hidden="true"></i> Телефон
                </div>
            </div>
        </div>
        <nav class="navbar navbar-toggleable-md col-md-12 col-3  navbar-inverse p-3 flex-first flex-md-last" style="background-color: #09ce7d;">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <li class="nav-item active">
                        <a class="nav-link" href="<?php echo Yii::app() -> controller -> createUrl('home/clinics',['area' => 'spb']); ?>">МРТ в Санкт-Петербурге</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo Yii::app() -> controller -> createUrl('home/clinics',['area' => 'msc']); ?>">МРТ в Москве</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo Yii::app() -> controller -> createUrl('home/articles'); ?>">Все о МРТ и КТ</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>
<main role="main">
    <?php
        echo $content;
    ?>
</main>
</body>
</html>

