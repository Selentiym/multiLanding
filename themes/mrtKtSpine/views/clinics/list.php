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
        $('#map').on('shown.bs.collapse', function(){
            $('#map').height(300);
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
 * @type CController $this
 */
?>

<nav class="breadcrumb bg-faded no-gutters">
    <a class="breadcrumb-item col-auto" href="<?php echo $this -> createUrl($this->id.'/'.$this->defaultAction); ?>">Главная</a>
    <a class="breadcrumb-item col-auto active" href="<?php $this -> createUrl('home/clinics',['area' => $triggers['area']]); ?>"><?php echo ($area = $fr('area','value')) ? $area : 'Поиск клиник' ; ?></a>
</nav>
<div class="container-fluid">
    <form>
        <div class="d-flex">
            <div><?php echo Triggers::triggerHtml('area',$triggers); ?></div>
            <div><?php echo Triggers::triggerHtml('mrt',$triggers); ?></div>
            <div><?php echo Triggers::triggerHtml('kt',$triggers); ?></div>
            <div><?php
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
                ?></div>
            <div>
                <?php echo Triggers::triggerHtml('magnetType',$triggers); ?>
            </div>
            <div>
                <?php echo Triggers::triggerHtml('field',$triggers); ?>
            </div>
            <div>
                <?php echo Triggers::triggerHtml('slices',$triggers); ?>
            </div>

        </div>
    </form>
    <div class="text-center">
        <?php
        $blockMrt = ObjectPriceBlock::model() -> findByPk(5);
        $blockKt = ObjectPriceBlock::model() -> findByPk(6);
        $prices = array_merge($blockMrt -> prices, $blockKt -> prices);
        foreach($prices as $price){
            echo "<div class='list-group m-3 d-inline-block'>";
            $this -> renderPartial('/prices/_single_price', ['price' => $price, 'mainPrice' => $research]);
            echo "</div>";
        } ?>
    </div>
    <div class="row">

    </div>
</div>