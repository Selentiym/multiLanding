<div class="clear"></div>
<a name="discount" style="padding-bottom: 100px;display: block;margin-top:-100px;"></a>
<div class="main_time_akciy">
	<div class="skidka_time_akciy">
		<div class="blocks_label">
			<span class="label_img"></span><span class="label_text">Акции и скидки</span>
		</div>

	</div>
	
	<div class="time_akciy">
		<h2>АКЦИЯ: <?php echo $model -> price -> text. ' '. $model -> price -> price.'р!'; ?></h2>
		<div id="timer">
			<?php
			Yii::app() -> getClientScript() -> registerScriptFile('js/flipclock.js', CClientScript::POS_BEGIN);
			Yii::app() -> ClientScript -> registerCssFile('css/flipclock.css');
			Yii::app() -> ClientScript -> registerScript('countDown',"
			var clock;
			clock = $('#clock').FlipClock({
		        clockFace: 'DailyCounter',
		        autoStart: false,
		        defaultLanguage: 'rus',
		        callbacks: {
		        	stop: function() {
		        		$('.message').html('Время вышло!')
		        	}
		        }
		    });
		    var toTime = new Date();
		    var toAdd = toTime.getDate() % 3 + 1;
		    toTime.setMinutes(0);
		    toTime.setSeconds(0);
		    toTime.setHours(toAdd*24);
		    var nowTime = new Date();
		    clock.setTime(Math.floor((toTime - nowTime)/1000));
		    clock.setCountdown(true);
		    clock.start();
			",CClientScript::POS_READY);
			?>
			<h4>До конца акции осталось</h4>
			<div class="container_countdown" style="width:380px;margin:0 auto;overflow:hidden;">
				<div id="clock"></div>
			</div>
		</div>
		<div id="akcii_other_cont">
		<p>Консультация НЕВРОЛОГА – <span>БЕСПЛАТНО</span></p>

		<p>Консультация ТРАВМАТОЛОГА - <span>БЕСПЛАТНО</span></p>

		<p>Консультация ДИАГНОСТА– <span>БЕСПЛАТНО</span></p>

		<p style="border:none;color:#e12b25;font-weight:600;">Скидки на АНАЛИЗЫ до 50%</p>
		<p class="dashed "> <img class="doctor" src="<?php echo Yii::app() -> baseUrl; ?>/img/ktdoctor.png" alt="Доктор">
			Но снизив цены, мы все равно будем лучшие, т.к.:<br>
			1.У нас лучшие Врачи;<br>
			2. У нас лучшее в городе оборудование;<br>
			

		</p>
		</div>
	</div>
</div>