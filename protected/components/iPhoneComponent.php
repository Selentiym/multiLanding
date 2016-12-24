<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 24.12.2016
 * Time: 18:23
 */
interface iPhoneComponent {
    /**
     * @param string $format
     * @return string formatted according to format argument telephone number
     */
    public function getFormatted($format = '');

    /**
     * @return string has to return a short number consisting of seven digits
     * without any other symbols
     */
    public function getShort();
}