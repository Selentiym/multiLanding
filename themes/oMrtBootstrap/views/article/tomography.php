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

Yii::app()->clientScript->registerLinkTag('canonical', null, $this -> createUrl('home/tomography',[],'&',false,true));
$cs -> registerMetaTag('Что такое томография, протипопоказания томографии, сколько в среднем стоит томография, адреса где можно пройти МРТ или КТ, акции и скидки на обследования - все это можно найти на нашем сайте.','description');
$cs -> registerMetaTag(implode(', ',['все о томографии','цены на МРТ и КТ','противопоказания для томографии','цены и адреса где можно сделать томографию']),'keywords');
$this -> setPageTitle('Томография');
$mod = Yii::app() -> getModule('clinics');
$criteria = new CDbCriteria();
$articles = Article::model() -> findByAttributes(['verbiage'=>'tomographyContainer']) -> giveChildren();
if (empty($articles)) {
    $articles = [];
}
$count = count($articles);
$c = 0;
?>
<nav class="breadcrumb bg-faded no-gutters">
    <a class="breadcrumb-item col-auto" href="<?php echo $this -> createUrl($this->id.'/'.$this->defaultAction); ?>">Главная</a>
    <a class='breadcrumb-item col-auto' href='<?php echo $this -> createUrl('home/tomography'); ?>'>Томография</a>
</nav>
<div class="container-fluid article p-3">
    <div class="row">
        <div class="col-12 col-md-10 mx-auto">
            <h1>Томография</h1>
            <div class="row justify-content-between">
                <div class="col-12">
                    <?php $this -> renderPartial('/article/renderList', array('articles' => $articles)); ?>
                </div>
            </div>
        </div>
    </div>
</div>