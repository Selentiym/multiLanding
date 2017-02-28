<?php
$base = Yii::app() -> baseUrl;
$baseTheme = Yii::app() -> theme -> baseUrl;
$baseRenderedTheme = Yii::app() -> themeManager -> getBaseUrl('__last');
Yii::app() -> getClientScript() -> registerScript('noEmptyGetParameters','
	$("form.noEmpty").submit(function() {
		$(this).find(":input").each(function(){
			var val = $(this).val();
			if ((val == "0")||(!val)) {
				$(this).attr("disabled","disabled");
			}
		});
	});
',CClientScript::POS_READY);
?>
<!DOCTYPE html>
<html class=" js no-touch">
<head>
	<!--[if lt IE 9]>
		<script type="text/javascript" src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!--<meta http-equiv="Cache-Control" content="no-cache">  Временный запрет кеширования. УБРАТЬ! -->

	<?php $cs = Yii::app()->getClientScript(); ?>
	<?php $cs -> registerCoreScript('jquery'); ?>
	<?php $cs -> registerCssFile($baseTheme.'/css/index_new.css'); ?>
	<?php $cs -> registerCssFile($baseTheme.'/css/common.css'); ?>
	
	<?php Yii::app()->getClientScript()->registerCssFile($baseTheme.'/css/select2.min.css'); ?>
	<?php Yii::app()->getClientScript()->registerScriptFile($baseTheme.'/js/select2.full.js'); ?>
	<?php
	$title = $this -> getPageTitle();
	$title = $title ? $title : Yii::app() -> name;
	?>
	
	<title><?php echo $title; ?></title>
	<link rel="icon" href="/favicon.ico" type="image/x-icon">
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
	
	
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
(function (d, w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter34545835 = new Ya.Metrika({id:34545835,
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
<!-- /Yandex.Metrika counter -->
	
	
</head>
<body>
	<div id="wrapper">
		<noscript><div><img src="//mc.yandex.ru/watch/34545835" style="position:absolute; left:-9999px;" alt="" /></div></noscript>

		<header>
			<div id="logo_cont"><a href="<?php echo Yii::app() -> baseUrl.'/'; ?>"><div id = "logo"></div></a></div>
			<div id="header_text">
				<div id="name">ВСЕ МРТ И КТ КЛИНКИ СПБ</div>
				<div id="words">Информационный портал медицинских услуг</div>
				<div id="long_hedaer_text">
					Здесь вы найдете полную информацию о медицинских услугах государственных<br/>
					учреждений города: врачи, лаборатории, реабилитационные центры, диагностика...<br/>
					Рейтинги, отзывы пациентов и многое другое.<br/>
					GOSCLINICA.RU - Ваш компас на карте медицинских услуг!
				</div>
			</div>
			<div id="tel_cont">
				<div id="tel_bold"><!--+7&nbsp;(812)&nbsp;309-9-209--></div>
				<div id="work_hours">режим работы 8<span class="up">00</span>-21<span class="up">00</span></div>
			</div>
			<div id="search">
	<!--<div class="ya-site-form ya-site-form_inited_no right_inner_header_block right big" onclick="return {'action':'http://cq97848.tmweb.ru/search','arrow':false,'bg':'transparent','fontsize':12,'fg':'#000000','language':'ru','logo':'rb','publicname':'Поиск по ...','suggest':true,'target':'_self','tld':'ru','type':2,'usebigdictionary':true,'searchid':2230691,'webopt':false,'websearch':false,'input_fg':'#000000','input_bg':'#ffffff','input_fontStyle':'normal','input_fontWeight':'normal','input_placeholder':'Введите запрос','input_placeholderColor':'#000000','input_borderColor':'#7f9db9'}">
				<form class="header_search_form">
					<input type="hidden" name="searchid" value="2230691"/>
					<input type="hidden" name="l10n" value="ru"/>
					<input type="hidden" name="reqenc" value=""/>
					<input type="search" placeholder="Поиск" name="text" value=""/>
					<input type="submit" value=""/>
				</form>
			</div>-->
			<div class="ya-site-form ya-site-form_inited_no right_inner_header_block right big"> <!--onclick="return {'action':'https://yandex.ru/search/site/','arrow':false,'bg':'transparent','fontsize':12,'fg':'#000000','language':'ru','logo':'rb','publicname':'gosclinica','suggest':true,'target':'_self','tld':'ru','type':2,'usebigdictionary':true,'searchid':2250420,'input_fg':'#000000','input_bg':'#ffffff','input_fontStyle':'normal','input_fontWeight':'normal','input_placeholder':'','input_placeholderColor':'#000000','input_borderColor':'#7f9db9'}">-->
				<form action="https://yandex.ru/search/site/" method="get" target="_self">
				<input type="hidden" name="searchid" value="2250420"/>
				<input type="hidden" name="l10n" value="ru"/>
				<input type="hidden" name="reqenc" value=""/>
				<input type="search" placeholder="Поиск" name="text" value=""/>
				<input type="submit" value=""/></form>
			</div>
			<script type="text/javascript">(function(w,d,c){var s=d.createElement('script'),h=d.getElementsByTagName('script')[0],e=d.documentElement;if((' '+e.className+' ').indexOf(' ya-page_js_yes ')===-1){e.className+=' ya-page_js_yes';}s.type='text/javascript';s.async=true;s.charset='utf-8';s.src=(d.location.protocol==='https:'?'https:':'http:')+'//site.yandex.net/v2.0/js/all.js';h.parentNode.insertBefore(s,h);(w[c]||(w[c]=[])).push(function(){Ya.Site.Form.init()})})(window,document,'yandex_site_callbacks');</script>
			</div>
		</header>
		<section class="content">

			<div class="content_block" id="search_block">
				<h2 class="heading" id="search_clinics">Поиск клиник</h2>
				<form id="searchForm" action="<?php echo $this -> createUrl('home/clinics',[],'&',true); ?>" class="noEmpty">
					<div class="row">

						<div class="speciality_dropdown select">
							<div class="image"><span></span></div>
							<div class="select_cont">
								<?php $specialities = CHtml::listData(ObjectPrice::model() -> findAll(),'verbiage','name'); ?>
								<?php CHtml::DropDownListChosen2('research','search_speciality', $specialities,array('placeholder' => 'Выберите исследование','empty_line' => 'Исследование'),array($_GET['research'])); ?>
							</div>
						</div>

						<div class="metro_dropdown select">
							<div class="image"><span></span></div>
							<div class="select_cont">
								<?php $metro_obj = Metro::model()->findAll(array('order' => 'name ASC')); ?>
								<?php CHtml::DropDownListChosen2('metro','search_metro', CHtml::listData($metro_obj, 'id', 'name'),array('placeholder' => 'Выберите метро','empty_line' => 'Метро'),array($_GET['metro'])); ?>
							</div>
						</div>
					</div>
					<div class="row">
						<a href="<?php echo $this -> createUrl('home/clinics',[],'&',true); ?>"><input type="button" value="Сбросить" class="search_submit"/></a>
						<input type="submit" value="Найти" class="search_submit"/>
					</div>
					<div class="row" id="triggers">
						<?php
							$this -> renderPartial('/triggers/_form');
						?>
					</div>
				</form>
			</div>
			<div id="main_content">
				<?php echo $content; ?>
			</div>
		</section>
		<footer>

		</footer>
	</div>
</body>
</html>