<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08.06.2017
 * Time: 13:04
 */
$cs = Yii::app() -> getClientScript();
$baseTheme = Yii::app() -> getTheme() -> getBaseUrl();
$baseSpecTheme = Yii::app() -> getThemeManager() -> getBaseUrl("mainSpecLib");
$crit = new CDbCriteria();
$crit -> addInCondition('id_block',Yii::app() -> params['priceBlocks']);
$prices = ObjectPrice::model() -> findAll($crit);
$priceIds = array_values(CHtml::listData($prices,'id','id'));
$cityCode = Geo::getCityCode();
$triggers = in_array($cityCode, ['spb','msc']) ? ['area' => $cityCode] : ['area' => 'spb'] ;
$prices = ObjectPrice::model() -> findAllByPk($priceIds);
$mapped = [];
foreach ($prices as $price) {
    $mapped[$price -> id] = $price;
}
$service = clinics::model() -> findByAttributes(['verbiage' => 'service'.$triggers['area']]);
if ($service instanceof Service) {
    $service -> setTriggers($triggers);
    $toShowPrices = [];
    foreach ($priceIds as $name => $id) {
        if (($name > 1)||($name === 0)||($name === 1)) {
            $name = $mapped[$id] -> name;
        }
        $toShowPrices[] = ['name' => $name, 'price' => $service -> getPriceValue($id) -> value];
    }
}
$cs -> registerScript('topCarousel','
function topSlider(rss) {
    var me = {
        delay:5000,
        animationLength: 1000,
        fadeLength:500,
        index: 0,
        element:$("#topSlider"),
        nameElement:$("#researchName"),
        priceElement:$("#researchPrice"),
        animateSlider: function(){
            me.index = (me.index+1) % rss.length;
            var nextItem = rss[me.index];
            me.nameElement.children().fadeOut(me.fadeLength, function(){
                me.nameElement.children().remove();
                me.nameElement.append($("<strong>",{style:"display:none;"}).append(nextItem.name).fadeIn(me.animationLength));
            });
            me.priceElement.children().fadeOut(me.fadeLength, function(){
                me.priceElement.children().remove();
                me.priceElement.append($("<span>",{style:"display:none;"}).append("от&nbsp;"+nextItem.price+"&nbsp;руб").fadeIn(me.animationLength));
            });
        },
        interval: false,
        stop:function(){
            if (me.interval) {
                clearInterval(me.interval);
            }
            me.interval = false;
        },
        start: function(){
            if (me.interval) {
                me.stop();
            }
            me.interval = setInterval(me.animateSlider, me.delay);
        }
    };
    me.rss = rss;
    me.element.mouseover(me.stop);
    me.element.mouseout(me.start);
    me.start();
    return me;
}
var slider = topSlider('.json_encode($toShowPrices).');
',CClientScript::POS_READY);

?>
<!DOCTYPE html>
<html lang="en">
<!-- Template by Quackit.com -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <link href="<?php echo $baseTheme; ?>/images/logo.ico" rel="shortcut icon" type="image/x-icon">
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
    $cs -> registerCssFile($baseSpecTheme.'/css/custom.css');
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
<div class="container-fluid">
<div class="row align-items-start justify-content-between text-center">
    <div class="col-md-12 d-flex justify-content-sm-around justify-content-md-end pt-3 p-md-3 align-items-center">
        <div class="hidden-xs-down mr-auto mr-xl-0"><a href="/"><img class="img-fluid" style="max-height:70px" src="<?php echo $baseTheme; ?>/images/logo.png" alt="Логотип" /></a></div>
        <div style="font-size:1.15rem;color:#0275d8;" class="font-weight-bold headerText ml-3 mr-auto hidden-lg-down">
            Единый<br/> консультативный<br/> центр&nbsp;по<br class="hidden-xl-up"/> МРТ&nbsp;и&nbsp;КТ
        </div>
        <div class="ml-3 align-items-center row">
            <div class="col-auto">
                <img style="width:50px;" src="<?php echo $baseSpecTheme; ?>/images/lamp.png" alt="list"/>
            </div>
            <div class="col">
                <div id="topSlider">
                    <div>
                        <div id="researchName"><strong><?php echo current($toShowPrices)['name']; ?></strong></div>
                        <div><a href="#" class="signUpButton" style="font-size:1.5rem" id="researchPrice"><span>от&nbsp;<?php echo current($toShowPrices)['price']; ?>&nbsp;руб</span></a></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row align-items-center pr-1 ml-md-3 pr-md-3">
            <div class="pr-2 col-12 col-md-auto hidden-md-down">
                <div class="row align-items-center ">
                    <div class="col-auto p-2"><img style="width:50px;" src="<?php echo $baseSpecTheme; ?>/images/time.png" alt="clock"/></div>
                    <div  class="col-auto p-2"><strong>Звоните</strong><div class="headerText">с&nbsp;7:00&nbsp;до&nbsp;00:00</div></div>
                </div>
            </div>
            <div class="pr-1 col-12 col-md-auto font-weight-bold align-items-center">
                <img style="width: 50px;" src="<?php echo $baseSpecTheme; ?>/images/assign.png" alt="phone"/>&nbsp
                <div class="ml-1 align-middle d-inline-block">
                    <strong>Консультация&nbsp;по МРТ&nbsp;и&nbsp;КТ</strong><br/>
                    <a href="tel:<?php echo Yii::app() -> phone -> getUnformatted(); ?>"><?php echo Yii::app() -> phone -> getFormatted(); ?></a><br/>
                    <a href="tel:<?php echo Yii::app() -> phoneMSC -> getUnformatted(); ?>"><?php echo Yii::app() -> phoneMSC -> getFormatted(); ?></a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- Navigation -->
<nav id="topNav" class="navbar navbar-inverse bg-inverse navbar-toggleable-md">
    <button style="" class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
        <ul class="nav navbar-nav align-items-center">
        <li class="nav-item">
            <a class="nav-link" href="<?php echo Yii::app() -> baseUrl.'/'; ?>">Библиотека</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo Yii::app() -> controller -> createUrl('home/clinics',['area' => 'msc'], '&', true); ?>">Каталог клиник Москвы</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo Yii::app() -> controller -> createUrl('home/clinics',['area' => 'spb'], '&', true); ?>">Каталог клиник Санкт-Петербурга</a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Единый консультативный центр по МРТ и КТ</a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="<?php echo Yii::app() -> controller -> createUrl('home/service',['area' => 'spb'], '&', true); ?>">В Санкт-Петербурге</a>
                <a class="dropdown-item" href="<?php echo Yii::app() -> controller -> createUrl('home/service',['area' => 'msc'], '&', true); ?>">В Москве</a>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo $this -> createUrl('home/news',[], '&',true); ?>">
                <button class="btn btn-primary" href="<?php echo $this -> createUrl('home/news',[], '&',true); ?>">Скидки</button>
            </a>
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

