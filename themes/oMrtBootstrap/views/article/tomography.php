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