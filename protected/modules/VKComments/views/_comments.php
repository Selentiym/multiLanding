<?php
/**
 * @type bool $showButton
 * @type Comment[] $reviews
 */
if (empty($reviews)) {
    //Чтобы убрать ненужную кнопку.
    echo "<span> </span>";
    return;
}
foreach($reviews as $rev){
    $this -> renderPartial('/_single_review',['model' => $rev]);
}
if ($showButton) {
    echo "<div class='showMoreReviews flat_button addpost_button send_post' style='text-align:center;mergin-top:10px;'>Показать еще</div>";
}