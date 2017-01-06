<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 06.04.2016
 * Time: 18:59
 */
$rules = CommonRule::model() -> findAll(array('order' => 'prior DESC'));
?>
<a href="<?php echo Yii::app() -> createUrl("admin/tel"); ?>">Правила для телефонов</a>
<h1>Список правил</h1>
<button onClick="location.href='<?php echo Yii::app() -> baseUrl.'/admin/createRule'; ?>'">Создать</button>
<table>
    <tr>
        <td>Приоритет</td>
        <td>Слово</td>
        <td>Цена</td>
        <td>Блок</td>
    </tr>
    <?php
        foreach ($rules as $rule) {
            $this -> renderPartial('//rules/_single', array('rule' => $rule));
        }
    ?>
</table>