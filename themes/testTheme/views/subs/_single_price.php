<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 20.12.2016
 * Time: 22:33
 */
?>
<tr <?php if ($active) { echo 'class="selected"'; } ?>>
<td class="price-name"><span id="price<?php echo $price->id; ?>" style="position:relative; display:inline-block; top:-100px;"></span><span><?php echo $price->text; echo $active ? '<img src="'.Yii::app() -> baseUrl.'/img/superprice.png" alt="superPrice"/>' : '';?></span></td>
<td class="price-new">от <?php echo $price -> price; ?>p.</td>
<td class="price-old"><?php echo $price -> price_old; ?>p.</td>
</tr>