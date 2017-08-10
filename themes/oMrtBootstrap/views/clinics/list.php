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
 * @param ClinicsModule $mod
 */
$_GET = array_map('addslashes',$_GET);
$mod = Yii::app() -> getModule('clinics');
$page = $_GET['page'] ? $_GET['page'] : 1;
unset($_GET['page']);
$triggers = TriggerValues::normalizeTriggerValueSet($_GET);
$_GET = $triggers;
$researchObject = $triggers['research'] ? ObjectPrice::model()->findByAttributes(['verbiage' => $triggers['research']]) : null;

Yii::app()->clientScript->registerLinkTag('canonical', null, $this -> createUrl('home/clinics',$triggers,'&',false,true));
//var_dump($triggers);
//return;
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
$partnerCount = $mod -> countClinics($triggers, null, null, $forPartnerCriteria);
$pageSize = max($partnerCount + 4, 20);
/**
 * @type ClinicsModule $mod
 */
$start = $page >= 1 ? $pageSize * ($page - 1) : 0;
if ($start > count($allObjects)) {
    $start = 0;
    $page = 1;
}
//Добавляем условие на часть клиник
if ($page != 'noPage') {
    $criteria -> offset = $start;
    $criteria -> limit = $pageSize;
}
$allObjects = $mod -> getClinics($triggers,null,$pageSize,$criteria);
$objects = &$allObjects;
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

generateMap($allObjects,'map',[
    'center' => ($triggers['area'] == 'spb' ? [59.939095, 30.315868] : [55.755814, 37.617635]),
    'zoom' => 10
]);

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
$geoName = generateGeo($fr,$triggers);
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
}
$rRod = isset($rRod) ? $rRod : $r;
$rVin = isset($rVin) ? $rVin : $r;
$text .= ($text ? ' с' : 'С').'делать '.$rVin;

$doKey = 'сделать ' . $rVin;
if ($geoName) {
    $doKey .= ' в '.$geoName;
}
$keys[] = $doKey;
$keys[] = 'цены на '.$rVin;

if ($triggers['contrast']) {
    $text .= ' с контрастом';
    $keys[] = 'с контрастом';
}
if (!$research) {
    $keys[] = 'сделать томографию';
}
$field = $fr('field','value');
$keys[] = $field;
$slices = preg_replace('/[^\d]/','',$fr('slices','value'));
$keys[] = $fr('slices','value');
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
$h1 = $text .' в '.$geoName;
$title = $text.' в '.$geoName;
if ($triggersPrepared['sortBy']['verbiage'] == 'priceUp') {
    $keys[] = $r.' недорого';
    $h1 .= ' недорого - представленные ниже клиники сгруппированы с учетом: Скидок, Акций и цен Ночью';
    $title .= ' недорого - здесь представлены клиники с наиболее выгодной ценой на данное исследование с учетом скидок, акций и ночных цен';
}
if ($page > 1) {
    $title .= ', страница '.$page;
}
$keys[] = 'поиск клиник';
$this -> pageTitle = $title;

//$geoName = $geoName ? $geoName : $fr('area','areaNameRod');
$description = "В ".$geoName." ".$rRod. " можно пройти в ".count($allObjects). clinicWord(count($allObjects)).", на данной странице представлены все эти медицинские центры, также здесь вы можете провести детальный поиск по различным параметрам исследования.";
/**
 * @type ObjectPrice $research
 */
$research = $researchObject;
if ($research) {
    $description .= ' '.$research -> getArticle() -> description;
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
        <div class="col-md-3 hidden-sm-down">
            <div id="accordion" role="tablist" aria-multiselectable="true">
                <?php foreach(ObjectPriceBlock::model() -> findAll(['order' => 'num ASC','with' => 'prices']) as $block){
                    $this -> renderPartial('/prices/_single_block', ['priceBlock' => $block, 'mainPrice' => $research]);
                } ?>
            </div>
        </div>
        <div class="col-md-6">
            <h2 class="text-center" style="font-size:1.75rem;">Цены и адреса, где можно сделать <?php echo $rVin; ?> в <?php echo $geoName; ?></h2>
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
                <div style="text-align:left" class="col-12 my-1 ml-2 form-inline">
                    <div class="mx-2 form-group">
                        <label for="sortBySelect">Сортировка по цене</label>
                        <select class="form-control" id="sortBySelect">
                            <?php
                                $vals = ['' => 'нет','priceUp' => 'дешевле','priceDown' => 'дороже'];
                                foreach ($vals as $val => $label) {
                                    $selected = $val == $triggers['sortBy'] ? 'selected=selected' : '';
                                    echo "<option value='$val' $selected>$label</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>
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
                    <?php
                    $counter = 1;
                    foreach($objects as $clinic){
                        if ($counter % 5 == 0) {
                            echo "<li class='clinic mb-3 single-clinic pt-3 d-flex row'><div class='d-block text-center'>";
                            echo "<div>Получить самую <strong>актуальную информацию</strong> и <strong>бесплатную</strong> консультацию по <strong>ценам на МРТ/КТ</strong> и <strong>адресам клиник</strong> в ".$geoName." вы можете, оставив </div>
                            <div class='text-center'><button class='btn signUpButton' data-city='".$triggers['area']."'>Заявку на обратный звонок</button></div>";
                            echo "<div>Через наш колл-центр Вы также можете </div><div class='text-center'><button class='btn signUpButton' data-city='".$triggers['area']."'>Записаться на $rVin в $geoName</button></div>";
                            echo "</div></li>";
                        }
                        $counter ++;
                        $this -> renderPartial('/clinics/_single_clinics',['model' => $clinic,'price' => $research]);
//                        break;
                    }
                    ?>
                </ul>
            </div>
            <div class="pager">
                <?php
                    $copy = $triggers;
                    unset($copy['isCity']);
                    $this -> renderPartial('/pager',[
                    'curPage' => $page,
                    'totalPages' => ceil(count($allObjects) / $pageSize),
                    'baseLink' => $this -> createUrl('home/clinics',array_merge($copy,['page'=>':pageNumber']))
                ]) ?>
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
            <?php
            //Закрываем обвес для индексации
            if (count($allObjects) == 0) { echo "<!--noindex-->"; } ?>

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
            //Конец куска запрещенного к индексации обвеса
            if (count($allObjects) == 0) { echo "<!--/noindex-->"; }
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
                echo "<div class='card'><div class='card-block'><div class='card-title'><h3>Полезные статьи</h3></div>";
                foreach ($articles as $article) {
                    $url = $this -> createUrl('home/articleView',['verbiage' => $article -> verbiage],null,false,true);
                    $imageUrl = $article -> getImageUrl();
                    if ($i < $decoratedArticles) {
                        echo "
                            <div>
                                <a class='article-name' href='$url'>
                                    <h3 class='text-center'>{$article->name}</h3>
                                    <img style='width:90%;margin:5px auto; display:block;' class='mx-auto' src='$imageUrl' alt='".addslashes($a->name)."'/>
                                </a>
                            </div>
                        ";
                    } else {
                        echo "
                            <div><a class='article-name' href='$url'><h3>{$article->name}</h3></a></div>
                        ";
                    }
                    $i ++;
                }
                echo "</div></div>";
            }
            ?>
        </div>
    </div>
</div>