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
$temp = ['mrt' => false, 'kt' => false];
$type = $price -> type -> alias;
$temp[$type] = $type;
unset ($temp['other']);
$temp['research'] = $price -> verbiage;
$url = $this -> createUrl('home/clinics',$temp);
$active = ($mainPrice -> id == $price -> id) ? ' active' : '' ;
?>
<a href="<?php echo $url; ?>" class="list-group-item list-group-item-action<?php echo $active; ?>">
    <?php echo $price -> name; ?>
</a>