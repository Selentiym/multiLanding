<ul>
	<?php
		foreach($articles as $a) {
			$this -> renderPartial('//article/_shortcut',array('article' => $a,'baseArticleUrl' => Yii::app() -> baseUrl.'/article'));
		}
	?>
</ul>