<?php
/**
 *
 */
clinics::$createService = true;
if (!in_array($triggers['area'],['spb','msc'])) {
    $triggers['area'] = 'spb';
}
$model = clinics::model() -> findByAttributes(['verbiage' => 'service'.$triggers['area']]);
$model -> partner = true;
?>
<li class="clinic mb-3 single-clinic pt-3 d-flex row">
    <div class="col-12 col-md-9 small_info">
        <h3 class="mt-0"><a href="<?php echo $this -> createUrl('home/service'); ?>">Бесплатная общегородская служба записи на МРТ и КТ диагностику</a></h3>
        <?php
        icon('clock-o','пн-вс: 7.00-0.00');
        if ($triggers['area'] == 'spb') {
            $phone = Yii::app() -> phone;
        } else {
            $phone = Yii::app() -> phoneMSC;
        }
        icon('phone',CHtml::link($phone -> getFormatted(), 'tel:'.$phone->getUnformatted()));
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
        <button class="btn signUpButton" data-city="<?php echo $triggers['area']; ?>">Записаться</button>
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
