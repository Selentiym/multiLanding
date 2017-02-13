<?php
/**
 *
 * @var \CommonRule $model
 */
?>

<section>
    <div class="container container-shift">
        <div class="row" id="oborud">

            <h1>Наше оборудование</h1>
            <p>В наших центрах Вы можете пройти обследование на современных МРТ и КТ томографах, экспертного класса
                (производство компаний «General Electric Medical Systems» и «Siemens») открытого и закрытого типов. В наших
                клиниках установлено следующее ОБОРУДОВАНИЕ:
            </p>
            <h2>мрт аппараты</h2>
            <div id="tabs">
                <ul>
                    <li><a href="#tabs-1" title="">3 Тесла</a></li>
                    <li><a href="#tabs-2" title="">1,5 Тесла</a></li>
                    <li><a href="#tabs-3" title="">Открытого типа</a></li>
                </ul>
                <div id="tabs_container">
                    <div id="tabs-1">
                        <img src="<?php echo $base; ?>/img/3tesla.jpg">
                        <br>
                        <p>3 Тесла – 1 аппарат</p>
                        <p>Томограф закрытого типа мощностью 3 Тесла –Самый современный аппарат, существующий на данный момент в мире, за счет сверхвысокого поля данное оборудование позволяет: </p>
                        <br>
                        <ol>
                            <li>Проводить исследования значительно быстрее, чем на аппаратах с менее высоким полем.</li>
                            <li>Данный тип аппаратов рекомендуем при исследованиях сердца.</li>
                            <li>Меньшее количество артефактов.</li>
                            <li>Более качественная диагностическая информация позволяет поставить диагноз в сложных случаях, когда мощности 1.5 Тесловых МРТ оказывается недостаточно!</li>
                        </ol>
                    </div>
                    <div id="tabs-2">
                        <img src="<?php echo $base; ?>/img/1.5tesla.jpg">
                        <p>1.5 Тесла (Золотой Стандарт при МРТ исследованиях) – более 10 аппаратов</p>
                        <p>Томографы закрытого типа мощностью
                            1,5 Тесла - Золотой Стандарт при МРТ
                            исследованиях, точность снимков
                            доходит до долей миллиметра.
                        </p>
                    </div>
                    <div id="tabs-3">
                        <img src="<?php echo $base; ?>/img/035tesla.jpg">
                        <p>0.35 Тесла – 1 аппарат</p>
                        <p>Томограф открытого типа
                            мощностью 0.35 Тесла
                            Данный томограф имеет низкий уровень шума, на нем можно проводить обследова-
                            ния детям и пациентам, страдающим клаустрофобией
                        </p>
                    </div>
                </div>
            </div>
            <div class="vrezka">
                <div>
                    <p>Проконсультируйтесь по телефону: <?php echo Yii::app() -> phone -> getFormatted(); ?>.</p>
                    <p>Вы сможете получить подробную консультацию по всем вопросам, связанным с МРТ и КТ исследованием и при желании записаться на обследование в удобное для вас время по лучшей цене!</p>
                </div>
            </div>
            <h2>кт аппараты</h2>

            <div class="col-lg-3">
                <img src="<?php echo $base; ?>/img/imgkt.png">
            </div>
            <div id="tabs2" class="col-lg-9">
                <ul>
                    <li><a href="#tabs-1" title="">16 срезовый аппарат </a></li>
                    <li><a href="#tabs-2" title="">64 срезовый аппарат</a></li>
                    <li><a href="#tabs-3" title="">128 срезовый аппарат</a></li>
                </ul>
                <div id="tabs_container">
                    <div id="tabs-1">
                        <p>16 срезовый аппарат (Золотой Стандарт при КТ исследованиях)
                            –  более 10 аппаратов</p>
                    </div>
                    <div id="tabs-2">
                        <p>64 срезовый аппарат
                            (Рекомендован к использованию
                            при исследованиях сердца)
                            – 2 аппарата</p>
                    </div>
                    <div id="tabs-3">
                        <p>128 срезовый аппарат
                            – 1аппарат</p>
                    </div>
                </div>
            </div>

            <div class="vrezka">
                <div>
                    <p>Компьютерные Томографы в Наших клиниках оснащены самым последним программным обеспечением (протоколами исследований), позволяющими получать КТ изображения на высочайшем уровне детализации…
                    </p>
                </div>
            </div>
        </div>
		
        <div class="call-me">
            <p><img src="<?php echo $base; ?>/img/registration.png">Записаться на МРТ и КТ можно КРУГЛОСУТОЧНО по телефону: <b><a href="tel:8812<?php echo Yii::app() -> phone -> getShort(); ?>"><?php echo Yii::app() -> phone -> getFormatted(); ?></a></b></p>
        </div>
		
    </div>
</section>
