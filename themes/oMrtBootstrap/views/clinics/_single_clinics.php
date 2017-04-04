<?php
/**
 * @type clinics|doctors $model
 */
//$model -> refresh();
?>


<li class="media clinic mb-5">
	<div class="media-body">
		<h3 class="mt-0"><a href="<?php echo $model -> getUrl(); ?>"><?php echo $model -> name; ?></a></h3>
		<?php $this -> renderPartial('/clinics/_iconData', ['model' => $model, 'data' => $data, 'price' => $price]); ?>
	</div>
	<div class="right-pane">
		<img class="d-flex align-self-start mr-3" src="<?php echo $model -> giveImageFolderRelativeUrl() . $model -> logo;?>" alt="">
		<div class="rateit" data-rateit-value="<?php echo $model->rating; ?>" data-rateit-ispreset="true" data-rateit-readonly="true"></div>
		<div class="mb-1"><a href="<?php echo $model -> getUrl(); ?>#reviews">Читать отзывы</a></div>
		<button class="btn">Записаться</button>
		<div class="mb-1">Или по телефону</div>
		<div class="">Телефон</div>
	</div>
</li>