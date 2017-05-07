<?php
/**
 * @type clinics|doctors $model
 */
//$model -> refresh();
?>


<li class="clinic mb-3 single-clinic pt-3 d-flex row">
	<div class="col-12 col-md-9">
		<h3 class="mt-0"><a href="<?php echo $model -> getUrl(); ?>"><?php echo $model -> name; ?></a></h3>
		<?php $this -> renderPartial('/clinics/_iconData', ['model' => $model, 'data' => $data, 'price' => $price]); ?>
		<?php
		if ($price) {
			$this->renderPartial('/clinics/_priceList', ['model' => $model, 'blocks' => [ObjectPriceBlock::model()->findByPk($price->id_block)], 'price' => $price]);
		}
		?>
	</div>
	<div class="right-pane col-12 col-md-3 flex-first flex-md-last">
		<?php
		$r = false;
		if ($model -> getFirstTriggerValueString('mrt')) {
			$r = "МРТ";
		}
		if ($model -> getFirstTriggerValueString('kt')) {
			if ($r) {
				$r .= ' и КТ';
			} else {
				$r = 'КТ';
			}
		}
		if (!$r) {
			$r = 'МРТ или КТ';
		}
		?>
		<a href="<?php echo $model -> getUrl(); ?>"><img class="mr-3 img-fluid" src="<?php echo $model -> giveImageFolderRelativeUrl() . $model -> logo;?>" alt="<?php echo "Центр $r ".htmlspecialchars($model -> name); ?>"></a>
		<div><div class="rateit" data-rateit-value="<?php echo $model->rating; ?>" data-rateit-ispreset="true" data-rateit-readonly="true"></div></div>
		<div class="mb-1"><a href="<?php echo $model -> getUrl(); ?>#reviews">Читать отзывы</a></div>
		<?php $this -> renderPartial('/clinics/_buttons',['model' => $model]); ?>
	</div>
</li>