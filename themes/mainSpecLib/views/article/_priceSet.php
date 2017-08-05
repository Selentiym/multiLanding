<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12.06.2017
 * Time: 13:42
 * @var ObjectPrice[] $prices
 * @var mixed[] $triggers
 * @var CDbCriteria|null $criteria
 * @var string|null $id
 * @var string $adding
 */
$id = $id.implode('-',array_values($triggers));
$prices = ObjectPrice::calculateMinValues($prices,$triggers,$criteria);
$typedPrices = UClinicsModuleModel::groupBy($prices,'id_type');
$names = [
    1 => '<i class="fa fa-life-ring"></i>&nbsp;Сделать МРТ'.$adding,
    2 => '<i class="fa fa-server"></i>&nbsp;Сделать КТ'.$adding,
    3 => '<i class="fa fa-toggle-on"></i>&nbsp;Отдельные'.$adding,
];
foreach ($typedPrices as $type => $pricesOfType) {
    ob_start();
    foreach ($pricesOfType as $price) {
        $copy = $triggers;
        $copy['research'] = $price -> verbiage;
        $rowUrl = $this -> createUrl('home/clinics',$copy,'&',false,true);
        $val = $price -> getCachedPrice();
        if ($val instanceof ObjectPriceValue) {
            $rowText = CHtml::link($price -> name, $rowUrl);
            $priceText = CHtml::link("от ".$val -> value,$rowUrl);
            $content .= $this -> renderPartial('/common/_dropDownLine', ['name' => $rowText, 'price' => $priceText], true, false);
        }
    }
    echo $content;
    //$this -> renderPartial('/common/_dropDown', ['id' => $id,'name' => '<i class="fa fa-rouble" aria-hidden="true"></i>&nbsp;'., 'content' => $content]);
//    $blockedPrices = UClinicsModuleModel::groupBy($pricesOfType,'id_block');
//    foreach ($blockedPrices as $blockId => $pricesOfBlock) {
//        /**
//         * @type ObjectPriceBlock $block
//         * @type ObjectPriceValue[] $pricesOfBlock
//         */
//        $firstPrice = current($pricesOfBlock);
//        if (!$firstPrice instanceof ObjectPrice) {
//            continue;
//        }
//        $content = '';
//        foreach ($pricesOfBlock as $price) {
//            $copy = $triggers;
//            $copy['research'] = $price -> verbiage;
//            $rowUrl = $this -> createUrl('home/clinics',$copy,'&',false,true);
//            $val = $price -> getCachedPrice();
//            if ($val instanceof ObjectPriceValue) {
//                $rowText = CHtml::link($price -> name, $rowUrl);
//                $priceText = CHtml::link("от ".$val -> value,$rowUrl);
//                $content .= $this -> renderPartial('/common/_dropDownLine', ['name' => $rowText, 'price' => $priceText], true, false);
//            }
//        }
//        $block = $firstPrice -> block;
//
//        $this -> renderPartial('/common/_dropDown', ['id' => $id,'name' => '<i class="fa fa-rouble" aria-hidden="true"></i>&nbsp;'.$block -> name, 'content' => $content]);
//    }
    $out = ob_get_contents();
    ob_end_clean();
    echo "<div class='col-md-4 col-12'>";
    $this -> renderPartial('/common/_dropDown', ['id' => $id,'name' => $names[$type],'content' => $out]);
    echo "</div>";
}
?>