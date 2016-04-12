<div class="clear"></div>

<div class="main_time_akciy">
	<div class="skidka_time_akciy">
		<img src="<?php echo Yii::app() -> baseUrl; ?>/img/skidka_time.png" alt="Скидки и акции"><p>АКЦИИ И СКИДКИ</p>
	</div>
	
	<div class="time_akciy">
		<h2>АКЦИЯ: <?php echo $model -> price -> text. ' '. $model -> price -> price.'р!'; ?></h2>
		<div class="timer">
			<div style="display:none;">
				$('#countdown').timeTo(new Date('<span id="date-str"></span>'));
				$('#countdown').timeTo({
				timeTo: new Date(new Date('<span id="date2-str"></span>')),
				displayDays: 2,
				theme: "black",
				displayCaptions: true,
				fontSize: 8,
				captionSize: 14
				});
			</div>
			<h4>До конца акции осталось</h4>
			<div id="countdown-3"></div>
		</div>
		<p>Консультация НЕВРОЛОГА – <span>БЕСПЛАТНО</span></p>

		<p>Консультация ТРАВМАТОЛОГА - <span>БЕСПЛАТНО</span></p>

		<p>Консультация ДИАГНОСТА– <span>БЕСПЛАТНО</span></p>

		<p style="border:none;color:#e12b25;font-weight:600;">Скидки на АНАЛИЗЫ до 50%</p>
		<p><a name="oborud"></a></p>
		<p class="dashed "> <img class="doctor" src="<?php echo Yii::app() -> baseUrl; ?>/img/ktdoctor.png" alt="Доктор">
			Но снизив цены, мы все равно будем лучшие, т.к.:<br>
			1.У нас лучшие Врачи;<br>
			2. У нас лучшее в городе оборудование;<br>
			

		</p>
	</div>

</div>