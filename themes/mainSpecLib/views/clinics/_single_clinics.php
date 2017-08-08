<?php
/**
 * @type clinics|doctors $model
 */
//$model -> refresh();
?>


<div class="row">
	<div class="col-12 col-sm-3">
		<a href="<?php echo $model -> getUrl(); ?>"><img class="mr-3 img-fluid" src="<?php echo $model -> giveImageFolderRelativeUrl() . $model -> logo;?>" alt="<?php echo "Центр $r ".htmlspecialchars($model -> name); ?>"></a>
		<div class="text-center"><div class="rateit" data-rateit-value="<?php echo $model->rating; ?>" data-rateit-ispreset="true" data-rateit-readonly="true"></div></div>
	</div>
	<div class="col-12 col-sm-9">
		<h2 style="font-size:1rem"><a href="<?php echo $model -> getUrl(); ?>"><?php echo Yii::app() -> params['clinicPrefix'].' "'.$model -> name.'"'; ?></a></h2>
		<div><?php $this -> renderPartial('/clinics/_icons',['model' => $model]); ?></div>
		<?php
			$mainPrice = $price;
			if ($mainPrice instanceof ObjectPrice) {
				$val = $model->getPriceValue($mainPrice->id);
				$relaced = false;
				if (!$val instanceof ObjectPriceValue) {
					$val = $model -> getPriceValue($mainPrice -> id_replace_price);
					$replaced = true;
				}
				echo "<ul class='list-group my-2'>";
				$this->renderPartial('/common/_dropDownLine', [
						'class' => 'active singlePrice',
						'name' => $replaced ? $mainPrice->replacement->name . ' (в том числе ' . $mainPrice->name . ')' : $mainPrice->name,
						'price' => $val->value
				]);
				echo "</ul>";
			} else {
				$pricesHtml = [];
				if (!empty($blocks)) {
					foreach ($blocks as $block) {
						foreach ($block->prices as $price) {
							$val = $model->getPriceValue($price->id);
							$isMain = $price->id == $mainPrice->id;
							if ($val instanceof ObjectPriceValue) {
								$pricesHtml[$price->id] = $this->renderPartial('/common/_dropDownLine', [
										'class' => ($isMain) ? 'active' : '',
										'name' => $price->name,
										'price' => $val->value
								], true);
							}
						}
						if (!$pricesHtml[$mainPrice->id]) {
							$repl = $mainPrice->id_replace_price;
							$val = $model->getPriceValue($repl);
							if ($val instanceof ObjectPriceValue) {
								unset($pricesHtml[$repl]);
								$pricesHtml[$mainPrice->id] = $pricesHtml[$mainPrice->id] = $this->renderPartial('/common/_dropDownLine', [
										'class' => 'active',
										'name' => $mainPrice->replacement->name . ' (в том числе ' . $mainPrice->name . ')',
										'price' => $val->value
								], true);
							}
						}
						$save = $pricesHtml[$mainPrice->id];
						unset($pricesHtml[$mainPrice->id]);
						$content = $save . implode('', $pricesHtml);
					}
					$this->renderPartial('/common/_dropDown', [
							'name' => 'Цены',
							'shown' => true,
							'content' => $content
					]);
				}
			}
		?>
		<div class="text-center">
			<?php if ($model -> partner): ?>
			<button class="btn signUpButton btn-outline-success">Записаться</button>
			<?php endif; ?>
			<a href="<?php echo $model -> getUrl(); ?>"><button class="btn btn-outline-info">Подробнее</button></a>
		</div>
		<div class="mb-1"><a href="<?php echo $model -> getUrl(); ?>#reviews">Читать отзывы</a></div>
		<p class="pull-right">
			<?php
				$this -> renderPartial('/clinics/_tags',['model' => $model]);
			?>
		</p>
	</div>
</div>
<hr>