<div class="row-fluid">

    <div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'triggers-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation'=>false,
        'htmlOptions'=>array('enctype'=>'multipart/form-data'),
    ));
    /**
     * @type CActiveForm $form
     */
    ?>

        <div class="span6">

            <p class="note"> <?php echo CHtml::encode('Поля с '); ?> <span class="required">*</span> <?php echo CHtml::encode('обязательны для заполнения'); ?></p>

            <div>
                <?php echo $form->labelEx($model,'name'); ?>
                <?php echo $form->textField($model, 'name',array('size'=>60,'maxlength'=>255)); ?>
                <?php echo $form->error($model,'name'); ?>
            </div>
            
            <div>
                <?php echo $form->labelEx($model,'verbiage'); ?>
                <?php echo $form->textField($model, 'verbiage',array('size'=>60,'maxlength'=>255)); ?>
                <?php echo $form->error($model,'verbiage'); ?>
            </div>

            <div>
                <?php echo $form->labelEx($model,'type'); ?>
                <?php echo CHtml::activeDropDownList($model,'type', Triggers::$types); ?>
                <?php echo $form->error($model,'type'); ?>
            </div>

            <div>
                <?php echo $form->labelEx($model,'showIfNullParent'); ?>
                <?php echo $form -> checkBox($model,'showIfNullParent'); ?>
                <?php echo $form->error($model,'showIfNullParent'); ?>
            </div>



            <div id="parents_block">
                <?php echo '<p>Зависит от</p>'; ?>
                <?php echo $form->dropDownList($model,'id_parent', ['' => 'Основной триггер'] + CHtml::listData(Triggers::model() -> findAll(),'id','name')); ?>
                <?php echo $form->error($model,'id_parent'); ?>
            </div>


           <input type="hidden" name="MAX_FILE_SIZE" value="20971520" />
           <div>
                <?php echo $form->labelEx($model,'logo'); ?>
                <?php
                    if (!empty($model->logo)) {
                        $logo = $model -> giveImageFolderRelativeUrl() .$model->logo;
                        echo '<div id="logo">' . CHtml::ajaxLink('<i class="icon-remove"></i>', CController::createUrl('admin/propDelete/' . $model->id), array('type'=> 'POST', 'data'=>array('model' => 'trigger', 'prop' => 'logo'), 'success' => 'js: $("#logo").hide()'))
                         . CHtml::image($logo, CHtml::encode('Логотип'),
                            array('style' => 'max-width:172px;max-height:200px; padding: 8px 0px 8px 15px;')) . '</div>';
                    }
                ?>
                <?php echo $form->fileField($model, 'logo'); ?>
                <?php echo $form->error($model,'logo'); ?>
            </div>

            <div class="buttons">
                <?php echo CHtml::submitButton($model->isNewRecord ? CHtml::encode('Создать') : CHtml::encode('Сохранить')); ?>
            </div>

        <?php $this->endWidget(); ?>
       </div>
    </div><!-- form -->
</div>