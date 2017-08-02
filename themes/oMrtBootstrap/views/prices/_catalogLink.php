<?php
/**
 *
 * @var ObjectPrice $model
 * @var array $triggers
 */
if (empty($triggers)) {
    $triggers = [];
}
$triggers['research'] = $model -> verbiage;
echo "<a href='".$this -> createUrl('home/clinics',$triggers)."'>".$model -> name.'</a>';
