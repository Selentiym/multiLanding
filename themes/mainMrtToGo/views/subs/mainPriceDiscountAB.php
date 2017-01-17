<?php
/**
 *
 */
CallTrackerModule::useTracker();
$experiment = CallTrackerModule::getExperiment();
/**
 * @type iExperiment $experiment
 */
$coeff = $experiment -> getProperty('price');
if (!$coeff) {
    $coeff = 1;
}
echo $model -> price -> text. ' <b>'. (round($coeff / 10 * $model -> price -> price) * 10) .'р!</b>';