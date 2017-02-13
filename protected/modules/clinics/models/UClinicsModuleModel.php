<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 01.02.2017
 * Time: 12:16
 */
abstract class UClinicsModuleModel extends CActiveRecord {
    public function getDbConnection(){
//        $db = ClinicsModule::getDbConnection();
        return ClinicsModule::getLastInstance() -> getDbConnection();
    }
    public function readData($data){
        return true;
    }
    public function checkCreateAccess(){
        return Yii::app() -> controller -> isSuperAdmin();
    }
    public function checkUpdateAccess(){
        return Yii::app() -> controller -> isSuperAdmin();
    }
    public function checkDeleteAccess(){
        return Yii::app() -> controller -> isSuperAdmin();
    }
    public function explainErrors(){
        var_dump($this -> getErrors());
    }
    public function customFind($id = null){
        if ($id) {
            return static::model() -> findByPk($id);
        } else {
            return static::model();
        }
    }
}