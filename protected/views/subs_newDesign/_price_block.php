<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.08.2016
 * Time: 16:41
 */
/**
 * @type PriceBlock $block
 * @type Price[] $prices
 * @type bool $opened
 * @type Price $highlight
 */
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
                $this -> renderPartial(Yii::app() -> session -> get('folder').'/_single_price',[
                    'price' => $price,
                    'active' => in_array($price -> id, $highlight)
                ]);
            }
            ?>
            
        </table>
    </div>
</li>
