<?php
/**
 * @var Rule $model a Rule that worked now.
 * @var Rule $rule - the same, just alias.
 */
$rule = $model;
?>
<!DOCTYPE html>
<html lang="ru" >
<head>
    <meta charset="UTF-8">
    <meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />
    <meta content="telephone=no" name="format-detection">
    <title>МРТ</title>
	
	<link rel="icon" href="<?php echo Yii::app() -> baseUrl; ?>/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" href="<?php echo Yii::app() -> baseUrl; ?>/favicon.ico" type="image/x-icon" />
	
    <link rel="stylesheet" href="<?php echo Yii::app() -> baseUrl; ?>/css/simple.css">
    <link rel="stylesheet" href="<?php echo Yii::app() -> baseUrl; ?>/css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app() -> baseUrl; ?>/css/demo.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app() -> baseUrl; ?>/css/elastislide.css" />
    <!-- arcticModal -->
    <link rel="stylesheet" href="<?php echo Yii::app() -> baseUrl; ?>/css/styles2.css">
    <!-- jQuery -->
    <script src="js/jquery-1.8.2.min.js"></script>

    <script src="js/jquery.arcticmodal-0.2.min.js"></script>
    <link rel="stylesheet" href="<?php echo Yii::app() -> baseUrl; ?>/css/jquery.arcticmodal-0.2.css">

     <script>
		$(document).ready(function(){
			$('.dropdown').click(function(){
				$(this).children().each(function(ind, element){
					if ($(element).children('.pointer').length == 0) {
						$(element).toggle();
					}
				});
			});
		});
		
        (function($) {

            // DOM ready
            $(function() {




                $('.in_main-content-left').on('click', '.nav-click', function(){

                  
                    $(this).siblings('.nav-submenu').toggle(1000);
                });
               


            });

        })(jQuery);

