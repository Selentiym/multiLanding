<?php
/**
 * @type clinics|doctors $model
 */
//$model -> refresh();
?>
<div class="single_object">
	<div class="left_side">
		<div class="object_image_cont">
			<img src="<?php echo $model -> giveImageFolderRelativeUrl() . $model -> logo;?>" alt="<?php echo $model->name; ?>"/>
		</div>
<!--		<div class="reviews">-->
<!--			--><?php //echo CHtml::link('Отзывы', $model -> getUrl()); ?>
<!--		</div>-->
	</div>
	<div class="right_side">
		<h2 class="name"><a href="<?php echo $model -> getUrl(); ?>"><span><?php echo $model -> name; ?></span></a></h2>
		<div class="rateit" data-rateit-value="<?php echo $model->rating; ?>" data-rateit-ispreset="true" data-rateit-readonly="true"></div>
		<?php
			$this -> renderPartial('/clinics/_iconData', ['model' => $model, 'data' => $data]);
		?>
		<div class="description">
			<?php echo $model -> text; ?>
		</div>
	</div>
	<div class="bottom">
		<!--<div class="assign"><a href="<?php echo Yii::app() -> baseUrl . '/assign'; ?>"><span>Записаться на прием</span></a></div>-->
		<div class="more_info"><a href="<?php echo $model -> getUrl(); ?>"><span>Подробнее..</span></a></div>
	</div>
</div>