<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 05.01.2017
 * Time: 9:58
 */
class UWebModule extends \CWebModule implements iCallFunc {
    protected $_dbConnection;

    public $dbConfig;

    use tCallFunc;

    /**
     * @return CDbConnection
     * @throws AccessException
     * @throws CDbException
     */
    public function getDbConnection() {
        if (!$this -> _dbConnection) {
            $temp = $this -> getAttribute('dbConfig');
            if (!($temp instanceof CDbConnection)) {
                $temp = Yii::app() -> getComponent($temp);
            }
            if (!($temp instanceof CDbConnection)) {
                throw new CDbException("Could not establish connection in module ". get_class($this));
            }
            $this -> _dbConnection = $temp;
        }
        return $this -> _dbConnection;
    }

    /**
     * @param string $name
     * @return bool
     */
    function _isAllowedToEvaluate($name) {
        return ($name == 'dbConfig');
    }
}