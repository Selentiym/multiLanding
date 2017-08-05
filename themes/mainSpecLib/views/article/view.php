<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12.06.2017
 * Time: 11:41
 * @var Article $model
 * @var SpecSiteHomeController $this
 */
$this->setPageTitle($model->title);
$cs = Yii::app() -> getClientScript();
$cs -> registerMetaTag($model -> description,'description');
$cs -> registerMetaTag($model -> keywords,'keywords');

$cs -> registerLinkTag('canonical', null, $this -> createUrl('home/articleView',['verbiage' => $model -> verbiage],'&',false,true));
$cityCodes = array(
    'Санкт-Петербург' => 'spb',
//		'Воронеж' => 'vrn',
//		'Екатеринбург' => 'ekb',
//		'Ижевск' => 'izh',
//		'Казань' => 'kazan',
//		'Краснодар' => 'krd',
//		'Московская область' => 'mo',
//		'Нижний Новгород' => 'nn',
//		'Новосибирск' => 'nsk',
//		'Пермь' => 'perm',
//		'Ростов-на-Дону' => 'rnd',
//		'Самара' => 'samara',
//		'Уфа' => 'ufa',
//		'Челябинск' => 'chlb'
);
if ($_GET['ip']) {
    $geo = new Geo(array('ip' => $_GET['ip']));
} else {
    $geo = new Geo();
}
$cityFromIp = $geo -> get_value('city');
$code = $cityCodes[$cityFromIp];
if (!$code) { $code = 'msc'; }

?>

<div class="row no-gutters">
    <div class="col-12 p-3 mx-auto article row">
        <div class="prices col-12 justify-content-around row">
            <?php
            if (count($model -> getPrices())) {
                $spbPrices = $this->renderPartial('/article/_priceSet', [
                    'prices' => $model->getPrices(),
                    'triggers' => ['area' => 'spb'],
                    'adding' => ' в Санкт-Петербурге'
                ], true);
                echo $spbPrices;
                //$this->renderPartial('/common/_dropDown', ['name' => 'Пройти обследование в Санкт-Петербурге', 'content' => $spbPrices, 'shown' => true]);
                $mscPrices = $this->renderPartial('/article/_priceSet', [
                    'prices' => $model->getPrices(),
                    'triggers' => ['area' => 'msc'],
                    'adding' => ' в Москве'
                ], true);
                echo $mscPrices;
                //$this->renderPartial('/common/_dropDown', ['name' => 'Пройти обследование в Москве', 'content' => $mscPrices, 'shown' => true]);
            }
            ?>
        </div>
        <div class="col-md-10 col-12 mx-auto">
            <?php
            $text = $model -> text;
            try {
                $text = $model -> prepareText($_GET);
            } catch (TextException $e) {
                $text = '<p class="textErrors">Внимание! В тексте могут быть ошибки отображения. Не обращайте на это внимания. В ближайшее время проблема будет решена.</p>'.$text;
            }
            echo $text;
            ?>
        </div>
        <div class="children row">
            <?php
            $children = empty($model -> giveChildren()) ? [] : $model -> giveChildren();
            $this -> renderPartial('/article/renderList',['articles' => $children]);
            //Вспомогательные ссылки
            $spec['mscCat']['obj'] = Article::model() -> findByAttributes(['verbiage' => 'mscCatalog']);
            $spec['mscCat']['url'] = $this -> createUrl('home/clinics',['area' => 'msc'],'&',false,true);
            $spec['spbCat']['obj'] = Article::model() -> findByAttributes(['verbiage' => 'spbCatalog']);
            $spec['spbCat']['url'] = $this -> createUrl('home/clinics',['area' => 'spb'],'&',false,true);
            $spec['mainLink']['obj'] = Article::model() -> findByAttributes(['verbiage' => 'mainLink']);
            $spec['mainLink']['url'] = Yii::app() -> baseUrl;
            foreach ($spec as $verb => $arr) {
                $obj = $arr['obj'];
                if (!$obj instanceof Article) {
                    continue;
                }
                echo "<div class='col-12 col-md-4'>";
                $this -> renderPartial('/article/_dumb_shortcut',[
                    'text' => $obj -> description,
                    'url' => $arr['url'],
                    'imageUrl' => $obj -> getImageUrl(),
                    'name' => $obj -> name
                ]);
                echo "</div>";
            }
            //$this -> renderPartial('/article/_dumb_shortcut')
            ?>
        </div>
    </div>
</div>
