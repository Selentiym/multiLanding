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
    <link rel="stylesheet" href="<?php echo Yii::app() -> baseUrl; ?>/css_newDesign/fonts.css" />
    <link rel="stylesheet" href="<?php echo Yii::app() -> baseUrl; ?>/css_newDesign/main.css" />
    <link rel="stylesheet" href="<?php echo Yii::app() -> baseUrl; ?>/css_newDesign/flipclock.css" />
    <link rel="stylesheet" href="<?php echo Yii::app() -> baseUrl; ?>/css_newDesign/tabulous.css" />

    <script>
        baseUrl = '<?php echo Yii::app() -> baseUrl; ?>';
    </script>
    <!-- Скрипт от Сергея -->
    <script type="text/javascript">(window.Image ? (new Image()) : document.createElement('img')).src = location.protocol + '//vk.com/rtrg?r=ZoWPAij/XsvmYwpBVp*mHyjxYFmtRk9FQyha6GkvAtetr588U5wbF5MZJj/ib6UydXHnWNMMtMP7Z8WtwIkSkH8cdWpm3HrI1QN5riGW/XLGtfE3*v7iSfoAoNxRKWe6XZ0BbseP2AqkhvDT8d**YI2Z7hHOYfH/YO7YrxfuUPw-';</script>
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
    <noscript><div><img src="https://mc.yandex.ru/watch/37896725" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->


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
$rule = $model;
if (is_a($model -> section,'Section')) {
    $this->renderPartial('//subs_newDesign/_section', array('section'=> $model -> section, 'rule' => $model));
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


<div id="info1" style="display:none">
    <p>Информация про доктора</p>

</div>

<div id="info2" style="display:none">
    <h2>Ананьева Наталия Исаевна</h2><img src="img/1.jpg" alt="alt" style="float: left;margin-right: 20px;">
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

<div id="info3" style="display:none"><img src="img/2.jpg" alt="alt" style="float: left;margin-right: 20px;">
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
    <h2>Холин А.В.</h2><img src="img/9.jpg" alt="alt" style="float: left;margin-right: 20px;">
    <p>Заведующий кафедрой лучевой диагностики СПб МАПО, профессор, член Европейского научного общества нейрорадиологов, член Европейского Конгресса Радиологов, член редакционного совета Британского журнала радиологии (British Journal of Radiology), член Европейского общества Академических радиологов.</p>
    <p>С 1996 по 2002, зам. главного врача по диагностике ГМПБ №2.</p>
    <p>С 2002 по 2009 руководитель отделения лучевой диагностики и адаптационных процессов Российского НИИ травматологии и ортопедии им. Р.Р.Вредена.  </p>
    <p>Кандидат медицинских наук - защита по специальностям онкология, рентгенология и радиология.</p>
    <p>Доктор медицинских наук - защита по специальностям лучевая диагностика и лучевая терапия, нервные болезни.</p>
    <p>Более 160 публикаций, включая 6 монографии.  </p>
    <p>Стажировки за рубежом: Великобритания, Швеция. </p>
</div>

<div id="info5" style="display:none"><img src="img/3.jpg" alt="alt" style="float: left;margin-right: 20px;">
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
    <h2>Макогонова Марина Евгеньевна</h2><img src="img/4.jpg" alt="alt" style="float: left;margin-right: 20px;">
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
    <h2>Гарапач Ирина Анатольевна</h2><img src="img/6.jpg" alt="alt" style="float: left;margin-right: 20px;">
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
    <h2>Меньков Игорь Анатольевич</h2><img src="img/5.jpg" alt="alt" style="float: left;margin-right: 20px;">
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
    <h2>Марченко Наталья Викторовна</h2><img src="img/8.jpg" alt="alt" style="float: left;margin-right: 20px;">
    <p>Врач-рентгенолог (МРТ), заведующий кабинетом МРТ</p>
    <p>Высшая квалификационная категория, кандидат медицинских наук</p>
    <p>Врачебный стаж: 18 лет		</p>
    <p>В 2004 г. защитила кандидатскую диссертацию на тему «Возможности использования цифровой флюорографической камеры для проведения проверочных и диагностических исследований органов грудной полости».</p>
    <p>Более 80 печатных работ, в том числе монографии и учебные пособия.</p>
    <p>Член Российской ассоциации радиологов, Санкт-Петербургского радиологического общества, Европейского общества радиологов (ESR), Европейского общества магнитного резонанса в биологии и медицине (ESMRMB).</p>
</div>

<div id="info10" style="display:none">
    <h2>Силина Галина Ивановна</h2><img src="img/7.jpg" alt="alt" style="float: left;margin-right: 20px;">
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
<script src="<?php echo Yii::app() -> baseUrl; ?>/libs_newDesign/fancybox/jquery.fancybox.pack.js"></script>
<script src="<?php echo Yii::app() -> baseUrl; ?>/libs_newDesign/owl-carousel/owl.carousel.min.js"></script>
<script src="<?php echo Yii::app() -> baseUrl; ?>/libs_newDesign/landing-nav/navigation.js"></script>
<script src="<?php echo Yii::app() -> baseUrl; ?>/js_newDesign/common.js"></script>
<script src="<?php echo Yii::app() -> baseUrl; ?>/js_newDesign/flipclock.min.js"></script>
<script src="<?php echo Yii::app() -> baseUrl; ?>/js_newDesign/tabulous.min.js"></script>
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
