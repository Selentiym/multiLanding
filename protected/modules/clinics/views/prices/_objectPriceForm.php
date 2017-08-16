<?php
/**
 *
 * @var clinics|doctors $object
 * @var ObjectPrice $model
 */
?>
<tr>
    <td><?php echo $model -> type -> name; ?></td>
    <td><?php echo $model -> block -> name; ?></td>
    <td><?php echo $model -> name; ?></td>
    <td><input type="number" name="prices[<?php echo $model -> id; ?>]" value="<?php echo $object -> getPriceValue($model -> id) -> value; ?>" /></td>
    <td><input type="checkbox" name="pricesLocked[<?php echo $model -> id; ?>]" <?php echo $object -> getPriceValue($model -> id) -> locked ? 'checked=checked' : ''; ?> /></td>
</tr>
