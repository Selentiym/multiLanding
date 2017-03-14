<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 13.03.2017
 * Time: 19:26
 */
abstract class UVKCommentsModel extends UModuleModel {
    private static $_module;

    public static function setModule(UWebModule $mod) {
        self::$_module = $mod;
    }

    /**
     * @return VKCommentsModule
     */
    public function getModule() {
        if (!self::$_module) {
            self::setModule(parent::getModule());
        }
        return self::$_module;
    }

    /**
     * @return string
     */
    public function getModuleClassName() {
        return 'VKCommentsModule';
    }
}