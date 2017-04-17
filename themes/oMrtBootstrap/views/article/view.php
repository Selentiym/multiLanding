<?php
/**
 * @type Article $model
 * @var HomeController $this
 */
$this->setPageTitle($model->title);
Yii::app() -> getClientScript() -> registerMetaTag($model -> description,'description');
Yii::app() -> getClientScript() -> registerMetaTag($model -> keywords,'keywords');

$this->renderPartial('/article/_navBar', array('article' => $model));
?>

<div class="row no-gutters">
	<div class="col-12 col-md-10 p-3 mx-auto article">
		<div>
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
		<div class="prices">
			<?php $this -> renderPartial('/prices/_price_group',[
					'id' => 'spbPrices',
					'name' => 'Цены в Санкт-Петербурге',
					'prices' => $model -> getPrices(),
					'model' => false,
					'show' => false,
					'triggers' => ['area' => 'spb']
				]); ?>
			<?php $this -> renderPartial('/prices/_price_group',[
					'id' => 'mscPrices',
					'name' => 'Цены в Москве',
					'prices' => $model -> getPrices(),
					'model' => false,
					'show' => false,
					'triggers' => ['area' => 'msc']
			]);
			?>
		</div>
		<div class="children">
			<?php
				$children = empty($model -> giveChildren()) ? [] : $model -> giveChildren();
				$this -> renderPartial('/article/renderList',['articles' => $children]);
			?>
		</div>
	</div>
</div>