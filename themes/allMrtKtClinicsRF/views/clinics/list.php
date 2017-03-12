<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 23.02.2017
 * Time: 13:24
 */
$mod = Yii::app() -> getModule('clinics');

$modelName = 'clinics';

$objects = $mod -> getClinics($_GET);

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
            Тут будет дескрипшн
            <?php
                $a = ArticleRule::getArticle('service');
                if ($a) {
                    echo $a -> prepareText($_GET);
                } else {
                    echo "Статья не неайдена.";
                }
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
                $a = Article::model() -> findByAttributes(['verbiage' => 'dynamic']);
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
        <h2 id="all_spec">Тут будут ссылочки</h2>
        <div id="spec_list">
            <div class="speciality_shortcut <?php echo $active; ?>" data-spec_id="<?php echo $id; ?>">
                <span><?php echo "abc"; ?></span>
            </div>
        </div>
    </div>
</div>
