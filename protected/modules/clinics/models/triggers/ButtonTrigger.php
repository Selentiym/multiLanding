<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 07.03.2017
 * Time: 14:15
 */
class ButtonTrigger extends Triggers {
    /**
     * @param array $data contains ALL information about the form
     * @param array $htmlOptions htmlOptions for the element
     * @param array $dopParameters additional parameters that may differ from trigger to trigger
     * @return null|string
     */
    public function getHtml($data, $htmlOptions = [], $dopParameters = []){
        $htmlOptions['name'] = $htmlOptions['name'] ? $htmlOptions['name'] : $this -> verbiage;
        $mainVal = current($this -> trigger_values);
        $htmlOptions['id'] = $htmlOptions['id'] ? $htmlOptions['id'] : $mainVal -> verbiage;
        $initialValue = $data[$this -> verbiage];
        if (!$data[$this -> verbiage]) {
            $data[$this -> verbiage] = [$this -> getUnpressedValue()];
        }
        $id = $htmlOptions['id'];
        $htmlOptions['data-val'] = $mainVal -> verbiage;
        $htmlOptions['class'] .= ' button';
        if ($initialValue == $htmlOptions['data-val']) {
            $htmlOptions['class'] .= ' pressed';
        }
        Yii::app() -> getClientScript() -> registerScript($id.'Button',"
            $('#{$id}Button').click(function(){
                var el = $('#$id');
                $(this).toggleClass('pressed');
                if ($(this).hasClass('pressed')) {
                    el.val($(this).attr('data-val'));
                } else {
                    el.val('');
                }
                el.trigger('change');
            });
        ",CClientScript::POS_READY);
        //Рендерим кнопку
        $htmlOptions['id'] = $id.'Button';
        $children = $this -> getChildrenHtml($data, $id);
        if ($dopParameters['noChildren']) {
            $children = '';
        }
        $optionsForDiv = $htmlOptions;
        unset($optionsForDiv['name']);
        return CHtml::tag('div',$optionsForDiv, $mainVal -> value) .
            $children .
            CHtml::hiddenField($htmlOptions['name'],$initialValue);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Triggers the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    public function getUnpressedValue(){
        $vals = $this -> trigger_values;
        if (count($vals) > 1) {
            $val = end($vals) -> verbiage;
        } else {
            $val = false;
        }
        return $val;
    }
    public function loadJavascripts() {
        $temp = parent::loadJavascripts();
        $temp["dataUpdate"] = 'js:function(data){
            this.element.html(data.html);
        }';
        $temp['uncheckedValue'] = $this -> getUnpressedValue();
        return $temp;
    }
}