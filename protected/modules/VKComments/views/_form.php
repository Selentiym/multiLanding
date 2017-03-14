<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 14.03.2017
 * Time: 20:13
 *
 * @type VKCommentsModule $mod
 * @type Comment $model
 * @type CActiveForm $form
 *
 */
if (!$mod) {
    $mod = $this -> getModule();
}
if ($model -> getIsNewRecord()) {
    $model -> approved = 1;
}
?>
<div class="row-fluid">

    <div class="form">

        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'comment-form',
            // Please note: When you enable ajax validation, make sure the corresponding
            // controller action is handling ajax validation correctly.
            // There is a call to performAjaxValidation() commented in generated controller code.
            // See class documentation of CActiveForm for details on this.
            'enableAjaxValidation'=>false,
        )); ?>

        <div class="span6">
            <?php if(Yii::app()->user->hasFlash('duplicateField')): ?>
                <div class="alert-danger">
                    <?php echo Yii::app()->user->getFlash('duplicateField'); ?>
                </div>
            <?php endif; ?>

            <p class="note"> <?php echo CHtml::encode('Поля с '); ?> <span class="required">*</span> <?php echo CHtml::encode('обязательны для заполнения'); ?></p>

            <div>
                <?php echo $form->labelEx($model,'text'); ?>
                <?php echo $form->textArea($model,'text',array('style' => 'width:450px;height:150px')); ?>
                <?php echo $form->error($model,'text'); ?>
            </div>

            <div>
                <?php echo $form->labelEx($model,'approved'); ?>
                <?php echo $form->checkBox($model,'approved'); ?>
                <?php echo $form->error($model,'approved'); ?>
            </div>
            <h3>Карточка пользователя</h3>
            <div id="personContainer">
                <?php echo $acc; ?>
            </div>
            <input type="button" id="changePerson" value="Сменить карточку"/>
            <?php echo $form -> hiddenField($model,'vk_id',['id' => 'vk_id']); ?>
            <input type="hidden" name="<?php echo get_class($model); ?>[api]" id="apiHidden"/>
            <br/>
            <div class="buttons">
                <?php echo CHtml::submitButton($model->isNewRecord ? CHtml::encode('Создать') : CHtml::encode('Сохранить'),['name' => 'submit']); ?>
            </div>
            <?php
                Yii::app() -> getClientScript() -> registerScript('changePerson','
                    var $vkId= $("#vk_id");
                    var $api= $("#apiHidden");
                    var $cont = $("#personContainer");
                    $("#changePerson").click(function(){
                        $.post("'.$mod -> createUrl('admin/GetRandomVK').'",{}, function(){}, "JSON").done(function(data){
                            $vkId.val("");
                            $api.val(data.id);
                            $cont.html(data.html);
                        });
                    });
                ',CClientScript::POS_READY);
            ?>
            <?php $this->endWidget(); ?>
        </div>
    </div><!-- form -->
</div>
