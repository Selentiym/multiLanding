<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.07.2016
 * Time: 12:20
 */
/**
 * This is a view file for a single Tel table line
 * @var Tel $tel - contains a Tel model to be showed
 */
?>
<tr>
    <td>
        <?php echo $tel -> prior; ?>
    </td>
    <td>
        <?php echo CHtml::link($tel -> word,Yii::app() -> baseUrl.'/admin/updateTel/'.$tel -> id); ?>
    </td>
    <td>
        <?php echo $tel -> tel; ?>
    </td>
</tr>

