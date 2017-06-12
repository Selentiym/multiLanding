<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 11.06.2017
 * Time: 16:29
 */
$id = $a -> verbiage;
?>
<div class="card mb-2">
    <div class="card-header p-b-0">
        <h5 class="card-title text-center">
            <i class="fa fa-book" aria-hidden="true"></i>
            <?php $heading = $a -> getHeading(); ?>
        </h5>
    </div>
    <div class="card-block">
        <?php
        if ($a) {
            echo $a -> description;
            $url = $a -> getImageUrl();
            if ($url) {
                echo "<img style='width:90%;margin:5px auto; display:block;' class='mx-auto' src='$url' alt='".addslashes($a->name)."'/>";
            }
        } ?>
        <div class="text-center"><button type="button" class="btn" data-toggle="modal" data-target="#articlePopup<?php echo $id; ?>">Подробнее</button></div>
        <div class="modal fade articleModal" id="articlePopup<?php echo $id;?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content p-3">
                    <?php
                    if ($a) : ?>
                        <div class="modal-header">
                            <h2>
                                <?php
                                echo $heading;
                                ?>
                            </h2>
                        </div>
                        <div class="modal-body">
                            <?php
                            echo $a -> prepareTextByVerbiage($triggers);
                            ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!--                    <button class="btn" data-toggle="collapse" data-target="#moreDynamic">Подробнее</button>-->
    </div>
</div>

