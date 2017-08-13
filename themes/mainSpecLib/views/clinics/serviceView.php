<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 11.06.2017
 * Time: 16:56
 * @var clinics $model
 * @var SpecSiteHomeController $this
 */
$triggers = $_GET;
$model = clinics::model() -> findByAttributes(['verbiage' => 'service'.$triggers['area']]);
$model -> name = "Единый консультативный центр по МРТ и КТ".($triggers['area'] == 'msc' ? ' в Москве' : ' в Санкт-Петербурге');
if (!$model) {
    $model = clinics::model();
}
Yii::app()->clientScript->registerLinkTag('canonical', null, $this -> createUrl('home/service',['area' => $triggers['area']],'&',false,true));
$cs = Yii::app() -> getClientScript();
$cs -> registerCoreScript('jquery');
$cs -> registerCoreScript('rateit');
$baseTheme = Yii::app() -> themeManager -> getBaseUrl('mainSpecLib');
$cs -> registerScriptFile($baseTheme.'/js/map.js',CClientScript::POS_END);
$cs -> registerScriptFile("https://api-maps.yandex.ru/2.1/?lang=ru_RU");
$cs -> registerCssFile($baseTheme.'/css/clinic.css');
//На карте отображаем всех партнеров
$partners = clinics::model() -> userSearch(['area' => $model -> getFirstTriggerValue('area') -> id],'rating',-1,$crit);
$partners = $partners['objects'];
//$partners = [];
generateMap($partners,'map',[
    'center' => ($triggers['area'] == 'spb' ? [59.939095, 30.315868] : [55.755814, 37.617635]),
    'zoom' => 10
]);

/**
 * doctors
 */
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
/**
 * end doctors
 */
