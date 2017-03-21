<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 23.02.2017
 * Time: 13:24
 *
 * @type ClinicsModule $mod
 */
$mod = Yii::app() -> getModule('clinics');

$modelName = 'clinics';
$criteria = new CDbCriteria();
$criteria -> addCondition("`ignore_clinic`=0");
$objects = $mod -> getClinics($_GET,null,null,$criteria);

$cs = Yii::app()->getClientScript();

$cs->registerCssFile(Yii::app() -> theme -> baseUrl.'/css/objects_list.css');
$cs->registerCssFile(Yii::app() -> theme -> baseUrl.'/css/rateit.css');
$cs->registerScriptFile(Yii::app() -> theme -> baseUrl.'/js/select2.full.js',CClientScript::POS_BEGIN);
$cs->registerScriptFile(Yii::app()->theme -> baseUrl.'/js/jquery.rateit.min.js?' . time(), CClientScript::POS_END);
$cs -> registerScript('Rate','Rate()',CClientScript::POS_READY);
$cs -> registerCoreScript('prettyFormUrl');
$cs -> registerCoreScript('font-awesome');
$cs -> registerScript('Order','
	$("#sortby a").click(function(e){

		$("#sortByField").val($(this).attr("data-sort"));
		$("#searchForm").submit();
		return false;
	});
',CClientScript::POS_READY);

$noDisplay = ['mrt', 'kt'];

?>

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
                <?php
                $triggers = $_GET;
                $triggersPrepared = Article::prepareTriggers($triggers);
                $fr = function ($trigger, $field) use ($triggersPrepared){
                    return Article::renderParameter($triggersPrepared, $trigger,$field);
                };
                $text = '';

                if ($street = $fr('street','value')) {
                    $text .= $street.",";
                } elseif ($distr = $fr('district','value')) {
                    $text .= $distr.' район,';
                }
                if ($triggersPrepared['time']['verbiage']) {
                    $text .= ($text ? ' к' : 'К').'круглосуточно';
                }
                $research = $fr('research', 'value');
                if (!$research) {
                    if ($triggersPrepared['mrt']['verbiage']) {
                        $r = 'МРТ ';
                    }
                    if ($triggersPrepared['kt']['verbiage']) {
                        $r = $r ? $r.' и КТ' : 'КТ' ;
                    }
                    $r = $r ? $r : 'МРТ или КТ';
                } else {
                    $r = $research;
                }
                $text .= ($text ? ' с' : 'С').'делать '.$r;

                if ($triggersPrepared['contrast']) {
                    $text .= ' с контрастом';
                }
                $field = $fr('field','value');
                $slices = preg_replace('/[^\d]/','',$fr('slices','value'));
                $type = $fr('magnetType', 'type');
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

                if (!$street) {
                    if ($metro = $fr('metro','value')) {
                        $text .= ' около метро '.$metro;
                    }
                }
                if ($temp = $fr("children","value")) {
                    $text .= ' детям';
                }

                if ($triggersPrepared['sortBy']['verbiage'] == 'priceUp') {
                    $text .= ' недорого - представленные ниже клиники сгруппированы с учетом: Скидок, Акций и цен Ночью';
                }

                echo $text;
                ?>
            </h1>
            <?php
                $countClinics = function($verbs) use ($triggers){
                    $condition = [];
                    foreach ($verbs as $verb) {
                        $condition[$verb] = $triggers[$verb];
                    }
                    $condition = array_filter($condition);
                    return count(Yii::app() -> getModule('clinics') -> getClinics($condition));
                };
                $echoClinicsNumber = function($num){
                    $r = $num;
                    if ($num == 0) {
                        $r .= ' клиник';
                    } elseif ($num % 10 == 1) {
                        $r .= ' клинике';
                    } elseif($num % 10 != 1 ){
                        $r .= ' клиниках';
                    }
                    return $r;
                };
                $echoMedCentersNumber = function($num){
                    $r = $num;
                    if ($num == 0) {
                        $r .= ' медицинских центров';
                    } elseif ($num % 10 == 1) {
                        $r .= ' медицинском центре';
                    } elseif($num % 10 != 1 ){
                        $r .= ' медицинских центрах';
                    }
                    return $r;
                };
                echo "<p>Где можно сделать $r в Санкт-Петербурге (СПб)?</p>";
                $num = $mod -> getClinics([
                    'mrt' => $triggersPrepared['mrt']['verbiage'],
                    'kt' => $triggersPrepared['kt']['verbiage'],
                    'research' => $triggersPrepared['research']['verbiage'],
                ]);
                echo "<p>Пройти диагностику $r можно в ".$echoClinicsNumber($countClinics(['mrt','kt','research'])). ' Санкт-Петербурга</p>';
                echo "<p>Сколько стоит {$r}?</p>";
                echo "<p>Средняя цена на $r равна {$mod->averagePrice($triggers)}</p>";


                if ($street) {
                    echo "<p>Где можно сделать $r в непосредственной близости от адреса: {$street}?</p>";
                    echo "Пройти $r можно в ".$echoMedCentersNumber($countClinics(['district']))." в непосредственной близости от адреса: {$street}";
                } elseif ($distr = $fr('district', 'districtPredl')) {
                    echo "<p>Где можно сделать $r в $distr районе?</p>";
                    echo "<p>Пройти $r можно в ".$echoMedCentersNumber($countClinics(['district','mrt','kt','research']))." в $distr районе.</p>";
                } elseif ($metro = $fr('metro','value')) {
                    echo "<p>Где можно сделать $r в возле метро $metro?</p>";
                    echo "<p>Пройти $r можно в ".$echoMedCentersNumber($countClinics(['metro']))." возле метро $metro.</p>";
                }
                if (($type)&&(!$slices)&&(!$field)) {
                    echo "<p>$r на ".$fr('magnetType','tomografTypeCommentPredl').' томографе можно пройти в '.$echoClinicsNumber($countClinics(['mrt','kt','research','magnetType']))."</p>";
                } elseif ($field) {
                    echo "<p>$r на $field ".$fr('field','fieldCommentPredl')." томографе можно пройти в ".$echoClinicsNumber($countClinics(['mrt','kt','research','magnetType','field']))."</p>";
                } elseif ($slices) {
                    echo "<p>$r на {$slices}-срезовом томографе можно пройти в ".$echoClinicsNumber($countClinics(['mrt','kt','research','magnetType','field']))."</p>";
                }
                if ($triggers['contrast']) {
                    echo "<p>$r с контрастом - $r с контрастированием можно сделать в ".$echoMedCentersNumber($countClinics(['mrt','kt','research','contrast']))."</p>";
                    //Определяем, что интересно пользоателю: мрт или кт
                    if ($triggers['research']) {
                        $rType = PriceType::getAlias(ObjectPrice::model()->findByAttributes(['verbiage' => $triggers['research']])->id_type);
                    } else {
                        if ($triggers['mrt']) {
                            $rType = 'mrt';
                        }
                        if ($triggers['kt']) {
                            $rType = 'kt';
                        }
                    }
                    if ($rType == 'mrt') {
                        echo "
                    <p>Это исследование, при котором пациенту внутривенно вводят парамагнитное контрастное вещество. В отличие от компьютерной томографии, контрастные вещества, используемые в МРТ диагностике легче переносятся организмом, но все же проверить функцию почек перед проведением исследования рекомендуется (анализ на креатинин). Использование контрастного усиления позволяет получить дополнительную диагностическую информацию при поиске и дифференциации новообразований (как доброкачественных, так и злокачественных), позволяет более качественно визуализировать сосуды, также контрастное усиление необходимо в ряде специализированных видов КТ и МРТ диагностики, таких как Перфузия.</p>
                    ";
                    } else {
                        echo "<p>Это исследование, при котором пациенту внутривенно вводят йодсодержащее контрастное вещество. Нужно понимать, что использование контраста при проведении компьютерной томографии имеет ограничения и противопоказания, к которым относятся: аллергия на йод и сниженная функция почек (рекомендуется сделать анализ на креатинин). Использование контрастного усиления позволяет получить дополнительную диагностическую информацию при поиске и дифференциации новообразований (как доброкачественных, так и злокачественных), позволяет визуализировать сосуды, также контрастное усиление необходимо в ряде специализированных видов КТ и МРТ диагностики, таких как Перфузия.</p>";
                    }
                }
                if ($triggers['children']) {
                    echo "<p>$r детям - сделать $r ребенку можно в ".$echoClinicsNumber($countClinics(['research','mrt','kt','children']))."</p>";
                }
                if ($triggers['sortBy'] == 'priceUp') {
                    echo "<p>Медицинские клиники, представленные ниже, отфильтрованы по возрастанию цены на $r с учетом: Скидок, Акций и цен Ночью. От более дешевого ценового предложения к более высокому.</p>";
                }
                if ($triggers['time']) {
                    echo "<p>$r круглосуточно – ниже представлены медицинские центры, где $r можно пройти круглосуточно.</p>";
                }
                //echo "Пройти диагностику $r можно в ".$countClinics(['mrt','kt','research']). " медцентрах.";
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
                $service = Yii::app() -> getModule('clinics') -> getClassModel('clinics') -> findByAttributes(['verbiage' => 'service']);
                if ($service instanceof clinics) {
                    $this->renderPartial('/clinics/_single_clinics', ['data' => $service]);
                }
                //$a = Article::model() -> findByAttributes(['verbiage' => 'dynamic']);
                if ($a) {
                    echo "<div class='single_object'>".$a -> prepareTextByVerbiage($_GET)."</div>";
                }
                if (!empty($objects)) {
                    foreach($objects as $object) {
                        $this -> renderPartial('/clinics/_single_clinics',['data' => $object]);
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
