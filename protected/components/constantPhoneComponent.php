<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 24.12.2016
 * Time: 18:26
 */
class constantPhoneComponent extends CComponent implements iPhoneComponent {
    public $number;
    public function init() {

    }
    /**
     * @param string $format
     * @return string formatted according to format argument telephone number
     */
    public function getFormatted($format = '') {
        return $this -> number;
    }

    /**
     * @return string has to return a short number consisting of seven digits
     * without any other symbols
     */
    public function getShort() {
        return substr(preg_replace('/[^\d]/', '', $this -> getFormatted('')), -7);
    }
}