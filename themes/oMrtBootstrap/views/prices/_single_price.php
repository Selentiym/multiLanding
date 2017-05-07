<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 03.04.2017
 * Time: 14:05
 *
 * @type ObjectPrice $price
 * @type ObjectPrice $mainPrice
 */
$url = $this -> createUrl('home/clinics',['research' => $price -> verbiage]);
$active = ($mainPrice -> id == $price -> id) ? ' active' : '' ;
?>
<a href="<?php echo $url; ?>" class="list-group-item list-group-item-action<?php echo $active; ?>">
    <?php echo $price -> name; ?>
</a>