<?php
/**
 * @type Article $model
 * @var HomeController $this
 */
$this->setPageTitle($model->title);
$cs = Yii::app() -> getClientScript();
$cs -> registerMetaTag($model -> description,'description');
$cs -> registerMetaTag($model -> keywords,'keywords');

$cs -> registerLinkTag('canonical', null, $this -> createUrl('home/articleView',['verbiage' => $model -> verbiage],'&',false,true));

$this->renderPartial('/article/_navBar', array('article' => $model));

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
		<div class="prices col-md-3">
			<?php $this -> renderPartial('/prices/_price_group_article',[
					'id' => 'spbPrices',
					'name' => 'Цены в Санкт-Петербурге',
					'prices' => $model -> getPrices(),
					'model' => false,
					'show' => $code == 'spb',
					'triggers' => ['area' => 'spb', 'sortBy' => 'priceUp']
			]); ?>
			<?php $this -> renderPartial('/prices/_price_group_article',[
					'id' => 'mscPrices',
					'name' => 'Цены в Москве',
					'prices' => $model -> getPrices(),
					'model' => false,
					'show' => $code == 'msc',
					'triggers' => ['area' => 'msc', 'sortBy' => 'priceUp']
			]);
			?>
		</div>
		<div class="col-md-9">
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
		<div class="children">
			<?php
				$children = empty($model -> giveChildren()) ? [] : $model -> giveChildren();
				$children = array_merge(dataForStandardArticleCards(),$children);
				$this -> renderPartial('/article/renderList',['articles' => $children]);
			?>
		</div>
	</div>
</div>