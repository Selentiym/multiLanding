<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 23.02.2017
 * Time: 14:00
 */

?>
<form method="get" class="noEmpty">
<?php
$triggers = Triggers::model() -> findAll();
if (!empty($triggers)) {
    foreach ($triggers as $t) {
        CHtml::DropDownListChosen2(
            $t -> verbiage,
            $t -> verbiage, CHtml::listData($t -> trigger_values,'verbiage','value'),
            ['placeholder' => $t -> name],
            [$_GET[$t -> verbiage]]
        );
    }
}
?>
    <input type="submit" value="go!"/>
</form>
