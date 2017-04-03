<?php
/**
 *
 */
?>
<div class="row">
    <div>

    </div>

    <div class="speciality_dropdown select">
        <div class="image"><span></span></div>
        <div class="select_cont">
            <?php $specialities = CHtml::listData(ObjectPrice::model() -> findAll(),'verbiage','name'); ?>
            <?php CHtml::DropDownListChosen2('research','search_speciality', $specialities,array('placeholder' => 'Выберите исследование','empty_line' => 'Исследование'),array($_GET['research'])); ?>
        </div>
    </div>

    <div class="metro_dropdown select">
        <div class="image"><span></span></div>
        <div class="select_cont">
            <?php $metro_obj = Metro::model()->findAll(array('order' => 'name ASC')); ?>
            <?php CHtml::DropDownListChosen2('metro','search_metro', CHtml::listData($metro_obj, 'id', 'name'),array('placeholder' => 'Выберите метро','empty_line' => 'Метро'),array($_GET['metro'])); ?>
        </div>
    </div>
</div>
