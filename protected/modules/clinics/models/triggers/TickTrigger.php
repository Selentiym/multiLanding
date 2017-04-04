<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.03.2017
 * Time: 16:05
 */
class TickTrigger extends Triggers {
    use tTriggersStandard;
    /**
     * @param array $data contains ALL information about the form
     * @param array $htmlOptions htmlOptions for the element
     * @param array $dopParameters additional parameters that may differ from trigger to trigger
     * @return null|string
     */
    public function getHtml($data, $htmlOptions = [], $dopParameters = []){
        $name = $htmlOptions['name'] ? $htmlOptions['name'] : $this -> verbiage;
        $mainVal = current($this -> trigger_values);
        $htmlOptions['id'] = $htmlOptions['id'] ? $htmlOptions['id'] : $mainVal -> verbiage;
        $htmlOptions['value'] = $mainVal -> verbiage;
        if (!$data[$this -> verbiage]) {
            $data[$this -> verbiage] = [$this -> getUncheckedValue()];
        }
        $children = $this -> getChildrenHtml($data, $htmlOptions['id']);
        if ($dopParameters['noChildren']) {
            $children = '';
        }
        return "<label for='{$htmlOptions['id']}'>".CHtml::checkBox(
            $name,
            in_array($mainVal -> verbiage,empty($data[$this -> verbiage]) ? [] : [$data[$this -> verbiage]]),
            $htmlOptions
        ) . "{$mainVal->value}</label>" . $children;
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
    public function getUncheckedValue(){
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
        $temp['uncheckedValue'] = $this -> getUncheckedValue();
        return $temp;
    }
}