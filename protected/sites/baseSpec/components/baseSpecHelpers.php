<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 11.06.2017
 * Time: 12:09
 */
class baseSpecHelpers {
    /**
     * @param string $verbiage of the trigger to be rendered
     * @param mixed[] $triggers
     * @return string - the html code of the trigger (for TickTrigger instances only!)
     */
    public static function customCheckbox($verbiage, &$triggers){
        return Triggers::triggerHtml($verbiage,$triggers,[],['renderFunc' => function($trigger, $htmlOptions, $dopParameters, $data){
            $mainVal = current($trigger -> trigger_values);
            $children = $trigger -> getChildrenHtml($data, $htmlOptions['id']);
            if ($dopParameters['noChildren']) {
                $children = '';
            }
            $htmlOptions['class'] .= ' custom-control-input';
            return "<label for='{$htmlOptions['id']}' class='custom-control custom-checkbox'>".CHtml::checkBox(
                $trigger -> verbiage,
                in_array($mainVal -> verbiage,empty($data[$trigger -> verbiage]) ? [] : [$data[$trigger -> verbiage]]),
                $htmlOptions
            ) . '<span class="custom-control-indicator"></span>' .
            " <span class='custom-control-description'>{$mainVal->value}</span></label>" . $children;
        }]);
    }

    public static function salesWord($number){
        if (($number < 20)&&($number > 10)) {
            $str = $number.' скидок';
        } elseif ($number % 10 == 1) {
            $str = $number.' скидка';
        } elseif (in_array($number % 10, [2,3,4])) {
            $str = $number.' скидки';
        } else {
            $str = $number.' скидок';
        }
        return $str;
    }

    /**
     * @param int $num
     * @return string
     */
    public static function medCenterWordRod($num){
        $r = $num;
        if ($num == 11) {
            $r .= ' медицинских центров';
        } elseif ($num % 10 == 1) {
            $r .= ' медицинского центра';
        } elseif($num % 10 != 1 ){
            $r .= ' медицинских центров';
        }
        return $r;
    }
}