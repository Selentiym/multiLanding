<?php
/**
 *
 * @var \Rule $model
 */
?>
<section>
    <div class="container container-shift">
        <div class="row" id="centru">

            <h1>Наши центры – ГЕОГРАФИЯ</h1>
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
                                <p>Телефон для записи: <?php echo Yii::app() -> phone -> getFormatted(); ?></p>
                            </div>
                            <div class="map_clinic_marker">
                            </div>
                        </div>

                        <div class="map_clinic_block" id="dmg">
                            <div class="map_clinic_description map_adres_hide" style="display:none">
                                <span class="delete"><a>x</a></span>
                                <p>Название центра: <br>МДЦ "DMG-clinic"</p>
                                <p>Адресс: ул. Ленина, д.5</p>
                                <p>МРТ и КТ: <br>
                                    Поле магнита: 1,5Тл</p>
                                <p>Телефон для записи: <?php echo Yii::app() -> phone -> getFormatted(); ?></p>
                            </div>
                            <div class="map_clinic_marker">
                            </div>
                        </div>

                        <div class="map_clinic_block" id="mart">
                            <div class="map_clinic_description map_adres_hide" style="display:none">
                                <span class="delete"><a>x</a></span>
                                <p>Название центра: <br>МДЦ МАРТ</p>
                                <p>Адресс: Малый пр. В.О., 54, корп. 3</p>
                                <p>МРТ и КТ: Siemens<br>
                                    Поле магнита: 1,5Тл</p>
                                <p>Телефон для записи: <?php echo Yii::app() -> phone -> getFormatted(); ?></p>
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
                                <p>Телефон для записи: <?php echo Yii::app() -> phone -> getFormatted(); ?></p>
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
                                <p>Телефон для записи: <?php echo Yii::app() -> phone -> getFormatted(); ?></p>
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
                                <p>Телефон для записи: <?php echo Yii::app() -> phone -> getFormatted(); ?></p>
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
                                <p>Телефон для записи: <?php echo Yii::app() -> phone -> getFormatted(); ?></p>
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
                                <p>Телефон для записи: <?php echo Yii::app() -> phone -> getFormatted(); ?></p>
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
                                <p>Телефон для записи: <?php echo Yii::app() -> phone -> getFormatted(); ?></p>
                            </div>
                            <div class="map_clinic_marker">
                            </div>
                        </div>


                        <div class="map_clinic_block" id="ona_vet">
                            <div class="map_clinic_description map_adres_hide" style="display:none">
                                <span class="delete"><a>x</a></span>
                                <p>Название центра: <br>ОНА</p>
                                <p>Адресс: Ветеранов, 56 </p>
                                <p>МРТ и КТ: <br>
                                    Поле магнита: 0,2Тл (открытый)</p>
                                <p>Телефон для записи: <?php echo Yii::app() -> phone -> getFormatted(); ?></p>
                            </div>
                            <div class="map_clinic_marker">
                            </div>
                        </div>

                        <div class="map_clinic_block" id="kup">
                            <div class="map_clinic_description map_adres_hide" style="display:none">
                                <span class="delete"><a>x</a></span>
                                <p>Название центра: <br>МДЦ МРТ Купчино</p>
                                <p>Адресс: Малая Балканская, 26В</p>
                                <p>МРТ и КТ: Toshiba<br>
                                    Поле магнита: 1,5Тл (закрытый)</p>
                                <p>Телефон для записи: <?php echo Yii::app() -> phone -> getFormatted(); ?></p>
                            </div>
                            <div class="map_clinic_marker">
                            </div>
                        </div>

                        <div class="map_clinic_block" id="magnet">
                            <div class="map_clinic_description map_adres_hide" style="display:none">
                                <span class="delete"><a>x</a></span>
                                <p>Название центра: <br>МДЦ "Магнит"</p>
                                <p>Адресс: 6-я Красноармейская, д.7 лит А</p>
                                <p>МРТ и КТ: Siemens<br>
                                    Поле магнита: 1,5Тл (полуоткрытый)</p>
                                <p>Телефон для записи: <?php echo Yii::app() -> phone -> getFormatted(); ?></p>
                            </div>
                            <div class="map_clinic_marker">
                            </div>
                        </div>

                        <div class="map_clinic_block" id="standard">
                            <div class="map_clinic_description map_adres_hide" style="display:none">
                                <span class="delete"><a>x</a></span>
                                <p>Название центра: <br>МДЦ Стандарт МРТ</p>
                                <p>Адресс: пл. Карла Фаберже, 8, корп. 2</p>
                                <p>МРТ и КТ: Siemens Symphony<br>
                                    Поле магнита: 1,5Тл</p>
                                <p>Телефон для записи: <?php echo Yii::app() -> phone -> getFormatted(); ?></p>
                            </div>
                            <div class="map_clinic_marker">
                            </div>
                        </div>

                        <div class="map_clinic_block" id="north-west">
                            <div class="map_clinic_description map_adres_hide" style="display:none">
                                <span class="delete"><a>x</a></span>
                                <p>Название центра: <br>"Северо-Западный Медицинский Центр"</p>
                                <p>Адресс: Боровая, д.55</p>
                                <p>КТ: Toshiba Aquilion<br>
                                    Срезов: 16</p>
                                <p>Телефон для записи: <?php echo Yii::app() -> phone -> getFormatted(); ?></p>
                            </div>
                            <div class="map_clinic_marker">
                            </div>
                        </div>

                        <div class="map_clinic_block" id="energo_len">
                            <div class="map_clinic_description map_adres_hide" style="display:none">
                                <span class="delete"><a>x</a></span>
                                <p>Название центра: <br>МДЦ ЭНЕРГО</p>
                                <p>Адресс: Ленинский, 160 </p>
                                <p>МРТ и КТ: General Electric<br>
                                    Поле магнита: 1,5Тл</p>
                                <p>Телефон для записи: <?php echo Yii::app() -> phone -> getFormatted(); ?></p>
                            </div>
                            <div class="map_clinic_marker">
                            </div>
                        </div>

                        <div class="map_clinic_block" id="kup">
                            <div class="map_clinic_description map_adres_hide" style="display:none">
                                <span class="delete"><a>x</a></span>
                                <p>Название центра: <br>МДЦ МРТ Купчино</p>
                                <p>Адресс: Малая Балканская, 26В</p>
                                <p>МРТ и КТ: Toshiba<br>
                                    Поле магнита: 1,5Тл (закрытый)</p>
                                <p>Телефон для записи: <?php echo Yii::app() -> phone -> getFormatted(); ?></p>
                            </div>
                            <div class="map_clinic_marker">
                            </div>
                        </div>

                        <div class="map_clinic_block" id="ndc_bor">
                            <div class="map_clinic_description map_adres_hide" style="display:none">
                                <span class="delete"><a>x</a></span>
                                <p>Название центра: <br>НДЦ Боровая</p>
                                <p>Адресс: ул.Боровая, 55</p>
                                <p>МРТ и КТ: Hitachi<br>
                                    Поле магнита: 0,4Тл (открытый)</p>
                                <p>Телефон для записи: <?php echo Yii::app() -> phone -> getFormatted(); ?></p>
                            </div>
                            <div class="map_clinic_marker">
                            </div>
                        </div>

                        <div class="map_clinic_block" id="ndc_isp">
                            <div class="map_clinic_description map_adres_hide" style="display:none">
                                <span class="delete"><a>x</a></span>
                                <p>Название центра: <br>НДЦ Испытателей</p>
                                <p>Адресс: пр. Испытателей, д. 39</p>
                                <p>МРТ: Siemens<br>
                                    Поле магнита: 1,5Тл (закрытый)</p>
                                <p>Телефон для записи: <?php echo Yii::app() -> phone -> getFormatted(); ?></p>
                            </div>
                            <div class="map_clinic_marker">
                            </div>
                        </div>



                        <div class="map_clinic_block" id="ona_sereb">
                            <div class="map_clinic_description map_adres_hide" style="display:none">
                                <span class="delete"><a>x</a></span>
                                <p>Название центра: <br>ОНА</p>
                                <p>Адресс: Серебристый бульвар, 20А</p>
                                <p>МРТ:<br>
                                    Поле магнита: 1,5Тл (закрытый)</p>
                                <p>Телефон для записи: <?php echo Yii::app() -> phone -> getFormatted(); ?></p>
                            </div>
                            <div class="map_clinic_marker">
                            </div>
                        </div>

                        <div class="map_clinic_block" id="ndc_ent">
                            <div class="map_clinic_description map_adres_hide" style="display:none">
                                <span class="delete"><a>x</a></span>
                                <p>Название центра: <br>НДЦ Энтузиастов</p>
                                <p>Адресс: пр-т Энтузиастов, д. 33, к. 1, л. А</p>
                                <p>МРТ: General Electric<br>
                                    Поле магнита: 0,2Тл (открытый)</p>
                                <p>Телефон для записи: <?php echo Yii::app() -> phone -> getFormatted(); ?></p>
                            </div>
                            <div class="map_clinic_marker">
                            </div>
                        </div>

                        <div class="map_clinic_block" id="prior">
                            <div class="map_clinic_description map_adres_hide" style="display:none">
                                <span class="delete"><a>x</a></span>
                                <p>Название центра: <br>Медицинский Центр "Приоритет"</p>
                                <p>Адрес: ул. Руставели, д.66 лит.&nbsp;Г</p>
                                <p>МРТ: Siemens<br>
                                </p>
                                <p>Телефон для записи: <?php echo Yii::app() -> phone -> getFormatted(); ?></p>
                            </div>
                            <div class="map_clinic_marker">
                            </div>
                        </div>


                        <div class="map_clinic_block" id="smt">
                            <div class="map_clinic_description map_adres_hide" style="display:none">
                                <span class="delete"><a>x</a></span>
                                <p>Название центра: <br>Клиника СМТ </p>
                                <p>Адрес: пр. Римского-Корсакова д. 87</p>
                                <p>МРТ и КТ: General Electric<br>
                                    Поле магнита: 1,5 Тл (закрытый)</p>
                                <p>Телефон для записи: <?php echo Yii::app() -> phone -> getFormatted(); ?></p>
                            </div>
                            <div class="map_clinic_marker">
                            </div>
                        </div>

                    </div>

                    <!--<img id='kartina' src="<?php echo $base; ?>//img/smal_map.png" alt="Карта" >-->
                </div>

            </div>

        </div>
    </div>
</section>

