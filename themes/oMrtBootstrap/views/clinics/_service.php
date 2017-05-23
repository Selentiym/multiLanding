<?php
/**
 *
 */
clinics::$createService = true;
$model = clinics::model() -> findByAttributes(['verbiage' => 'service']);
$model -> partner = true;
?>
<li class="clinic mb-3 single-clinic pt-3 d-flex row">
    <div class="col-12 col-md-9 small_info">
        <h3 class="mt-0"><a href="#">Бесплатная общегородская служба записи на МРТ и КТ диагностику</a></h3>
        <?php
        icon('clock-o','пн-вс:круглосуточно');
        icon('phone','Телефон');
        ?>
        <p>Пройти МРТ и КТ можно во всех районах города.</p>
        <div class="row">
            <div class="col-12"><?php icon('child','МРТ и КТ детям (с наркозом и без)'); ?></div>
            <div class="col-12"><?php icon('hand-stop-o','Без ограничений по весу'); ?></div>
            <div class="col-12"><?php icon('clock-o','Круглосуточно'); ?></div>
            <div class="col-12"><?php icon('money','Горячие предложения на МРТ и КТ диагностику (Акции и скидки по городу)'); ?></div>
            <div class="col-12"><?php icon('user-md','Бесплатная консультация врача (диагност, невролог, травматолог)'); ?></div>
            <div class="col-12"><?php icon('life-ring','МРТ 0.2-0.4 Тесла, 1.5 Тесла, 3 Тесла, КТ 16 срезов, 64 среза, 128 срезов'); ?></div>
            <div class="col-12"><?php icon('paint-brush','Исследования с контрастом'); ?></div>
        </div>
    </div>
    <div class="right-pane col-12 col-md-3 flex-first flex-md-unordered">
        <img class="mr-3 img-fluid" src="<?php echo Yii::app() -> theme -> baseUrl; ?>/images/logo_old.png" alt="Общегородская служба записи" />
        <div><div class="rateit" data-rateit-value="5" data-rateit-ispreset="true" data-rateit-readonly="true"></div></div>
        <button class="btn signUpButton">Записаться</button>
        <div class="mb-1">Или по телефону</div>
        <?php
        if ($triggers['area'] == 'msc') {
            $phone = Yii::app() -> phoneMSC;
        } else {
            $phone = Yii::app() -> phone;
        }
        ?>
        <div class="phone">
            <a href="tel:<?php echo $phone -> getUnformatted(); ?>"><?php echo $phone -> getFormatted(); ?></a>
        </div>
    </div>

    <div class="col-12">
        <div class="collapse" id="moreAboutService">
            <p>Обращаясь в общегородскую службу записи на МРТ и КТ обследования, всегда можно получить:</p>
            <ul>
                <li>консультацию по поводу прохождения МРТ/КТ-обследований, относящуюся к общим вопросам о противопоказаниях, особенностях диагностики и т.д.;</li>
                <li>- помощь в выборе клиники в своем районе, которая будет располагать всеми необходимыми возможностями;</li>
                <li>- консультацию о возможностях отдельного диагностического центра: оборудования, врачей и прочих характеристик, которые могут быть полезны клиенту;</li>
                <li>- помощь в записи на обследование в выбранную клинику на конкретное время, в том числе в ночное время суток.</li>
            </ul>
            <p>База данных службы записи содержит только проверенные центры, которые оказывают сертифицированные услуги и прошли аттестацию независимыми медицинскими аудиторами. Обращаясь в эти клиники, клиент может быть уверен в качестве оказанной услуги.</p>
            <p>Каждый из медицинских центров, предлагаемых службой записи, оборудован современным высокоинформативным оборудованием, которое не причиняет вреда здоровью, а штат клиник укомплектован грамотными опытными специалистами.</p>
            <p>Записаться на прием через службу записи - бесплатно. Просто позвоните, и вам помогут подобрать клинику, прояснить все сложные моменты, запишут на обследование. Услуги центра ничего не стоят, оплату за обследование пациент вносит непосредственно в клинике.</p>
            <p>В отдельных центрах при записи через службу можно пройти диагностику даже дешевле, чем при самостоятельном выборе этой же клиники: этому способствуют партнерские скидки. Помимо того, при записи всегда будут учитываться особенности клиента: группа (студенты, медицинские работники, инвалиды), время записи (существуют скидки на обследование, например, в ночное время), прочие возможные основания для получения скидки. Общегородская служба записи на МРТ и КТ обследования постарается сделать все, чтобы клиент получил качественную услугу по максимально сниженной стоимости.</p>
        </div>
        <button class="btn my-2" data-toggle="collapse" data-target="#moreAboutService">Подробнее</button>
        <?php
        if ($price) {
            $copy = [
                'area' => $triggers['area'],
                'research' => $triggers['research'],
                'sortBy' => 'priceUp'
            ];
            if ($triggers['area'] == 'msc') {
                $servicePrices = ObjectPriceBlock::model()->findByPk($price->id_block)->prices;
                if (!empty($servicePrices)) {
                    $criteria = new CDbCriteria();
                    $criteria->compare('partner', 1);
                    $this->renderPartial('/prices/_price_group_article', [
                        'id' => 'spbPrices',
                        'name' => $price->block->name,
                        'prices' => $servicePrices,
                        'model' => false,
                        'show' => true,
                        'triggers' => $copy,
                        'criteria' => $criteria,
                        'mainPrice' => $price
                    ]);
                }
            } else {
                $model -> getPriceValuesArray(true, $triggers);
                $this->renderPartial('/clinics/_priceList', ['model' => $model, 'blocks' => [ObjectPriceBlock::model()->findByPk($price->id_block)], 'price' => $price]);
            }
//            $this->renderPartial('/clinics/_priceList', ['model' => $model, 'blocks' => [ObjectPriceBlock::model()->findByPk($price->id_block)], 'price' => $price]);
        }
        ?>
    </div>
</li>
