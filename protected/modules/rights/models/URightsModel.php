<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 20.02.2017
 * Time: 15:57
 */
abstract class URightsModel extends CActiveRecord {
    public function getDbConnection() {
//        $db = ClinicsModule::getDbConnection();
        return RightsModule::getLastInstance()->getDbConnection();
    }
}