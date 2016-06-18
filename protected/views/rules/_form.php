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
    'id'=>'rulesForm',
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
            <label>Секция</label>
            <?php

                $sections = CHtml::listData(Section::model() -> findAll(array('order' => 'num ASC')),'id','name');
                //var_dump($data);
                //echo Section::trivialId();
                $selected = array();
                if ($model -> id_section) {
                    $selected[] = $model -> id_section;
                } else {
                    $selected[] = Section::trivialId();
                }
                CHtml::activeDropDownListChosen2(Rule::model(), 'id_section',$sections, array('style' => 'width:300px;','class' => 'select2'), $selected, '{
                    placeholder:"Первая секция"
                }');
            ?>
        </div>
        <div class="form-group">

            <?php
            echo "<select name='Rule[prices_input][]' id='basePriceSelect' style='display: none;'>";
            foreach (Price::model() -> findAll() as $price) {
                /**
                 * @type Price $price
                 */
                echo "<option value='{$price -> id}'>{$price -> text}</option>";
            }
            echo "</select>";
            Yii::app()->getClientScript()->registerScript('prices',"
                var selectToCopy = $('#basePriceSelect');
                $('#subm').click(function(){
                    selectToCopy.remove();
                    $('#rulesForm').submit();
                });
                function add_new_image(param){
                   total = $('#table_container').attr(\"data-rangesCount\");
                   total++;
                   var toAppend = selectToCopy.clone();
                   toAppend.removeAttr('id');
                   if (param) {
                    if (param.priceId) {
                        toAppend.children('[value=\"'+param.priceId+'\"]').attr('selected','selected');
                    }
                   }
                   toAppend.show();

                   $('#table_container').attr('data-rangesCount', total);
                   $('<tr>')
                   .attr('id','tr_image_'+total)
                   .css({lineHeight:'20px'})
                   .append (
                       $('<td>')
                       .attr('id','td_title_'+total)
                       .css({paddingRight:'5px',width:'500px'})
                       .append(
                           toAppend
                       )
                    )
                    .append(
                        $('<td>')
                        .css({width:'60px'})
                        .append(
                           $('<span id=\"progress_'+total+'\" class=\"padding5px\"><span onclick=\"$(\'#tr_image_'+total+'\').remove()\" class=\"ico_delete\"><img src=\"".Yii::app() -> baseUrl.'/img/'."deleteRange.png\" alt=\"del\" border=\"0\"></span></span>')
                         )
                     )
                     .appendTo('#table_container');
                     toAppend.select2({});
                }",CClientScript::POS_END);
            $rez = '';
            count($model -> prices);
            foreach($model -> prices as $price) {
                $rez .= "add_new_image({priceId:'".$price -> id."'});\r\n";
            }
            Yii::app()->getClientScript()->registerScript('ranges',$rez,CClientScript::POS_READY);
            ?>
            <table id="table_container" data-rangesCount="0">
                <tr>
                </tr>
            </table>
            <input type="button" value="Добавить выделенную цену" id="add" onclick="return add_new_image({});">
        </div>
        <div class="form-group">
            <input type="button" id="subm" name="submitRuleForm" value="<?php echo $model->isNewRecord ? CHtml::encode('Создать') : CHtml::encode('Сохранить'); ?>"/>

        </div>
    </div>
</fieldset>
<?php $this -> endWidget(); ?>
