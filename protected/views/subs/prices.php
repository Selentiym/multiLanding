	<p><a name="price"></a></p>
	<h2>ЦЕНЫ, АКЦИИ И СКИДКИ</h2>
	

   
	<p class="dashed"> <img class="doctor2" src="<?php echo Yii::app() -> baseUrl; ?>/img/doctor2.png" alt="Доктор">
		Мы решили снизить цены на МРТ и КТ диагностику, сделав этот метод более доступным - дешевле только бесплатно!
	</p>

	<!--<img class="price" src="<?php //echo Yii::app() -> baseUrl; ?>/img/price.png" alt="price">-->
	<?php
		/**
		 * Массив категорий
		 */
		$names = array(
			'mrt' => 'Цены МРТ',
			'kt_' => 'Цены КТ',
			'sel' => 'Общие цены',
		);
		/**
		 * Выводим блок цен, в котором находится выделенная цена.
		 */
		$block = $model -> price -> block;
		/**
		 * Сохраняем на будущее айдишник единственной выбранной цены
		 */
		$id = $model -> price -> id;
		//Рендерим заголовки и выбранную цену.
		?>
		<div class="blocks_label">
			<span class="label_img"></span><span class="label_text"><?php echo $names[$block -> category_name]; ?></span>
		</div>
		<?php
		if (is_a($block, 'PriceBlock')) {
			$block -> renderHeading();
			if ($model -> price) {
				$this -> renderPartial('//subs/_single_price', array('price' => $model -> price, 'active' => true));
			}
			$this -> renderPartial('//subs/_price_block', array('block' => $block, 'id' => $id, 'opened' => true, 'noHeading' => true));
		}
		
		$blocks['mrt'] = PriceBlock::model() -> findAllByAttributes(array('category_name'=>'mrt'));
		$blocks['kt_'] = PriceBlock::model() -> findAllByAttributes(array('category_name'=>'kt_'));
		$blocks['sel'] = PriceBlock::model() -> findAllByAttributes(array('category_name'=>'sel'));
		
		$this -> renderPartial('//subs/_block_category',array('label' => $names[$block -> category_name], 'blocks' => $blocks[$block -> category_name], 'id' => $id, 'block' => $block,'noHeading' => true));
		foreach($blocks as $category => $block_arr){
			if ($category == $block -> category_name) {continue;}
			$this -> renderPartial('//subs/_block_category',array('label' => $names[$category], 'blocks' => $block_arr, 'id' => $id, 'block' => $block));
		}
		
		//echo $price;
		/*Yii::app()->getClientScript()->registerScript('highlight',"
			var highlight = $('div.left-center:contains(\"$price\")');
			highlight.css('color','red');
			highlight.detach();
			//alert($('div.left-center:first').html());
			$('div.left-center:first').before(highlight);
		",CClientScript::POS_READY);*/
	?>
	<div class="main_uzi">
	
	<p class="uzi_text">* Также в наших клиниках Вы можете пройти УЗИ исследования, сдать анализы<br>
	   </p>
	   <p><a name="akcii"></a></p>
	<p class="uzi"></p>
	<p class="p_uzi">Записаться на МРТ и/или <br>КТ можно по телефону:<br><?php echo $model -> tel -> tel; ?></p>
	</div>