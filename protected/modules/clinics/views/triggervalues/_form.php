<div class="row-fluid">

    <div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'trigger-values-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation'=>false,
        'htmlOptions'=>array('enctype'=>'multipart/form-data'),
    ));?>

        <div class="span6">

            <p class="note"> <?php echo CHtml::encode('Поля с '); ?> <span class="required">*</span> <?php echo CHtml::encode('обязательны для заполнения'); ?></p>

            <div>
                <?php echo $form->labelEx($model,'trigger_id'); ?>
                <?php if(isset($trigger_id)) $model->trigger_id = $trigger_id; echo $form->textField($model, 'trigger_id', array('disabled'=>'disabled')); ?>
                <?php echo $form->error($model,'trigger_id'); ?>
            </div>

            <div>
                <?php echo $form->labelEx($model,'value'); ?>
                <?php echo $form->textField($model,'value',array('size'=>60,'maxlength'=>255)); ?>
                <?php echo $form->error($model,'value'); ?>
            </div>

            <div>
                <?php echo $form->labelEx($model,'verbiage'); ?>
                <?php echo $form->textField($model,'verbiage',array('size'=>60,'maxlength'=>255)); ?>
                <?php echo $form->error($model,'verbiage'); ?>
            </div>

            <div>
                <?php echo $form->labelEx($model,'comment'); ?>
                <?php echo $form->textArea($model,'comment',array('size'=>60,'maxlength'=>255)); ?>
                <?php echo $form->error($model,'comment'); ?>
            </div>


                <?php
                /**
                 * @type TriggerValues $model
                 */
                $parent = $model -> trigger -> parent;
                if ($parent) {
                    echo "<div>
                <p>Зависит от (если есть родитель)</p>";
                    echo CHtml::activeDropDownList(
                        TriggerValues::model(),
                        'id',
                        CHtml::listData($parent -> trigger_values, 'verbiage', 'value'),
                        array('name' => 'TriggerValues[dependency_array][]', 'multiple' => 'multiple'),
                        array_map(function($data){
                            return $data -> verbiage_parent;
                        }, $model -> dependencies)
                    );
                    echo "</div>";
                }
                /**
                 * @type TriggerValues $model
                 */
                $children = $model -> trigger -> children;
                if ($children) {
                    echo "<div>
                <p>Показывать при данном значении (Если есть дочерние триггеры)</p>";
                    $possibleChildren = [];
                    foreach ($children as $child) {
                        /**
                         * @type Triggers $child
                         */
                        $possibleChildren = array_merge($child -> trigger_values, $possibleChildren);
                    }
                    echo CHtml::activeDropDownList(
                        TriggerValues::model(),
                        'id',
                        CHtml::listData($possibleChildren, 'verbiage', 'value'),
                        array('name' => 'TriggerValues[children_array][]', 'multiple' => 'multiple'),
                        array_map(function($data){
                            return $data -> verbiage_child;
                        }, $model -> children)
                    );
                    echo "</div>";
                }
                ?>

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
                <?php echo CHtml::submitButton($model->isNewRecord ? CHtml::encode('Создать') : CHtml::encode('Сохранить'),['name' => 'submitted']); ?>
            </div>
            <table>
                <tr>
                    <td>Имя</td><td>Verbiage</td><td>Значение</td>
                </tr>
            <?php
                foreach ($model -> trigger -> parameters as $param) {
                    $this -> renderPartial('/triggers/parameters/_parameterForm', ['param' => $param, 'model' => $model]);
                }
            ?>
            </table>

        <?php $this->endWidget(); ?>
       </div>
    </div><!-- form -->
</div>