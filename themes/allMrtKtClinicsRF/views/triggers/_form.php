<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 23.02.2017
 * Time: 14:00
 */

?>
<?php
$triggers = Triggers::topLevel();
if (!empty($triggers)) {
    foreach ($triggers as $t) {
        /**
         * @type Triggers $t
         */
        echo $t -> getHtml($_GET,['placeholder' => $t -> name,'empty_line' => true, 'class' => 'trigger_select']);

//        CHtml::DropDownListChosen2(
//            $t -> verbiage,
//            $t -> verbiage, CHtml::listData($t -> trigger_values,'verbiage','value'),
//            ['placeholder' => $t -> name,'empty_line' => true, 'class' => 'trigger_select'],
//            [$_GET[$t -> verbiage]],
//            []
//        );
    }
}
?>
