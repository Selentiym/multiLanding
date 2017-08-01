<div class="row-fluid">

    <div class="form">

    <?php
    /**
     * @type CActiveForm $form
     * @type News $model
     */
    $form=$this->beginWidget('CActiveForm', array(
        'id'=>'news-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation'=>false,
    ));
    if ($model -> isNewRecord) {
        $model -> id_object = $_GET['id'];
        $model -> object_type = Objects::getNumber($_GET['modelName']);
    }
    $parent = $model -> getObject();
    echo "<h2>Новость для &lt;".$parent -> name."&gt;</h2>";
    echo $form -> hiddenField($model, 'id_object');
    echo $form -> hiddenField($model, 'object_type');
    ?>
        <div class="span6">
        <p class="note"> <?php echo CHtml::encode('Поля с '); ?> <span class="required">*</span> <?php echo CHtml::encode('обязательны для заполнения'); ?></p>
            <div>
                <?php echo $form->labelEx($model,'heading'); ?>
                <?php
                echo $form -> textField($model, 'heading');
                ?>
                <?php echo $form->error($model,'heading'); ?>
            </div>

            <div>
                <?php
                $attr = 'validFrom';
                $defaultValue = '';
                $time = strtotime($model -> $attr);
                if ($time > 1000) {
//                    $defaultValue = "value='".date('o-m-d\TH:i:s',$time)."'";
                    $defaultValue = "value='".date('o-m-d',$time)."'";
                }
                echo $form->labelEx($model,$attr);
                echo "<input type='date' ".$defaultValue." name='".CHtml::resolveName($model, $attr)."' />";
                echo $form->error($model,$attr);
                ?>
            </div>

            <div>
                <?php
                $attr = 'validTo';
                $defaultValue = '';
                $time = strtotime($model -> $attr);
                if ($time > 1000) {
//                    $defaultValue = "value='".date('o-m-d\TH:i:s',$time)."'";
                    $defaultValue = "value='".date('o-m-d',$time)."'";
                }
                echo $form->labelEx($model,$attr);
                echo "<input type='date' ".$defaultValue." name='".CHtml::resolveName($model, $attr)."' />";
                echo $form->error($model,$attr);
                ?>
            </div>

            <div>
                <?php
                $attr = 'published';
                $defaultValue = '';
                $time = strtotime($model -> $attr);
                if ($time > 1000) {
                    $defaultValue = "value='".date('o-m-d\TH:i:s',$time)."'";
                }
                echo $form->labelEx($model,$attr);
                echo "<input type='datetime-local' ".$defaultValue." name='".CHtml::resolveName($model, $attr)."' />";
                echo $form->error($model,$attr);
                ?>
            </div>

            <div>
                <?php echo $form->labelEx($model,'id_price'); ?>
                <?php
                echo $form -> dropDownList($model, 'id_price',['' => 'Выберите цену'] + CHtml::listData(ObjectPrice::model() -> findAll(),'id','name'));
                ?>
                <?php echo $form->error($model,'id_price'); ?>
            </div>

            <div>
                <?php echo $form->labelEx($model,'saleSize'); ?>
                <?php
                echo $form -> textField($model, 'saleSize');
                ?>
                <?php echo $form->error($model,'saleSize'); ?>
            </div>

            <div>
                <?php echo $form->labelEx($model,'text'); ?>
                <div class="controls">
                    <?php
                    $this->widget('application.extensions.tinymce.TinyMce',
                        array(
                            'model'=>$model,
                            'attribute'=>'text',
                            'htmlOptions' => ['style' => 'height:300px;witdh:80%'],
                            'settings' => array(
                                'entity_encoding' => 'raw',
                            )
                        ));
                    ?>
                </div>
                <?php echo $form->error($model,'text'); ?>
                <br/>
            </div>

              
        <br/>
        <div class="buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? CHtml::encode('Создать') : CHtml::encode('Сохранить')); ?>
        </div>

    <?php $this->endWidget(); ?>
    </div>
    </div><!-- form -->
</div>