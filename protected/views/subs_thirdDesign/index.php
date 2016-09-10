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

$tel = [];
//Костыль
if (strpos($_SERVER['SERVER_NAME'],'rt-to-go')) {
    $tel['formatted'] = '8 (812) 241-10-52';
    $tel['raw'] = '88122411052';
} else {
    $tel['formatted'] = '8 (812) 313-27-04';
    $tel['raw'] = '88123132704';
}

?>

<!DOCTYPE html>
<!--[if lt IE 7]><html lang="ru" class="lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if IE 7]><html lang="ru" class="lt-ie9 lt-ie8"><![endif]-->
<!--[if IE 8]><html lang="ru" class="lt-ie9"><![endif]-->
<!--[if gt IE 8]><!-->
<?php $base = Yii::app() -> baseUrl; ?>
<html lang="ru">
<!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <title>МРТ и КТ ЦЕНТРЫ ВО ВСЕХ РАЙОНАХ САНКТ-ПЕТЕРБУРГА</title>
    <meta name="description" content="МРТ и КТ ЦЕНТРЫ ВО ВСЕХ РАЙОНАХ САНКТ-ПЕТЕРБУРГА" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="<?php echo $base; ?>/favicon.ico" rel="shortcut icon" type="image/x-icon" />
    <link rel="shortcut icon" href="<?php echo $base; ?>/favicon.png" />
    <link rel="stylesheet" href="<?php echo $base; ?>/libs_thirdDesign/bootstrap/bootstrap-grid-3.3.1.min.css" />
    <link rel="stylesheet" href="<?php echo $base; ?>/libs_thirdDesign/bootstrap/bootstrap_col_5.css" />
    <link rel="stylesheet" href="<?php echo $base; ?>/libs_thirdDesign/font-awesome-4.2.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="<?php echo $base; ?>/libs_thirdDesign/fancybox/jquery.fancybox.css" />
    <link rel="stylesheet" href="<?php echo $base; ?>/libs_thirdDesign/owl-carousel/owl.carousel.css" />
<!--    <link rel="stylesheet" href="<?php echo Yii::app() -> baseUrl; ?>/css_newDesign/fonts.css" />-->
	<link href="https://fonts.googleapis.com/css?family=PT+Sans:400,700&subset=cyrillic,cyrillic-ext" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $base; ?>/css_thirdDesign/main.css" />
    <link rel="stylesheet" href="<?php echo $base; ?>/css_thirdDesign/flipclock.css" />
    <link rel="stylesheet" href="<?php echo $base; ?>/css_thirdDesign/tabulous.css" />


    <script>
        baseUrl = '<?php echo Yii::app() -> baseUrl; ?>';
    </script>




