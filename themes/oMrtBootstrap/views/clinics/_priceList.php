<?php
/**
 * @type clinics $model
 * @type ObjectPriceBlock[] $blocks
 */
if (!$blocks) {
	$blocks = [];
}

	foreach($blocks as $block) {
		$temp = [];
		$prices = $block -> prices ? $block -> prices : [];
		foreach ($prices as $price) {
			if ($model -> getPriceValue($price -> id)) {
				$temp[] = $price;
			}
		}
		$block -> prices = $temp;
		$this -> renderPartial('/prices/_single_block_clinics',['block' => $block, 'model' => $model, 'mainPrice' => $price]);
	}
?>
<!--<div id="small_clinic_info">-->
<!--	--><?php //echo $clinic -> prices_text;?>
<!--</div>-->