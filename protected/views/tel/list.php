<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.07.2016
 * Time: 12:17
 */
$tels = Tel::model() -> findAll(array('order' => 'prior DESC'));
?>
<a href="<?php echo Yii::app() -> createUrl("admin/rules"); ?>">Правила для запроса</a>
<h1>Список телефонов</h1>
<button onClick="location.href='<?php echo Yii::app() -> baseUrl.'/admin/createTel'; ?>'">Создать</button>
<table>
    <tr>
        <td>Приоритет</td>
        <td>Слово</td>
        <td>Телефон</td>
    </tr>
    <?php
    foreach ($tels as $tel) {
        $this -> renderPartial('//tel/_single', array('tel' => $tel));
    }
    ?>
</table>