</head>
<body>
<!-- Скрипт от Сергея -->
<script type="text/javascript">(window.Image ? (new Image()) : document.createElement('img')).src = location.protocol + '//vk.com/rtrg?r=ZoWPAij/XsvmYwpBVp*mHyjxYFmtRk9FQyha6GkvAtetr588U5wbF5MZJj/ib6UydXHnWNMMtMP7Z8WtwIkSkH8cdWpm3HrI1QN5riGW/XLGtfE3*v7iSfoAoNxRKWe6XZ0BbseP2AqkhvDT8d**YI2Z7hHOYfH/YO7YrxfuUPw-';</script>
<?php if (strpos($_SERVER['SERVER_NAME'],'rt-to-go')) : ?>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter37896725 = new Ya.Metrika({
                    id:37896725,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true,
                    params:{
                        design:"new2"
                    }
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/37896725" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
<?php else: ?>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter39368130 = new Ya.Metrika({
                    id:39368130,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/39368130" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
<?php endif; ?>
<header class="top_header">
    <div class="header_topline default" id="topline">
        <div class="container">
            <div class="col-md-12">
                <div class="row">

                    <div class="col-lg-3 col-md-1 col-sm-1 col-xs-1 logo-outer" id="logo-outer">
                        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12 logo"><a href="#"><img src="<?php echo $base; ?>/img_thirdDesign/logo.png"></a></div>
                        <div class="col-lg-9 logo-text" id="logo-text"><a href="#slujba-info">Бесплатная общегородская служба записи на МРТ и КТ</a></div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-10 col-xs-10 top_contacts">
                        <div><?php echo $tel['formatted']; ?></div>
                        <a href="#callback" class="order fancybox"><img src="<?php echo $base; ?>/img_thirdDesign/phone-sm.png"><span>Заказать обратный звонок</span></a>
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
            <div class="slide_item"><img src="<?php echo $base; ?>/img_thirdDesign/background1.jpg" alt="alt" /></div>
            <div class="slide_item"><img src="<?php echo $base; ?>/img_thirdDesign/background2.jpg" alt="alt" /></div>
            <div class="slide_item"><img src="<?php echo $base; ?>/img_thirdDesign/background3.jpg" alt="alt" /></div>
            <div class="slide_item"><img src="<?php echo $base; ?>/img_thirdDesign/background5.jpg" alt="alt" /></div>
        </div>

    </div>


    <div class="over-slider-container">
        <marquee behavior="scroll" direction="left" scrollamount="5">
            Запись на приём через Общегородскую службу записи на МРТ и КТ теперь не только удобнее, но и <b>дешевле, чем напрямую</b>!
        </marquee>
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-8">
                    <div class="discount-header">
                        <div class="discount-top"><img src="<?php echo $base; ?>/img_thirdDesign/discount-top.png"></div>
                        <div class="discount-content">
                            <span class="discount-name"><?php echo $model -> price -> text; ?></span>
                            <span class="discount-old-price"><?php echo $model -> price -> price_old;?>р.</span>
                            <span class="discount-price"><?php echo $model -> price -> price;?>р.</span>
                        </div>
                        <div class="discount-bottom"><img src="<?php echo $base; ?>/img_thirdDesign/discount-bottom.png"></div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-4">

                    <a href="#callback-registration" class="fancybox" id="order-button"> <span class="btn-title">Записаться <br> на МРТ и КТ</span> <span class="day-and-night">Круглосуточно!</span></a>
                </div>
            </div>
            <div class="advantages row">
                <div class="col15-lg-2 col-md-4 col-sm-4 col-xs-3" style="margin-top:10px;pading-left: 5px;">
                    <img src="<?php echo $base; ?>/img_thirdDesign/advantage1.png">
                    <span>МРТ и КТ<br> срочно</span>
                    <p class="adv-comment">Обследование <br>в день обращения</p>
                </div>
                <div class="col15-lg-2 col-md-4 col-sm-4 col-xs-3 narrow">
                    <img src="<?php echo $base; ?>/img_thirdDesign/advantage4.png">
                    <span>Скидки<br> Акции</span>
                </div>
                <div class="col15-lg-2 col-md-4 col-sm-4 col-xs-3">
                    <img src="<?php echo $base; ?>/img_thirdDesign/advantage6.png">
                    <span>Результат<br> за час</span>
                </div>
                <div class="col15-lg-3 col-md-4 col-sm-4 col-xs-3">
                    <img src="<?php echo $base; ?>/img_thirdDesign/advantage7.png">
                    <span class="best-price">Гарантия лучшей цены</span>
                    <p class="adv-comment" style="color: #d82b3a;padding-left: 40px;border-top: 1px dashed #d82b3a;">Наши услуги <br>абсолютно бесплатны! </p>
                </div>
                <div class="col15-lg-2 col-md-4 col-sm-4 col-xs-4 narrow">
                    <img src="<?php echo $base; ?>/img_thirdDesign/advantage3.png">
                    <span>Опыт работы<br> 24 года</span>
                </div>
                <div class="col15-lg-2 col-md-4 col-sm-4 col-xs-4">
                    <img src="<?php echo $base; ?>/img_thirdDesign/advantage5.png">
                    <span>Бесплатная<br> консультация врача </span>
                </div>
                <div class="col15-lg-2 col-md-4 col-sm-4 col-xs-4" style="margin-top:10px;">
                    <img src="<?php echo $base; ?>/img_thirdDesign/advantage2.png">
                    <span>МРТ и КТ<br> ночью</span>
                    <p class="adv-comment">Скидка 50%</p>
                </div>
            </div>


        </div>
    </div>
</header>

<div class="content">
	<div class="container review-section">
	
	<div id="arrow">
		<a class="previous" title="Перейти к предыдущему блоку"><</a><a class="next" title="Перейти к следующему блоку">></a>
	</div>
	
	<div class="reviews default" id="reviews">
		<div class="reviews-inner">
            <div class="reviews-h1">Отзывы</div>
            <div class="one-review">
                <div class="review-author">
                    ТАТЬЯНА КАЗАНКИНА,
                    советская легкоатлетка,
                    трехкратная Олимпийская
                    чемпионка, рекордсменка
                    мира и Олимпийских игр
                </div>
                <div class="review-text">
                    <img src="<?php echo Yii::app() -> baseUrl; ?>/img_newDesign/kazankina.jpg">
                    Самые замечательные
                    впечатления от посещения
                    клиники. Здесь работают
                    внимательные, добрые,
                    грамотные специалисты.
                    С ними хочется поделиться своими
                    проблемами, рассказать о своих бедах.
                    Большое спасибо Елене Юрьевне Карабан,
                    с таким человеком хочется беседовать и
                    делиться всем, она все расскажет доступно
                    для пациента, посоветует что и как нужно
                    сделать лучшим образом. Большое спасибо
                    всему персоналу. Ведь очень приятно, когда
                    к тебе внимательны и доброжелательны
                </div>
            </div>
            <div class="one-review">
                <div class="review-author">
                    ВИКТОР ТИХОМИРОВ, художник известной группы "Митьки", кинорежиссер, писатель, сценарист
                </div>
                <div class="review-text">
                    <img src="<?php echo Yii::app() -> baseUrl; ?>/img_newDesign/tihomir.jpg">
                    Приятное впечатление от посещения вашего центра, как этическое, так и эстетическое. Особливо обаятельное впечатление от терапевта Елены Юрьевны Карабан. Привет ей. Успехов в деле и исцеления болящих.
                </div>
            </div>
            <div class="one-review">
                <div class="review-author">
                    СВЕТЛАНА ПИСЬМИЧЕНКО, российская актриса кино и театра, заслуженная артистка Российской Федерации
                </div>
                <div class="review-text">
                    <img src="<?php echo Yii::app() -> baseUrl; ?>/img_newDesign/svetlana.jpg">
                    Я очень благодарна сотрудникам центра, за предоставленную мне возможность узнать о состоянии своего здоровья. В нашей актерской профессии мы подвергаем себя бесконечным стрессам, переездам, гастролям, съемкам и иногда не задумываемся, а что же завтра... Здесь очень приятный персонал, внимательные и доброжелательные врачи и высокого уровня диагностика. В бесконечной суете дней особенно люди творческих профессий забывают - что здоровье и прекрасное самочувствие - это залог успеха, удачи и долгой, трудоспособной жизни. И наступает час пик - когда нужно сказать - стоп - и пойти на обследование. Я пришла сюда, привела своих детей - и буду рекомендовать Вас друзьям. Спасибо Всем и будьте здоровы!
                </div>
            </div>
            <div class="one-review">
                <div class="review-author">
                    ОКОРОКОВ ВАСИЛИЙ РОМАНОВИЧ, Профессор СПбГПУ, доктор экономических наук заведующий кафедрой "Международных экономических отношений"
                </div>
                <div class="review-text">
                    <img src="<?php echo Yii::app() -> baseUrl; ?>/img_newDesign/okorokov.jpg">
                    Первое впечатление, которое создалось - попали в настоящий медицинский рай! Такое впечатление ещё более усилилось, познакомившись с современным оборудованием центра и крайне внимательным отношением врачей и сотрудников центра. Желаю вам, дорогие коллеги, доброго здоровья и создания медицинского благополучия для всех людей нашей страны. С благодарностью и искренним уважением В.Р. и Л.Г. Окороковы, профессора СПБГПУ.
                </div>
            </div>
            <div class="one-review">
                <div class="review-author">
                    Аксиновская Светлана Сергеевна
                    27/10/2015
                </div>
                <div class="review-text">
                    Спасибо Вашей клинике за высокий уровень профессионализма, желание помочь и неравнодушие! Особая благодарность Рузановой Ирине Николаевне. Своим друзьям и близким могу рекомендовать только Вашу клинику.
                </div>
            </div>
            <div class="one-review">
                <div class="review-author">
                    Григорьева Екатерина Николаевна
                    21/10/2015
                </div>
                <div class="review-text">
                    Великолепный медицинский центр! Попала случайно, страховая направила сделать мрт. Все быстро, качественно, комфортно, без утомительных очередей в регистратуру и поисков карточки. После первого знакомства стала ходить к вам, хотя раньше лечилась в клинике РАМН. Пока всем очень довольна. Хочу отметить профессионализм лора Дежневой Е.В., такого целостного подхода к проблеме я давно не встречала. Очень профессиональный и доброжелательный мануальный терапевт Канкулов В.Ж., замечательная массажист Зарезина С.В. Отдельное спасибо за детскую комнату, это очень выручает. Рекомендую вашу клинику всем своим знакомым.
                </div>
            </div>
            <div class="one-review">
                <div class="review-author">
                    Добавил Жуды
                    07/10/2015
                </div>
                <div class="review-text">
                    Специально прилетаю из Казахстана делать МРТ лично у профессора Холина. Знаю, так многие у нас делают, Доверяют только ему. Встречала на его приеме пациентов и из других бывших республик,а также из дальнего зарубежья. Авторитет его очень высокий. Многие наши специалисты его ученики.
                </div>
            </div>
            <div class="one-review">
                <div class="review-author">
                    Иванова Александра
                    03/09/2015
                </div>
                <div class="review-text">
                    Внимательный, сочувствующий и, главное, профессиональный и не равнодушный доктор Ольга Кротова - это главное, что привлекает в вашу клинику. Ее помощница - доброжелательная, симпатичная и грамотная Ирина Климовцева дополняет достоинства доктора. Отличные специалисты. Девушек на ресепшне, вполне вежливых и терпеливых стоит, может быть, обучить подробностям подготовки в зависимости от ситуации. В целом клиника хорошего уровня. Буду обращаться снова.
                </div>
            </div>
            <div class="one-review">
                <div class="review-author">
                    Пьянкова Галина Николаевна
                    10/09/2015
                </div>
                <div class="review-text">
                    Был очень приятно удивлен прекрасной организацией сопровождения пациентов и широким спектром комплексных диагностических программ. Особую благодарность выражаю старшему администратору reception Татьяне Ляшок, благодаря которой я прошел индивидуальное обследование и лечение в Вашей Клинике в максимально сжатые сроки, в очень удобном для меня графике и комфортной обстановке, как в эмоциональном, так и в физическом плане. Несмотря на то, что постоянно живу в другой европейской стране, за обследованием и лечением я буду обращаться только в Вашу Клинику и буду рекомендовать Вас своим знакомым и друзьям.
                </div>
            </div>
            <div class="one-review">
                <div class="review-author">
                    Разина Я.В.
                    01/09/2015
                </div>
                <div class="review-text">
                    Я, Разина Яна Владимировна, хочу выразить огромную благодарность всем докторам которые в короткий срок смогли обнаружить мою проблему со здоровьем! Персонал очень отзывчивый и дружелюбный, Особую благодарность хотела передать врачу (лечащему) Осташкову А.В., мануальной т. Юсупжанову В.И., эндокринологу Надеждиной Э.А., психотерапевту Алесе Викторовне и всем врачам ЛОР. Спасибо вам огромное!!! За ваш нелегкий руд!!!
                </div>
            </div>
            <div class="one-review">
                <div class="review-author">
                    Волохова С.В.
                    21/08/2015
                </div>
                <div class="review-text">
                    Приношу вам сердечную, человеческую благодарность! Благодаря вашему профессионализму, чуткому пониманию проблемы пациента, внимательному отношению и терпению, я спокойна за свое здоровье. Отдельно хотела бы поблагодарить кардиолога Хихелову Елену Олеговну. Записавшись на прием, получила подробную консультацию по своей проблеме, сразу же сделали КT и назначили своевременное лечение. Самочувствие мое улучшилось, а через неделю, на повторном приеме была отмечена положительная динамика моего состояния. Так же хочется отметить внимательное отношение сотрудников колл-центра и ресепшн — всегда напомнят о приеме, встретят, проводят до кабинета, готовы помочь, очень вежливы и обходительны.
                </div>
            </div>
            <div class="one-review">
                <div class="review-author">
                    Румянцев О. С.
                    11/08/2015
                </div>
                <div class="review-text">
                    Хочется оставить положительный отзыв о докторе И.И. Гелетее (гастроэнтеролог). Первый раз встречаю доктора, который в высшей степени внимателен ко всем жалобам, отзывам пациента. Всегда откликается на любое пожелание. Всегда находится в хорошем настроении и подбадривает пациента. Впредь буду посещать ТОЛЬКО Гелетея И.И. и советовать его всем знакомым.
                </div>
            </div>
            <div class="one-review">
                <div class="review-author">
                    Полякова М.И
                    07/08/2015
                </div>
                <div class="review-text">
                    Пожелания: оставайтесь на той же волне, волне позитива и понимания пациента, продолжайте разговаривать с нами (пациентами) на понятном нам языке, в этом Вам нет пока равных. 10 из 10. Желаю я и моя семья Вам процветания, теперь я буду Вас рекомендовать всем моим знакомым и родственникам. Да, у Вас дорого, но оно того стоит, я ни о чем не жалею. Теперь я на ногах и полон сил. Сердечно благодарен всем врачам и мед персоналу. Спасибо большое.
                </div>
            </div>
            <div class="one-review">
                <div class="review-author">
                    Нижегородова Ольга Викторовна
                    23/07/2015
                </div>
                <div class="review-text">
                    Мои близкие родственники являются постоянными пациентами Вашей Клиники. Я хотел бы выразить благодарность доктору Капитоновой Н.В. за четкий и оперативный диагноз, доктору Клочко Р.В. за заботу и внимание, а так же сотрудникам контактного центра, за оперативную работу и предоставление четкой информации по всем моим вопросам.
                </div>
            </div>
            <div class="one-review">
                <div class="review-author">
                    Котович О.И. Ген. дир. ООО «Завод Северная Венеция»
                    27/07/2015
                </div>
                <div class="review-text">
                    Хочу выразить благодарность сотрудникам отдела ресепшн за внимательное, доброе отношение к пациентам, организованность, особенно Кристине Соболевой. Особая благодарность доктору Ирине Леонидовне за высокий профессионализм, отзывчивость и чуткость.
                </div>
            </div>
            <div class="one-review">
                <div class="review-author">
                    Колпакова Людмила Ивановна
                    25/07/2015
                </div>
                <div class="review-text">
                    Хочу выразить огромную благодарность и сказать большое спасибо сотруднику контактного центра Мурскому Дмитрию за быструю организацию записи и предоставление всех необходимых услуг моей матери. Всё было сделано молниеносно, несмотря на то, что мы были очень сжаты в сроках. Отдельно хочется отметить высокопрофессиональных врачей Маковскую А.И. и Капитонову Н.В. Весь процесс, начиная со звонка, записи на прием, и заканчивая получением необходимой помощи, прошел очень гладко и профессионально. Все просто молодцы!
                </div>
            </div>
            <div class="one-review">
                <div class="review-author">
                    Добавил Наталья
                    17/07/2015
                </div>
                <div class="review-text">
                    Обследовалась у профессора по совету своего лечащего врача. И не пожалела. Можно было рядом с домом, но это совсем не то. Профессор знает, что надо моему доктору. Сравнивает с предыдущими снимками. Видит многое, что другим неясно. Не акцентирует на несущественном. Заключение понятно.
                </div>
            </div>
            <div class="one-review">
                <div class="review-author">
                    Б. В.А.
                    12/07/2015
                </div>
                <div class="review-text">
                    Атмосфера в клинике, начиная с встречи на ресепшен и заканчивая приемом врача, напоминает клиники Германии. Это очень приятно, и вызывает неосознанное чувство доверия. Была удивлена этому островку европейской медицины.
                </div>
            </div>
        </div>
		</div>
	</div>

<?php
$rule = $model;
if (is_a($rule -> section,'Section')) {
    $this->renderPartial('//subs_thirdDesign/_section', array('section'=> $rule -> section, 'rule' => $rule,'base' => $base, 'tel' => $tel));
}


foreach(Section::model() -> findAll(array('order' => 'num ASC')) as $section){
    if ($section -> id == $rule -> section -> id) {
        continue;
    }
    $this->renderPartial('//subs_thirdDesign/_section', array('section' => $section, 'rule' => $model, 'base' => $base, 'tel' => $tel));
}



?>


<?php /* $this -> renderPartial('//subs_thirdDesign/prices', [
    'model'=>$model
]);  $this -> renderPartial('//subs_thirdDesign/skidki', [
    'model'=>$model
]);  $this -> renderPartial('//subs_thirdDesign/doctors', [
    'model'=>$model
]);  $this -> renderPartial('//subs_thirdDesign/jelezo', [
    'model'=>$model
]);  $this -> renderPartial('//subs_thirdDesign/geo', [
    'model'=>$model
]); $this -> renderPartial('//subs_thirdDesign/raznica', [
    'model'=>$model
]); $this -> renderPartial('//subs_thirdDesign/faq', [
    'model'=>$model
]); $this -> renderPartial('//subs_thirdDesign/form', [
    'model'=>$model
]); //*/ ?>


</div>
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <span>© 2016, Бесплатная общегородская служба записи на МРТ и КТ</span>
            </div>
            <div class="col-md-6">
                <a class="phone-footer" href="tel:<?php echo $tel['raw']; ?>"><?php echo $tel['formatted']; ?></a>
            </div>
        </div>
    </div>
</footer>


<div id="info1" style="display:none">
    <p>Информация про доктора</p>

</div>

<div id="info2" style="display:none">
    <h2>Ананьева Наталия Исаевна</h2><img src="<?php echo $base; ?>/img_thirdDesign/1.jpg" alt="alt" style="float: left;margin-right: 20px;">
    <p>Более 25 лет работает в Научно-исследовательском психоневрологическом институте имени В. М. Бехтерева, в настоящее время – руководитель отдела неврологии и клинико-диагностических методов исследования психоневрологических больных.
    </p>
    <p>Профессор научно-клинического и образовательного центра «Лучевая диагностика и ядерная медицина» Института высоких медицинских технологий СПбГУ. Ученый секретарь Санкт-Петербургского радиологического общества. Член Европейского общества радиологов (ESR), Европейского общества нейрорадиологов (ESNR), Европейского общества магнитного резонанса в биологии и медицине (ESMRMB).
    </p>
    <p>Кандидатская диссертация «Сравнительная информативность методов лучевого обследования у больных с эпилептическими припадками».
    </p>
    <p>Докторская диссертация «Комплексная лучевая диагностика нарушений мозгового кровообращения».
    </p>
    <p>Автор более 150 научных работ, в том числе монографий «КТ и МРТ диагностика ишемических инсультов», «Лучевая анатомия человека», «Нейрорадиология», «Лучевая диагностика заболеваний головы и шеи».
    </p>
    <p><b>Приоритетная направление научной и клинической деятельности:</b>
    </p>
    <ul>
        <li>лучевая диагностика эпилепсии, сосудистых заболеваний ЦНС, нейродегенеративных заболеваний, деменций.</li>
    </ul>
</div>

<div id="info3" style="display:none"><img src="<?php echo $base; ?>/img_thirdDesign/2.jpg" alt="alt" style="float: left;margin-right: 20px;">
    <h2>Голимбиевская Тамара Анатольевна</h2>
    <p>Научно-педагогический, рентгенологический стаж более 38 лет.</p>
    <p>С 1999 года – доцент кафедры рентгенологии СПб МАПО, в настоящий момент доцент кафедры лучевой диагностики и лучевой терапии Северо-Западного медицинского университета имени И. И. Мечникова. Является членом СПб радиологического общества. Член Европейского общества радиологов (ESR).</p>
    <p>Как клиницист работала в сфере неврологии, торакальной хирургии.</p>
    <p>Автор 75 научных работ, в числе которых учебные пособия и главы в 3-х монографиях: «Лучевая анатомия человека», «Национальное руководство “Лучевая диагностика заболеваний головы и шеи”», «ВИЧ-медицина», «Лучевая и возрастная анатомия человека».</p>
    <p>Разрабатывает ряд методик КТ-диагностики, в том числе такие как виртуальная колонография, энтерография, виртуальная бронхография и др.</p>
    <p><b>Приоритетное направление научной и клинической деятельности:</b></p>
    <ul>
        <li>пульмонология, виртуальная колоноскопия.</li>
    </ul>
</div>

<div id="info4" style="display:none">
    <h2>Холин А.В.</h2><img src="<?php echo $base; ?>/img_thirdDesign/9.jpg" alt="alt" style="float: left;margin-right: 20px;">
    <p>Заведующий кафедрой лучевой диагностики СПб МАПО, профессор, член Европейского научного общества нейрорадиологов, член Европейского Конгресса Радиологов, член редакционного совета Британского журнала радиологии (British Journal of Radiology), член Европейского общества Академических радиологов.</p>
    <p>С 1996 по 2002, зам. главного врача по диагностике ГМПБ №2.</p>
    <p>С 2002 по 2009 руководитель отделения лучевой диагностики и адаптационных процессов Российского НИИ травматологии и ортопедии им. Р.Р.Вредена.  </p>
    <p>Кандидат медицинских наук - защита по специальностям онкология, рентгенология и радиология.</p>
    <p>Доктор медицинских наук - защита по специальностям лучевая диагностика и лучевая терапия, нервные болезни.</p>
    <p>Более 160 публикаций, включая 6 монографии.  </p>
    <p>Стажировки за рубежом: Великобритания, Швеция. </p>
</div>

<div id="info5" style="display:none"><img src="<?php echo $base; ?>/img_thirdDesign/3.jpg" alt="alt" style="float: left;margin-right: 20px;">
    <h2>Савельева Татьяна Вячеславовна</h2>
    <p>Стаж работы врачом- рентгенологом на КТ - 12 лет, на МРТ - 9 лет.</p>
    <p>Доцент кафедры рентгенологии Санкт-Петербургского Государственного медицинского университета. Доцент научно-клинического и образовательного центра «Лучевая диагностика и ядерная медицина» Института высоких медицинских технологий СПбГУ. В 2009 г защитила диссертацию «Возможности МСКТ в выявлении опухолевого поражения поджелудочной железы и желчевыводящих протоков». Много лет работает в области компьютерной и магнитно-резонансной томографии, специалист широкого профиля. В настоящее время заведует кабинетами МРТ клинической больницы № 122 имени Л. Г. Соколова ФМБА России.</p>
    <p>Диссертационная работа посвящена диагностике опухолей поджелудочной железы и желчевыводящих протоков методом многослойной спиральной компьютерной томографии.</p>
    <p>Автор 12 научных публикаций.</p>
    <p>С 2013 года врач рентгенолог МРТ и КТ в МДЦ Рэмси Диагностика.</p>
    <p><b>Приоритетное направление научной и клинической деятельности:</b></p>
    <ul>
        <li>диагностика патологии органов брюшной полости и забрюшинного пространства.</li>
    </ul>
</div>

<div id="info6" style="display:none">
    <h2>Макогонова Марина Евгеньевна</h2><img src="<?php echo $base; ?>/img_thirdDesign/4.jpg" alt="alt" style="float: left;margin-right: 20px;">
    <p>Работает врачом-рентгенологом с 2005 года после окончания клинической ординатуры в СПбМАПО. Работала врачом-рентгенологом в кабинетах компьютерной томографии клиники СПб МАПО, МЦ «Адмиралтейские верфи».</p>
    <p>В настоящее время заведует кабинетом магнитно-резонансной томографии НИИ фтизиопульмонологии и работает врачом кабинета МРТ в международной клинике «МЕДЕМ».</p>
    <p>Готовит кандидатскую диссертацию на тему «Диагностические возможности магнитно-резонансной томографии (МРТ) в оценке состояния спинного мозга и позвоночника при спондилитах».</p>
    <p>Автор более 30 научных работ.</p>
    <p>С 2013 года врач рентгенолог МРТ и КТ в МДЦ Рэмси Диагностика</p>
    <p><b>Приоритетное направление научной и клинической деятельности:</b></p>
    <ul>
        <li>лучевая диагностика в вертебрологии и ортопедической стоматологии.</li>
    </ul>
</div>

<div id="info7" style="display:none">
    <h2>Гарапач Ирина Анатольевна</h2><img src="<?php echo $base; ?>/img_thirdDesign/6.jpg" alt="alt" style="float: left;margin-right: 20px;">
    <p>Работает врачом-рентгенологом с 2000 года после окончания клинической ординатуры в СПбМАПО.</p>
    <p>Доцент кафедры рентгенологии Санкт-Петербургского Государственного медицинского университета. В 2006 г защитила диссертацию о возможностях лучевой диагностики в стоматологии. Член Санкт-Петербургского радиологического общества, Европейской ассоциации радиологов. Много лет работает в области компьютерной и магнитно-резонансной томографии, специалист широкого профиля. Работала в кабинете компьютерной томографии ГБ №2, в течении четырех лет работала заведующей отделением лучевой диагностики ДГБ № 2 «Святой Марии Магдалины».</p>
    <p>С 2015 года врач-рентгенолог МРТ и КТ в МДЦ Рэмси Диагностика</p>
    <p>Автор более 20 научных публикаций, в том числе двух монографий.</p>
    <p><b>Приоритетное направление научной и клинической деятельности:</b></p>
    <ul>
        <li>лучевая диагностика в педиатрии, лучевая диагностика в стоматологии.</li>
    </ul>
</div>

<div id="info8" style="display:none">
    <h2>Меньков Игорь Анатольевич</h2><img src="<?php echo $base; ?>/img_thirdDesign/5.jpg" alt="alt" style="float: left;margin-right: 20px;">
    <p>С ноября 2014 года по настоящее время – заведующий отделениями компьютерной томографии и неотложной диагностики кафедры рентгенологии и радиологии (с курсом ультразвуковой диагностики) Военно-медицинской академии им. С.М. Кирова.</p>
    <p>С 2011 года по ноябрь 2014 года – врач-рентгенолог рентгеновского отделения (компьютерной томографии) кафедры рентгенологии и радиологии (с курсом ультразвуковой диагностики) Военно-медицинской академии им. С.М.Кирова.</p>
    <p>С 2012 года по настоящее время – врач-рентгенолог отделения лучевой диагностики СПБ ГУЗ «Городская Александровская больница».</p>
    <p>В 2013 году защитил диссертацию на тему «Рентгеновская компьютерная томография в оценке состояния коронарных шунтов в отдаленном послеоперационном периоде».</p>
    <p>Член Санкт-Петербургского радиологического общества, Европейской ассоциации радиологов (ESR), Европейского общества кардиорадиологии (ESCR).</p>
    <p>С 2014 года врач рентгенолог МРТ и КТ в МДЦ “Рэмси Диагностика” г.Санкт-Петербург</p>
    <p>Автор более 25 научных публикаций, 2 практикумов.</p>
    <p><b>Приоритетное направление научной и клинической деятельности:</b></p>
    <ul>
        <li>лучевая диагностика в педиатрии, лучевая диагностика в стоматологии.</li>
    </ul>
</div>

<div id="info9" style="display:none">
    <h2>Марченко Наталья Викторовна</h2><img src="<?php echo $base; ?>/img_thirdDesign/8.jpg" alt="alt" style="float: left;margin-right: 20px;">
    <p>Врач-рентгенолог (МРТ), заведующий кабинетом МРТ</p>
    <p>Высшая квалификационная категория, кандидат медицинских наук</p>
    <p>Врачебный стаж: 18 лет		</p>
    <p>В 2004 г. защитила кандидатскую диссертацию на тему «Возможности использования цифровой флюорографической камеры для проведения проверочных и диагностических исследований органов грудной полости».</p>
    <p>Более 80 печатных работ, в том числе монографии и учебные пособия.</p>
    <p>Член Российской ассоциации радиологов, Санкт-Петербургского радиологического общества, Европейского общества радиологов (ESR), Европейского общества магнитного резонанса в биологии и медицине (ESMRMB).</p>
</div>

<div id="info10" style="display:none">
    <h2>Силина Галина Ивановна</h2><img src="<?php echo $base; ?>/img_thirdDesign/7.jpg" alt="alt" style="float: left;margin-right: 20px;">
    <p>	Врач-рентгенолог (МРТ)</p>
    <p>Врачебный стаж: 12 лет</p>
    <p> Образование: СПБГМА им И.И. Мечникова 2001-2007 г.</p>
    <p> Работала врачом-рентгенологом в Санкт-Петербургском клиническом научно-практическом центре специализированных видов медицинской помощи (онкологический). С 2012 г. по настоящее время работаю врачом-рентгенологом в ФГБУЗ Клиническая больница №122 им. Л.Г. Соколова. С 2013 г. работаю врачом-рентгенологом кабинета МРТ медицинского центра МАРТ.</p>
</div>



<div class="hidden">
    <form id="callback-registration" class="pop_form">
        <h3>Записаться на МРТ и КТ</h3>
        <p>Врач-консультант перезвонит вам в течение 10 минут!</p>
        <p>Вы сможете получить подробную консультацию по всем вопросам, связанным с МРТ и КТ исследованием и при желании записаться на обследование в удобное для вас время по лучшей цене!</p>
        <input type="text" class="your-name form_field" name="name" placeholder="Ваше имя..." required />
        <input type="text" class="your-phone form_field" name="phone" placeholder="Ваше телефон..." required />
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
<script src="<?php echo $base; ?>/libs_thirdDesign/html5shiv/es5-shim.min.js"></script>
<script src="<?php echo $base; ?>/libs_thirdDesign/html5shiv/html5shiv.min.js"></script>
<script src="<?php echo $base; ?>/libs_thirdDesign/html5shiv/html5shiv-printshiv.min.js"></script>
<script src="<?php echo $base; ?>/libs_thirdDesign/respond/respond.min.js"></script>
<![endif]-->
<script src="<?php echo $base; ?>/libs_thirdDesign/jquery/jquery-1.11.1.min.js"></script>
<script src="<?php echo $base; ?>/libs_thirdDesign/fancybox/jquery.fancybox.pack.js"></script>
<script src="<?php echo $base; ?>/libs_thirdDesign/owl-carousel/owl.carousel.min.js"></script>
<script src="<?php echo $base; ?>/libs_thirdDesign/landing-nav/navigation.js"></script>
<script src="<?php echo $base; ?>/js_thirdDesign/common.js"></script>
<script src="<?php echo Yii::app() -> baseUrl; ?>/js_newDesign/flipclock.min.js"></script>
<script src="<?php echo Yii::app() -> baseUrl; ?>/js_newDesign/tabulous.min.js"></script>
<script src="<?php echo $base; ?>/js_thirdDesign/jquery.maskedinput.min.js"></script>

<script>
    jQuery(function($){
        $(".your-phone").mask("+7(999)999-99-99");
    });
</script>
<!-- BEGIN K50 TRACKER CODE-->
<script>
    (function(c,a,p) {
        var s = document.createElement(a); s.src = p; s.type = "text/javascript"; s.async =!0; s.readyState ? s.onreadystatechange = function() { if ( s.readyState === "loaded" || s.readyState === "complete" ) { s.onreadystatechange = null; c();}} : s.onload = function () {c();}; var n = document.getElementsByTagName(a)[0]; n.parentNode.insertBefore(s,n); })(function(){
        k50Tracker.init({
            siteId: 46841313737734
        })
    },"script","https://k50-a.akamaihd.net/k50/k50tracker2.js");
</script>
<!-- END K50 TRACKER CODE-->
<!-- BEGIN K50 TRACKER CODE-->
<style>
    #k50-track-code {
        margin: 10px;
        padding: 4px 8px;
        position: fixed;
        top: 0;
        right: 0;
        display: inline-block;
        font-family: Arial;
        font-size: 12px;
        font-weight: Normal;
        line-height: 1;
        color: #ffffff;
        background: #333333;
        border: 0px solid #ffffff;
        border-radius: 4px;
        z-index: 9999;
    }
</style>
<script>
    (function(c,a,p) {
        var s = document.createElement(a); s.src = p; s.type = "text/javascript"; s.async =!0; s.readyState ? s.onreadystatechange = function() { if ( s.readyState === "loaded" || s.readyState === "complete" ) { s.onreadystatechange = null; c();}} : s.onload = function () {c();}; var n = document.getElementsByTagName(a)[0]; n.parentNode.insertBefore(s,n); })(function(){
        k50Tracker.init({
            siteId: 75901313737734
        })
    },"script","https://k50-a.akamaihd.net/k50/k50tracker2.js");
</script>
<div id="k50-track-code"></div>
<!-- END K50 TRACKER CODE-->
</body>
</html>