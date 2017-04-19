<?php
/**
 * @type clinics|doctors $model
 * @type HomeController $this
 * @type ClinicsModule $mod
 */
$triggers = $_GET;
$triggersPrepared = Article::prepareTriggers($triggers);
$mod = Yii::app() -> getModule('clinics');
$word = 'prices';
$this->setPageTitle($model->title);

$cs = Yii::app() -> getClientScript();
//Ниже оно генерится
//$cs -> registerMetaTag($model -> description,'description');
//Ниже проставляются
//$cs -> registerMetaTag($model -> keywords,'keywords');
$cs -> registerCoreScript('rateit');
$cs -> registerCoreScript('bootstrap4collapseFix');
$theme = Yii::app() -> theme -> baseUrl;
$cs -> registerScript($theme.'/js/map.js', CClientScript::POS_END);

$cs -> registerCoreScript('owl');

$cs -> registerScript('start_carousel','
var owl2 = $(".owl-carousel");
console.log(owl2);
	owl2.owlCarousel({
		autoHeight : true,
		autoWidth: false,
		stopOnHover : true,
		autoplay : true,
		autoplayTimeout:5000,
		autoplaySpeed:1000,
		autoplayHoverPause:true,
		nav:true,
		navText:["",""],
		rewind:true,
		touchDrag : true,
		mouseDrag:true,
		responsive: {
			0: {
				items:1,

			},
			768: {
				items:2,
			}
		},

	});
',CClientScript::POS_READY);

$modelName = get_class($model);
$data = $_GET;
if ($data['research']) {
	$data['research'] = ObjectPrice::model() -> findByAttributes(['verbiage' => $data['research']]);
}

$info = $this -> renderPartial('/clinics/_info', array('clinic' => $model),true);

$cs = Yii::app()->getClientScript();
$cs -> registerCoreScript('font-awesome');
$cs->registerScriptFile(Yii::app()->theme->baseUrl.'/js/map.js');
$cs -> registerScriptFile("https://api-maps.yandex.ru/2.1/?lang=ru_RU");
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
$r = false;
if ($model -> giveMinMrtPrice()) {
	$r = "МРТ";
}
if ($model -> giveMinKtPrice()) {
	if ($r) {
		$r .= ' и КТ';
	} else {
		$r = 'КТ';
	}
}
$descr = "Где можно сделать $r в ".$model -> getFirstTriggerValue('district') -> getParameterValueByVerbiage('districtPredl') -> value . " или возле метро ".$model -> getSortedMetroString()." - Клиника {$r}: $model->name, ".$model ->getFullAddress();
$cs -> registerMetaTag($descr,'description');
$cs -> registerMetaTag($r.' головного мозга, позвоночника, суставов, малого таза, брюшной полости, легких, носовых пазух, с контрастом','keywords');
?>

<nav class="breadcrumb bg-faded no-gutters">
	<a class="breadcrumb-item col-auto" href="<?php echo $this -> createUrl($this->id.'/'.$this->defaultAction); ?>">Главная</a>
	<?php $area = $mod -> renderParameter($triggersPrepared, 'area','value'); ?>
	<a class="breadcrumb-item col-auto" href="<?php echo $this -> createUrl('home/clinics',['area' => $triggers['area']]); ?>"><?php echo ($area) ? $area : 'Поиск клиник' ; ?></a>
	<a class="breadcrumb-item col-auto" href="<?php echo $this -> createUrl('home/modelView',['modelName' => get_class($model)]); ?>"><?php echo $model -> name ; ?></a>
</nav>

<div class="container-fluid clinic clinic-full" id="clinic" role="tablist">
	<div class="row">
		<div class="col-12 col-lg-10 mx-auto">
			<div class="row d-flex">
				<div class="col-12 col-md-4">
					<?php
						$phrase = '';
						if ($model -> getFirstTriggerValue('mrt')) {
							$phrase = "МРТ";
						}
						if ($model -> getFirstTriggerValue('kt')) {
							if ($phrase) {
								$phrase .= ' и ';
							}
							$phrase .= "КТ";
						}
					?>
					<h1 class="mb-0 pb-1 text-center" style="font-size:1.5rem"><strong><?php echo $model -> name; ?></strong></h1>
					<?php if ($model -> getFirstTriggerValue('finance') -> verbiage == 'commercial'): ?>
					<h2 class="text-center mt-0"><?php echo "Центр $phrase диагностики"; ?></h2>
					<?php endif; ?>
					<?php $this -> renderPartial('/clinics/_iconData',['model' => $model, 'data' => $triggers, 'expanded' => true]); ?>
					<div class="text-center">
					<?php $this -> renderPartial('/clinics/_buttons',['model' => $model]); ?>
					</div>
				</div>
				<div class="col-12 col-md-8 pt-5" >
					<div id="map" style="height:400px;"></div>
					<div><h6>Как добраться</h6><?php echo $model -> path; ?></div>
				</div>
			</div>

			<div class="d-flex justify-content-between p-3">
				<div>Значки</div>
				<div><div class="rateit" data-rateit-value="<?php echo $model->rating; ?>" data-rateit-ispreset="true" data-rateit-readonly="true"></div></div>
			</div>

			<div class="row buttons text-center" role="tablist">
				<?php
					function createBigButton($id, $text){
						echo '
						<div class="col p-4 tabControl" data-toggle="collapse" data-tablist-id="clinic"  data-target="#'.$id.'">
							'.$text.'
						</div>';
					}
					createBigButton('description','Описание');
					createBigButton('doctors','Врачи');
					createBigButton('prices','Цены');
					createBigButton('reviews','Отзывы');
				?>
			</div>
			<div id="clinic-tabs" role="tablist">
				<div class="collapse p-3"  id="description" >
					<div class="mb-3">
						<?php echo $model -> text; ?>
					</div>
					<div id="clinic-carousel" class="carousel slide" data-ride="carousel">
						<ol class="carousel-indicators">
							<li data-target="#clinic-carousel" data-slide-to="0" class="active"></li>
							<li data-target="#clinic-carousel" data-slide-to="1"></li>
							<li data-target="#clinic-carousel" data-slide-to="2"></li>
						</ol>
						<div class="carousel-inner" role="listbox">
							<?php
							$images = array_map(function($image){
								return trim($image);
							}, explode(';', $model->pictures));
							$images = array_filter($images, function ($image) use($model) {
								return file_exists($model -> giveImageFolderAbsoluteUrl().'/'.$image)&&($image);
							});
							$active='active';
							foreach ($images as $im) {
								echo '

								<div class="carousel-item '.$active.'">
									<img class="d-block img-fluid" src="'.$model->giveImageFolderRelativeUrl() . '/' . $im.'" alt="Фотография Центра '.$r.' '.$model -> name.'">
								</div>
								';
								$active = '';
							}
							?>
						</div>
						<a class="carousel-control-prev" href="#clinic-carousel" role="button" data-slide="prev">
							<span class="carousel-control-prev-icon" aria-hidden="true"></span>
							<span class="sr-only">Previous</span>
						</a>
						<a class="carousel-control-next" href="#clinic-carousel" role="button" data-slide="next">
							<span class="carousel-control-next-icon" aria-hidden="true"></span>
							<span class="sr-only">Next</span>
						</a>
					</div>
				</div>
				<div class="collapse p-3"  id="doctors" >

						<?php
						if (!empty($model -> doctors)) {
							echo '<div class="owl-carousel">';
							foreach ($model -> doctors as $doctor) {
								$this -> renderPartial('/doctors/_carousel',['doctor' => $doctor]);
							}
							echo '</div>';
						} else {
							echo "<p>К сожалению, список врачей пуст.</p>";
						}
						?>
				</div>
				<div class="collapse p-3"  id="prices" >
					<?php
						$this -> renderPartial('/clinics/_priceList',['model' => $model,'blocks' => ObjectPriceBlock::model()->findAll(['order' => 'num ASC'])]);
					?>
				</div>
				<div class="collapse p-3 mx-auto" id="reviews" >
					<?php
						echo Yii::app() -> getModule('clinics') -> getObjectsReviewsPool(get_class($model)) -> showObjectCommentsWidget($model -> id);
					?>
				</div>
			</div>
		</div>
	</div>
</div>
