<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 05.08.2017
 * Time: 22:40
 */
class Phone implements iPhoneComponent {
    private $_number;
    public function __construct($number) {
        $this -> _number = $number;
    }

    /**
     * @param string $format
     * @return string formatted according to format argument telephone number
     */
    public function getFormatted($format = '') {
        return $this -> _number;
    }

    /**
     * @return string has to return a short number consisting of seven digits
     * without any other symbols
     */
    public function getShort() {
        return substr(preg_replace('/[^\d]/', '', $this -> getFormatted('')), -7);
    }

    /**
     * @return string has to return a number consisting of eleven digits
     * without any other symbols
     */
    public function getUnformatted() {
        return '8'.substr(preg_replace('/[^\d]/', '', $this -> getFormatted('')), -10);
    }
}