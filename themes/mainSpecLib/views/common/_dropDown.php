<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12.06.2017
 * Time: 9:19
 * @var string $name
 * @var string $content
 * @var bool $shown
 */
$id = $id.str2url(strip_tags($name));
?>
<div class="card w-100">
    <div class="card-header" data-toggle="collapse" href="#<?=$id?>">
        <h5 class="card-title">
            <?php echo $name; ?>
        </h5>
    </div>
    <div class="card-block collapse<?php echo $shown ? ' show' : ''; ?>" id="<?=$id?>">
        <ul class="list-group">
        <?php echo $content; ?>
        </ul>
    </div>
</div>
