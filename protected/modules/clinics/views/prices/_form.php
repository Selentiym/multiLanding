<div class="row-fluid">

    <div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'fields-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation'=>false,
    )); ?>

        <div class="span6">
            
        <p class="note"> <?php echo CHtml::encode('Поля с '); ?> <span class="required">*</span> <?php echo CHtml::encode('обязательны для заполнения'); ?></p>
            <div>
                <?php echo $form->labelEx($model,'id_block'); ?>

                <?php
                $objects= CHtml::listData(ObjectPriceBlock::model()->findAll(), 'id', 'name');

                echo CHtml::activeDropDownList($model,'id_block', $objects,array());
                ?>
                <?php echo $form->error($model,'id_block'); ?>
            </div>

            <div>
                <?php echo $form->labelEx($model,'id_type'); ?>

                <?php
                $objects= CHtml::listData(PriceType::model()->findAll(), 'id', 'name');

                echo CHtml::activeDropDownList($model,'id_type', $objects,array());
                ?>
                <?php echo $form->error($model,'id_type'); ?>
            </div>

            <div>
                <?php echo '<label>Цена для</label>'; ?>

                <?php
                $objects= CHtml::listData(Objects::model()->findAll(), 'id', 'name');

                echo CHtml::activeDropDownList($model,'object_type', $objects,array());
                ?>
                <?php echo $form->error($model,'object_type'); ?>
            </div>

            <div>
                <?php echo $form->labelEx($model,'name'); ?>
                <?php echo $form->textField($model,'name',array('size'=>50,'maxlength'=>50)); ?>
                <?php echo $form->error($model,'name'); ?>
            </div>

            <div>
                <?php echo $form->labelEx($model,'name2'); ?>
                <?php echo $form->textField($model,'name2',array('size'=>50,'maxlength'=>50)); ?>
                <?php echo $form->error($model,'name2'); ?>
            </div>

            <div>
                <?php echo $form->labelEx($model,'verbiage'); ?>
                <?php echo $form->textField($model,'verbiage',array('size'=>50,'maxlength'=>50)); ?>
                <?php echo $form->error($model,'verbiage'); ?>
            </div>

            <div>
                <?php
                echo $form->labelEx($model,'id_article');
                echo CHtml::activeDropDownList($model,'id_article',['' => 'Не выбрано'] + CHtml::listData(Article::model() -> findAll(),'id','name'), [],[$model -> id_article],'');
                echo $form->error($model,'id_article');
                ?>
            </div>

              
        <br/>
        <div class="buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? CHtml::encode('Создать') : CHtml::encode('Сохранить')); ?>
        </div>

    <?php $this->endWidget(); ?>
    </div>
    </div><!-- form -->
</div>