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

$cs -> registerMetaTag('c05418a51fe33efa','yandex-verification');
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
?>
<div class="container-fluid article p-3">
    <div class="row">
        <div class="col-12 col-md-10 mx-auto">
            <h1>Все об МРТ и КТ</h1>
            <div class="row justify-content-between">
                <div class="col-12 col-md-5">
                    <?php $this -> renderPartial('/article/renderList', array('articles' => $first_column)); ?>
                </div>
                <div class="col-12 col-md-5">
                    <?php $this -> renderPartial('/article/renderList', array('articles' => $second_column)); ?>
                </div>
            </div>
        </div>
    </div>
</div>