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

$cs -> registerMetaTag('22b30a9a80600a49','yandex-verification');

$this -> setPageTitle('Все об МРТ, КТ и ПЭТ');
$mod = Yii::app() -> getModule('clinics');
$articles = $mod -> getRootArticles();
$count = count($articles);
$c = 0;
$first_column = array();
$second_column = array();
foreach($articles as $a){
    if ($c < $count/2) {
        $first_column[] = $a;
    } else {
        $second_column[] = $a;
    }
    $c++;
}
$this -> renderPartial('/article/_navBar',[]);

$main = Article::model() -> findByAttributes(['verbiage' => 'mainPage']);
if (!$main instanceof Article) {
    $main = new Article();
    $main -> name = 'Все об МРТ, КТ и ПЭТ';
}
?>
<div class="container-fluid article p-3">
    <div class="row">
        <div class="col-12 col-md-10 mx-auto">
            <h1><?php echo $main -> name; ?></h1>
            <?php echo $main -> text; ?>
            <div class="row justify-content-between">
                <div class="col-12">
                    <?php $this -> renderPartial('/article/renderList', array('articles' => $first_column)); ?>
                </div>
                <div class="col-12">
                    <?php $this -> renderPartial('/article/renderList', array('articles' => $second_column)); ?>
                </div>
            </div>
        </div>
    </div>
</div>