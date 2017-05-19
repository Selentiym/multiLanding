<?php
/**
 * @type clinics $model
 * @type mixed[] $data
 */
?>
<div class="small_info">
			<?php
			$verb = 'finance';
			if ($temp = $model -> getFirstTriggerValueString($verb)) : ?>
                <div class="time ">
                    <i class="fa fa-user fa-lg fa-fw" aria-hidden="true"></i>&nbsp;
                    <div class="text" title="
                    <?php
                    $t = $model -> getFirstTriggerValue($verb);
                    $val = $t -> getParameterValueByVerbiage($verb.'Comment');
                    echo  $val -> value; ?>"><?php echo ($data[$verb] ? '<b>' : ''). $temp . ($data[$verb] ? '</b>' : ''); ?></div>
                </div>
            <?php endif; ?>
<?php if ($model -> working_hours) : ?>

    <div class="time ">
        <div class="row no-gutters align-items-center">
            <div class="col-auto"><i class="fa fa-clock-o fa-lg fa-fw" aria-hidden="true"></i>&nbsp;</div>
            <div class="col">
                <div class="text"><?php echo $model -> working_hours; ?></div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php
$verb = 'time';
if ($temp = $model -> getFirstTriggerValueString($verb)) : ?>
    <div class="time ">
        <i class="fa fa-clock-o fa-lg fa-fw" aria-hidden="true"></i>&nbsp;
        <div class="text"><?php echo ($data[$verb] ? '<b>' : ''). $temp . ($data[$verb] ? '</b>' : ''); ?></div>
    </div>
<?php endif; ?>
<?php
$verb = 'contrast';
if ($temp = $model -> getFirstTriggerValueString($verb)) : ?>
    <div class="time ">
        <i class="fa fa-paint-brush fa-lg fa-fw" aria-hidden="true"></i>&nbsp;
        <div class="text"><?php echo ($data[$verb] ? '<b>' : ''). $temp . ($data[$verb] ? '</b>' : ''); ?></div>
    </div>
<?php endif; ?>
<?php
$verb = 'children';
if ($temp = $model -> getFirstTriggerValueString($verb)) : ?>
    <div class="time ">
        <i class="fa fa-child fa-lg fa-fw" aria-hidden="true"></i>&nbsp;
        <div class="text"><?php echo ($data[$verb] ? '<b>' : ''). $temp . ($data[$verb] ? '</b>' : ''); ?></div>
    </div>
<?php endif; ?>

<?php if ($model -> address) : ?>
    <div class="address ">
        <?php
        $text = '';
        if($expanded) {
            $text .= "Клиника располагается по адресу: ";
        }
        $text .= $model -> getFullAddress();
        icon('map-marker', $text);
        ?>
    </div>
<?php endif; ?>

<?php
$verb = 'district';
if ($temp = $model -> getFirstTriggerValueString($verb)) : ?>
    <div class="time ">
        <i class="fa fa-map fa-lg fa-fw" aria-hidden="true"></i>&nbsp;
        <div class="text"><?php echo ($data[$verb] ? '<b>' : ''). $temp . ($data[$verb] ? '</b>' : ''); ?></div>
    </div>
<?php endif; ?>
<?php
$verb = 'doctor';
if ($temp = $model -> getFirstTriggerValueString($verb)) : ?>
    <div class="row no-gutters align-items-center">
        <div class="col-auto"><i class="fa fa-clock-o fa-lg fa-fw" aria-hidden="true"></i></div>
        <div class="col"><div class="text"><?php echo ($data[$verb] ? '<b>' : ''). $temp . ($data[$verb] ? '</b>' : ''); ?></div></div>
    </div>
<?php endif; ?>

<?php
$verb = 'metro';
if ($model -> metro_station) : ?>
    <div class="row no-gutters align-items-center">
        <div class="col-auto"><i class="fa fa-subway fa-lg fa-fw" aria-hidden="true"></i>&nbsp;</div>
        <div class="col">
            <div class="text">
                <?php
                if ($data[$verb]) {
                    list($lat, $long) = $model -> getCoordinates();
                    echo "<b>";
                    $m = Metro::model() -> findByAttributes(['id' => $data[$verb]]);
                    echo $m -> display($lat, $long);
                    echo "</b>";
                } else {
                    echo $model -> getSortedMetroString();
                }
                ?>
            </div>
        </div>
    </div>
<?php endif; ?>

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