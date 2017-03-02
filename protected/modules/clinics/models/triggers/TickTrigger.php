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
     * @param array $values selected values
     * @param array $htmlOptions htmlOptions for the element
     * @param array $dopParameters additional parameters that may differ from trigger to trigger
     * @return null|string
     */
    public function getHtml($values = [], $htmlOptions = [], $dopParameters = []){
        $name = $htmlOptions['name'] ? $htmlOptions['name'] : $this -> verbiage;
        $mainVal = current($this -> trigger_values);
        $htmlOptions['id'] = $htmlOptions['id'] ? $htmlOptions['id'] : $mainVal -> verbiage;
        $htmlOptions['value'] = $mainVal -> verbiage;
        return CHtml::checkBox(
            $name,
            in_array($mainVal -> verbiage,$values),
            $htmlOptions
        ) . "<label for='{$htmlOptions['id']}'>{$mainVal->value}</label>";
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
}