<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 06.04.2016
 * Time: 18:57
 */
/**
 * @var CommonRule $model - contains an object to be changed
 */
echo "<h2>Изменить правило</h2>";
$this -> renderPartial('//rules/_form',array('model' => $model));
?>