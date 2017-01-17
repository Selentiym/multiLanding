<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 16.01.2017
 * Time: 12:26
 */
class CallTrackerPhoneComponent extends CComponent implements iPhoneComponent {
    /**
     * Id of the call tracker module which provides phone numbers
     * @var string
     */
    public $moduleId;
    /**
     * @var CallTrackerModule
     */
    public $module;
    /**
     * @return CallTrackerModule
     */
    private function getModule() {
        if (!$this -> module) {
            $this -> module = Yii::app() -> getModule($this -> moduleId);
        }
        return $this -> module;
    }
    public function init(){}
    /**
     * @param string $format
     * @return string formatted according to format argument telephone number
     */
    public function getFormatted($format = '') {
        return $this -> getModule() -> getFormattedNumberNonStatic();
    }

    /**
     * @return string has to return a short number consisting of seven digits
     * without any other symbols
     */
    public function getShort()
    {
        return $this -> getModule() -> getShortNumberNonStatic();
    }
}