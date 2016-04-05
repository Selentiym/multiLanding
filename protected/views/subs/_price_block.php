	<?php
		/**
		 * $id contains the highlighted price id. It must be shown in the beginning
		 * $opened - whether the contaier must be opened or closed
		 * $noHeading - whether to hide heading
		 * $block contains a block active record to be shown
		 */
		//$prices = Price::model() -> findAll();
		$prices = $block -> prices;
		$count = 0;
		$max = count ($prices);
		if (!$noHeading) {
			$block -> renderHeading();
		}
		
		for ($i = 0; $i < 3; $i ++) {
			$price = $prices[$i];
			if (!$price) {
				break;
			}
			if ($price -> id != $id) {
				$this -> renderPartial('//subs/_single_price',array('price' => $price, 'active' => false));
			}
			/*$count ++;
			if ($count == ceil($max/2)) {
				break;
			}*/
		}
	?>
	
	<div>
		<div class="nav-submenu" <?php if ($opened) { echo "style='display:block;'"; } ?>>
			<?php
				$i = 3;
				while($price = $prices[$i]){
					$i++;
					if ($price -> id != $id) {
						$this -> renderPartial('//subs/_single_price',array('price' => $price, 'active' => false));
					}
				}
			?>
		</div>
		<?php if ((!$opened)&&($prices[3])) : ?><h2 class="all_price nav-click" ><a>ВСЕ ЦЕНЫ</a></h2><?php endif; ?>
	</div>