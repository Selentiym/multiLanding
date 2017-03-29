<?php
/**
 * @type Article $model
 */
$this->setPageTitle($model->title);
Yii::app() -> getClientScript() -> registerMetaTag($model -> description,'description');
Yii::app() -> getClientScript() -> registerMetaTag($model -> keywords,'keywords');
//echo $model -> title;
Yii::app()->getClientScript()->registerCssFile(Yii::app()->theme->baseUrl.'/css/articles_list.css');
Yii::app()->getClientScript()->registerCssFile(Yii::app()->theme->baseUrl.'/css/objects_list.css'); ?>

<div class="content_block_no_padding">
	<div id="article_head">
		<?php $this->renderPartial('/article/_navBar', array('article' => $model)); ?>
		<h1>
		   <?php echo $model->name; ?>
		</h1>
	</div>
	<?php //if (empty($children)): ?>
    <div id="article_text_cont">
        <?php
			$text = $model -> text;
			try {
				$text = $model -> prepareText($_GET);
			} catch (TextException $e) {
				$text = '<p class="textErrors">Внимание! В тексте могут быть ошибки отображения. Не обращайте на это внимания. В ближайшее время проблема будет решена.</p>'.$text;
			}
			echo $text; ?>
    </div>
	<?php //else: ?>
	<?php
	echo "<ul class='children'>";
	$children = $model -> giveChildren();
	foreach ($children as $child)
	{
		//	echo "<li>";
		echo $this->renderPartial('/article/_shortcut_expanded',array('article' => $child, 'baseArticleUrl' => $model -> GenerateUrl()));
		//echo "</li>";
	}
	echo "</ul>";
	?>
	<?php //endif; ?>
    <br/>
    <?php
		//var_dump($clinic);
		if ($clinic !== '')
		{
			//листалка для карточки клиник
			$id = 'clinic_card_container';
			echo CHtml::openTag('div',array('id' => $id));
			//Отображаем текущую карточку.
//			$this -> renderPartial('//home/viewLister', array(
//				'clinic' => $clinic,
//				'left' => $left,
//				'right' => $right,
//				'page' => $page)
//			);
			echo CHtml::closeTag('div');
			//Обеспечиваем листалку на ajax'е.
			Yii::app()->clientScript->registerScript('take', "
				function TakePage(page)
				{
					//alert(document.location.hostname + document.location.pathname);
					//var URL_part = document.location.hostname + document.location.pathname;
					var verbiage = '".$model -> verbiage."';
					
					$.ajax({
						url:'http://'+document.location.hostname + '".Yii::app() -> baseUrl."' + '/home/listpage?page='+page+'&verbiage='+verbiage,
						dataType:'html',
						success: function(data){
							$('#".$id."').html(data);
							Rate();
						}
					});
				}
			",CClientScript::POS_HEAD);
		}
	?>
</div>