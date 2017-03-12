<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12.03.2017
 * Time: 0:08
 *
 * @type ArticleRule $model
 * @type CActiveForm $form
 */
$form=$this->beginWidget('CActiveForm', array(
    'id'=>'clinics-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation'=>false,
    'htmlOptions'=>array('enctype'=>'multipart/form-data'),
));
$_GET = array_map(function($d){return $d -> valueVerbiage;},$model -> getTriggers());
$baseTheme = Yii::app() -> theme -> baseUrl;
$cs = Yii::app()->getClientScript();
$cs-> registerCoreScript('select2');
$cs-> registerCssFile($baseTheme.'/css/objects_list.css');
$cs -> registerScript('add_select2s','$("#search_speciality").select2();$("#search_metro").select2();',CClientScript::POS_READY);
?>
<div class="row-fluid">
    <hr><br/>

    <?php $this -> renderPartial('//clinics/_beautiful_form'); ?>
    <?php $this -> renderPartial('//triggers/_form'); ?>
    <div class="span5">

        <p class="note"> <?php echo CHtml::encode('Поля с '); ?> <span class="required">*</span> <?php echo CHtml::encode('обязательны для заполнения'); ?></p>

        <div>
            <?php echo $form->labelEx($model,'verbiage'); ?>
            <p>Менять не рекомендуется</p>
            <?php echo $form->textField($model,'verbiage',array('size'=>60,'maxlength'=>255)); ?>
            <?php echo $form->error($model,'verbiage'); ?>
        </div>

        <div>
            <?php echo $form->labelEx($model,'num'); ?>
            <?php echo $form->textField($model,'num',array('size'=>60,'maxlength'=>255)); ?>
            <?php echo $form->error($model,'num'); ?>
        </div>

        <div>
            Активно
            <?php
            echo CHtml::activeCheckBox($model,'active');
            ?>
        </div>
        <div>
            Отрицание
            <?php
            echo CHtml::activeCheckBox($model,'negative');
            ?>
        </div>
        <div>
            <?php
                echo $form->labelEx($model,'id_object');
                echo CHtml::activeDropDownList($model,'id_object',CHtml::listData(Article::model() -> findAllByAttributes(['id_type' => $model -> id_object_type]),'id','name'), [],[$model -> id_object],'');
                echo $form->error($model,'id_object');
            ?>
        </div>
        <div>
            <div>
                <?php echo $form->labelEx($model,'expression'); ?>
                <?php echo $form->textField($model,'expression',array('size'=>60,'maxlength'=>255)); ?>
                <?php echo $form->error($model,'expression'); ?>
            </div>
        </div>
        <?php $form -> hiddenField($model, 'id_object_type'); ?>
        <?php echo CHtml::submitButton($model->isNewRecord ? CHtml::encode('Создать') : CHtml::encode('Сохранить'),['name' => 'submitButton']); ?>
    </div>
</div>
<?php
    $this->endWidget();
?>