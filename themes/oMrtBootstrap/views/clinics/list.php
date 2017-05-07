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
$triggers = $_GET;
$model = clinics::model() -> findByAttributes(['verbiage' => 'service']);
if (!$model) {
    $model = clinics::model();
    $model -> partner = true;
}
$modelName = 'clinics';
$criteria = new CDbCriteria();
$criteria -> addCondition("`ignore_clinic`=0");
//comment
$objects = [];
if (!$triggers['prigorod']) {
    $triggers['isCity'] = 'city';
}
$objects = $mod -> getClinics($triggers,null,null,$criteria);

$cs = Yii::app()->getClientScript();

$cs -> registerScript('implementLinks',"
    var body = $('body');

//    body.on('change.triggers', function(e, extra){
//        console.log(extra);
//        alert('changed');
//    });


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
//        inputObject.mrtInput.change(mrtChange);
//        inputObject.ktInput.change(ktChange);
//        mrtChange();
//        ktChange();
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
//            var el = $(e.params.data.element);
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
    $('#priceUpButton').click(function(){
        var val = sortByField.val();
        if (!val) {
            sortByField.val('priceUp');
        } else {
            sortByField.val('');
        }
        $('#searchForm').submit();
    });

",CClientScript::POS_READY);

$cs -> registerCoreScript('select2_4');
$cs -> registerCoreScript('rateit');

$cs->registerScriptFile("https://api-maps.yandex.ru/2.1/?lang=ru_RU");
//$extraArticles = ArticleRule::getAllArticles('commercial', $triggers);
$toAdd = '';
foreach ($objects as $clinic) {
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
        $('#map').on('shown.bs.collapse', function(){
            $('#map').height(300);
            $(window).trigger('resize');
            allClinics.container.fitToViewport()
//            if (typeof allClinics.redraw == 'function') {
//                allClinics.redraw();
//            }
        });
    });
",CClientScript::POS_READY);

//$cs->registerCssFile(Yii::app()->theme->baseUrl.'/css/clinicsView.css');
//$cs->registerCssFile(Yii::app() -> theme -> baseUrl.'/css/rateit.css');

//$cs->registerScriptFile(Yii::app()->theme -> baseUrl.'/js/jquery.rateit.min.js?' . time(), CClientScript::POS_END);
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
$description = "В ".$geoName." ".$rRod. " можно пройти в ".count($objects). ' ' . clinicWord(count($objects)).", на данной странице представлены все эти медицинские центры, также здесь вы можете провести детальный поиск по различным параметрам исследования.";
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
 * @type CController $this
 */
?>

<nav class="breadcrumb bg-faded no-gutters">
    <a class="breadcrumb-item col-auto" href="<?php echo $this -> createUrl($this->id.'/'.$this->defaultAction); ?>">Главная</a>
    <a class="breadcrumb-item col-auto active" href="<?php $this -> createUrl('home/clinics',['area' => $triggers['area']]); ?>"><?php echo ($area = $fr('area','value')) ? $area : 'Поиск клиник' ; ?></a>
</nav>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <div id="accordion" role="tablist" aria-multiselectable="true">
                <?php foreach(ObjectPriceBlock::model() -> findAll(['order' => 'num ASC']) as $block){
                    $this -> renderPartial('/prices/_single_block', ['priceBlock' => $block, 'mainPrice' => $research]);
                } ?>
            </div>
        </div>
        <div class="col-md-6">
            <form id="searchForm" action="prettyFormUrl" data-action="home/clinics" data-params="{}" data-gen-url="<?php echo addslashes(Yii::app() -> createUrl('home/createFormUrl')); ?>" class="noEmpty prettyFormUrl">
<!--            <form id="searchForm">-->
                <?php echo Triggers::triggerHtml('area',$triggers); ?>
                <div class="d-flex align-items-start mb-3" id="formHead">
                    <div>
                        <?php echo Triggers::triggerHtml('mrt',$triggers); ?>
                    </div>
                    <div>
                        <?php echo Triggers::triggerHtml('kt',$triggers); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-4">

                        <select id="research" name="research">
                            <option value="">Исследование</option>
                        <?php
                            $cs -> registerScript('researchSelectScript','var $sel = $("#research"); $sel.select2(); $sel.trigger("change")',CClientScript::POS_READY);
                            foreach (ObjectPrice::model() -> findAll(['order' => 'id_block ASC']) as $price) {
                                $selected = $triggers['research'] == $price->verbiage ? " selected=selected" : "";
                                echo "<option value='$price->verbiage'$selected data-type='$price->id_type'>$price->name</option>";
                            }
