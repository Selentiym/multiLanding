<div class="list-group">
	<?php
		foreach($articles as $a) {
			$this -> renderPartial('/article/_shortcut_expanded',['article' => $a]);
		}
	?>
</div>