//Статья-описание and metatags
$article = Article::model() -> findByAttributes(['verbiage' => 'service'.$triggers['area']]);
if ($article instanceof Article) {
    $cs -> registerMetaTag($article -> description,'description');
    $this -> setPageTitle($article -> title);
}
$sales = (strlen(trim(strip_tags($model -> sales))) > 10);
$cs -> registerScript('sticky','
(function(){
var panel = document.getElementById("clinicNav"), basePanel = document.getElementById("topNav");
var $panel = $(panel);
var isSticky = false;
var rect, baseNavRect;
$(document).scroll(function(){
    rect = panel.getBoundingClientRect();
    if (!isSticky) {
        if (rect.top < 0) {
            $panel.addClass("sticky");
            $panel.removeClass("row");
            isSticky = true;
        }
    } else {
        baseNavRect = basePanel.getBoundingClientRect();
        if (baseNavRect.top + baseNavRect.height > rect.top) {
            $panel.removeClass("sticky");
            $panel.addClass("row");
            isSticky = false;
        }
    }
});
})();

',CClientScript::POS_READY);
?>
<div id="clinicNav" class="header_topline navbar navbar-toggleable-lg navbar-light row">
    <button style="margin-top:15px;" class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#clinicNavbarText" aria-controls="clinicNavbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#"><img alt="logo" style="height:70px" class="p-2" src="<?php echo $baseTheme.'/images/logo.png'; ?>"/></a>
    <div class="collapse navbar-collapse" id="clinicNavbarText">
        <ul class="nav navbar-nav align-items-center">
            <li class="nav-item"><a href="#mapHead" class="list-group-item list-group-item-action">Карта</a></li>
            <li class="nav-item"><a href="#description" class="list-group-item list-group-item-action">Описание</a></li>
            <?php if($sales): ?>
                <li class="nav-item"><a href="#sales" class="list-group-item list-group-item-action">Акции&nbsp;и&nbsp;скидки</a></li>
            <?php endif; ?>
            <li class="nav-item"><a href="#prices" class="list-group-item list-group-item-action">Цены</a></li>
            <?php if(count($model -> doctors)) : ?>
                <li class="nav-item"><a href="#doctors" class="list-group-item list-group-item-action">Врачи</a></li>
            <?php endif; ?>
            <li class="nav-item"><a href="#reviewsHead" class="list-group-item list-group-item-action">Отзывы</a></li>
            <li class="nav-item buttonLine"><a class="btn signUpButton list-group-item list-group-item-action" style="background-color: #5cb85c">Записаться на МРТ или КТ обследование</a></li>
        </ul>
    </div>
</div>
<div class="row clinicsPage pt-3">
    <div class="col-12 col-md-10 mx-auto">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-6 text-center">
                    <h1 class="text-center"><?php echo $model -> name; ?></h1>
                    <img class="mr-3 img-fluid" src="<?php echo $model -> giveImageFolderRelativeUrl() . $model -> logo;?>" alt="<?php echo htmlspecialchars($model -> name); ?>">
                    <div class="text-left">
                        <?php
                        $phone = $model -> getPhoneObject();
                        $this -> renderPartial('/clinics/_icon',['iClass' => 'fa-phone', 'text' => CHtml::link($phone -> getFormatted(),'tel:'.$phone -> getUnformatted())]);
                        $this -> renderPartial('/clinics/_icon', ['iClass' => 'fa-map', 'text' => "Клиники по <strong>всему городу</strong>!"]);
                        $this -> renderPartial('/clinics/_icon', ['iClass' => 'fa-train', 'text' => 'Любая <strong>удобная Вам станция</strong> метро']);
                        $this -> renderPartial('/clinics/_icon', ['iClass' => 'fa-calendar-check-o', 'text' => 'Звоните <strong>с 8:00 до 23:00</strong>, заявки принимаем <strong>круглосуточно</strong>!']);
                        $this -> renderPartial('/clinics/_icon', ['iClass' => 'fa-hand-stop-o', 'text' => '<strong>Без ограничений</strong> по весу или объему!']);
                        ?>
                    </div>
                    <div class="text-center"><div class="rateit" data-rateit-value="<?php echo $model->rating; ?>" data-rateit-ispreset="true" data-rateit-readonly="true"></div></div>
                    <div class="text-center"><button class="btn btn-outline-success signUpButton">Записаться</button></div>
                    <div class="text-center">
                        <?php
                        $tags = ['МРТ','КТ','круглосуточно', 'высокопольный магнит','современное оборудование','ночью дешевле','высококвалифицированные специалисты','открытый магнит','с контрастом','частная', 'любое метро','любой район'];
                        foreach ($tags as $tag) {
                            echo " <span class='badge badge-info'>".$tag."</span> ";
                        }
                        ?>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div id="mapHead" class="anchorHolder"></div>
                    <div id="map" style="height:400px; width:90%; margin: 0 auto;"></div>
                </div>
            </div>
        </div>
        <div id="description" class="anchorHolder"></div>
        <div>
            <div class="mb-3">
                <?php
                    if ($article instanceof Article) {
                        echo $article -> text;
                    }
                ?>
            </div>
            <div id="clinic-carousel" class="carousel slide mx-auto" data-ride="carousel">
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
                                <img class="d-block img-fluid mx-auto" src="'.$model->giveImageFolderRelativeUrl() . '/' . $im.'" alt="Фотография единого консультативного центра МРТ и КТ">
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
        <?php if ($sales): ?>
            <div id="sales" class="anchorHolder"></div>
            <h3>Акции и скидки</h3>
            <div class="p-3">
                <?php
                if (strlen(trim(strip_tags($model -> sales))) < 10) {
                    echo "<p>Информация о скидках отсутсвует</p>";
                } else {
                    echo $model -> sales;
                }
                ?>
            </div>
        <?php endif; ?>
        <div id="prices" class="anchorHolder"></div>
        <h3>Цены на исследования</h3>
        <div class="p3 mx-auto justify-content-center row">
            <?php
            $typedPrices = UClinicsModuleModel::groupBy($model -> getPriceValues(true),function(ObjectPriceValue $pv){ return $pv -> price -> id_type;});
            $names = [
                1 => '<i class="fa fa-life-ring"></i>&nbsp;МРТ',
                2 => '<i class="fa fa-server"></i>&nbsp;КТ',
                3 => '<i class="fa fa-toggle-on"></i>&nbsp;Отдельные',
            ];
            foreach ($typedPrices as $type => $pricesOfType) {
                ob_start();
                $blockedPrices = UClinicsModuleModel::groupBy($pricesOfType,function(ObjectPriceValue $pv){ return $pv -> price -> id_block;});
                $newBlocked = [];
                //Выносим тематические цены вверх
                foreach (Yii::app() -> params['priceBlocks'] as $blockId) {
                    if ($blockedPrices[$blockId]) {
                        $newBlocked[$blockId] = $blockedPrices[$blockId];
                        unset($blockedPrices[$blockId]);
                    }
                }
                $newBlocked = array_replace($newBlocked, $blockedPrices);
                foreach ($newBlocked as $blockId => $pricesOfBlock) {
                    /**
                     * @type ObjectPriceBlock $block
                     * @type ObjectPriceValue[] $pricesOfBlock
                     */
                    $firstPrice = current($pricesOfBlock);
                    if (!$firstPrice instanceof ObjectPriceValue) {
                        continue;
                    }
                    $content = '';
                    foreach ($pricesOfBlock as $price) {
                        $content .= $this -> renderPartial('/common/_dropDownLine', ['name' => $price -> price -> name, 'price' => $price -> value], true, false);
                    }
                    $block = $firstPrice -> price -> block;

                    $this -> renderPartial('/common/_dropDown', ['name' => '<i class="fa fa-rouble" aria-hidden="true"></i>&nbsp;'.$block -> name, 'content' => $content,'shown' => in_array($blockId,Yii::app() -> params['priceBlocks'])]);
                }
                $out = ob_get_contents();
                ob_end_clean();
                echo "<div class='col-md-4 col-12'>";
                $this -> renderPartial('/common/_dropDown', ['name' => $names[$type],'content' => $out,'shown' => true]);
                echo "</div>";
            }
            ?>
        </div>
        <?php if (count($model -> doctors)): ?>
            <div id="doctors" class="anchorHolder"></div>
            <h3>Врачи</h3>
            <div class="row p-3">

                <?php
                if (!empty($model -> doctors)) {
                    echo '<div class="owl-carousel">';
                    foreach ($model -> doctors as $doctor) {
                        $this -> renderPartial('/doctors/_carousel',['doctor' => $doctor]);
                    }
                    echo '</div>';
                }
                ?>
            </div>
        <?php endif; ?>

        <div class="collapse p-3"  id="prices" >
            <?php
            $this -> renderPartial('/clinics/_priceList',['model' => $model,'blocks' => ObjectPriceBlock::model()->findAll(['order' => 'num ASC'])]);
            ?>
        </div>
        <div id="reviewsHead" class="anchorHolder"></div>
        <h3>Отзывы</h3>
        <div class="p-3 mx-auto" style="max-width: 700px" id="reviews" >
            <?php
            echo Yii::app() -> getModule('clinics') -> getObjectsReviewsPool(get_class($model)) -> showObjectCommentsWidget($model -> id);
            //        echo Yii::app() -> getModule('clinics') -> getObjectsReviewsPool(get_class($model)) -> showObjectCommentsWidget($model -> id);
            ?>
        </div>
    </div>
</div>