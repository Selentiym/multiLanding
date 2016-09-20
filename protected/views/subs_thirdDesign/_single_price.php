<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.08.2016
 * Time: 17:26
 */
/**
 * @type Price $price
 * @type bool $active
 */
?>
<tr <?php if ($active) { echo 'class="selected"'; } ?>>
    <td class="price-name"><span><?php echo $price->text; echo $active ? '<img src="'.Yii::app() -> baseUrl.'/img_thirdDesign/superprice.png" alt="superPrice"/>' : '';?></span></td>
    <td class="price-new">от <?php echo $price -> price; ?>p.</td>
    <td class="price-old"><?php echo $price -> price_old; ?>p.</td>
</tr>
