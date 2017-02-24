<?php
/**
 *
 * @var TriggerParameter $param
 * @var TriggerValues $model
 */
?>
<tr>
<td><?php echo $param -> name; ?></td>
<td><?php echo $param -> verbiage; ?></td>
<td><input type="text" name="parameters[<?php echo $param -> id; ?>]" value="<?php echo $model -> getParameterValue($param -> id) -> value; ?>" /></td>
</tr>