<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 23.02.2017
 * Time: 13:24
 *
 * @param $icon
 * @param $text
 * @param string $class
 * @internal param ClinicsModule $mod
 */

$mod = Yii::app() -> getModule('clinics');
$page = $_GET['page'] ? $_GET['page'] : 1;
unset($_GET['page']);
$triggers = $_GET;
$model = clinics::model() -> findByAttributes(['verbiage' => 'service']);
if (!$model) {
    $model = clinics::model();
    $model -> partner = true;
}
$modelName = 'clinics';
$criteria = new CDbCriteria();
$criteria -> addCondition("`ignore_clinic`=0");
$criteria -> order = 'partner DESC';
//comment
$objects = [];
if (!$triggers['prigorod']) {
    $triggers['isCity'] = 'city';
}
$forPartnerCriteria = clone $criteria;
$forPartnerCriteria -> compare('partner', 1);
$partnerCount = count($mod -> getClinics($triggers, null, null, $forPartnerCriteria));
$pageSize = max($partnerCount + 4, 20);
$allObjects = $mod -> getClinics($triggers,null,null,$criteria);
$start = $page >= 1 ? $pageSize * ($page - 1) : 0;
if ($start > count($allObjects)) {
    $start = 0;
    $page = 1;
}
if ($page != 'noPage') {
    $objects = array_slice($allObjects,$start,$pageSize);
} else {
    $objects = $allObjects;
}
if (!$triggers['research']) {
    $blocks = ObjectPriceBlock::model() -> findAllByPk(Yii::app() -> params['priceBlocks']);
}
//$criteria -> offset = $page >= 1 ? $pageSize * ($page - 1) : 0 ;
//$criteria -> limit = $pageSize;
//$objects = $mod -> getClinics($triggers,null,null,$criteria);
$cs = Yii::app()->getClientScript();

