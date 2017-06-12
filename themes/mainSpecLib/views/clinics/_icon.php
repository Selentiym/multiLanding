<?php
/**
 *
 * @var String $iClass
 * @var String $text
 */
if (!$text) {
    return;
}
?>
<div class="row align-items-center">
    <div class="col-auto">
        <i class="fa <?php echo $iClass; ?>" aria-hidden="true"></i>
    </div>
    <div class="col">
        <?php echo $text; ?>
    </div>
</div>
