<?php
/**
 * @type bool $expanded
 * @type clinics $model
 * @type mixed[] $data
 */
$cityRod = $model -> getFirstTriggerValue('area') -> verbiage == 'msc' ? 'Москвы' : 'Санкт-Петербурга';
?>
<div class="small_info">
    <?php
    $verb = 'finance';
    ?>

    <div class="time ">
        <div class="row no-gutters align-items-center">
            <div class="col-auto"><i class="fa fa-user fa-lg fa-fw" aria-hidden="true"></i>&nbsp;</div>
            <div class="col">
                <div class="text">Как <strong>частные</strong>, так и <strong>государственные</strong> клиники и медицинские центры</div>
            </div>
        </div>
    </div>

    <div class="time ">
        <div class="row no-gutters align-items-center">
            <div class="col-auto"><i class="fa fa-clock-o fa-lg fa-fw" aria-hidden="true"></i>&nbsp;</div>
            <div class="col">
                <div class="text">Обследования проводятся <strong>круглосуточно</strong>, а <strong>ночью - дешевле</strong>!</div>
            </div>
        </div>
    </div>


    <div class="time ">
        <?php icon('paint-brush', 'Можно пройти диагностику <strong>с контрастом</strong> по цене обычного обследования') ?>
    </div>

    <div class="time ">
        <i class="fa fa-child fa-lg fa-fw" aria-hidden="true"></i>&nbsp;
        <div class="text">МРТ и КТ для <strong>детей</strong> любого возраста</div>
    </div>

        <div class="address ">
            <?php
            icon('map-marker', 'Наши партнеры находятся <strong>по всему городу</strong>, а также загородом');
            ?>
        </div>

        <div class="time ">
            <?php
                icon('map','Мы находимся в <strong>каждом районе</strong> '.$cityRod.', а также в <strong>пригородах</strong>');
            ?>
        </div>
        <div class="row no-gutters align-items-center">
            <div class="col-auto"><i class="fa fa-subway fa-lg fa-fw" aria-hidden="true"></i>&nbsp;</div>
            <div class="col">
                <div class="text">
                    Выбирайте любое удобное для Вас метро
                </div>
            </div>
        </div>

    <div class="phone ">
        <i class="fa fa-mobile fa-lg fa-fw" aria-hidden="true"></i>&nbsp;
        <div class="text p-adr"><?php echo $model -> getPhone(); ?></div>
    </div>
    <?php if (($model -> mrt)||($model -> getFirstTriggerValue('field'))||($model -> getFirstTriggerValue('magnetType'))||($model -> getFirstTriggerValue('mrt'))) : ?>
        <div class="row no-gutters align-items-center">
            <div class="col-auto">
                <i class="fa fa-life-ring fa-lg fa-fw" aria-hidden="true"></i>&nbsp;
            </div>
            <div class="col">
                <div class="text p-adr">
                    <?php
                    if (!$model -> mrt) {
                        $model -> mrt = 'томограф';
                    }
                    echo 'МРТ '.$model -> mrt . ' ' . ($data['field']||$data['magnetType'] ? '<b>': '') . $model -> getConcatenatedTriggerValueString('field') . ' '. $model -> getConcatenatedTriggerValueString('magnetType') . ($data['field']||$data['magnetType'] ? '</b>': ''); ?></div>
            </div>
        </div>
    <?php endif; ?>

    <?php if (($model -> kt)||($model -> getFirstTriggerValue('slices'))||($model -> getFirstTriggerValue('kt'))) : ?>
        <div class="row no-gutters align-items-center">
            <div class="col-auto"><i class="fa fa-navicon fa-lg fa-fw" aria-hidden="true"></i>&nbsp;</div>
            <?php
            if (!$model -> kt) {
                $model -> kt = 'томограф';
            }
            ?>
            <div class="col"><div class="text p-adr"><?php echo 'КТ '.$model -> kt.' '.($data['slices'] ? '<b>': '') . $model -> getConcatenatedTriggerValueString('slices') . ($data['slices'] ? '</b>': ''); ?></div></div>
        </div>
    <?php endif; ?>
    <?php if ($model -> restrictions) : ?>
        <div class="row no-gutters align-items-center">
            <div class="col-auto"><i class="fa fa-hand-stop-o fa-lg fa-fw" aria-hidden="true"></i>&nbsp;</div>
            <div class="col"><div class="text p-adr"><?php echo $model -> restrictions; ?></div></div>
        </div>
    <?php endif; ?>
</div>