$cs -> registerScript('implementLinks',"
    var body = $('body');

    (function(){
        var inputObject = {};
        inputObject.mrtInput = $('input[name=mrt]');
        inputObject.ktInput = $('input[name=kt]');
        inputObject.ktElements = [Triggers.objs['slices'].element];
        inputObject.mrtElements = [Triggers.objs['magnetType'].element,Triggers.objs['field'].element];
        console.log(inputObject);
        function mrtChange () {
            var mrtVal = Triggers.objs['mrt'].element.val();
            var ktVal = Triggers.objs['kt'].element.val();
            if (mrtVal) {
                showMrtElements();
                if (!ktVal) {
                    hideKtElements();
                }
            } else if ((!mrtVal)&&(!ktVal)) {
                showMrtElements();
                showKtElements();
            } else {
                hideMrtElements();
            }
        }
        function ktChange () {
            var mrtVal = Triggers.objs['mrt'].element.val();
            var ktVal = Triggers.objs['kt'].element.val();
            if (ktVal) {
                showKtElements();
                if (!mrtVal) {
                    hideMrtElements();
                }
            } else if ((!mrtVal)&&(!ktVal)) {
                showMrtElements();
                showKtElements();
            } else {
                hideKtElements();
            }
        }
        function hideMrtElements(){
            hideElements(inputObject.mrtElements);
        }
        function hideKtElements(){
            hideElements(inputObject.ktElements);
        }
        function showMrtElements(){
            showElements(inputObject.mrtElements);
        }
        function showKtElements(){
            showElements(inputObject.ktElements);
        }
        function hideElements(els){
            for (var i = 0; i < els.length; i++) {

                els[i].prop('disabled',true);
                try{
                    if (els[i].data('select2')) {
                        els[i].select2('destroy');
                    }
                } catch (e) {}
                els[i].hide();
            }
        }
        function showElements(els){
            for (var i = 0; i < els.length; i++) {
                els[i].prop('disabled',false);
                els[i].show();
                try {
                    els[i].select2({});
                } catch (e) {}
            }
        }
        body.on('mrtChange.triggers', mrtChange);
        body.on('ktChange.triggers', ktChange);
        var mrtButton = $('#mrtButton');
        var ktButton = $('#ktButton');
        function clickButton(button, neededState) {
            if ((button.hasClass('pressed')) ^ (neededState)) {
                button.trigger('click');
            }
        }
        $('#research').on('change',function(e){
            var el = $(this).find(':selected');
            var type = el.attr('data-type');
            if (type==1) {
                clickButton(mrtButton, true);
                clickButton(ktButton, false);
            } else if (type==2) {
                clickButton(ktButton,true);
                clickButton(mrtButton, false);
            }
        });
        mrtChange();
        ktChange();
    })();
    var group = ['metro','district','prigorod','okrug'];
    var i;
    var metro = new Trigger({
        url:false,
        verbiage:'metro',
        childrenVerbs:[],
        elementId:'metro',
    });

    function createHandlerForGeo(saveI){
        return function(e,extra){
            var flag = false;
            for( var k=0; k < group.length; k++) {
                var trig = Triggers.objs[group[k]];
                if (trig) {
                    flag = flag||(trig.element.val());
                }
            }
            for(var j=0;j < group.length; j++) {
                var str = group[j];
                var el = Triggers.objs[str].element;
                if (flag) {
                    if (!el.val()) {
                        el.prop('disabled',true);
                    }
                } else {
                    el.prop('disabled', false);
                }
            }
        }
    }
    for (i = 0; i < group.length; i++) {
        body.on(group[i] + 'Change', createHandlerForGeo(i));
        body.trigger(group[i] + 'Change',{});
    }
    var sortByField = $('#sortBy');
    $('#sortBySelect').change(function(){
        sortByField.val($(this).val());
        $('#searchForm').submit();
    });

",CClientScript::POS_READY);

$cs -> registerCoreScript('select2_4');
$cs -> registerCoreScript('rateit');

$cs->registerScriptFile("https://api-maps.yandex.ru/2.1/?lang=ru_RU");
$cs -> registerScript('initiate_popup_map','
$(".mapButton").attr("data-target","#mapModal").attr("data-toggle","modal").attr("data-keyboard","true");
$(".mapButton").modal({
    keyboard:true,
    show:false,
    focus:true
});
',CClientScript::POS_READY);

//$extraArticles = ArticleRule::getAllArticles('commercial', $triggers);
$toAdd = '';
foreach ($allObjects as $clinic) {
    $variab = 'v'.str_replace('-','',$clinic -> verbiage);
    if ($clinic -> map_coordinates) {
        $toAdd .= "{$variab} = new ymaps.Placemark( ".json_encode(array_values($clinic -> getCoordinates()))." , {
											hintContent: '".prepareTextToJS ($clinic -> name).", ".prepareTextToJS ($clinic -> address)."'
										});";
        $toAdd .= "allClinics.geoObjects.add({$variab});
        ";
    }
    $i++;
//    if ($i>10) break;
}
$cs->registerScript("map_init","
    ymaps.ready(function () {

        allClinics = new ymaps.Map('map', {
            center: ".($triggers['area'] == 'spb' ? '[59.939095, 30.315868]' : '[55.755814, 37.617635]') ." ,
            zoom: 10,
            id: 'map'
        }, {
            searchControlProvider: 'yandex#search'
        });
        ".$toAdd."
        $('#mapModal').on('shown.bs.modal', function(){
            var height = document.documentElement.clientHeight *0.7;
            if (height < 100) {
                height = 100;
            }
            $('#map').height(height);
            $(window).trigger('resize');
            allClinics.container.fitToViewport()
        });
    });
",CClientScript::POS_READY);

$cs -> registerCoreScript('prettyFormUrl');
$cs -> registerCoreScript('font-awesome');
$cs -> registerScript('Order','
	$("#sortby a").click(function(e){

		$("#sortByField").val($(this).attr("data-sort"));
		$("#searchForm").submit();
		return false;
	});
',CClientScript::POS_READY);

$keys = [];
$triggersPrepared = Article::prepareTriggers($triggers);
$fr = encapsulateTriggersForRender($triggers);
$text = '';

if ($street = $fr('street','value')) {
    $text .= $street.",";
    $keys[] = $street;
} elseif ($distr = $fr('district','value')) {
    $text .= $distr.' район,';
    $keys[] = $distr;
}
if ($triggers['time']) {
    $text .= ($text ? ' к' : 'К').'руглосуточно';
    $keys[] = 'круглосуточно';
}
$research = $fr('research', 'value');
if (!$research) {
    $keys[] = 'томография';
    if ($triggers['mrt']) {
        $r = 'МРТ ';
        $keys[] = 'мрт';
    }
    if ($triggers['kt']) {
        $r = $r ? $r.' и КТ' : 'КТ' ;
        $keys[] = 'кт';
    }
    $r = $r ? $r : 'МРТ или КТ';
} else {
    $r = $research;
    $rRod = $fr('research','nameRod');
    $rVin = $fr('research','nameVin');
    $keys[] = $research;
}
$rRod = isset($rRod) ? $rRod : $r;
$rVin = isset($rVin) ? $rVin : $r;
$text .= ($text ? ' с' : 'С').'делать '.$rVin;

if ($triggers['contrast']) {
    $text .= ' с контрастом';
    $keys[] = 'с контрастом';
}
$field = $fr('field','value');
$keys[] = $field;
$slices = preg_replace('/[^\d]/','',$fr('slices','value'));
$keys[] = $slices;
$type = $fr('magnetType', 'type');
$keys[] = $type;
if (($field)||($slices)||($type)) {

    $text .= ' на';
    if ($type) {
        $text .= ' '.$type;
    }
    if ($field) {
        $text .= ' '.$field;
    } elseif($slices) {
        $text .= ' '.$slices.'-срезовом';
    }
    $text .= ' томографе';
}
$keys[] = 'томограф';
$metro = $fr('metro','value');
$keys[] = $metro;
if (!$street) {
    if ($metro) {
        $text .= ' около метро '.$metro;
    }
}
if ($temp = $fr("children","value")) {
    $text .= ' детям';
    $keys[] = 'детям';
    $keys[] = 'ребенку';
}
$h1 = $text;
$title = $text;
if ($triggersPrepared['sortBy']['verbiage'] == 'priceUp') {
    $keys[] = $r.' недорого';
    $h1 .= ' недорого - представленные ниже клиники сгруппированы с учетом: Скидок, Акций и цен Ночью';
    $title .= ' недорого - здесь представлены клиники с наиболее выгодной ценой на данное исследование с учетом скидок, акций и ночных цен';
}
$keys[] = 'поиск клиник';
$this -> pageTitle = $title;
$geoName = generateGeo($fr,$triggers);
//$geoName = $geoName ? $geoName : $fr('area','areaNameRod');
$description = "В ".$geoName." ".$rRod. " можно пройти в ".count($allObjects). ' ' . clinicWord(count($allObjects)).", на данной странице представлены все эти медицинские центры, также здесь вы можете провести детальный поиск по различным параметрам исследования.";
/**
 * @type ObjectPrice $research
 */
$research = $triggers['research'] ? ObjectPrice::model()->findByAttributes(['verbiage' => $triggers['research']]) : null;
if ($research) {
    $description .= $research -> getArticle() -> description;
}
Yii::app() -> getClientScript() -> registerMetaTag($description,'description');
Yii::app() -> getClientScript() -> registerMetaTag(implode(',',array_filter($keys)),'keywords');
/**
 * @type SpecSiteHomeController $this
 */
$prices = $this -> getPrices();
?>

<!--<nav class="breadcrumb bg-faded no-gutters">-->
<!--    <a class="breadcrumb-item col-auto" href="--><?php //echo $this -> createUrl($this->id.'/'.$this->defaultAction); ?><!--">Главная</a>-->
<!--    <a class="breadcrumb-item col-auto active" href="--><?php //$this -> createUrl('home/clinics',['area' => $triggers['area']]); ?><!--">--><?php //echo ($area = $fr('area','value')) ? $area : 'Поиск клиник' ; ?><!--</a>-->
<!--</nav>-->
<div class="row pt-2">
    <!-- Left Column -->
    <div class="col-sm-3 hidden-xs-down">

        <!-- List-Group Panel -->
        <div class="card">
            <div class="card-header p-b-0">
                <h5 class="card-title"><i class="fa fa-thermometer" aria-hidden="true"></i>&nbspИсследование</h5>
            </div>
            <div class="list-group list-group-flush">
                <?php
                    foreach ($prices as $price) {
                        $this -> renderPartial('/prices/_single_price', ['price' => $price, 'mainPrice' => $research]);
                    }
                ?>
            </div>
        </div>

    </div><!--/Left Column-->


    <!-- Center Column -->
    <div class="col-sm-6 col-12">
        <!--Form-->
        <div class="card mb-3">
            <div class="card-header p-b-0">
                <h5 class="card-title">
                    <i class="fa fa-search" aria-hidden="true"></i>&nbsp;
                    Поиск клиник
                </h5>
            </div>
            <div class="card-block">
                <form id="searchForm" action="prettyFormUrl" data-action="home/clinics" data-params="{}" data-gen-url="<?php echo addslashes(Yii::app() -> createUrl('home/createFormUrl')); ?>" class="noEmpty prettyFormUrl row">
                    <?php echo Triggers::triggerHtml('area',$triggers); ?>
                    <div class="col-12 d-flex justify-content-around"><?php echo Triggers::triggerHtml('mrt', $triggers,['class'=>'btn btn-primary']);
                        echo Triggers::triggerHtml('kt', $triggers, ['class'=>'btn btn-primary']); ?></div>
                    <div class="dropdowns form-group col-12 col-md-6">
                        <select id="research" name="research">
                            <option value="">Исследование</option>
                            <?php
                            $cs -> registerScript('researchSelectScript','var $sel = $("#research"); $sel.select2(); $sel.trigger("change")',CClientScript::POS_READY);
                            foreach ($prices as $price) {
                                $selected = $triggers['research'] == $price->verbiage ? " selected=selected" : "";
                                echo "<option value='$price->verbiage'$selected data-type='$price->id_type'>$price->name</option>";
                            }
                            echo "</select>";
                        echo CHtml::DropDownListChosen2(
                            'metro',
                            'metro',
                            CHtml::listData(Metro::model() -> findAllByAttributes(['city' => $triggers['area']],['order' => 'name ASC']),'id','name'),
                            //$htmlOptions['disabled'] ? [] : CHtml::listData($this -> trigger_values,'verbiage','value'),
                            ['style' => 'width:100%', 'empty_line' => true, 'placeholder' => 'Метро'],
                            $triggers['metro'] ? [$triggers['metro']] : [],
                            [],
                            true
                        );
                        ?>
                        <?php echo Triggers::triggerHtml('magnetType', $triggers); ?>
                        <?php echo Triggers::triggerHtml('field', $triggers); ?>
                        <?php echo Triggers::triggerHtml('slices', $triggers);
                        $d = Triggers::triggerHtml('district',$triggers);
                        if ($triggers['area'] == 'msc') {
                        echo Triggers::triggerHtml('okrug',$triggers);
                        }
                        echo $d;
                        echo Triggers::triggerHtml('street',$triggers);
                        echo Triggers::triggerHtml('prigorod',$triggers);
                        ?>
                    </div>
                    <div class="ticks form-group col-12 col-md-6">
                        <?php
                        echo baseSpecHelpers::customCheckbox('contrast', $triggers);
                        echo baseSpecHelpers::customCheckbox('time', $triggers);
                        echo baseSpecHelpers::customCheckbox('children', $triggers);
                        echo baseSpecHelpers::customCheckbox('doctor', $triggers);
                        ?>

                        <div class='buttons text-center w-100'>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-forward" aria-hidden="true"></i>Найти</button>
                            <a href="<?php echo $this -> createUrl('home/clinics',['area' => $triggers['area']],'&',true); ?>"><button type="button" class="btn btn-primary" >Сбросить</button></a>
                            <button type="button" class="btn btn-primary mapButton">Карта</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Alert -->
<!--        <div class="alert alert-success alert-dismissible" role="alert">-->
<!--            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
<!--            <strong>Synergize:</strong> Seamlessly visualize quality intellectual capital!-->
<!--        </div>-->

        <!-- Clinics -->
        <div>
        <?php
            foreach ($objects as $clinic) {
                $this -> renderPartial('/clinics/_single_clinics',['model' => $clinic,'price' => $research,'blocks' => $blocks]);
            }
        ?>
        </div>
    </div><!--/Center Column-->



    <!-- Right Column -->
    <div class="col-sm-3 col-12">

        <div class="card mb-2">
            <div class="card-header p-b-0">
                <h5 class="card-title text-center">
                    <i class="fa fa-exclamation" aria-hidden="true"></i>
                    <?php echo $h1 ?>
                </h5>
            </div>
            <div class="card-block">
                <?php generateText($triggers); ?>
            </div>
        </div>
        <?php
        if (count($allObjects) == 0) { echo "<!--noindex-->"; }
        $extraArticles = ArticleRule::getAllArticles('commercial', $triggers);
        if (!empty($extraArticles)) {
            foreach ($extraArticles as $article) {
                $this -> renderPartial('/article/_popup_article', ['a' => $article, 'triggers' => $triggers]);
            }
        }
        if (count($allObjects) == 0) { echo "<!--/noindex-->"; }
        //Ссылки на информационные статьи
        $copy = $triggers;
        unset($copy['area']);
        unset($copy['district']);
        unset($copy['prigorod']);
        unset($copy['metro']);
        unset($copy['street']);
        unset($copy['orderBy']);
        unset($copy['isCity']);
        if (count($copy) == 0) {
            $articles = Article::model() -> root() -> findAllByAttributes(['id_type' => Article::getTypeId('text')]);
        } elseif (count($copy) == 1) {
            if ($copy['mrt']) {
                $parentVerb = 'mrt';
            }
            if ($copy['kt']) {
                $parentVerb = 'kt';
            }
            $parent = Article::model() -> findByAttributes(['verbiage' => $parentVerb]);
            if ($parent) {
                $articles = Article::model()->findAllByAttributes(['parent_id' => $parent->id]);
            }
        }
        if (!$articles) {
            $criteria = new CDbCriteria();
            $criteria -> compare('id_type', Article::getTypeId('text'));
            $articles = $mod -> getArticles($copy, false, null, $criteria);
        }
        if (!empty($articles)) {
            $decoratedArticles = 5;
            $i = 0;
            echo "<div class='card'><div class='card-header p-b-0'><h5 class='card-title text-center'><i class='fa fa-warning' aria-hidden='true'></i>&nbsp;Может пригодиться</h5></div><div class='card-block'>";
            foreach ($articles as $article) {
                $url = $this -> createUrl('home/articleView',['verbiage' => $article -> verbiage],null,false,true);
                $imageUrl = $article -> getImageUrl();
                if ($i < $decoratedArticles) {
                    echo "
                            <div>
                                <a class='article-name' href='$url'>
                                    <h3 class='text-center' style='font-size: 1rem;'>{$article->name}</h3></a>
                                    ";
                    if ($imageUrl) {
                        echo "<a class='article-name w-100 d-block' href='$url'><img style='width:90%;margin:5px auto; display:block;' class='mx-auto' src='$imageUrl' alt='".addslashes($a->name)."'/></a>";
                    }
                    echo "
                                </a>
                            </div>
                        ";
                } else {
                    echo "
                            <div><a class='article-name' href='$url'><h3 class='text-center' style='font-size: 1rem;'>{$article->name}</h3></a></div>
                        ";
                }
                $i ++;
            }
            echo "</div></div>";
        }
        ?>

    </div><!--/Right Column -->
</div>

<div class="modal fade" id="mapModal" tabindex="-1" role="dialog" aria-labelledby="mapModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mainColor" id="mapModalLabel">Центры МРТ и КТ на карте</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div  id="map" style="width:100%; height:90%">
                </div>
            </div>
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-success signUpButton">Записаться</button>
            </div>
        </div>
    </div>
</div>
