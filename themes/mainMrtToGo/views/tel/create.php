<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 06.04.2016
 * Time: 18:54
 */
/**
 * @var Tel $model - contains an empty model.
 */
echo "<h2>Создать новое правило для телефонов</h2>";
$this -> renderPartial('//tel/_form',array('model' => $model));
?>