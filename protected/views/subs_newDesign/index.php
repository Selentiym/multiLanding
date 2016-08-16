<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.08.2016
 * Time: 14:54
 */
/**
 * @type Rule $model
 * @type Rule $rule
 */

?>
<!DOCTYPE html>
<!--[if lt IE 7]><html lang="ru" class="lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if IE 7]><html lang="ru" class="lt-ie9 lt-ie8"><![endif]-->
<!--[if IE 8]><html lang="ru" class="lt-ie9"><![endif]-->
<!--[if gt IE 8]><!-->
<html lang="ru">
<!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <title>МРТ и КТ ЦЕНТРЫ ВО ВСЕХ РАЙОНАХ САНКТ-ПЕТЕРБУРГА</title>
    <meta name="description" content="МРТ и КТ ЦЕНТРЫ ВО ВСЕХ РАЙОНАХ САНКТ-ПЕТЕРБУРГА" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="<?php echo Yii::app() -> baseUrl; ?>/img_newDesign/favicon.ico" rel="shortcut icon" type="image/x-icon" />
    <link rel="shortcut icon" href="<?php echo Yii::app() -> baseUrl; ?>/img_newDesign/favicon.png" />
    <link rel="stylesheet" href="<?php echo Yii::app() -> baseUrl; ?>/libs_newDesign/bootstrap/bootstrap-grid-3.3.1.min.css" />
    <link rel="stylesheet" href="<?php echo Yii::app() -> baseUrl; ?>/libs_newDesign/bootstrap/bootstrap_col_5.css" />
    <link rel="stylesheet" href="<?php echo Yii::app() -> baseUrl; ?>/libs_newDesign/font-awesome-4.2.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="<?php echo Yii::app() -> baseUrl; ?>/libs_newDesign/fancybox/jquery.fancybox.css" />
    <link rel="stylesheet" href="<?php echo Yii::app() -> baseUrl; ?>/libs_newDesign/owl-carousel/owl.carousel.css" />
    <link rel="stylesheet" href="<?php echo Yii::app() -> baseUrl; ?>/libs_newDesign/countdown/jquery.countdown.css" />
    <link rel="stylesheet" href="<?php echo Yii::app() -> baseUrl; ?>/css_newDesign/fonts.css" />
    <link rel="stylesheet" href="<?php echo Yii::app() -> baseUrl; ?>/css_newDesign/main.css" />
    <link rel="stylesheet" href="<?php echo Yii::app() -> baseUrl; ?>/css_newDesign/flipclock.css" />
    <link rel="stylesheet" href="<?php echo Yii::app() -> baseUrl; ?>/css_newDesign/tabulous.css" />
    <link rel="stylesheet" href="<?php echo Yii::app() -> baseUrl; ?>/css_newDesign/media.css" />

    <script>
        baseUrl = '<?php echo Yii::app() -> baseUrl; ?>';
    </script>
