<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12.06.2017
 * Time: 11:42
 *
 * @var Controller $this
 * @var Article $main
 */
$cs = Yii::app() -> getClientScript();


$this -> setPageTitle('Библиотека');
$mod = Yii::app() -> getModule('clinics');
$articles = $mod -> getRootArticles();
$main = Article::model() -> findByAttributes(['verbiage' => 'mainPage']);
if (!$main instanceof Article) {
    $main = new Article();
    $main -> name = 'Библиотека';
    $title = 'Библиотека';
    $description = 'На странице Вы найдете статьи о МРТ и КТ, когда стоит проходить диагностику, сколько стоит сделать томографию, адреса и клиники, где это можно сделать.';
    $keys = implode(',',['цены на МРТ','цены на КТ','адреса',"противопоказания","клиники","ночью дешевле","скидки"]);
} else {
    $title = $main -> title;
    $description = $main -> description;
    $keys = $main -> keywords;
}
$this -> setPageTitle($title);
$cs -> registerMetaTag($description,'description');
$cs -> registerMetaTag($keys,'keywords');
?>
<div class="row">
    <div class="col-12 col-md-10 mx-auto pt-3">
        <h1><?php echo $main -> name; ?></h1>
        <?php echo $main -> text; ?>
        <div class="children row">
        <?php $this -> renderPartial('/article/renderList',['articles' => $articles]); ?>
        </div>
        <div class="col-12">

            <?php
            $common = baseSpecHelpers::dataForStandardArticleCards();
            unset($common['lib']);
            $this -> renderPartial('/article/renderList', array('articles' => $common)); ?>
        </div>
    </div>
</div>
