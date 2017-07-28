<div class="row">
	<?php
		foreach($articles as $arr) {
			if ($arr instanceof Article) {
				$arr = articleForImagedShortcut($arr);
			}
//			$this -> renderPartial('/article/_shortcut_expanded',['article' => $a]);
			$this -> renderPartial('//article/_shortcut_imaged',$arr);
		}
	?>
</div>