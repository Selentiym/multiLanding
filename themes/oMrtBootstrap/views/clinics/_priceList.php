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
		$prs = $block -> prices ? $block -> prices : [];
		foreach ($prs as $pr) {
			if ($pr -> id == $price -> id) {
				if ($model -> getPriceValue($pr -> id)) {
					array_unshift($temp, $pr);
//					$temp[$pr -> id] = $pr;
					continue;
				}
				if ($model -> getPriceValue($pr -> id_replace_price)) {
					$repl = $pr -> replacement;
					$name = $pr -> nameRod;
					if (!$name) {
						$name = $pr -> name;
					}
					$delId = $repl -> id;
					unset($temp[$delId]);
					$temp = array_merge([$repl -> name.' (включает '.$name.')' => $repl],$temp);
					continue;
				}
			}
			if (($pr -> id != $delId)&&($model -> getPriceValue($pr -> id))) {
				$temp[$pr->id] = $pr;
			}
		}
		$block -> prices = $temp;
		$this -> renderPartial('/prices/_single_block_clinics',['block' => $block, 'model' => $model, 'mainPrice' => $price]);
	}
?>
<!--<div id="small_clinic_info">-->
<!--	--><?php //echo $clinic -> prices_text;?>
<!--</div>-->