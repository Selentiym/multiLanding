<?php
/**
 * @type News $model
 */
?>


<div class="card mb-3">
    <?php if ($model -> heading) : ?>
        <div class="card-header">
            <h3><?php echo $model -> heading; ?></h3>
        </div>
    <?php endif; ?>

    <div class="card-block">
        <div class="card-text">
        <?php echo $model -> text; ?>
        </div>
    </div>
    <?php
    $from = $model -> getTimeAttr('validFrom');
    $to = $model -> getTimeAttr('validTo');
    if (($from)||($to)) {
        echo "<div class='card-footer'>Действует";
        if ($from) {
            echo " с ".date('j.m.Y',$from);
        }
        if ($to) {
            echo " по ".date('j.m.Y',$to);
        }
        echo "</div>";
    }
    ?>
</div>


