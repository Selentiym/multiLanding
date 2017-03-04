<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.03.2017
 * Time: 16:47
 */
class DropDownTrigger extends Triggers {
    use tTriggersStandard;
    /**
     * @param array $data contains ALL information about the form
     * @param array $htmlOptions htmlOptions for the element
     * @param array $dopParameters additional parameters that may differ from trigger to trigger
     * @return null|string
     */
    /*public function getHtml(&$data = [], $htmlOptions = [], $dopParameters = []){
        $name = $htmlOptions['name'] ? $htmlOptions['name'] : $this -> verbiage;
        $id = $htmlOptions['id'] ? $htmlOptions['id'] : $this -> verbiage;
        return CHtml::DropDownListChosen2(
            $name,
            $id,
            CHtml::listData($this -> trigger_values,'verbiage','value'),
            $htmlOptions,
            $data[$this -> verbiage] ? [$data[$this -> verbiage]] : [],
            $dopParameters,
            true
        ) . $this -> getChildrenHtml($data, $id);
    }*/

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