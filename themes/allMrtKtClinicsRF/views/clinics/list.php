
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

Yii::app()->getClientScript()->registerCssFile(Yii::app() -> theme -> baseUrl.'/css/objects_list.css');
Yii::app()->getClientScript()->registerScriptFile(Yii::app() -> theme -> baseUrl.'/js/select2.full.js',CClientScript::POS_BEGIN);
?>


<div id="objects_list">
    <div id="column1" class="content_column">
        <div id="links" class="content_block">
            Тут будет дескрипшн
<!--            <a href="--><?php //echo Yii::app() -> baseUrl.'/'; ?><!--">Главная</a>-->
<!--            --><?php //$val = $_POST["clinicsSearchForm"]["speciality"] ? $_POST["clinicsSearchForm"]["speciality"] : $_POST["doctorsSearchForm"]["speciality"]; ?>
<!--            <a href="--><?php //echo $this -> createUrl('home/clinics');?><!--">--><?php //echo "Клиники" ; ?><!--</a>-->
        </div>
        <div id="search_menu">
            <div id="search_info">
                Найдено <span><?php echo count($objects) + 1; ?></span> <?php echo $modelName=='clinics' ? 'клиник' : 'врачей'; ?>
            </div>
            <div id="sortby">
                Сортиовать по: <a href="#" data-sort = "rating">Рейтинг</a><a href="#" data-sort="experience">Опыт</a><? if ($modelName=='doctors') :?><a href="#" data-sort = "price">Цена</a><? endif; ?>
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
