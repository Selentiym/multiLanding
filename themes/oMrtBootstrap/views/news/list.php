<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 01.08.2017
 * Time: 10:56
 */
$area = in_array($_GET['area'],['spb','msc']) ? $_GET['area'] : null ;
$cs = Yii::app()->clientScript;
$url = $this -> createUrl('home/news',['area' => $area],'&',false,true);
$cs->registerLinkTag('canonical', null, $url);
$cs -> registerCoreScript('select2');
$cs -> registerScript('submitform','
    var drop = $("#areaDropdown");
    drop.select2();
    drop.change(function(){
        var url = drop.find("option:selected").attr("data-url");
        location.href = url;
    });
',CClientScript::POS_READY);

$data = $_GET;
$page = $data['page'] > 0 ? $data['page'] : 1;
$pageSize = 20;
$criteria = new CDbCriteria();
//1 добавили, чтобы выводить кнопку или нет.
$criteria -> limit = $pageSize;
$criteria -> offset = $pageSize * ($page-1);
$models = News::newsPageByCriteria($data, $criteria);
?>
<nav class="breadcrumb bg-faded no-gutters">
    <a class="breadcrumb-item col-auto" href="<?php echo $this -> createUrl($this->id.'/'.$this->defaultAction); ?>">Главная</a>
    <a class="breadcrumb-item col-auto" href="<?php echo $url; ?>">Новости</a>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-9">
            <h1 style="font-size:1.75rem">Новости, акции и скидки на МРТ и КТ в
                <?php
                $phrase = ['spb' => 'Санкт-Петербурге','msc' => 'Москве', null => 'Москве и Санкт-Петербурге'];
                echo $phrase[$area];
                ?></h1>
            <form class="mb-3" id="areaForm">Ваш город:
                <select id="areaDropdown">
                    <option value="" data-url="<?php echo $this -> createUrl('home/news'); ?>">Не выбран</option>
                    <option value="spb" <?php if ($area=='spb') { echo "selected=selected";} ?> data-url="<?php echo $this -> createUrl('home/news',['area' => 'spb']); ?>">Санкт-Петербург</option>
                    <option value="msc" <?php if ($area=='msc') { echo "selected=selected";} ?> data-url="<?php echo $this -> createUrl('home/news',['area' => 'msc']); ?>">Москва</option>
                </select>
                <?php

                //echo CHtml::dropDownList('area',$area,['' => 'Не выбран', 'spb' => 'Санкт-Петербург', 'msc' => 'Москва'],['id'=>'areaDropdown']);
            ?></form>
            <div>
                <?php
                    foreach ($models as $news) {
                        $this -> renderPartial('/news/_imagedShortcut',['model' => $news]);
                    }
                ?>
            </div>
        </div>
        <div class="col-12 col-md-3 article-right">
            <div class="card">
                <div class="card-block">
                    <?php
                        $crit = new CDbCriteria();
                        $time = 'CURRENT_TIMESTAMP';
                        $crit -> addCondition("
                            ((validFrom > 0 and $time > validFrom) or (not validFrom > 0))
                            AND ((validTo > 0 and $time < validTo) or (not validTo > 0))
                            AND (validFrom > 0 or validTo > 0)
                        ");
                        $toResearch = clone $crit;
                        $crit -> with = 'clinic';
                        $save = clone $crit;
                        clinics::model() -> setAliasedCondition(['area' => 3342], $crit,'clinic.');
                        clinics::model() -> setAliasedCondition(['area' => 3341], $save,'clinic.');
                        $spb = News::model() -> count($crit);
                        $msc = News::model() -> count($save);
                        $toResearch -> with = 'research';
                        $toResearch -> group = 'id_price';
                        $toResearch -> addCondition('id_price is not null');
                        $researchedNews = News::model() -> findAll($toResearch);
                    ?>
                    <p>В настоящий момент в <strong>Санкт-Петербурге</strong> проводится <a href="<?php echo $this -> createUrl('home/news',['area' => 'spb']); ?>"><?php echo salesWord($spb); ?></a></p>
                    <p>В настоящий момент в <strong>Москве</strong> проводится <a href="<?php echo $this -> createUrl('home/news',['area' => 'msc']); ?>"><?php echo salesWord($msc); ?></a></p>
                    <?php if (count($researchedNews) > 0): ?>
                    <p><strong>Со скидкой</strong> Вы можете пройти следующие <strong>обследования</strong>:
                    <ul>
                    <?php foreach($researchedNews as $news){
                        echo"<li><a href='".$this -> createUrl('home/clinics',['research' => $news -> research -> verbiage, 'area' => $area,'sortBy' => 'priceUp'])."'>".$news -> research -> name."</a></li>";
                    } ?>
                    </ul>
                    </p>
                    <?php endif; ?>
                </div>
            </div>
            <?php
            $extraArticles = [Article::model() -> findByAttributes(['verbiage' => 'mrt-besplatno']),Article::model() -> findByAttributes(['verbiage' => 'kt-besplatno'])];
            if (!empty($extraArticles)) {
                foreach ($extraArticles as $article) {
                    $this -> renderPartial('/article/_popup_article', ['a' => $article, 'triggers' => []]);
                }
            }
            ?>
        </div>
    </div>
</div>