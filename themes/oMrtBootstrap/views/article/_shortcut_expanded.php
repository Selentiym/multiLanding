<?php
/**
 * @type Article $article
 */
?>
<a href="<?php echo $this -> createUrl('home/articleView',['verbiage' => $article -> verbiage]); ?>" class="list-group-item list-group-item-action flex-column align-items-start">
	<div class="d-flex w-100 justify-content-between">
		<h4 class="mb-1"><?php echo $article -> name; ?></h4>
	</div>
	<p class="mb-1"><?php echo $article -> description;?></p>
</a>