</head>
<body>
<header class="top_header">
    <div class="header_topline default" id="topline">
        <div class="container">
            <div class="col-md-12">
                <div class="row">

                    <div class="col-lg-3 col-md-1 col-sm-1 col-xs-1 logo-outer" id="logo-outer">
                        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12 logo"><a href="#"><img src="<?php echo Yii::app() -> baseUrl; ?>/img_newDesign/logo.png"></a></div>
                        <div class="col-lg-9 logo-text" id="logo-text">Записаться на МРТ и КТ по телефону</div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-10 col-xs-10 top_contacts">
                        <div>8 (812) 241-10-52</div>
                        <a href="#callback" class="order fancybox"><img src="<?php echo Yii::app() -> baseUrl; ?>/img_newDesign/phone-sm.png"><span>Заказать обратный звонок</span></a>
                        <span class="perezvonim">Перезвоним в течение 10 минут!</span>
                    </div>
                    <nav class="col-lg-6 col-md-8 col-sm-1 col-xs-1 main_menu clearfix">
                        <button class="main_mnu_button hidden-md hidden-lg"><i class="fa fa-bars"></i></button>
                        <ul>
                            <li><a href="#price">ЦЕНЫ</a></li>
                            <li><a href="#share">АКЦИИ</a></li>
                            <li><a href="#oborud">ОБОРУДОВАНИЕ</a></li>
                            <li><a href="#doctora">ВРАЧИ</a></li>
                            <li><a href="#centru">ЦЕНТРЫ</a></li>
                            <li><a href="#vopros">ОТВЕТЫ И ВОПРОСЫ</a></li>
                        </ul>
                    </nav>
                    <div class="col-md-2" id="callback-on-fix-menu">
                        <a href="#callback-registration" class="fancybox" id="order-button"> <span class="btn-title">Записаться <br> на МРТ и КТ</span><span class="day-and-night">Круглосуточно!</span> </a>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="slider_container container">

        <div class="next_button"><i class="fa fa-angle-right"></i></div>
        <div class="prev_button"><i class="fa fa-angle-left"></i></div>
        <div class="carousel">
            <div class="slide_item"><img src="<?php echo Yii::app() -> baseUrl; ?>/img_newDesign/background1.jpg" alt="alt" /></div>
            <div class="slide_item"><img src="<?php echo Yii::app() -> baseUrl; ?>/img_newDesign/background2.jpg" alt="alt" /></div>
            <div class="slide_item"><img src="<?php echo Yii::app() -> baseUrl; ?>/img_newDesign/background3.jpg" alt="alt" /></div>
            <div class="slide_item"><img src="<?php echo Yii::app() -> baseUrl; ?>/img_newDesign/background5.jpg" alt="alt" /></div>
        </div>

    </div>


    <div class="over-slider-container">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-8">
                    <div class="discount-header">
                        <div class="discount-top"><img src="<?php echo Yii::app() -> baseUrl; ?>/img_newDesign/discount-top.png"></div>
                        <div class="discount-content">
                            <span class="discount-name"><?php echo $model -> price -> text; ?></span>
                            <span class="discount-old-price"><?php echo $model -> price -> price_old;?>р.</span>
                            <span class="discount-price"><?php echo $model -> price -> price;?>р.</span>
                        </div>
                        <div class="discount-bottom"><img src="<?php echo Yii::app() -> baseUrl; ?>/img_newDesign/discount-bottom.png"></div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-4">
                    <a href="#callback-registration" class="fancybox" id="order-button"> <span class="btn-title">Записаться <br> на МРТ и КТ</span> <span class="day-and-night">Круглосуточно!</span></a>
                </div>
            </div>
            <div class="advantages row">
                <div class="col-lg-2 col-md-4 col-sm-4 col-xs-6" style="margin-top:10px;">
                    <img src="<?php echo Yii::app() -> baseUrl; ?>/img_newDesign/advantage1.png">
                    <span>МРТ и КТ<br> срочно</span>
                    <p class="adv-comment">Обследование <br>в день обращения</p>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-4 col-xs-6">
                    <img src="<?php echo Yii::app() -> baseUrl; ?>/img_newDesign/advantage4.png">
                    <span>Скидки<br> Акции</span>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-4 col-xs-6">
                    <img src="<?php echo Yii::app() -> baseUrl; ?>/img_newDesign/advantage6.png">
                    <span>Результат<br> за час</span>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-4 col-xs-6">
                    <img src="<?php echo Yii::app() -> baseUrl; ?>/img_newDesign/advantage3.png">
                    <span>Опыт работы<br> 24 года</span>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-4 col-xs-6">
                    <img src="<?php echo Yii::app() -> baseUrl; ?>/img_newDesign/advantage5.png">
                    <span>Бесплатная<br> консультация врача </span>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-4 col-xs-6" style="margin-top:10px;">
                    <img src="<?php echo Yii::app() -> baseUrl; ?>/img_newDesign/advantage2.png">
                    <span>МРТ и КТ<br> ночью</span>
                    <p class="adv-comment">Скидка 50%</p>
                </div>
            </div>


        </div>
    </div>
</header>


<?php
if (is_a($rule -> section,'Section')) {
    $this->renderPartial('//subs/_section', array('section'=> $rule -> section, 'rule' => $rule));
}


foreach(Section::model() -> findAll(array('order' => 'num ASC')) as $section){
    if ($section -> id == $rule -> section -> id) {
        continue;
    }
    $this->renderPartial('//subs_newDesign/_section', array('section' => $section, 'rule' => $model));
}
?>


<?php /* $this -> renderPartial('//subs_newDesign/prices', [
    'model'=>$model
]);  $this -> renderPartial('//subs_newDesign/skidki', [
    'model'=>$model
]);  $this -> renderPartial('//subs_newDesign/doctors', [
    'model'=>$model
]);  $this -> renderPartial('//subs_newDesign/jelezo', [
    'model'=>$model
]);  $this -> renderPartial('//subs_newDesign/geo', [
    'model'=>$model
]); $this -> renderPartial('//subs_newDesign/raznica', [
    'model'=>$model
]); $this -> renderPartial('//subs_newDesign/faq', [
    'model'=>$model
]); $this -> renderPartial('//subs_newDesign/form', [
    'model'=>$model
]); //*/ ?>






<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <span>© 2016</span>
            </div>
            <div class="col-md-6">
                <a class="phone-footer" href="tel:88122411052">8 (812) 241-10-52</a>
            </div>
        </div>
    </div>
</footer>


<div id="info1" style="display:none"><p>Информация про доктора</p></div>


