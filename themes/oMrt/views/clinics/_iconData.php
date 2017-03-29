<?php
/**
 * @type clinics $model
 * @type mixed[] $data
 */
?>
<div class="small_info list-group">
			<?php
			$verb = 'finance';
			if ($temp = $model -> getFirstTriggerValueString($verb)) : ?>
                <div class="time list-group-item">
                    <i class="fa fa-clock-o fa-lg fa-fw" aria-hidden="true"></i>&nbsp;
                    <div class="text" title="
                    <?php
                    $t = $model -> getFirstTriggerValue($verb);
                    $val = $t -> getParameterValueByVerbiage($verb.'Comment');
                    echo  $val -> value; ?>"><?php echo ($data[$verb] ? '<b>' : ''). $temp . ($data[$verb] ? '</b>' : ''); ?></div>
                </div>
            <?php endif; ?>
<?php if ($model -> working_hours) : ?>
    <div class="time list-group-item">
        <i class="fa fa-clock-o fa-lg fa-fw" aria-hidden="true"></i>&nbsp;
        <div class="text"><?php echo $model -> working_hours; ?></div>
    </div>
<?php endif; ?>

<?php
$verb = 'time';
if ($temp = $model -> getFirstTriggerValueString($verb)) : ?>
    <div class="time list-group-item">
        <i class="fa fa-clock-o fa-lg fa-fw" aria-hidden="true"></i>&nbsp;
        <div class="text"><?php echo ($data[$verb] ? '<b>' : ''). $temp . ($data[$verb] ? '</b>' : ''); ?></div>
    </div>
<?php endif; ?>
<?php
$verb = 'contrast';
if ($temp = $model -> getFirstTriggerValueString($verb)) : ?>
    <div class="time list-group-item">
        <i class="fa fa-clock-o fa-lg fa-fw" aria-hidden="true"></i>&nbsp;
        <div class="text"><?php echo ($data[$verb] ? '<b>' : ''). $temp . ($data[$verb] ? '</b>' : ''); ?></div>
    </div>
<?php endif; ?>
<?php
$verb = 'children';
if ($temp = $model -> getFirstTriggerValueString($verb)) : ?>
    <div class="time list-group-item">
        <i class="fa fa-clock-o fa-lg fa-fw" aria-hidden="true"></i>&nbsp;
        <div class="text"><?php echo ($data[$verb] ? '<b>' : ''). $temp . ($data[$verb] ? '</b>' : ''); ?></div>
    </div>
<?php endif; ?>

<?php if ($model -> address) : ?>
    <div class="address list-group-item">
        <i class="fa fa-map-marker fa-lg fa-fw" aria-hidden="true"></i>&nbsp;
        <div class="text p-adr"><?php echo $model -> address;?></div>
    </div>
<?php endif; ?>

<?php
$verb = 'district';
if ($temp = $model -> getFirstTriggerValueString($verb)) : ?>
    <div class="time list-group-item">
        <i class="fa fa-clock-o fa-lg fa-fw" aria-hidden="true"></i>&nbsp;
        <div class="text"><?php echo ($data[$verb] ? '<b>' : ''). $temp . ($data[$verb] ? '</b>' : ''); ?></div>
    </div>
<?php endif; ?>
<?php
$verb = 'doctor';
if ($temp = $model -> getFirstTriggerValueString($verb)) : ?>
    <div class="time list-group-item">
        <i class="fa fa-clock-o fa-lg fa-fw" aria-hidden="true"></i>&nbsp;
        <div class="text"><?php echo ($data[$verb] ? '<b>' : ''). $temp . ($data[$verb] ? '</b>' : ''); ?></div>
    </div>
<?php endif; ?>

<?php
$verb = 'metro';
if ($model -> metro_station) : ?>
    <div class="time list-group-item">
        <i class="fa fa-clock-o fa-lg fa-fw" aria-hidden="true"></i>&nbsp;
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
<?php endif; ?>

<div class="phone list-group-item">
    <i class="fa fa-mobile fa-lg fa-fw" aria-hidden="true"></i>&nbsp;
    <div class="text p-adr"><?php echo $model -> phone ? $model -> phone : 'нужный телефон'; ?></div>
</div>
<?php if ($model -> mrt) : ?>
    <div class="tomogrMrt list-group-item">
        <i class="fa fa-life-ring fa-lg fa-fw" aria-hidden="true"></i>&nbsp;
        <div class="text p-adr"><?php echo $model -> mrt . ' ' . ($data['field']||$data['magnetType'] ? '<b>': '') . $model -> getFirstTriggerValue('magnetType')->value. ' ' . $model -> getFirstTriggerValue('field')->value . ($data['field']||$data['magnetType'] ? '</b>': ''); ?></div>
    </div>
<?php endif; ?>

<?php if ($model -> kt) : ?>
    <div class="tomogrKt list-group-item">
        <i class="fa fa-navicon fa-lg fa-fw" aria-hidden="true"></i>&nbsp;
        <div class="text p-adr"><?php echo $model -> kt.' '.($data['slices'] ? '<b>': '') . $model -> getFirstTriggerValue('slices')->value . ($data['slices'] ? '</b>': ''); ?></div>
    </div>
<?php endif; ?>
</div>
<p>
    <?php
    if ($price = $data['research']) {
        echo "<b>".$price -> name.'</b> '.$model -> getPriceValue($price -> id) -> value;
    }
    ?>
</p>