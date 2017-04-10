<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10.04.2017
 * Time: 17:22
 */
function icon($icon, $text, $class = ''){
    echo '
<div class="row no-gutters align-items-center">
    <div class="col-auto"><i class="'.$class.' fa fa-'.$icon.' fa-lg fa-fw" aria-hidden="true"></i>&nbsp;</div>
    <div class="col"><div class="text">'.$text.'</div></div>
</div>';
}