<div class="hidden">
    <form id="callback-registration" class="pop_form">
        <h3>Записаться на МРТ и КТ</h3>
        <p>Врач-консультант перезвонит вам в течение 10 минут!</p>
        <p>Вы сможете получить подробную консультацию по всем вопросам, связанным с МРТ и КТ исследованием и при желании записаться на обследование в удобное для вас время по лучшей цене!</p>
        <input type="text" class="your-name form_field" name="name" placeholder="Ваше имя..." required />
        <input type="text" class="your-phone form_field" name="phone" placeholder="Ваш телефон..." required />
        <button class="order-button" name="your-name" value="" size="40" type="submit"><span class="btn-title">Отправить <br> запрос</span></button>
    </form>
</div>
<div class="hidden">
    <form id="callback" class="pop_form">
        <h3>Врач-консультант перезвонит вам в течение 10 минут!</h3>
        <p>Вы сможете получить подробную консультацию по всем вопросам, связанным с МРТ и КТ исследованием и при желании записаться на обследование в удобное для вас время по лучшей цене!</p>
        <input type="text" class="your-name form_field" name="name" placeholder="Ваше имя..." required />
        <input type="text" class="your-phone form_field" name="phone" placeholder="Ваше телефон..." required />
        <button class="order-button" name="your-name" value="" size="40" type="submit"><span class="btn-title">Перезвоните <br>мне</span></button>
    </form>
</div>
<!--[if lt IE 9]>
<script src="<?php echo Yii::app() -> baseUrl; ?>/libs_newDesign/html5shiv/es5-shim.min.js"></script>
<script src="<?php echo Yii::app() -> baseUrl; ?>/libs_newDesign/html5shiv/html5shiv.min.js"></script>
<script src="<?php echo Yii::app() -> baseUrl; ?>/libs_newDesign/html5shiv/html5shiv-printshiv.min.js"></script>
<script src="<?php echo Yii::app() -> baseUrl; ?>/libs_newDesign/respond/respond.min.js"></script>
<![endif]-->
<script src="<?php echo Yii::app() -> baseUrl; ?>/libs_newDesign/jquery/jquery-1.11.1.min.js"></script>
<script src="<?php echo Yii::app() -> baseUrl; ?>/libs_newDesign/jquery-mousewheel/jquery.mousewheel.min.js"></script>
<script src="<?php echo Yii::app() -> baseUrl; ?>/libs_newDesign/fancybox/jquery.fancybox.pack.js"></script>
<script src="<?php echo Yii::app() -> baseUrl; ?>/libs_newDesign/waypoints/waypoints-1.6.2.min.js"></script>
<script src="<?php echo Yii::app() -> baseUrl; ?>/libs_newDesign/scrollto/jquery.scrollTo.min.js"></script>
<script src="<?php echo Yii::app() -> baseUrl; ?>/libs_newDesign/owl-carousel/owl.carousel.min.js"></script>
<script src="<?php echo Yii::app() -> baseUrl; ?>/libs_newDesign/countdown/jquery.plugin.js"></script>
<script src="<?php echo Yii::app() -> baseUrl; ?>/libs_newDesign/countdown/jquery.countdown.min.js"></script>
<script src="<?php echo Yii::app() -> baseUrl; ?>/libs_newDesign/countdown/jquery.countdown-ru.js"></script>
<script src="<?php echo Yii::app() -> baseUrl; ?>/libs_newDesign/landing-nav/navigation.js"></script>
<script src="<?php echo Yii::app() -> baseUrl; ?>/js_newDesign/common.js"></script>
<script src="<?php echo Yii::app() -> baseUrl; ?>/js_newDesign/flipclock.js"></script>
<script src="<?php echo Yii::app() -> baseUrl; ?>/js_newDesign/tabulous.js"></script>
<script src="<?php echo Yii::app() -> baseUrl; ?>/js_newDesign/jquery.maskedinput.min.js"></script>



<script type="text/javascript">
    /*<![CDATA[*/
    jQuery(function($) {

        var clock;
        clock = $('#clock').FlipClock({
            clockFace: 'DailyCounter',
            autoStart: false,
            defaultLanguage: 'rus',
            callbacks: {
                stop: function() {
                    $('.message').html('Время вышло!')
                }
            }
        });
        var toTime = new Date();
        var toAdd = toTime.getDate() % 3 + 2;
        toTime.setMinutes(0);
        toTime.setSeconds(0);
        toTime.setHours(toAdd*24);
        var nowTime = new Date();
        clock.setTime(Math.floor((toTime - nowTime)/1000));
        clock.setCountdown(true);
        clock.start();

    });
    /*]]>*/
</script>
<script>
    jQuery(function($){
        $(".your-phone").mask("+7(999)999-99-99");
    });
</script>
</body>
</html>
