<?php
/**
 * @type Article $article
 */
?>
<nav class="breadcrumb bg-faded no-gutters">
	<a class="breadcrumb-item col-auto" href="<?php echo $this -> createUrl($this->id.'/'.$this->defaultAction); ?>">Главная</a>
	<?php
	/**
	 * @type Article $article
	 */
	if ($article) {
		//echo CHtml::encode("->");
		$parents = $article -> GiveParentList($article);
		unset($parents[-1]);
		if ($parents[0]['verbiage'] == 'tomographyContainer') {
			?>
			<a class='breadcrumb-item col-auto' href='<?php echo $this -> createUrl('home/tomography'); ?>'>Томография</a>
			<?php
			array_shift($parents);
		} else {
			?>
			<a class='breadcrumb-item col-auto' href='<?php echo $this -> createUrl('home/articles'); ?>'>Все об МРТ и КТ</a>
			<?php
		}
		//foreach($parents as $parent)
		//print_r($parents);
		for ($i = 0; $i < count($parents); $i ++) {
			$parent = $parents[$i];
			$url = $this -> createUrl('home/articleView',['verbiage' => $parent['verbiage']]);
			echo "<a class='breadcrumb-item col-auto' href='{$url}'>{$parent['name']}</a>";
			//echo '<div class="arrow"></div>';
		}
		$url = $this -> createUrl('home/articleView',['verbiage' => $article['verbiage']]);
		echo "<a class='breadcrumb-item col-auto active' href='{$url}'>{$article['name']}</a>";
	}
	?>
</nav>