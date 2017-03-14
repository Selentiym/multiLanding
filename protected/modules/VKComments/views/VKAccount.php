<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 13.03.2017
 * Time: 21:13
 *
 * @type VKAccount $model
 */
?>
<table>
    <tr><td>Имя</td><td><?php echo $model -> first_name; ?></td></tr>
    <tr><td>Фамилия</td><td><?php echo $model -> last_name; ?></td></tr>
    <tr><td>идентификатор</td><td><?php echo CHtml::link($model -> domain, 'https://vk.com/'.$model -> domain); ?></td></tr>
    <tr><td>Фото</td><td><img src="<?php echo $model -> photo; ?>"/></td></tr>
</table>
