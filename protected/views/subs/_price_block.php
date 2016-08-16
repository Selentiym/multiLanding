<?php
$count = 0;
$max = count ($prices);

echo "<h2>---" . $block->name . "---</h2>";
//$block -> renderHeading();


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
