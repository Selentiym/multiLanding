<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 20.02.2017
 * Time: 21:18
 */
abstract class UModuleModel extends CActiveRecord {
    /**
     * @return string
     */
    abstract public function getModuleClassName();

    /**
     * @return UWebModule
     */
    public function getModule() {
        $name = $this -> getModuleClassName();
        return $name::getLastInstance();
    }
    public function getDbConnection(){
        $i = $this -> getModule();
        return $i -> getDbConnection();
    }
    public function customFind($id = null){
        if ($id) {
            return static::model() -> findByPk($id);
        } else {
            return static::model();
        }
    }
    public function checkCreateAccess(){
        return !Yii::app() -> user -> getIsGuest();
    }
    public function checkUpdateAccess(){
        return !Yii::app() -> user -> getIsGuest();
    }
    public function checkDeleteAccess(){
        return !Yii::app() -> user -> getIsGuest();
    }
}