//                        echo CHtml::DropDownListChosen2(
//                            'research',
//                            'research',
//                            CHtml::listData(ObjectPrice::model() -> findAll(['order' => 'id_block ASC']),'verbiage','name'),
//                            //$htmlOptions['disabled'] ? [] : CHtml::listData($this -> trigger_values,'verbiage','value'),
//                            ['style' => 'width:100%', 'empty_line' => true, 'placeholder' => 'Исследование'],
//                            $triggers['research'] ? [$triggers['research']] : [],
//                            [],
//                            true
//                        );
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
                    </div>
                    <div class="col-12 col-md-4">
                        <?php
                            echo Triggers::triggerHtml('magnetType',$triggers);
                            echo Triggers::triggerHtml('field',$triggers);
                            echo Triggers::triggerHtml('slices',$triggers);
                        ?>
                    </div>
                    <div class="col-12 col-md-4">
                        <?php
                            $d = Triggers::triggerHtml('district',$triggers);
                            if ($triggers['area'] == 'msc') {
                                echo Triggers::triggerHtml('okrug',$triggers);
                            }
                            echo $d;
                            echo Triggers::triggerHtml('street',$triggers);
                            echo Triggers::triggerHtml('prigorod',$triggers);
                        ?>
                    </div>
                    <div class="col-12 col-md-4"><?php echo Triggers::triggerHtml('time',$triggers); ?></div>
                    <div class="col-12 col-md-4"><?php echo Triggers::triggerHtml('contrast',$triggers); ?></div>
                    <div class="col-12 col-md-4"><?php echo Triggers::triggerHtml('doctor',$triggers); ?></div>
                    <div class="col-12 col-md-4"><?php echo Triggers::triggerHtml('children',$triggers); ?></div>

                </div>
                <div class="row no-gutters justify-content-center">
                    <div class="col-auto"><button type="submit" class="btn">Найти</button></div>
                    <div class="col-auto ml-3"><a href="<?php echo $this -> createUrl('home/clinics',['area' => $triggers['area']],'&',true); ?>"><button type="button" class="btn" >Сбросить</button></a></div>
                </div>
                <?php echo Triggers::triggerHtml('sortBy',$triggers); ?>
            </form>
            <div id="mapContainer" class="hidden-sm-down mb-3">
                <h2 class="mb-3">Клиники на карте</h2>
                <div><button class="btn" data-toggle="collapse" data-target="#map">Показать на карте</button></div>
                <div class="collapse"  id="map" style="width:100%; height:300px">
                </div>
                <div style="text-align:left" class="col-12 my-1 ml-2">Сортировка по цене: <button id="priceUpButton" type="button" style="font-weight:bold;padding:4px;" class="rounded <?php echo $triggers['sortBy']=='priceUp' ? "active" : ""; ?>" data-toggle="button" aria-pressed="<?php echo $triggers['sortBy']=='priceUp' ? "true" : "false"; ?>" autocomplete="off">по возр.</button></div>
            </div>
            <div id="clinicsList">
                <ul class="list-unstyled">
                    <?php if (count($objects) == 0): ?>
                    <li class="clinic mb-3 single-clinic pt-3">
                        К сожалению клиник, удовлетворяющих всем критериям поиска, не найдено.
                        Вы можете обратиться к специалистам "Общегородской Службы Записи", где вам помогут найти подходящий диагностический центр.
                    </li>
                    <?php endif; ?>
                    <?php $this -> renderPartial('/clinics/_service',['triggers' => $triggers,'price' => $research]); ?>
                    <?php foreach($objects as $clinic){
                        $this -> renderPartial('/clinics/_single_clinics',['model' => $clinic,'price' => $research]);
//                        break;
                    } ?>
                </ul>
            </div>
        </div>
        <div class="col-md-3 article-right">
            <div class="card mb-3">
                <div class="card-block">
                    <h1 class="card-title"><?php echo $h1; ?></h1>
                    <?php
                    generateText($triggers);
                    //echo "Пройти диагностику $r можно в ".$countClinics(['mrt','kt','research','area']). " медцентрах.";
                    ?>

                </div>
            </div>
<!--            --><?php //if ($triggers['contrast']): ?>
<!--            <div class="card mb-3">-->
<!--                <div class="card-block">-->
<!--                    --><?php
//                    contrastText($triggers);
//                    //echo "Пройти диагностику $r можно в ".$countClinics(['mrt','kt','research','area']). " медцентрах.";
//                    ?>
<!---->
<!--                </div>-->
<!--            </div>-->
<!--            --><?php //endif; ?>
            <?php if ($a = ArticleRule::getArticle('dynamic')): ?>
            <div class="card">
                <div class="card-block">
                    <?php
                    if ($a) {
                        echo $a -> prepareTextByVerbiage($triggers);
                    } ?>
                </div>
            </div>
            <?php endif; ?>

            <?php
            if ($research instanceof ObjectPrice) {
                if ($commercialArticle = $research->getArticle()) {
                    $this->renderPartial('/article/_popup_article', ['a' => $commercialArticle, 'triggers' => $triggers]);
                }
            }
            $extraArticles = ArticleRule::getAllArticles('commercial', $triggers);
            if (!empty($extraArticles)) {
                foreach ($extraArticles as $article) {
                    $this -> renderPartial('/article/_popup_article', ['a' => $article, 'triggers' => $triggers]);
                }
            }

            $copy = $triggers;
            unset($copy['area']);
            unset($copy['district']);
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
                echo "<div class='card'><div class='card-block'><div class='card-title'><h3>Полезные статьи</h3></div>";
                foreach ($articles as $article) {
                    $url = $this -> createUrl('home/articleView',['verbiage' => $article -> verbiage],null,false,true);
                    echo "
                        <div><a class='article-name' href='$url'>{$article->name}</a></div>
                    ";
                }
                echo "</div></div>";
            }
            ?>
        </div>
    </div>
</div>