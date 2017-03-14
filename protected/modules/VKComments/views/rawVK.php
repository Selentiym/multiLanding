<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 13.03.2017
 * Time: 21:13
 */
?>
<table>
    <tr><td>Имя</td><td><?php echo $data -> first_name; ?></td></tr>
    <tr><td>Фамилия</td><td><?php echo $data -> last_name; ?></td></tr>
    <tr><td>идентификатор</td><td><?php echo CHtml::link($data -> domain, 'https://vk.com/'.$data -> domain); ?></td></tr>
    <tr><td>Фото</td><td><img src="<?php echo $data -> photo_50; ?>"/></td></tr>
</table>
