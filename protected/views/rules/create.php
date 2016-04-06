<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 06.04.2016
 * Time: 18:54
 */
/**
 * @var Rule $model - contains an empty model.
 */
echo "<h2>Создать новое правило</h2>";
$this -> renderPartial('//rules/_form',array('model' => $model));
?>