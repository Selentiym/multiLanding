<?php
/**
 * @type Article $model
 */
$this->setPageTitle($model->title);
Yii::app() -> getClientScript() -> registerMetaTag($model -> description,'description');
Yii::app() -> getClientScript() -> registerMetaTag($model -> keywords,'keywords');

$this->renderPartial('/article/_navBar', array('article' => $model));
?>

<div class="row no-gutters">
	<div class="col-12 col-md-10 p-3 mx-auto article">
		<h2>
			<?php echo $model->name; ?>
		</h2>
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
		<div class="children">
			<?php
				$children = empty($model -> giveChildren()) ? [] : $model -> giveChildren();
				$this -> renderPartial('/article/renderList',['articles' => $children]);
			?>
		</div>
	</div>
</div>