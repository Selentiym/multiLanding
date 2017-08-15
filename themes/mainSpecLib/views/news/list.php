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
$phrase = ['spb' => 'Санкт-Петербурге','msc' => 'Москве', null => 'Москве и Санкт-Петербурге'];
$data = $_GET;
$page = $data['page'] > 0 ? $data['page'] : 1;
$pageSize = 20;
$criteria = new CDbCriteria();
//1 добавили, чтобы выводить кнопку или нет.
$criteria -> limit = $pageSize;
$criteria -> offset = $pageSize * ($page-1);
$models = News::newsPageByCriteria($data, $criteria);
$this -> setPageTitle('Скидки и акции в '.$phrase[$area]);
$cs -> registerMetaTag('На странице Вы найдете скидки и акции на МРТ и КТ обследования, которые можно пройти в '.$phrase[$area].'.','description');
?>

<div class="container-fluid pt-3">
    <div class="row">
        <div class="col-12 col-md-9">
            <h1 style="font-size:1.75rem">
                <?php
                echo 'Скидки и акции в '.$phrase[$area];
                ?></h1>
            <form class="mb-3" id="areaForm">Выберите город, в котором показать скидки:
                <select id="areaDropdown">
                    <option value="" data-url="<?php echo $this -> createUrl('home/news'); ?>">Любой</option>
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
                    <p>В <strong>Санкт-Петербурге</strong> сейчас действует <a href="<?php echo $this -> createUrl('home/news',['area' => 'spb']); ?>"><?php echo baseSpecHelpers::salesWord($spb); ?></a></p>
                    <p>В <strong>Москве</strong> сейчас действует <a href="<?php echo $this -> createUrl('home/news',['area' => 'msc']); ?>"><?php echo baseSpecHelpers::salesWord($msc); ?></a></p>
                    <?php if (count($researchedNews) > 0): ?>
                    <p>нижеперечисленные исследования можно пройти <strong>более выгодно</strong>:
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
                $head = ['mrt-besplatno' => 'МРТ бесплатно', 'kt-besplatno' => 'КТ бесплатно'];
                foreach ($extraArticles as $article) {
                    $this -> renderPartial('/article/_popup_article', ['a' => $article, 'heading' => $head[$article -> verbiage],'triggers' => []]);
                }
            }
            ?>
        </div>
    </div>
</div>