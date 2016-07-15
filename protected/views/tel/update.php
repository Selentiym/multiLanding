<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 06.04.2016
 * Time: 18:57
 */
/**
 * @var Tel $model - contains an object to be changed
 */
echo "<h2>Изменить правило для телефонов</h2>";
$this -> renderPartial('//tel/_form',array('model' => $model));
?>