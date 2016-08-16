<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 18.06.2016
 * Time: 12:39
 */
/**
 * @type string $text
 */
$names = array(
    'mrt' => 'Цены МРТ',
    'kt_' => 'Цены КТ',
    'sel' => 'Общие цены',
);
$label = $names[$name];
if ($label) :
?>
<div class="blocks_label">
    <span class="label_img"></span><span class="label_text"><?php echo $label; ?></span>
</div>
<?php endif; ?>