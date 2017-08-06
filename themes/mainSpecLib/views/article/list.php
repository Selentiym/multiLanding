<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12.06.2017
 * Time: 11:42
 */
$this -> setPageTitle('Библиотека');
$mod = Yii::app() -> getModule('clinics');
$articles = $mod -> getRootArticles();
$main = Article::model() -> findByAttributes(['verbiage' => 'mainPage']);
if (!$main instanceof Article) {
    $main = new Article();
    $main -> name = 'Библиотека';
}
?>
<div class="row">
    <div class="col-12 col-md-10 mx-auto pt-3">
        <h1><?php echo $main -> name; ?></h1>
        <?php echo $main -> text; ?>
        <div class="children row">
        <?php $this -> renderPartial('/article/renderList',['articles' => $articles]); ?>
        </div>
    </div>
</div>
