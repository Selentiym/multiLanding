<?php
/**
 * @type Article $article
 */
?>
<div class="col-md-4 col-12 p-1">
    <a href="<?php echo $this -> createUrl('home/articleView',['verbiage' => $article -> verbiage]); ?>" class="list-group-item list-group-item-action flex-column align-items-start">
        <div class="d-flex w-100 justify-content-between">
            <h4 class="mb-1"><?php echo $article -> name; ?></h4>
        </div>
        <div class="text-center w-100"><img class="m-1" style="max-height: 300px; max-width:100%;" src="<?php echo $article -> getImageUrl(); ?>" alt="<?php echo $article -> name; ?>"/></div>
        <p class="mb-1"><?php echo $article -> description;?></p>
    </a>
</div>