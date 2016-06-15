<a name="geo" style="padding-bottom: 100px;display: block;margin-top:-100px;"></a>
<a name="centru" style="padding-bottom: 100px;display: block;margin-top:-100px;"></a>
<div class="raions" style="margin-top: 50px">
<h2>НАШИ ЦЕНТРЫ – ГЕОГРАФИЯ</h2>
<p class="dashed "> <img class="doctor" src="<?php echo Yii::app() -> baseUrl; ?>/img/doctor.png" alt="Доктор">
	   Мы во всех районах города!
	</p>
</div>

<div class="main_map">
	<div class="in_main_map">
	
		<div id="kartina">
			<div class="map_clinic_block" id="ramsey">
				<div class="map_clinic_description map_adres_hide" style="display:none">
					<span class="delete"><a>x</a></span>
					<p>Название центра: <br>МДЦ "РЭМСИ Диагностика"</p>
					<p>Адресс: ул. Чапаева, д.5 лит А</p>
					<p>МРТ и КТ: General Electric<br>
						Поле магнита: 1,5Тл</p>
					<p>Телефон для записи: <?php echo $model -> tel -> tel; ?></p>
				</div>
				<div class="map_clinic_marker">
				</div>
			</div>
			
			<!--<div class="map_clinic_block" id="mart">
				<div class="map_clinic_description map_adres_hide" style="display:none">
					<span class="delete"><a>x</a></span>
					<p>Название центра: <br>МДЦ МАРТ</p>
					<p>Адресс: Малый пр. В.О., 54, корп. 3</p>
					<p>МРТ и КТ: Siemens<br>
						Поле магнита: 1,5Тл</p>
					<p>Телефон для записи: <?php /*echo $model -> tel -> tel; */?></p>
				</div>
				<div class="map_clinic_marker">
				</div>
			</div>
			
			<div class="map_clinic_block" id="cmrt">
				<div class="map_clinic_description map_adres_hide" style="display:none">
					<span class="delete"><a>x</a></span>
					<p>Название центра: <br>МДЦ ЦМРТ</p>
					<p>Адресс: Рентгена, 5</p>
					<p>МРТ и КТ: General Electric<br>
						Поле магнита: 0,2Тл (открытый)</p>
					<p>Телефон для записи: <?php /*echo $model -> tel -> tel; */?></p>
				</div>
				<div class="map_clinic_marker">
				</div>
			</div>
			
			<div class="map_clinic_block" id="ami">
				<div class="map_clinic_description map_adres_hide" style="display:none">
					<span class="delete"><a>x</a></span>
					<p>Название центра: <br>МДЦ АМИ</p>
					<p>Адресс: В.О. 16-я линия, 81А</p>
					<p>МРТ и КТ: Siemens Symphony<br>
						Поле магнита: 1,5Тл</p>
					<p>Телефон для записи: <?php /*echo $model -> tel -> tel; */?></p>
				</div>
				<div class="map_clinic_marker">
				</div>
			</div>
			
			<div class="map_clinic_block" id="expert">
				<div class="map_clinic_description map_adres_hide" style="display:none">
					<span class="delete"><a>x</a></span>
					<p>Название центра: <br>МДЦ Эксперт</p>
					<p>Адресс: Северный, 1А</p>
					<p>МРТ и КТ: Siemens Magnetom Symphony<br>
						Поле магнита: 1,5Тл</p>
					<p>Телефон для записи: <?php /*echo $model -> tel -> tel; */?></p>
				</div>
				<div class="map_clinic_marker">
				</div>
			</div>
			
			
			
			<div class="map_clinic_block" id="energo_eng">
				<div class="map_clinic_description map_adres_hide" style="display:none">
					<span class="delete"><a>x</a></span>
					<p>Название центра: <br>МДЦ ЭНЕРГО</p>
					<p>Адресс: Энгельса, 33, корп. 1</p>
					<p>МРТ и КТ: General Electric<br>
						Поле магнита: 1,5Тл</p>
					<p>Телефон для записи: <?php /*echo $model -> tel -> tel; */?></p>
				</div>
				<div class="map_clinic_marker">
				</div>
			</div>
			
			<div class="map_clinic_block" id="medem">
				<div class="map_clinic_description map_adres_hide" style="display:none">
					<span class="delete"><a>x</a></span>
					<p>Название центра: <br>МДЦ Медем</p>
					<p>Адресс:  Марата, 6А</p>
					<p>МРТ и КТ: General Electric Signa<br>
						Поле магнита: 3,0Тл</p>
					<p>Телефон для записи: <?php /*echo $model -> tel -> tel; */?></p>
				</div>
				<div class="map_clinic_marker">
				</div>
			</div>
			
			<div class="map_clinic_block" id="polenova">
				<div class="map_clinic_description map_adres_hide" style="display:none">
					<span class="delete"><a>x</a></span>
					<p>Название центра: <br>НИИ Поленова</p>
					<p>Адресс: ул. Маяковского, 12</p>
					<p>МРТ и КТ: Siemens<br>
						Поле магнита: 1,5Тл (закрытый)</p>
					<p>Телефон для записи: <?php /*echo $model -> tel -> tel; */?></p>
				</div>
				<div class="map_clinic_marker">
				</div>
			</div>-->
			
			
			
			
			
			<!--<div class="map_clinic_block" id="kup">
				<div class="map_clinic_description map_adres_hide" style="display:none">
					<span class="delete"><a>x</a></span>
					<p>Название центра: <br>МДЦ МРТ Купчино</p>
					<p>Адресс: Малая Балканская, 26В</p>
					<p>МРТ и КТ: Toshiba<br>
						Поле магнита: 1,5Тл (закрытый)</p>
					<p>Телефон для записи: <?php //echo $model -> tel -> tel; ?></p>
				</div>
				<div class="map_clinic_marker">
				</div>
			</div>-->
			
			<div class="map_clinic_block" id="magnet">
				<div class="map_clinic_description map_adres_hide" style="display:none">
					<span class="delete"><a>x</a></span>
					<p>Название центра: <br>МДЦ "Магнит"</p>
					<p>Адресс: 6-я Красноармейская, д.7 лит А</p>
					<p>МРТ и КТ: Siemens<br>
						Поле магнита: 1,5Тл (полуоткрытый)</p>
					<p>Телефон для записи: <?php echo $model -> tel -> tel; ?></p>
				</div>
				<div class="map_clinic_marker">
				</div>
			</div>
			
			<!--<div class="map_clinic_block" id="standard">
				<div class="map_clinic_description map_adres_hide" style="display:none">
					<span class="delete"><a>x</a></span>
					<p>Название центра: <br>МДЦ Стандарт МРТ</p>
					<p>Адресс: пл. Карла Фаберже, 8, корп. 2</p>
					<p>МРТ и КТ: Siemens Symphony<br>
						Поле магнита: 1,5Тл</p>
					<p>Телефон для записи: <?php /*echo $model -> tel -> tel; */?></p>
				</div>
				<div class="map_clinic_marker">
				</div>
			</div>-->
			
			<div class="map_clinic_block" id="north-west">
				<div class="map_clinic_description map_adres_hide" style="display:none">
					<span class="delete"><a>x</a></span>
					<p>Название центра: <br>МДЦ "Северо-Западный Медицинский Центр"</p>
					<p>Адресс: Боровая, д.55</p>
					<p>КТ: Toshiba Aquilion<br>
						Срезов: 16</p>
					<p>Телефон для записи: <?php echo $model -> tel -> tel; ?></p>
				</div>
				<div class="map_clinic_marker">
				</div>
			</div>
			
			<!--<div class="map_clinic_block" id="energo_len">
				<div class="map_clinic_description map_adres_hide" style="display:none">
					<span class="delete"><a>x</a></span>
					<p>Название центра: <br>МДЦ ЭНЕРГО</p>
					<p>Адресс: Ленинский, 160 </p>
					<p>МРТ и КТ: General Electric<br>
						Поле магнита: 1,5Тл</p>
					<p>Телефон для записи: <?php /*echo $model -> tel -> tel; */?></p>
				</div>
				<div class="map_clinic_marker">
				</div>
			</div>-->
			
			<!--<div class="map_clinic_block" id="kup">
				<div class="map_clinic_description map_adres_hide" style="display:none">
					<span class="delete"><a>x</a></span>
					<p>Название центра: <br>МДЦ МРТ Купчино</p>
					<p>Адресс: Малая Балканская, 26В</p>
					<p>МРТ и КТ: Toshiba<br>
						Поле магнита: 1,5Тл (закрытый)</p>
					<p>Телефон для записи: <?php /*echo $model -> tel -> tel; */?></p>
				</div>
				<div class="map_clinic_marker">
				</div>
			</div>-->

			<!--<div class="map_clinic_block" id="ndc_bor">
				<div class="map_clinic_description map_adres_hide" style="display:none">
					<span class="delete"><a>x</a></span>
					<p>Название центра: <br>НДЦ Боровая</p>
					<p>Адресс: ул.Боровая, 55</p>
					<p>МРТ и КТ: Hitachi<br>
						Поле магнита: 0,4Тл (открытый)</p>
					<p>Телефон для записи: <?php /*echo $model -> tel -> tel; */?></p>
				</div>
				<div class="map_clinic_marker">
				</div>
			</div>-->

			<!--<div class="map_clinic_block" id="ndc_isp">
				<div class="map_clinic_description map_adres_hide" style="display:none">
					<span class="delete"><a>x</a></span>
					<p>Название центра: <br>НДЦ Испытателей</p>
					<p>Адресс: пр. Испытателей, д. 39</p>
					<p>МРТ: Siemens<br>
						Поле магнита: 1,5Тл (закрытый)</p>
					<p>Телефон для записи: <?php /*echo $model -> tel -> tel; */?></p>
				</div>
				<div class="map_clinic_marker">
				</div>
			</div>-->

			<!--<div class="map_clinic_block" id="ndc_ent">
				<div class="map_clinic_description map_adres_hide" style="display:none">
					<span class="delete"><a>x</a></span>
					<p>Название центра: <br>НДЦ Энтузиастов</p>
					<p>Адресс: пр-т Энтузиастов, д. 33, к. 1, л. А</p>
					<p>МРТ: General Electric<br>
						Поле магнита: 0,2Тл (открытый)</p>
					<p>Телефон для записи: <?php /*echo $model -> tel -> tel; */?></p>
				</div>
				<div class="map_clinic_marker">
				</div>
			</div>-->

			<div class="map_clinic_block" id="prior">
				<div class="map_clinic_description map_adres_hide" style="display:none">
					<span class="delete"><a>x</a></span>
					<p>Название центра: <br>Медицинский Центр "Приоритет"</p>
					<p>Адресс: ул. Руставели, д.66 лит.&nbspГ</p>
					<p>МРТ: Siemens<br>
						</p>
					<p>Телефон для записи: <?php echo $model -> tel -> tel; ?></p>
				</div>
				<div class="map_clinic_marker">
				</div>
			</div>
		</div>

		<!--<img id='kartina' src="<?php echo Yii::app() -> baseUrl; ?>/img/smal_map.png" alt="Карта" >-->
	</div>

</div>