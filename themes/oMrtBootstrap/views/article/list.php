<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 28.02.2017
 * Time: 18:30
 *
 * @type HomeController $this
 * @type ClinicsModule $mod
 */
$cs = Yii::app()->getClientScript();

Yii::app()->clientScript->registerLinkTag('canonical', null, $this -> createUrl('home/articles',[],'&',false,true));

$cs -> registerMetaTag('c05418a51fe33efa','yandex-verification');
$cs -> registerMetaTag('fa27ede9b02e532c5b752c4cb14f0a21','wmail-verification');
$this -> setPageTitle('Все об МРТ, КТ и ПЭТ');
$mod = Yii::app() -> getModule('clinics');
$articles = $mod -> getRootArticles();
$count = count($articles);
$c = 0;
$first_column = array();
$second_column = array();
$baseTheme = Yii::app() -> getTheme() -> baseUrl;
foreach($articles as $a){
    if ($c < $count/2) {
        $first_column[] = $a;
    } else {
        $second_column[] = $a;
    }
    $c++;
}
$this -> renderPartial('/article/_navBar',[]);
?>
<div class="container-fluid article p-3">
    <div class="row">
        <div class="col-12 col-md-10 mx-auto">
            <h1>Все об МРТ, КТ и ПЭТ</h1>
            <div class="row justify-content-between">
                <div class="col-12">
                    <?php $this -> renderPartial('/article/renderList', array('articles' => $first_column)); ?>
                </div>
                <div class="col-12">
                    <?php $this -> renderPartial('/article/renderList', array('articles' => $second_column)); ?>
                </div>
                <div class="col-12">

                    <?php
                    $common = dataForStandardArticleCards();
                    unset($common['lib']);
                    $this -> renderPartial('/article/renderList', array('articles' => $common)); ?>
                </div>
            </div>
        </div>
    </div>
</div>