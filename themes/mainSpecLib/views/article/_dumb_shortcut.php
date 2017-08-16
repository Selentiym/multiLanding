<?php
/**
 *
 * @var string $name
 * @var string $url
 * @var string $imageUrl
 * @var string $text
 */
?>
<div class="card w-100">
    <div class="card-header">
        <h5 class="card-title text-center">
            <a href="<?php echo $url; ?>"><i class="fa fa-book"></i>&nbsp;<?php echo $name; ?></a>
        </h5>
    </div>
    <div class="card-block">
        <?php if ($imageUrl) : ?>
            <a href="<?php echo $url; ?>"><img class="img-fluid" src="<?php echo $imageUrl; ?>" alt="<?php echo $name; ?>" /></a>
        <?php endif; ?>
        <div>
            <?php echo $text; ?>
        </div>
    </div>
</div>

