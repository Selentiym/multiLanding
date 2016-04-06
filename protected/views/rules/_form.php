<?php
Yii::app()->getClientScript()->registerCoreScript('jquery');
Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.'/css/select2.min.css');
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl.'/js/select2.full.js');
//Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.min.js');
/**
 * Created by PhpStorm.
 * User: user
 * Date: 05.04.2016
 * Time: 20:39
 */
/**
 * @var Rule model
 */
$form=$this->beginWidget('CActiveForm', array(
    'id'=>'users-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation'=>false,
    'htmlOptions'=>array('enctype'=>'multipart/form-data'),
));
?>
<fieldset>
    <div class="well">
        <div class="form-group">
            <label>Слово</label>
            <?php echo $form->textField($model, 'word',array('size'=>60,'maxlength'=>512,'placeholder'=>'Слово')); ?>
        </div>
        <div class="form-group">
            <label>Телефон</label>
            <?php CHtml::activeDropDownListChosen2(Tel::model(), 'id',CHtml::listData(Tel::model() -> findAll(),'id','tel'), array('style' => 'width:300px;','class' => 'select2','name' => 'Rule[id_tel]'), ($model -> id_tel ? array($model -> id_tel) : false), '{
						tokenSeparators: [";"],
						placeholder:"Номер телефона для отображения на странице",
					}'); ?>
        </div>
        <div class="form-group">
            <label>Приоритет</label>
            <?php echo $form->textField($model, 'prior',array('size'=>60,'maxlength'=>512,'placeholder'=>'Приоритет')); ?>
        </div>
        <div class="form-group">
            <label>Объект</label>
            <?php
                /**
                 * Запихиваем с список одновременно все разделы (у разделов берем
                 * отрицательный id,чтобы не смешивать), а потом цены.
                 */
                $data1 = CHtml::listData(Price::model() -> findAll(),'id','text');
                $data2 = CHtml::listData(Section::model() -> findAll(array('order' => 'num ASC')),function ($obj) { return (0 - $obj -> id); },'name');
                $data = $data2 + $data1;
                //var_dump($data);
                //echo Section::trivialId();
                if ($model -> id_price != Price::trivialId()) {
                    $selected = array($model -> id_price);
                } elseif ($model -> id_section != Section::trivialId()) {
                    $selected = array( - $model -> id_section);
                } else {
                    $selected = false;
                }

                CHtml::activeDropDownListChosen2(Rule::model(), 'object_input',$data, array('style' => 'width:300px;','class' => 'select2'), $selected, '{
                    placeholder:"Объект на первом месте"
                }');

            ?>
        </div>
        <div class="form-group">
            <?php echo CHtml::submitButton($model->isNewRecord ? CHtml::encode('Создать') : CHtml::encode('Сохранить')); ?>
        </div>
    </div>
</fieldset>
<?php $this -> endWidget(); ?>
