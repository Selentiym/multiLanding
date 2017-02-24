<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 20.02.2017
 * Time: 21:13
 */
class TaskGenModel extends UModuleModel {
    /**
     * @return string
     */
    public function getModuleClassName() {
        return 'TaskGenModule';
    }
    public function beforeSave() {
        $this -> addError('id','Not allowed to change anything in taskgen from here!');
        return false;
    }
}