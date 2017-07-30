<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 01.04.2017
 * Time: 10:56
 * @type HomeControllerCatalogCommon $this
 */
$cs = Yii::app() -> getClientScript();
$cs -> registerCoreScript('bootstrap4css');
$cs -> registerCoreScript('bootstrap4js');
$cs -> registerCoreScript('font-awesome');
//$cs -> registerCoreScript('owl');
$cs -> registerCoreScript('scrollToTopActivate');
$cs -> registerCoreScript('maskedInput');
$cs -> registerCoreScript('toggler');

$cs -> registerCoreScript('bootstrapBreakpointJS');
$cs -> registerScript('showOnMedium','
	if (isBreakpoint("md")) {
		var toShow = $(".hidden-with-preview.showDefault");
		toShow.addClass("opened");
		toShow.removeClass("showDefault");
	}
',CClientScript::POS_READY);

$cs -> registerScript('initiate_popup_forms','
    $(".signUpForm #phone").mask("+7(999)999-99-99");
    $(".signUpButton").attr("data-target","#signUpFormModal").attr("data-toggle","modal").attr("data-keyboard","true");
    $(".signUpButton").modal({
        keyboard:true,
        show:false,
        focus:true
    });
    $(".signUpButton").click(function(){
        var city = $(this).attr("data-city");
        $("#signUpFormModal").find("#cityInput").val(city);
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
    $.get("'.$this -> createUrl('/form/submit').'",$(this).serialize(),function(){},"JSON").done(function(data){
        if (data.success) {
            alert("Ваша заявка успешно принята!");
        } else {
            alert("Заявка не отправлена, пожалуйста, попробуйте воспользоваться телефоном на странице.");
        }
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
$priceIds = [
    1,6,//GM
    "МРТ сустава" => 83,//joint
    22,26,//abdomen
    29, 30,//pelvis
    "МРТ отдела позвоночника" => 14,//spine
    68,//kt lungs
    "МРТ сосудов" => 60,
    "КТ сосудов" => 78
];
$cityCode = Geo::getCityCode();
$triggers = in_array($cityCode, ['spb','msc']) ? ['area' => $cityCode] : [] ;
$prices = ObjectPrice::model() -> findAllByPk($priceIds);
$mapped = [];
foreach ($prices as $price) {
    $mapped[$price -> id] = $price;
}
$criteria = new CDbCriteria();
$criteria -> addCondition('clinic.partner = 1');
$prices = ObjectPrice::calculateMinValues($mapped, $triggers);
$toShowPrices = [];
foreach ($priceIds as $name => $id) {
    if (($name >= 1)||($name == 0)) {
        $name = $mapped[$id] -> name;
    }
    $toShowPrices[] = ['name' => $name, 'price' => $mapped[$id] -> getCachedPrice() -> value];
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
                me.priceElement.append($("<span>",{style:"display:none;"}).append(nextItem.price+" руб").fadeIn(me.animationLength));
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

$baseTheme = Yii::app() -> theme -> baseUrl;

$isTom = strpos($_SERVER['REQUEST_URI'], 'tomography') !== false;
$triggers = $_GET;
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="<?php echo $baseTheme."/images/logo.ico"; ?>" rel="shortcut icon" type="image/x-icon" />
    <!--    <link rel="icon" href="../../favicon.ico">-->

    <?php
    $title = $this -> getPageTitle();
    $title = $title ? $title : Yii::app() -> name;
    ?>
    <title><?php echo $title; ?></title>
    <script type="text/javascript">(window.Image ? (new Image()) : document.createElement('img')).src = 'https://vk.com/rtrg?p=VK-RTRG-145004-9vUy2';</script>
</head>

<body>
<?php echo Yii::t('scripts', 'yandexCounter'); ?>
<?php echo Yii::t('scripts', 'GA'); ?>
<header class="container-fluid">
    <div class="row align-items-start justify-content-between text-center">
        <div class="col-md-12 d-flex justify-content-sm-around justify-content-md-end pt-3 p-md-3 align-items-center">
            <div class="hidden-xs-down mr-auto mr-xl-0"><a href="/"><img class="img-fluid" style="max-height:70px" src="<?php echo $baseTheme; ?>/images/logo.png" alt="Логотип" /></a></div>
            <div style="font-size:1.15rem;" class="headerText ml-3 mr-auto hidden-lg-down">
                Общегородская<br class="hidden-xl-up"/> служба<br/> записи на<br class="hidden-xl-up"/> МРТ&nbsp;и&nbsp;КТ
            </div>
            <div class="ml-3 align-items-center row">
                <div class="col-auto">
                    <img style="width:50px;" src="<?php echo $baseTheme; ?>/images/price.png" alt="list"/>
                </div>
                <div class="col">
                    <div id="topSlider">
                        <div>
                            <div>Минимальная цена на</div>
                            <div id="researchName"><strong><?php echo current($toShowPrices)['name']; ?></strong></div>
                            <div><a href="#" class="signUpButton" style="font-size:1.5rem" id="researchPrice"><span><?php echo current($toShowPrices)['price']; ?> руб</span></a></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row align-items-center pr-1 ml-md-3 pr-md-3">
                <div class="pr-2 col-12 col-md-auto hidden-md-down">
                    <div class="row align-items-center ">
                        <div class="col-auto p-2"><img style="width:50px;" src="<?php echo $baseTheme; ?>/images/clock.png" alt="clock"/></div>
                        <div  class="col-auto p-2">Мы работаем <br/><strong>без выходных</strong><div class="headerText">с&nbsp;7:00&nbsp;до&nbsp;00:00</div></div>
                    </div>
                </div>
                <div class="pr-1 col-12 col-md-auto font-weight-bold align-items-center">
                    <img style="width: 50px;" src="<?php echo $baseTheme; ?>/images/phone.png" alt="phone"/>&nbsp
                    <div class="ml-1 align-middle d-inline-block">
                        <strong>Запись на МРТ&nbsp;и&nbsp;КТ</strong><br/>
                        <a href="tel:<?php echo Yii::app() -> phone -> getUnformatted(); ?>"><?php echo Yii::app() -> phone -> getFormatted(); ?></a><br/>
                        <a href="tel:<?php echo Yii::app() -> phoneMSC -> getUnformatted(); ?>"><?php echo Yii::app() -> phoneMSC -> getFormatted(); ?></a>
                    </div>
                </div>
            </div>
        </div>
        <nav class="navbar navbar-toggleable-md col-12  navbar-inverse p-3 flex-md-last">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0 d-flex">
                    <li class="nav-item <?php echo $triggers['area'] == 'spb' && (!$isTom) ? 'active' : ''; ?>">
                        <a class="nav-link" href="<?php echo $this -> createUrl('home/clinics',['area' => 'spb'], '&',true); ?>">Адреса и цены на МРТ в Санкт-Петербурге</a>
                    </li>
                    <li class="nav-item <?php echo $triggers['area'] == 'msc' && (!$isTom)? 'active' : ''; ?>">
                        <a class="nav-link" href="<?php echo Yii::app() -> controller -> createUrl('home/clinics',['area' => 'msc'], '&',true); ?>">Адреса и цены на МРТ в Москве</a>
                    </li>
                    <li class="nav-item <?php echo ( $triggers['area'] != 'spb' && (!$isTom) && $triggers['area'] != 'msc' ) ? 'active' : ''; ?>">
<!--                        <a class="nav-link" href="--><?php //echo Yii::app() -> controller -> createUrl('home/articles'); ?><!--">Все о МРТ и КТ</a>-->
                        <a class="nav-link" href="<?php echo Yii::app() -> baseUrl."/"; ?>">Все о МРТ, КТ и ПЭТ</a>
                    </li>
                    <li class="nav-item <?php echo ( $isTom ) ? 'active' : ''; ?>">
<!--                        <a class="nav-link" href="--><?php //echo Yii::app() -> controller -> createUrl('home/articles'); ?><!--">Все о МРТ и КТ</a>-->
                        <a class="nav-link" href="<?php echo $this -> createUrl('home/tomography'); ?>">Томография</a>
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
                <button class="btn signUpButton" <?php if (Geo::isCity('msc')) echo "data-city='msc'"; ?>>Записаться на МРТ/КТ</button>
            </div>
            <div class="col-6 col-md-3 mb-3 mb-md-0">
                <span>Звоните круглосуточно</span><br/>
                <span><a href="tel:<?php echo Yii::app() -> phone -> getUnformatted(); ?>"><?php echo Yii::app() -> phone -> getFormatted(); ?></a></span>,
                <span><a href="tel:<?php echo Yii::app() -> phoneMSC -> getUnformatted(); ?>"><?php echo Yii::app() -> phoneMSC -> getFormatted(); ?></a></span>
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
                <input type="hidden" name="city" id="cityInput" />
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

