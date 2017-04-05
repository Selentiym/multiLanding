<?php
/**
 * @type clinics|doctors $model
 * @type HomeController $this
 * @type ClinicsModule $mod
 */
$mod = Yii::app() -> getModule('clinics');
$word = 'prices';
$this->setPageTitle($model->title);
Yii::app() -> getClientScript() -> registerMetaTag($model -> description,'description');
Yii::app() -> getClientScript() -> registerMetaTag($model -> keywords,'keywords');
$modelName = get_class($model);
$data = $_GET;
if ($data['research']) {
	$data['research'] = ObjectPrice::model() -> findByAttributes(['verbiage' => $data['research']]);
}

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
	$temp = $model -> getCoordinates();
	$coordinaty[0] = $temp[1];
	$coordinaty[1] = $temp[0];
	if ((!$coordinaty[0])||(!$coordinaty[1])) {
		$adress = $model->address;
		//$adress = "Санкт-петербург, проспект металлистов, 25к1";
		//$key = "ключ апи яндекс карт";
		$found = array();
		if (trim($adress)) {
			$adress1 = urlencode($adress);
			$url = "http://geocode-maps.yandex.ru/1.x/?geocode=" . $adress1;//."&key=".$key;
			//$content=file_get_contents($url);
			preg_match('/<pos>(.*?)<\/pos>/', $content, $point);
			preg_match('/<found>(.*?)<\/found>/', $content, $found);
		}
		$coordinaty = explode(' ', trim(strip_tags($point[1])));
	}
	if ($coordinaty[1]&&$coordinaty[0]) {
		$cs->registerScript('mapAct', '
			addCoords([' . $coordinaty[1] . ', ' . $coordinaty[0] . '],"' . CJavaScript::encode($model->name) . ', ' . $adress . '");
		', CClientScript::POS_READY);
	} else {
		$cs->registerScript('mapAct', '
			$("#map").html("Не удалось найти местоположение заправшиваемого объекта. Пожалуйста, сообщите о данной ошибке в техподдержку сайта. Адрес: ' . $adress . '.");
		', CClientScript::POS_READY);
	}
	//$this -> renderPartial('//home/searchForm', array('filterForm' => $filterForm, 'modelName' => $modelName, 'fromPage' => $fromPage,'page' => $page));
?>

<nav class="breadcrumb bg-faded no-gutters">
	<a class="breadcrumb-item col-auto" href="<?php echo $this -> createUrl($this->id.'/'.$this->defaultAction); ?>">Главная</a>
	<?php $area = $mod -> renderParameter($triggersPrepared, $trigger,$field); ?>
	<a class="breadcrumb-item col-auto" href="<?php $this -> createUrl('home/clinics',['area' => $triggers['area']]); ?>"><?php echo ($area) ? $area : 'Поиск клиник' ; ?></a>
	<a class="breadcrumb-item col-auto" href="<?php $this -> createUrl('home/modelView',['modelName' => get_class($model)]); ?>"><?php echo $model -> name ; ?></a>
</nav>

<div class="container-fluid clinic-full">
	<div class="row">
		<div class="col-12 col-md-8 mx-auto">
			<div class="row">
				<div class="col-4">
					<h1><?php echo $model -> name; ?></h1>
					<?php $this -> renderPartial('/clinics/_iconData',['model' => $model]); ?>
					<?php $this -> renderPartial('//clinics/_buttons',['model' => $model]); ?>
				</div>
				<div class="col-8"></div>
			</div>
			<div class="row">

			</div>
		</div>
	</div>
</div>

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

			<?php
			$this -> renderPartial('//clinics/_iconData', ['model' => $model, 'data' => $data]);
			?>
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
		<div data-word="reviews" class="item <?php echo ($word == 'reviews') ? 'active' : '' ; ?>">Отзывы <span class="amount">(<?php echo count($comments = $model -> getApprovedComments()); ?>)</span></div>
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
	<div id="reviews" style="display:<?php echo $word == 'reviews' ? 'block' : 'none' ;?>">
		<?php
		echo Yii::app() -> getModule('clinics') -> getObjectsReviewsPool(get_class($model)) -> showObjectCommentsWidget($model -> id);
		//$this -> renderPartial('//clinics/_clinic_reviews', array('model' => $model));
		?>
	</div>
</div>
</div>