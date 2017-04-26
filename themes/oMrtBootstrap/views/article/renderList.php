<div class="row">
	<?php
		foreach($articles as $a) {
//			$this -> renderPartial('/article/_shortcut_expanded',['article' => $a]);
			$this -> renderPartial('//article/_shortcut_imaged',['article' => $a]);
		}
	?>
</div>