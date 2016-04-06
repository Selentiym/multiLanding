<?php
/**
 * This is a view file for a single rule table line
 * @var Rule $rule - contains a rule model to be showed
 */
?>
<tr>
    <td>
        <?php echo $rule -> prior; ?>
    </td>
    <td>
        <?php echo CHtml::link($rule -> word,Yii::app() -> baseUrl.'/admin/updateRule/'.$rule -> id); ?>
    </td>
    <td>
        <?php echo $rule -> price -> text; ?>
    </td>
    <td>
        <?php echo $rule -> section -> name; ?>
    </td>
</tr>
