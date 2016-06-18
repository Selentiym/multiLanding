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
    $this -> renderPartial('//prices/_category_heading', array('name' => $block -> category_name));
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
$count = 0;
$max = count ($prices);

$block -> renderHeading();


for ($i = 0; $i < 3; $i ++) {
    $price = $prices[$i];
    if (!$price) {
        break;
    }
    $this -> renderPartial('//subs/_single_price',array('price' => $price, 'active' => in_array($price -> id, $highlight)));
}
?>

<div>
    <div class="nav-submenu" <?php if ($opened) { echo "style='display:block;'"; } ?>>
        <?php
        $i = 3;
        while($price = $prices[$i]){
            $i++;
            $this -> renderPartial('//subs/_single_price',array('price' => $price, 'active' => false));
        }
        ?>
    </div>
    <?php if ((!$opened)&&($prices[3])) : ?><h2 class="all_price nav-click" ><a>ВСЕ ЦЕНЫ</a></h2><?php endif; ?>
</div>
