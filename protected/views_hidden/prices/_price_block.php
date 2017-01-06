<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 18.06.2016
 * Time: 12:25
 */
/**
 * @type PriceBlock $block
 * @type PriceBlock $prev
 * @type int[] $highlight
 */
//Если название категории цен отличается от предыдущего блока, то рендерим название.
$renderBlockCategoryHeading = false;
$renderBlockCategoryHeading |= (!is_a($prev,'PriceBlock'));
$renderBlockCategoryHeading |= ($prev -> category_name != $block -> category_name);

if ($renderBlockCategoryHeading) {
    $this -> renderPartial('//subs/_category_heading', array('name' => $block -> category_name));
}

$prices_initial = $block -> prices;
$prices = array();
foreach ($prices_initial as $price) {
    if (in_array($price -> id, $highlight)) {
        array_unshift($prices, $price);
    } else {
        array_push($prices, $price);
    }
}

/**
 * Конец обще части, теперь рендерим частности
 */
$this -> renderPartial('//subs/_price_block',[
    'block' => $block,
    'prices' => $prices,
    'opened' => $opened,
    'highlight' => $highlight
]);
?>