</script>
    <script>
        $(document).ready(function(){

            $(".map_adres_hide .delete").click(function(){
                $(this).parents(".map_adres_hide").animate({ opacity: "hide" }, "slow");
            });

        });
    </script>
    <!-- arcticModal -->

    <!--[if lt IE 9]>
    <script>
        document.createElement('figure');
        document.createElement('figcaption');
    </script>
    <![endif]-->
    <link href="<?php echo Yii::app() -> baseUrl; ?>/css/timeTo.css" type="text/css" rel="stylesheet"/>
    <script src="js/modernizr.custom.17475.js"></script>
    <script>window.jQuery || document.write('<script src="js/jquery-1.8.min.js">\x3C/script>')</script>
	
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
(function (d, w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter34545880 = new Ya.Metrika({id:34545880,
                    webvisor:true,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true});
        } catch(e) { }
    });

    var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); };
    s.type = "text/javascript";
    s.async = true;
    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

    if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f, false);
    } else { f(); }
})(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="//mc.yandex.ru/watch/34545880" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
	
</head>
<body >
<div class="wrapper">
<div class="l-container">
    <ul>

        <li>

            <div class="g-hidden">
                <div class="box-modal" id="exampleModal1">
                    <div class="box-modal_close arcticmodal-close">закрыть</div>
					
                    <div class="form">
					
                        <form action="<?php echo Yii::app() -> baseUrl;?>/post" method="POST">
							
                            <img src="<?php echo Yii::app() -> baseUrl; ?>/img/fio.png" class="form_fio" alt="fio"><input type="text" name="name" required placeholder="Ваше ФИО"><br>
                            <img class="form_mobile" src="<?php echo Yii::app() -> baseUrl; ?>/img/mobile.png" alt="mobile"><input type="text" name="name2" required placeholder="Ваш телефон"><br>
                            <span style="font-size:9px;color:red;display:block;padding-left:10px;text-align:center;width:50%;float:left;padding-top:14px;margin-left:-10px;">    Вам перезвонят в течении 15 минут!</span><button type="submit" class="pointer"><img src="<?php echo Yii::app() -> baseUrl; ?>/img/submit.png" alt="submit"></button>
                        </form>
                    </div>
                </div>
            </div>
        </li>

    </ul>
</div>

<div class="l-container">
    <ul>

        <li>

            <div class="g-hidden">
                <div class="box-modal" id="exampleModal2">
                    <div class="box-modal_close arcticmodal-close">закрыть</div>
                    <div class="form">
                        <form action="<?php echo Yii::app() -> baseUrl;?>/post" method="POST">
                            <img src="<?php echo Yii::app() -> baseUrl; ?>/img/fio.png" class="form_fio" alt="fio"><input type="text" name="name" required placeholder="Ваше ФИО"><br>
                            <img class="form_mobile" src="<?php echo Yii::app() -> baseUrl; ?>/img/mobile.png" alt="mobile"><input type="text" name="name2" required placeholder="Ваш телефон"><br>
                             <span style="font-size:9px;color:red;display:block;padding-left:10px;text-align:center;width:50%;float:left;padding-top:14px;margin-left:-10px;">    Вам перезвонят в течении 15 минут!</span><button type="submit" class="pointer"><img src="<?php echo Yii::app() -> baseUrl; ?>/img/submit.png" alt="submit"></button>
                        </form>
                    </div>
                </div>
            </div>
        </li>

    </ul>
</div>

        <header id="block">
        <div class="in_header">

            <div class="menu">
                <ul>

					
                    <li><a href="#price" >Цены</a></li>
                    <li><a href="#oborud">Оборудование</a></li>
                    <li><a href="#doctora">Врачи</a></li>
                    <!--<li><a href="#centru" >Центры</a></li>-->
                    <li><a href="#vopros">Ответы и вопросы</a></li>
					<li class="zapis_modal" id="#example1" onclick="$('#exampleModal1').arcticmodal()"><span class="m-dotted" ></span></li>

                </ul>
                <a href="#" id="pull"></a>

            </div>
            </div>

        </header>
        <div class="clear"></div>
        <div class="obchestvo" >

            <div class="logo_left">


                <div class="phone">
                    <h2>МРТ <span style="text-transform:none;">и</span> КТ ЦЕНТРЫ ВО ВСЕХ РАЙОНАХ САНКТ-ПЕТЕРБУРГА</h2>

                    <div class="number" id="#example2" onclick="$('#exampleModal2').arcticmodal()">
                        <p ><?php echo $model -> tel -> tel; ?></p>
                        <a  class="pointer" style="text-decoration: none">Заказать обратный звонок</a>
                        <p>Перезвоним в течение 15 минут!</p>
                    </div>
                </div>

            </div>

            <div class="logo_right">
                <img src="<?php echo Yii::app() -> baseUrl; ?>/img/slugba.png" alt="slugba" class="slugba" >
                <div class="akciy">
                    <p><?php echo $model -> price -> text.' '. $model -> price -> price.'р'; ?></p>

                </div>
                <h1 class="zagolovok">МРТ в Санкт-Петербурге от 1500р.</h1>

            </div>

        </div>
        <div class="clear"></div>
        <div class="srochno">
            <div class="in_srochno">
                <ul>
                    <li><a >МРТ СРОЧНО</a></li>
                    <li><a >МРТ НОЧЬЮ</a></li>
                    <li><a >ОПЫТ РАБОТЫ 24года</a></li>
                    <li><a href="#akcii">СКИДКИ АКЦИИ</a></li>
                    <li><a >БЕСПЛАТНАЯ КОНСУЛЬТАЦИЯ ВРАЧА</a></li>
                </ul>
            </div>
        </div>

        <div class="clear"></div>

        <div class="main-content">
            <div class="main-content-left">
                <div class="in_main-content-left">
                    <?php
                        if (is_a($rule -> section,'Section')) {
                            $this->renderPartial('//subs/_section', array('section'=> $rule -> section, 'rule' => $rule));
                        }


                        foreach(Section::model() -> findAll(array('order' => 'num ASC')) as $section){
                            if ($section -> id == $rule -> section -> id) {
                                continue;
                            }
                            $this->renderPartial('//subs/_section', array('section' => $section, 'rule' => $rule));
                        }
                    ?>
                 </div>
            </div>

            <div class="main-content-right">
                <h2>ОТЗЫВЫ ЗНАМЕНИТЫХ ГОСТЕЙ</h2>
                <div class="avtor">
                    <img src="<?php echo Yii::app() -> baseUrl; ?>/img/kazankina.jpg" alt="avtor" width="100">
                    <p>
					<span style="font-style: italic;font-family:arial;font-weight:bold;">ТАТЬЯНА КАЗАНКИНА, советская легкоатлетка, трехкратная Олимпийская чемпионка, рекордсменка мира и Олимпийских игр.</span><br>
					"Самые замечательные впечатления от посещения клиники. Здесь работают внимательные, добрые, грамотные специалисты. С ними хочется поделиться своими проблемами, рассказать о своих бедах.

					Большое спасибо Елене Юрьевне Карабан, с таким человеком хочется беседовать и делиться всем, она все расскажет доступно для пациента, посоветует что и как нужно сделать лучшим образом. Большое спасибо всему персоналу. Ведь очень приятно, когда к тебе внимательны и доброжелательны."
                    </p>
                </div>
                <div class="avtor">
                     <img src="<?php echo Yii::app() -> baseUrl; ?>/img/tihomir.jpg" alt="avtor" width="100">
                    <p>
					<span style="font-style: italic;font-family:arial;font-weight:bold;">ВИКТОР ТИХОМИРОВ, художник известной группы "Митьки", кинорежиссер, писатель, сценарист</span><br>
					"Приятное впечатление от посещения вашего центра, как этическое, так и эстетическое.
					Особливо обаятельное впечатление от терапевта Елены Юрьевны Карабан. Привет ей.

					Успехов в деле и исцеления болящих."
                    </p>
                </div>
                <div class="avtor">
                    <img src="<?php echo Yii::app() -> baseUrl; ?>/img/svetlana.jpg" alt="avtor" width="100">
                    <p>
					<span style="font-style: italic;font-family:arial;font-weight:bold;">СВЕТЛАНА ПИСЬМИЧЕНКО, российская актриса кино и театра, заслуженная артистка Российской Федерации</span><br>
					"Я очень благодарна сотрудникам центра, за предоставленную мне возможность узнать о состоянии своего здоровья. В нашей актерской профессии мы подвергаем себя бесконечным стрессам, переездам, гастролям, съемкам и иногда не задумываемся, а что же завтра... Здесь очень приятный персонал, внимательные и доброжелательные врачи и высокого уровня диагностика.

					В бесконечной суете дней особенно люди творческих профессий забывают - что здоровье и прекрасное самочувствие - это залог успеха, удачи и долгой, трудоспособной жизни. И наступает час пик - когда нужно сказать - стоп - и пойти на обследование. Я пришла сюда, привела своих детей - и буду рекомендовать Вас друзьям. Спасибо Всем и будьте здоровы!"
                    </p>
                </div>
                <div class="avtor">
                    <img src="<?php echo Yii::app() -> baseUrl; ?>/img/okorokov.jpg" alt="avtor" width="100">
                    <p>
					<span style="font-style: italic;font-family:arial;font-weight:bold;">ОКОРОКОВ ВАСИЛИЙ РОМАНОВИЧ, Профессор СПбГПУ, доктор экономических наук заведующий кафедрой "Международных экономических отношений"</span><br>
					Первое впечатление, которое создалось - попали в настоящий медицинский рай! Такое впечатление ещё более усилилось, познакомившись с современным оборудованием центра и крайне внимательным отношением врачей и сотрудников центра. 
  
					Желаю вам, дорогие коллеги, доброго здоровья и создания медицинского благополучия для всех людей нашей страны. 
					С благодарностью и искренним уважением В.Р. и Л.Г. Окороковы, профессора СПБГПУ.
                    </p>
                </div>
                
				<h2>ОТЗЫВЫ</h2>
                <div class="avtor">
                    <p style="text-align:center;"><span style="font-style: italic;font-family:arial;font-weight:bold;text-align:center;">Аксиновская Светлана Сергеевна<br>27/10/2015</span></p>
                    <p><br>Спасибо Вашей клинике за высокий уровень профессионализма, желание помочь и неравнодушие! Особая благодарность Рузановой Ирине Николаевне. Своим друзьям и близким могу рекомендовать только Вашу клинику.  
                    </p>
                </div>
                <div class="avtor">
                    <p style="text-align:center;"><span style="font-style: italic;font-family:arial;font-weight:bold;text-align:center;">Григорьева Екатерина Николаевна
					<br>21/10/2015</span></p>
                    <p><br>Великолепный медицинский центр! Попала случайно, страховая направила сделать мрт.  Все быстро, качественно, комфортно, без утомительных очередей в регистратуру и поисков карточки. После первого знакомства стала ходить к вам, хотя раньше лечилась в клинике РАМН. Пока всем очень довольна. Хочу отметить профессионализм лора Дежневой Е.В., такого целостного подхода к проблеме я давно не встречала. Очень профессиональный и доброжелательный мануальный терапевт Канкулов В.Ж., замечательная массажист Зарезина С.В.
					Отдельное спасибо за детскую комнату, это очень выручает. Рекомендую вашу клинику всем своим знакомым. 
                    </p>
                </div>
				
				<div class="avtor">
                    <p style="text-align:center;"><span style="font-style: italic;font-family:arial;font-weight:bold;text-align:center;">Добавил  Жуды
					<br>07/10/2015</span></p>
                    <p><br>Специально прилетаю из Казахстана делать МРТ лично у профессора Холина. Знаю, так многие у нас делают, Доверяют только ему. Встречала на его приеме пациентов и из других бывших республик,а также из дальнего зарубежья. Авторитет его очень высокий. Многие наши специалисты его ученики.
                    </p>
                </div>
                <div class="avtor">
                    <p style="text-align:center;"><span style="font-style: italic;font-family:arial;font-weight:bold;text-align:center;">Иванова Александра
					<br>03/09/2015</span></p>
                    <p><br>Внимательный, сочувствующий и, главное, профессиональный и не равнодушный доктор Ольга Кротова - это главное, что привлекает в вашу клинику.
					Ее помощница - доброжелательная, симпатичная и грамотная Ирина Климовцева дополняет достоинства доктора. Отличные специалисты.
					Девушек на ресепшне, вполне вежливых и терпеливых стоит, может быть, обучить подробностям подготовки в зависимости от ситуации. В целом клиника хорошего уровня. Буду обращаться снова.
                    </p>
                </div>
                <div class="avtor">
                    <p style="text-align:center;"><span style="font-style: italic;font-family:arial;font-weight:bold;text-align:center;">Пьянкова Галина Николаевна
					<br>10/09/2015</span></p>
                    <p><br>Был очень приятно удивлен прекрасной организацией сопровождения пациентов и широким спектром комплексных диагностических программ. Особую благодарность выражаю старшему администратору reception Татьяне Ляшок, благодаря которой я прошел индивидуальное обследование и лечение в Вашей Клинике в максимально сжатые сроки, в очень удобном для меня графике и комфортной обстановке, как в эмоциональном, так и в физическом плане. Несмотря на то, что постоянно живу в другой европейской стране, за обследованием и лечением я буду обращаться только в Вашу Клинику и буду рекомендовать Вас своим знакомым и друзьям.
                    </p>
                </div>
                <div class="avtor">
                    <p style="text-align:center;"><span style="font-style: italic;font-family:arial;font-weight:bold;text-align:center;">Разина Я.В.
					<br>01/09/2015</span></p>
                    <p><br>Я, Разина Яна Владимировна, хочу выразить огромную благодарность всем докторам которые в короткий срок смогли обнаружить мою проблему со здоровьем! Персонал очень отзывчивый и дружелюбный, Особую благодарность хотела передать врачу (лечащему) Осташкову А.В., мануальной т. Юсупжанову В.И., эндокринологу Надеждиной Э.А., психотерапевту Алесе Викторовне и всем врачам ЛОР. Спасибо вам огромное!!! За ваш нелегкий  руд!!! 
                    </p>
                </div>
				<div class="avtor">
                    <p style="text-align:center;"><span style="font-style: italic;font-family:arial;font-weight:bold;text-align:center;">Волохова С.В.
					<br>21/08/2015</span></p>
                    <p><br>Приношу вам сердечную, человеческую благодарность! Благодаря вашему профессионализму, чуткому пониманию проблемы пациента, внимательному отношению и терпению, я спокойна за свое здоровье. Отдельно хотела бы поблагодарить кардиолога Хихелову Елену Олеговну. Записавшись на прием, получила подробную консультацию по своей проблеме, сразу же сделали КT и назначили своевременное лечение. Самочувствие мое улучшилось, а через неделю, на повторном приеме была отмечена положительная динамика моего состояния. 
					Так же хочется отметить внимательное отношение сотрудников колл-центра и ресепшн — всегда напомнят о приеме, встретят, проводят до кабинета, готовы помочь, очень вежливы и обходительны. 
                    </p>
                </div>
				<div class="avtor">
                    <p style="text-align:center;"><span style="font-style: italic;font-family:arial;font-weight:bold;text-align:center;">Румянцев О. С.
					<br>11/08/2015</span></p>
                    <p><br>Хочется оставить положительный отзыв о докторе И.И. Гелетее (гастроэнтеролог). Первый раз встречаю доктора, который в высшей степени внимателен ко всем жалобам, отзывам пациента. Всегда откликается на любое пожелание. Всегда находится в хорошем настроении и подбадривает пациента. Впредь буду посещать ТОЛЬКО Гелетея И.И. и советовать его всем знакомым.
                    </p>
                </div>
				<div class="avtor">
                    <p style="text-align:center;"><span style="font-style: italic;font-family:arial;font-weight:bold;text-align:center;">Полякова М.И
					<br>07/08/2015</span></p>
                    <p><br>Пожелания: оставайтесь на той же волне, волне позитива и понимания пациента, продолжайте разговаривать с нами (пациентами) на понятном нам языке, в этом Вам нет пока равных. 10 из 10. Желаю я и моя семья Вам процветания, теперь я буду Вас рекомендовать всем моим знакомым и родственникам. Да, у Вас дорого, но оно того стоит, я ни о чем не жалею. Теперь я на ногах и полон сил. Сердечно благодарен всем врачам и мед персоналу. Спасибо большое.
                    </p>
                </div>
				<div class="avtor">
                    <p style="text-align:center;"><span style="font-style: italic;font-family:arial;font-weight:bold;text-align:center;">Нижегородова Ольга Викторовна
					<br>23/07/2015</span></p>
                    <p><br>Мои близкие родственники являются постоянными пациентами Вашей Клиники. Я хотел бы выразить благодарность доктору Капитоновой Н.В. за четкий и оперативный диагноз, доктору Клочко Р.В. за заботу и внимание, а так же сотрудникам контактного центра, за оперативную работу и предоставление четкой информации по всем моим вопросам.
                    </p>
                </div>
				<div class="avtor">
                    <p style="text-align:center;"><span style="font-style: italic;font-family:arial;font-weight:bold;text-align:center;">Котович О.И. Ген. дир. ООО «Завод Северная Венеция»
					<br>27/07/2015</span></p>
                    <p><br>Хочу выразить благодарность сотрудникам отдела ресепшн за внимательное, доброе отношение к пациентам, организованность, особенно Кристине Соболевой. Особая благодарность доктору Ирине Леонидовне за высокий профессионализм, отзывчивость и чуткость.
                    </p>
                </div>
				<div class="avtor">
                    <p style="text-align:center;"><span style="font-style: italic;font-family:arial;font-weight:bold;text-align:center;">Колпакова Людмила Ивановна
					<br>25/07/2015</span></p>
                    <p><br>Хочу выразить огромную благодарность и сказать большое спасибо сотруднику контактного центра Мурскому Дмитрию за быструю организацию записи и предоставление всех необходимых услуг моей матери. Всё было сделано молниеносно, несмотря на то, что мы были очень сжаты в сроках. Отдельно хочется отметить высокопрофессиональных врачей Маковскую А.И. и Капитонову Н.В. Весь процесс, начиная со звонка, записи на прием, и заканчивая получением необходимой помощи, прошел очень гладко и профессионально. Все просто молодцы!
                    </p>
                </div>
				<div class="avtor">
                    <p style="text-align:center;"><span style="font-style: italic;font-family:arial;font-weight:bold;text-align:center;">Добавил  Наталья

					<br>17/07/2015</span></p>
                    <p><br>Обследовалась у профессора по совету своего лечащего врача. И не пожалела. Можно было рядом с домом, но это совсем не то. Профессор знает, что надо моему доктору. Сравнивает с предыдущими снимками. Видит многое, что другим неясно. Не акцентирует на несущественном. Заключение понятно.
                    </p>
                </div>
				<div class="avtor">
                    <p style="text-align:center;"><span style="font-style: italic;font-family:arial;font-weight:bold;text-align:center;">Б. В.А.

					<br>12/07/2015</span></p>
                    <p><br>Атмосфера в клинике, начиная с встречи на ресепшен и заканчивая приемом врача, напоминает клиники Германии. Это очень приятно, и вызывает неосознанное чувство доверия. Была удивлена этому островку европейской медицины.
                    </p>
                </div>
				<!--<div class="avtor">
                    <p style="text-align:center;"><span style="font-style: italic;font-family:arial;font-weight:bold;text-align:center;">А. Ольга Викторовна

					<br>03/07/2015</span></p>
                    <p><br>Администраторам Рите и Надежде выражаю Огромную благодарность за терпение при общении с больными клиентами. Спасибо им большое!
                    </p>
                </div>-->
				<!--<div class="avtor">
                    <p style="text-align:center;"><span style="font-style: italic;font-family:arial;font-weight:bold;text-align:center;">Семья О.

					<br>03/07/2015</span></p>
                    <p><br>Пациент и его супруга благодарят администраторов reception (Ляшок Татьяну и Кудрину Надежду) за внимание, оперативное решение всех вопросов и позитивное общение. Встречаемся с ними не первый раз и всегда получаем ответы на все наши просьбы и вопросы с улыбкой и радушием.
                    </p>
                </div>-->
            </div>
        </div>




		<footer>
        <div class="in_footer">
            
            <div class="menu_footer">
                <ul>
                    <li>
                        <a href="#vopros">Ответы и вопросы</a>
                    </li>
					<!--<li>
                        <a href="#centru" >Центры</a>
                    </li>
                    uncoment!
                    -->
					<li>
                        <a href="#doctora">Врачи</a>
                    </li>
					<li>
                        <a href="#oborud">Оборудование</a>
                    </li>
                    <li>
                        <a href="#price" >Цены</a>
                    </li>
                </ul>
               
            </div>

        </div>
        </footer>
</div>
        <script>
			$(document).ready(function(){
				$('.map_clinic_marker').click(function(){
					$('.map_clinic_marker').not($(this)).parent().children('.map_clinic_description').hide(1000);
					$(this).parent().children('.map_clinic_description').toggle(1000);
				});
			});
			function changeCursor(){
				return false;
			var x = y = 0;
                var event = event || window.event;

                // Получаем координаты клика по странице, то есть абсолютные координаты клика.

                if (document.attachEvent != null) { // Internet Explorer & Opera
                    x = window.event.clientX + (document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft);
                    y = window.event.clientY + (document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop);
                } else if (!document.attachEvent && document.addEventListener) { // Gecko
                    x = event.clientX + window.scrollX;
                    y = event.clientY + window.scrollY;
                }

                //Определяем границы объекта, в нашем случае картинки.

                y0=document.getElementById("kartina").offsetTop;
                x0=document.getElementById("kartina").offsetLeft;

                // Пересчитываем координаты и выводим их алертом.

                x = x-x0;
                y = y-y0;
				
				//alert(x+'|'+y);
				
				if(x > 220 && x < 250){
                   document.body.style.cursor = 'pointer';
					//alert(x+'|'+y);
                        
                }else
                    if (x > 270 && x < 300 && y > 130 && y < 160){
                     document.body.style.cursor = 'pointer';
                 }else
                    if (x > 120 && x < 155 && y > 360 && y < 400){
                        document.body.style.cursor = 'pointer';
                 }else
                    if (x > 200 && x < 225 && y > 62 && y < 90){
                       document.body.style.cursor = 'pointer';
                 }else
                    if (x > 180 && x < 205 && y > 250 && y < 275){
                        document.body.style.cursor = 'pointer';
                 }else
                    if (x > 146 && x < 170 && y > 224 && y < 250){
                        document.body.style.cursor = 'pointer';
				}else
                    if (x > 105 && x < 130 && y > 165 && y < 190){
                       document.body.style.cursor = 'pointer';
				}else
                    if (x > 95 && x < 120 && y > 155 && y < 180){
                       document.body.style.cursor = 'pointer';
				}else
                    if (x > 160 && x < 185 && y > 130 && y < 155){
                        document.body.style.cursor = 'pointer';
				}else {document.body.style.cursor = 'default';}

				
			};
			 </script>
			 <script>
            function defPosition(event) {
				return false;
                var x = y = 0;
                var event = event || window.event;

                // Получаем координаты клика по странице, то есть абсолютные координаты клика.

                if (document.attachEvent != null) { // Internet Explorer & Opera
                    x = window.event.clientX + (document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft);
                    y = window.event.clientY + (document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop);
                } else if (!document.attachEvent && document.addEventListener) { // Gecko
                    x = event.clientX + window.scrollX;
                    y = event.clientY + window.scrollY;
                }

                //Определяем границы объекта, в нашем случае картинки.

                y0=document.getElementById("kartina").offsetTop;
                x0=document.getElementById("kartina").offsetLeft;

                // Пересчитываем координаты и выводим их алертом.

                x = x-x0;
                y = y-y0;

               //alert(x+'|'+y);

                var t = document.getElementById('map_adres1');
                var g = document.getElementById('map_adres2');
                var u = document.getElementById('map_adres3');
                var p = document.getElementById('map_adres6');
                var l = document.getElementById('map_adres5');
                var w = document.getElementById('map_adres4');
				var yi = document.getElementById('map_adres7');
				var map8 = document.getElementById('map_adres8');
				var map9 = document.getElementById('map_adres9');
				var map10 = document.getElementById('map_adres10');
				var map10_2 = document.getElementById('map_adres10_2');
				var map11 = document.getElementById('map_adres11');
                if(x > 220 && x < 250 && y > 154 && y < 210){
                    if(t.style.display =='block')
                        {t.style.display = 'none'}
                            else{t.style.display ='block'}
                }/*else
                    if (x > 140 && x < 170 && y > 50 && y < 80){
                        if(g.style.display =='block')
                        {g.style.display = 'none'}
                        else{g.style.display ='block'}
                 } */else
                    if (x > 270 && x < 300 && y > 130 && y < 160){
                      /* document.body.style.cursor = 'pointer';*/
					   if(u.style.display =='block')
                        {u.style.display = 'none'}
                        else{u.style.display ='block'}
                 }else
                    if (x > 120 && x < 155 && y > 360 && y < 400){
                        if(p.style.display =='block')
                        {p.style.display = 'none'}
                        else{p.style.display ='block'}
                 }/*else
                    if (x > 45 && x < 75 && y > 330 && y < 360){
                        if(l.style.display =='block')
                        {l.style.display = 'none'}
                        else{l.style.display ='block'}}*/
				/*else
                    if (x > 250 && x < 280 && y > 300 && y < 340){
                        if(w.style.display =='block')
                        {w.style.display = 'none'}
                        else{w.style.display ='block'}
                 }*/else
                    if (x > 200 && x < 225 && y > 62 && y < 90){
                        if(yi.style.display =='block')
                        {yi.style.display = 'none'}
                        else{yi.style.display ='block'}
                 }else
                    if (x > 180 && x < 205 && y > 250 && y < 275){
                        if(map8.style.display =='block')
                        {map8.style.display = 'none'}
                        else{map8.style.display ='block'}
                 }else
                    if (x > 146 && x < 170 && y > 224 && y < 250){
                        if(map9.style.display =='block')
                        {map9.style.display = 'none'}
                        else{map9.style.display ='block'}
				}else
                    if (x > 105 && x < 130 && y > 165 && y < 190){
                        if(map10_2.style.display =='block')
                        {map10_2.style.display = 'none'}
                        else{map10_2.style.display ='block'}
				}else
                    if (x > 95 && x < 120 && y > 155 && y < 180){
                        if(map10.style.display =='block')
                        {map10.style.display = 'none'}
                        else{map10.style.display ='block'}
				}else
                    if (x > 160 && x < 185 && y > 130 && y < 155){
                        if(map11.style.display =='block')
                        {map11.style.display = 'none'}
                        else{map11.style.display ='block'}
				}


               /*if (x > 250 && x < 280 && y > 300 && y < 340){
                    alert('da6!');
                }*/


            }
        </script>


        <script type="text/javascript" src="js/jquerypp.custom.js"></script>
        <script type="text/javascript" src="js/jquery.elastislide.js"></script>
        <script type="text/javascript">

            $( '#carousel' ).elastislide();

        </script>
        <script>
        //Адаптация меню
        $(function() {
            var pull 		= $('#pull');
            menu 		= $('.menu ul');
            menuHeight	= menu.height();

            $(pull).on('click', function(e) {
                e.preventDefault();
                menu.slideToggle();
            });

            $(window).resize(function(){
                var w = $(window).width();
                if(w > 320 && menu.is(':hidden')) {
                    menu.removeAttr('style');
                }
            });
        });
    </script>
        <script>window.jQuery || document.write('<script src="js/jquery-1.11.2.min.js"><\/script>')</script>


<script>

    var s = document.getElementById('read_more_child')
    function formShow(){
        if(s.style.display =='block'){s.style.display = 'none'} else{s.style.display ='block'}
    }
</script>
<script>

    var z = document.getElementById('more_child1')
    function formShow2(){
        if(z.style.display =='block'){z.style.display = 'none'} else{z.style.display ='block'}
    }

	 var sh = document.getElementById('more_child1')
    function formShow2(){
        if(sh.style.display =='block'){sh.style.display = 'none'} else{sh.style.display ='block'}
    }
	
    var r = document.getElementById('more_child2')
    function formShow3(){
        if(r.style.display =='block'){r.style.display = 'none'} else{r.style.display ='block'}
    }
</script>

<script>



    window.onscroll = function(){

        var html = document.documentElement, body = document.body;

        var BlkStyle = document.getElementById('block').style;

        if(html.scrollTop>100||body.scrollTop>100) { //alert()

            BlkStyle.position="fixed";



        } else BlkStyle.position="relative";

    }

</script>


</body>
</html>