<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 01.02.2017
 * Time: 12:16
 */
abstract class UClinicsModuleModel extends CActiveRecord {
    public function getDbConnection(){
        $db = ClinicsModule::getConnection();
        return ClinicsModule::getConnection();
    }
}