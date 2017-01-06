<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 05.01.2017
 * Time: 15:05
 */
/**
 * @type PriceBlock $block
 */
$prices = $block -> getOrderedPrices();
$count = 0;
$blockName = preg_replace('/([а-я]+)/ui','<b>$1</b>',$block -> name, 1, $count);
if ($count == 0) {
    $blockName = "<b>$blockName</b>";
}
$type = $block -> category_name == 'mrt' ? 'mrt' : 'kt';
?>
<li class="<?php echo $type; ?> <?php echo 'price-'.$block -> className; ?>">
    <div class="h1" id="<?php echo $type.'-'.$block -> className; ?>"><?php echo $blockName; ?></div>
    <div class="price-content">
        <table>
            <?php
            foreach($prices as $price){
                $this -> renderPartial('//subs/_single_price',[
                    'price' => $price,
                    'active' => $price -> getHighlight()
                ]);
            }
            ?>

        </table>
    </div>
</li>
