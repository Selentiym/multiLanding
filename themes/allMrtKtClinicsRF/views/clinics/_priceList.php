<?php
/**
 * @type ObjectPriceValue[] $prices
 */
?>
<h2 id="price_heading">Цены клиники</h2>
<div id="price_cont">
<?php
	foreach($prices as $price) {
		echo "<div class='single_price'>";
		echo "<span class='price_name'>".$price -> price -> name."</span>";
		echo "<span class='price_value'>".round($price -> value)." руб.</span>";
		echo "</div>";
	}
?>
</div>
<!--<div id="small_clinic_info">-->
<!--	--><?php //echo $clinic -> prices_text;?>
<!--</div>-->