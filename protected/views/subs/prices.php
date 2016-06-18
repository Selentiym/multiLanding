<?php
/**
 * @type Rule $model
 */
?>
	<p><a name="price"></a></p>
	<a name="reviewsdva"></a>
	<a name="plus"></a>
	<h2>ЦЕНЫ, АКЦИИ И СКИДКИ</h2>
	

   
	<p class="dashed"> <img class="doctor2" src="<?php echo Yii::app() -> baseUrl; ?>/img/doctor2.png" alt="Доктор">
		Мы решили снизить цены на МРТ и КТ диагностику, сделав этот метод более доступным - дешевле только бесплатно!
	</p>

	<!--<img class="price" src="<?php //echo Yii::app() -> baseUrl; ?>/img/price.png" alt="price">-->
	<?php
		//Нашли все блоки.
		$blocks = PriceBlock::model() -> findAll(array('order' => '`num` ASC'));
		foreach ($model -> prices as $price) {
			//Перемещаем блоки с нужными ценами в начало массива
			$block = $price -> block;
			$key = array_search($block, $blocks);
			array_splice($blocks,$key,1);
			array_unshift($blocks,$block);
		}
		$prev = NULL;
		$light = CHtml::giveAttributeArray($model -> prices, 'id');
		foreach($blocks as $key => $block){
			$this -> renderPartial('//prices/_price_block',array(
					'prev' => $prev,
					'block' => $block,
					'highlight' => $light
			));
			$prev = $block;
		}
	?>
	<div class="main_uzi">
	
	<p class="uzi_text">* Также в наших клиниках Вы можете пройти УЗИ исследования, сдать анализы<br>
	   </p>
	   <p><a name="akcii"></a></p>
	<p class="uzi"></p>
	<p class="p_uzi">Записаться на МРТ и/или <br>КТ можно по телефону:<br><?php echo $model -> tel -> tel; ?></p>
	</div>