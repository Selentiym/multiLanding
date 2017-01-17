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
$basePrice = $price -> price;
$oldCoeff = 1.3;
$round = 100;
if (!$coeff) { $coeff = 1; }
?>

<tr <?php if ($active) { echo 'class="selected"'; } ?>>
    <td class="price-name"><span id="price<?php echo $price->id; ?>" style="position:relative; display:inline-block; top:-100px;"></span><span><?php echo $price->text; echo $active ? '<img src="'.Yii::app() -> baseUrl.'/img/superprice.png" alt="superPrice"/>' : '';?></span></td>
    <td class="price-new">от <?php echo round($basePrice * $coeff / 10) * 10; ?>p.</td>
    <td class="price-old"><?php echo round($basePrice * $coeff * $oldCoeff / $round) * $round; ?>p.</td>
</tr>
