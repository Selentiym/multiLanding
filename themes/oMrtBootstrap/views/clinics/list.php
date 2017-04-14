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
$objects = $mod -> getClinics($_GET,null,null,$criteria);

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
            console.log(extra);
            for(var j=0;j < group.length; j++) {
                var str = group[j];
                var el = Triggers.objs[str].element;
                if (extra.newVal) {
                    if (saveI != j) {
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
    }

",CClientScript::POS_READY);

$cs -> registerCoreScript('select2');
$cs -> registerCoreScript('rateit');

$cs->registerScriptFile("https://api-maps.yandex.ru/2.1/?lang=ru_RU");
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
            console.log(allClinics);
            allClinics.redraw();
            if (typeof allClinics.redraw == 'function') {
                allClinics.redraw();
            }
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
$geoName = $fr('area', 'areaNameRod');
//$geoName = $geoName ? $geoName : $fr('area','areaNameRod');
$description = $rRod. " можно пройти в ".count($objects). ' ' . clinicWord(count($objects))." ".$geoName.", на данной странице представлены все эти медицинские центры, также здесь вы можете провести детальный поиск по различным параметрам исследования.";
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
                        <?php
                        echo CHtml::DropDownListChosen2(
                            'research',
                            'research',
                            CHtml::listData(ObjectPrice::model() -> findAll(['order' => 'id_block ASC']),'verbiage','name'),
                            //$htmlOptions['disabled'] ? [] : CHtml::listData($this -> trigger_values,'verbiage','value'),
                            ['style' => 'width:100%', 'empty_line' => true, 'placeholder' => 'Исследование'],
                            $triggers['research'] ? [$triggers['research']] : [],
                            [],
                            true
                        );
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
            </form>
            <div id="mapContainer" class="hidden-sm-down mb-3">
                <h2 class="mb-3">Клиники на карте</h2>
                <div><button class="btn" data-toggle="collapse" data-target="#map">Показать на карте</button></div>
                <div class="collapse"  id="map" style="width:100%; height:300px">
                </div>
            </div>
            <div id="clinicsList">
                <ul class="list-unstyled">
                    <?php if (count($objects) == 0): ?>
                    <li class="clinic mb-3 single-clinic pt-3">
                        К сожалению клиник, удовлетворяющих всем критериям поиска, не найденно.
                        Вы можете обратиться к специалистам "Общегородской Службы Записи", где вам помогут найти подходящий диагностический центр.
                    </li>
                    <?php endif; ?>


                    <li class="clinic mb-3 single-clinic pt-3 d-flex row">
                        <div class="col-12 col-md-9 small_info">
                            <h3 class="mt-0"><a href="#">Бесплатная общегородская служба записи на МРТ и КТ диагностику</a></h3>
                            <?php
                            icon('clock-o','пн-вс:круглосуточно');
                            icon('phone','Телефон');
                            ?>
                            <p>Пройти МРТ и КТ можно во всех районах города.</p>
                            <div class="row">
                                <div class="col-12"><?php icon('child','МРТ и КТ детям (с наркозом и без)'); ?></div>
                                <div class="col-12"><?php icon('hand-stop-o','Без ограничений по весу'); ?></div>
                                <div class="col-12"><?php icon('clock-o','Круглосуточно'); ?></div>
                                <div class="col-12"><?php icon('money','Горячие предложения на МРТ и КТ диагностику (Акции и скидки по городу)'); ?></div>
                                <div class="col-12"><?php icon('user-md','Бесплатная консультация врача (диагност, невролог, травматолог)'); ?></div>
                                <div class="col-12"><?php icon('life-ring','МРТ 0.2-0.4 Тесла, 1.5 Тесла, 3 Тесла, КТ 16 срезов, 64 среза, 128 срезов'); ?></div>
                                <div class="col-12"><?php icon('paint-brush','Исследования с контрастом'); ?></div>
                            </div>
                        </div>
                        <div class="right-pane col-12 col-md-3 flex-first flex-md-unordered">
                            <img class="mr-3 img-fluid" src="<?php echo Yii::app() -> theme -> baseUrl; ?>/images/logo.png" alt="Общегородская служба записи" />
                            <div><div class="rateit" data-rateit-value="5" data-rateit-ispreset="true" data-rateit-readonly="true"></div></div>
                            <?php $this -> renderPartial('/clinics/_buttons',['model' => $model]); ?>
                        </div>

                        <div class="col-12">
                            <p>Обращаясь в общегородскую службу записи на МРТ и КТ обследования, всегда можно получить:</p>
                            <ul>
                                <li>консультацию по поводу прохождения МРТ/КТ-обследований, относящуюся к общим вопросам о противопоказаниях, особенностях диагностики и т.д.;</li>
                                <li>- помощь в выборе клиники в своем районе, которая будет располагать всеми необходимыми возможностями;</li>
                                <li>- консультацию о возможностях отдельного диагностического центра: оборудования, врачей и прочих характеристик, которые могут быть полезны клиенту;</li>
                                <li>- помощь в записи на обследование в выбранную клинику на конкретное время, в том числе в ночное время суток.</li>
                            </ul>
                            <div class="collapse" id="moreAboutService">
                            <p>База данных службы записи содержит только проверенные центры, которые оказывают сертифицированные услуги и прошли аттестацию независимыми медицинскими аудиторами. Обращаясь в эти клиники, клиент может быть уверен в качестве оказанной услуги.</p>
                            <p>Каждый из медицинских центров, предлагаемых службой записи, оборудован современным высокоинформативным оборудованием, которое не причиняет вреда здоровью, а штат клиник укомплектован грамотными опытными специалистами.</p>
                            <p>Записаться на прием через службу записи - бесплатно. Просто позвоните, и вам помогут подобрать клинику, прояснить все сложные моменты, запишут на обследование. Услуги центра ничего не стоят, оплату за обследование пациент вносит непосредственно в клинике.</p>
                            <p>В отдельных центрах при записи через службу можно пройти диагностику даже дешевле, чем при самостоятельном выборе этой же клиники: этому способствуют партнерские скидки. Помимо того, при записи всегда будут учитываться особенности клиента: группа (студенты, медицинские работники, инвалиды), время записи (существуют скидки на обследование, например, в ночное время), прочие возможные основания для получения скидки. Общегородская служба записи на МРТ и КТ обследования постарается сделать все, чтобы клиент получил качественную услугу по максимально сниженной стоимости.</p>
                            </div>
                            <button class="btn" data-toggle="collapse" data-target="#moreAboutService">Подробнее</button>
                        </div>
                    </li>
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
            <?php if ($research&&($a = $research -> getArticle())): ?>
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
            $criteria = new CDbCriteria();
            $criteria -> compare('id_type', Article::getTypeId('text'));
            $articles = $mod -> getArticles($triggers, false, null, $criteria);
            if (!empty($articles)) {
                echo "<div class='card'><div class='card-block'><div class='card-title'><h3>Полезные статьи</h3></div>";
                foreach ($articles as $article) {
                    $url = $this -> createUrl('home/articleView',['verbiage' => $article -> verbiage]);
                    echo "
                        <div><a href='$url'>{$article->name}</a></div>
                    ";
                }
                echo "</div></div>";
            }
            ?>
        </div>
    </div>
</div>

<?php return; ?>

<div class="content_block" id="search_block">
    <h2 class="heading" id="search_clinics">Поиск клиник</h2>
    <form id="searchForm" action="prettyFormUrl" data-action="home/clinics" data-params="{}" data-gen-url="<?php echo addslashes(Yii::app() -> createUrl('home/createFormUrl')); ?>" class="noEmpty prettyFormUrl">
        <input name="sortBy" id="sortByField" type="hidden" value='<?php echo $_GET["sortBy"]; ?>'/>
        <?php
            $this -> renderPartial('/clinics/_beautiful_form');
        ?>
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
<div id="objects_list">
    <div id="column1" class="content_column">
        <div id="links" class="content_block">
            <h1>
                <?php echo $h1; ?>
            </h1>
            <?php
                generateText();
                //echo "Пройти диагностику $r можно в ".$countClinics(['mrt','kt','research','area']). " медцентрах.";
            ?>
            <?php
            /**
             * Генерируем title
             */
            $title = '';
            ?>

<!--            <a href="--><?php //echo Yii::app() -> baseUrl.'/'; ?><!--">Главная</a>-->
<!--            --><?php //$val = $_POST["clinicsSearchForm"]["speciality"] ? $_POST["clinicsSearchForm"]["speciality"] : $_POST["doctorsSearchForm"]["speciality"]; ?>
<!--            <a href="--><?php //echo $this -> createUrl('home/clinics');?><!--">--><?php //echo "Клиники" ; ?><!--</a>-->
        </div>
        <div id="search_menu">
            <div id="search_info">
                Найдено <span><?php echo count($objects) + 1; ?></span> <?php echo $modelName=='clinics' ? 'клиник' : 'врачей'; ?>
            </div>
            <div id="sortby">
                Сортиовать по:
                <a href="#" data-sort="rating">Рейтинг</a>
                <?php $priceVar = ($_GET['sortBy'] == 'priceUp') ? 'priceDown' : 'priceUp'; ?>
                <a href="#" class="<?php echo $_GET['sortBy']; ?>" data-sort = "<?php echo $priceVar; ?>">
                    Цена
                    <?php if ($_GET['sortBy'] == 'priceUp') echo '<i class="fa fa-sort-up"></i>'; ?>
                    <?php if ($_GET['sortBy'] == 'priceDown') echo '<i class="fa fa-sort-down"></i>'; ?>
                </a>
            </div>
        </div>
        <div id="the_list">
            <?php
                $data = $triggers;
                if ($data['research']) {
                    $data['research'] = ObjectPrice::model() -> findByAttributes(['verbiage' => $data['research']]);
                }
                $service = Yii::app() -> getModule('clinics') -> getClassModel('clinics') -> findByAttributes(['verbiage' => 'service']);
                if ($service instanceof clinics) {
                    $this->renderPartial('/clinics/_single_clinics', ['model' => $service, 'data' => $data]);
                }
                $a = ArticleRule::getArticle('dynamic');
                //$a = ;
                if ($a) {
                    echo "<div class='single_object'>".$a -> prepareTextByVerbiage($_GET)."</div>";
                }
                if (($research instanceof ObjectPrice)&&($a = $research -> getArticle())) {
                    echo "<div class='single_object'>".$a -> prepareTextByVerbiage($triggers)."</div>";
                }

                if (!empty($objects)) {
                    foreach($objects as $object) {
                        $this -> renderPartial('/clinics/_single_clinics',['model' => $object, 'data' => $data]);
                    }
                } else {
                    echo "<div class='single_object'>Не найдено ни одной клиники. Тут будет отдельная страничка.</div>";
                }
            ?>
        </div>
<!--        <div id="pager" class="content_block">-->
            <?php
//            $show_pages = 7;
//            $start = max(1,$page - $show_pages);
//            $stop = min($page + $show_pages, $maxPage);
//            if ($start != $stop) {
//                if ($start != $page) {
//                    echo "<div id='list_left'></div>";
//                }
//                for ($i = $start; $i <= $stop; $i++){
//                    $active = $page == $i ? 'active' : '' ;
//                    echo "<a href='?page=".$i."'><div class='pageNum ".$active."'>".$i."</div></a>";
//                }
//                if (($stop != $page)&&($stop > 0)) {
//                    echo "<div id='list_right'></div>";
//                }
//            }
            ?>
<!--        </div>-->
    </div>
    <div id="column2" class="content_column">
        <h2 id="all_spec">Вам могло бы быть интересно</h2>
        <?php
            $criteria = new CDbCriteria();
            $criteria -> compare('id_type', Article::getTypeId('text'));
            $articles = $mod -> getArticles($_GET, false, null, $criteria);
        ?>
        <div id="spec_list">
            <?php
            foreach ($articles as $article) {
                $url = $this -> createUrl('home/articleView',['verbiage' => $article -> verbiage]);
                echo "
                <div class='speciality_shortcut' >
                    <span><a href='$url'>{$article->name}</a></span>
                </div>
                ";
            }
            ?>
        </div>
    </div>
</div>
