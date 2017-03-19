<?php
/**
 * @type clinics|doctors $model
 * @type HomeController $this
 */
$this->setPageTitle($model->title);
Yii::app() -> getClientScript() -> registerMetaTag($model -> description,'description');
Yii::app() -> getClientScript() -> registerMetaTag($model -> keywords,'keywords');
$modelName = get_class($model);
$data = $_GET;

$info = $this -> renderPartial('/clinics/_info', array('clinic' => $model),true);


$cs = Yii::app()->getClientScript();
$cs -> registerCoreScript('font-awesome');
$cs->registerCssFile(Yii::app()->theme->baseUrl.'/css/objects_list.css');
$cs->registerCssFile(Yii::app()->theme->baseUrl.'/css/clinicsView.css');
$cs->registerCssFile(Yii::app()->theme->baseUrl.'/css/rateit.css?' . time());
$cs->registerScriptFile(Yii::app()->theme->baseUrl.'/js/map.js');
$cs -> registerScriptFile("https://api-maps.yandex.ru/2.1/?lang=ru_RU");
$cs->registerScriptFile(Yii::app()->theme->baseUrl.'/js/jquery.rateit.min.js?' . time());
$cs->registerScriptFile("https://docdoc.ru/widget/js", CClientScript::POS_BEGIN);
$cs -> registerScript('Rate','Rate()',CClientScript::POS_READY);
$cs -> registerScript('Order','
	$("#sortby a").click(function(e){
		
		$("#sortByField").val($(this).attr("sort"));
		$("#searchForm").submit();
		return false;
	});
	myMap = false;
',CClientScript::POS_READY); 
 $cs -> registerScript('Insets','
	$("#personal_object_cont .menu  .item").click(function(){
		$("#personal_object_cont .menu  .item").each(function(){
			$("#"+$(this).attr("data-word")).css("display","none");
			$(this).removeClass("active");
		});
		$(this).addClass("active");
		$("#"+$(this).attr("data-word")).css("display","block");
	});
',CClientScript::POS_READY); 
 $cs -> registerScript('show_hide','
	var cont;
	$(".show").click(function(){
		$(this).hide();
		$(this).parent().children(".full").show();
		$(this).parent().children(".short").hide();
		$(this).parent().children(".hide").show();
		var cont = $(this).parents(".single_review");
		cont.saveHeight = cont.css("max-height");
		cont.css("max-height","none");
		//$(this).parent().css("max-height","none");
		
	});
	$(".hide").click(function(){
		$(this).parent().children(".full").hide();
		$(this).parent().children(".short").show();
		$(this).hide();
		$(this).parent().children(".show").show();
	});
',CClientScript::POS_READY); 

	$adress = $model -> address;
	//$adress = "Санкт-петербург, проспект металлистов, 25к1";
	//$key = "ключ апи яндекс карт";
	$found = array();
	if (trim($adress)) {
		$adress1=urlencode($adress);
		$url="http://geocode-maps.yandex.ru/1.x/?geocode=".$adress1;//."&key=".$key;
		//echo $url;
		$content=file_get_contents($url);
		//echo $content;
		preg_match('/<pos>(.*?)<\/pos>/',$content,$point);
		preg_match('/<found>(.*?)<\/found>/',$content,$found);
	}
	if (trim(next($found)) > 0) {
		$coordinaty=explode(' ',trim(strip_tags($point[1])));
		
		$cs -> registerScript('mapAct','
			addCoords(['.$coordinaty[1].', '.$coordinaty[0].'],"'.$model -> name.', '.$adress.'");
		',CClientScript::POS_READY);
	} else {
		$cs -> registerScript('mapAct','
			$("#map").html("Не удалось найти местоположение заправшиваемого объекта. Пожалуйста, сообщите о данной ошибке в техподдержку сайта. Адрес: '.$adress.'.");
		',CClientScript::POS_READY);
	}


	//$this -> renderPartial('//home/searchForm', array('filterForm' => $filterForm, 'modelName' => $modelName, 'fromPage' => $fromPage,'page' => $page));
?>
<div class="h-card">
<div class="content_block" id="personal_object_cont">
	<div id="links">
		<a href="<?php echo $this -> createUrl('/'); ?>">Главная</a>
		<a href="<?php echo $this -> createUrl('home/clinics');?>"><?php echo $modelName == "clinics" ? 'Клиники' : 'Врачи' ; ?></a>
		
		
		<a href="#"><?php echo $model -> name; ?></a>
	</div>
	<div class="main_part">
		<div class="left_side">
			<div class="image_cont">
				<img class="u-logo" src="<?php echo $model -> giveImageFolderRelativeUrl() . $model -> logo;?>" alt="<?php echo $model->name; ?>"/>
			</div>
		</div>
		<div class="center">
			<h2 class="name object_name p-name"><?php echo $model -> name; ?></h2>
			<div class="rateit" data-rateit-value="<?php echo $model->rating; ?>" data-rateit-ispreset="true" data-rateit-readonly="true"></div>
			<div class="object_text">
				<?php echo $model -> text; ?>
			</div>
			<div class="small_info list-group">
				<?php
				$verb = 'finance';
				if ($temp = $model -> getFirstTriggerValueString($verb)) : ?>
					<div class="time list-group-item">
						<i class="fa fa-clock-o fa-lg fa-fw" aria-hidden="true"></i>&nbsp;
						<div class="text"><?php echo ($data[$verb] ? '<b>' : ''). $temp . ($data[$verb] ? '</b>' : ''); ?></div>
					</div>
				<?php endif; ?>

				<?php if ($model -> working_hours) : ?>
				<div class="time list-group-item">
					<i class="fa fa-clock-o fa-lg fa-fw" aria-hidden="true"></i>&nbsp;
					<div class="text"><?php echo $model -> working_hours; ?></div>
				</div>
				<?php endif; ?>

				<?php if ($model -> address) : ?>
				<div class="address list-group-item">
					<i class="fa fa-map-marker fa-lg fa-fw" aria-hidden="true"></i>&nbsp;
					<div class="text p-adr"><?php echo $model -> address; echo " (".implode(', ',array_filter(array_map(function($id){
									return Districts::model() -> findByPk($id) -> name;
								},explode(';',$model -> district))));?>)</div>
				</div>
				<?php endif; ?>

				<?php
				$verb = 'district';
				if ($temp = $model -> getFirstTriggerValueString($verb)) : ?>
					<div class="time list-group-item">
						<i class="fa fa-clock-o fa-lg fa-fw" aria-hidden="true"></i>&nbsp;
						<div class="text"><?php echo ($data[$verb] ? '<b>' : ''). $temp . ($data[$verb] ? '</b>' : ''); ?></div>
					</div>
				<?php endif; ?>

				<?php
				$verb = 'metro';
				if ($model -> metro_station) : ?>
					<div class="time list-group-item">
						<i class="fa fa-clock-o fa-lg fa-fw" aria-hidden="true"></i>&nbsp;
						<div class="text">
							<?php
								if ($data[$verb]) {
									list($lat, $long) = $model -> getCoordinates();
									echo "<b>";
									$m = Metro::model() -> findByAttributes(['id' => $data[$verb]]);
									echo $m -> display($lat, $long);
									echo "</b>";
								} else {
									echo $model -> getSortedMetroString();
								}
							?>
						</div>
					</div>
				<?php endif; ?>

				<?php if ($model -> phone) : ?>
				<div class="phone list-group-item">
					<i class="fa fa-mobile fa-lg fa-fw" aria-hidden="true"></i>&nbsp;
					<div class="text p-adr"><?php echo $model -> phone; ?></div>
				</div>
				<?php endif; ?>
				<?php if ($model -> mrt) : ?>
				<div class="tomogrMrt list-group-item">
					<i class="fa fa-life-ring fa-lg fa-fw" aria-hidden="true"></i>&nbsp;
					<div class="text p-adr"><?php echo $model -> mrt; ?></div>
				</div>
				<?php endif; ?>
				<?php if ($model -> kt) : ?>
				<div class="tomogrKt list-group-item">
					<i class="fa fa-navicon fa-lg fa-fw" aria-hidden="true"></i>&nbsp;
					<div class="text p-adr"><?php echo $model -> kt; ?></div>
				</div>
				<?php endif; ?>
				<?php if ($model -> site) : ?>
				<div class="tomogrKt list-group-item">
					<i class="fa fa-link fa-lg fa-fw" aria-hidden="true"></i>&nbsp;
					<div class="text p-adr"><?php echo $model -> site; ?></div>
				</div>
				<?php endif; ?>
				<?php if ($model -> experience) : ?>
				<div class="tomogrKt list-group-item">
					<i class="fa fa-line-chart fa-lg fa-fw" aria-hidden="true"></i>&nbsp;
					<div class="text p-adr">Существует <?php echo $model -> experience; ?> лет</div>
				</div>
				<?php endif; ?>
			</div>
			<div class="assign_cont objects_cont">
				<!--<div class="assign"><a href="<?php echo  Yii::app() -> baseUrl;?>/assign"><span>Записаться на прием</span></a></div>-->
				<div id="<?php echo $id; ?>"></div>
				<!--<div class="number"><div class="tel_img"></div><div class="tel_number">Запись по телефону: <span class="p-tel"><?php echo $model -> phone; ?></span></div></div>-->
			</div>
		</div>
		<div class="right_side">
			<div id="map"></div>
		</div>
	</div>
	<div class="menu">
		<?php if (count($model -> doctors)): ?>
		<div data-word="doctors_list" class="item <?php echo ($word == 'main') ? 'active' : '' ; ?>">Доктора <span class="amount">(<?php echo count($model -> doctors); ?>)</span></div>
		<?php endif; ?>
		<?php if ($info): ?>
		<div data-word="info" class="item <?php echo ($word == 'info') ? 'active' : '' ; ?>">О клинике</div>
		<?php endif; ?>
		<div data-word="prices" class="item <?php echo ($word == 'prices') ? 'active' : '' ; ?>">Цены</div>
<!--		<div data-word="reviews" class="item --><?php //echo ($word == 'reviews') ? 'active' : '' ; ?><!--">Отзывы <span class="amount">(--><?php ////echo count($model->comments); ?><!--)</span></div>-->
	</div>
</div>
<div class="content_block_no_padding">
	<div id="doctors_list" style="display:<?php echo $word == 'main' ? 'block' : 'none' ;?>">
		<?php foreach($model -> doctors as $doctor) {
			$this -> renderPartial('/doctors/_single_doctors', array('data' => $doctor));
		} ?>
	</div>
	<div id="info" style="display:<?php echo $word == 'info' ? 'block' : 'none' ;?>">
		<?php echo $info; ?>
	</div>
	<div id="prices" style="display:<?php echo $word == 'prices' ? 'block' : 'none' ;?>">
		<?php $this -> renderPartial('/clinics/_priceList', array('prices' => $model -> getPriceValues(),'clinic' => $model)); ?>
	</div>
<!--	<div id="reviews" style="display:--><?php //echo $word == 'reviews' ? 'block' : 'none' ;?><!--">-->
<!--		--><?php //$this -> renderPartial('//home/_clinic_reviews', array('id'=>$model -> id,'reviews' => $model->comments)); ?>
<!--	</div>-->
</div>
</div>