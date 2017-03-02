<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.03.2017
 * Time: 16:50
 */
trait tTriggersStandard {
    /**
     * @param $object - to be checked
     * @param array $values of the trigger that are selected
     * @param array $cached some data that may be useful for all the triggers in common
     * @return bool
     */
    public function checkObject($object, $values = [], $cached = []) {
        return count(array_intersect($cached, $values)) == count($values);
    }
}