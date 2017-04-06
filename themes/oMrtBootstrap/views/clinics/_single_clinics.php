<?php
/**
 * @type clinics|doctors $model
 */
//$model -> refresh();
?>


<li class="media clinic mb-3 single-clinic pt-3">
	<div class="media-body">
		<h3 class="mt-0"><a href="<?php echo $model -> getUrl(); ?>"><?php echo $model -> name; ?></a></h3>
		<?php $this -> renderPartial('/clinics/_iconData', ['model' => $model, 'data' => $data, 'price' => $price]); ?>
	</div>
	<div class="right-pane">
		<img class="d-flex align-self-start mr-3 img-fluid" src="<?php echo $model -> giveImageFolderRelativeUrl() . $model -> logo;?>" alt="">
		<div class="rateit" data-rateit-value="<?php echo $model->rating; ?>" data-rateit-ispreset="true" data-rateit-readonly="true"></div>
		<div class="mb-1"><a href="<?php echo $model -> getUrl(); ?>#reviews">Читать отзывы</a></div>
		<?php $this -> renderPartial('/clinics/_buttons',['model' => $model]); ?>
	</div>
</li>